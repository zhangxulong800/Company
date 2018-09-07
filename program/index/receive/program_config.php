<?php
$act=@$_GET['act'];


if($act=='up_new'){	
	$v=@$_POST['v'];
	$v=explode("|",$v);
	$v=$v[count($v)-1];
	if($v==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['is_null']."'}");}
	$path=extract_zip('./temp/'.$v);
	if($path==false){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['extract_fail']."'}");}
	
	$r=scandir($path);
	
	$r2=check_installation_files($path,$r[2]);
	if($r2!=''){exit("{'info':'<fieldset><legend>".self::$language['lack']."</legend>".$r2."</fieldset>','id':'installation_package'}");}			
	

	if(program_permissions(self::$config,self::$language,$r[2],$path.'/'.$r[2].'/')==false){
		exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['illegal_use']."'}");	
	}
	
	$dir=new Dir();
	
	
	
	if(is_dir('./program/'.$r[2])){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['already_exists']."'}");}
	if($dir->copy_dir($path.'/'.$r[2].'/','./program/'.$r[2])){$dir->del_dir($path);}	
	
	
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>'}");
}



if($act=='set'){
	$update=trim(@$_GET['update']);
	//echo $update;

	$$update=trim(@$_POST[$update]);
	//echo $update.'='.$$update;
	if($$update=='false'){$$update=false;}
	if($$update=='true'){$$update=true;}
	//echo $update.'='.var_dump($$update);
	$program=@$_GET['program'];
	$config=require('./program/'.$program.'/config.php');
	if($update=='cache_time'){$$update=intval($$update);}
	
	$config['program'][$update]=$$update;
	if(file_put_contents('./program/'.$program.'/config.php','<?php return '.var_export($config,true).'?>')){
		self::sum_modules($pdo);
		echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
	}else{
		echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
	}	
	exit;
}

if($act=='del'){
	$program=safe_str(@$_GET['program']);
	if($program=='index'){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['illegal']."'}");}
	$sql="select count(id) as c from ".$pdo->index_pre."program where `name`='".$program."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['illegal']."'}");}
	$dir=new Dir();
	$dir->del_dir('./program/'.$program);
	if(!is_dir('./program/'.$program)){
		$sql="delete from ".$pdo->index_pre."sum_modules where `key` like '".$program.".%'";
		$pdo->exec($sql);
		echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
	}else{
		echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
	}
		
}
if($act=='uninstall'){//弃用的
	$program=safe_str(@$_GET['program']);
	if($program==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['is_null']."'}");}	
	if($program=='index'){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['illegal']."'}");}
	
	require("./program/$program/uninstall.php");
	if(uninstall($pdo)){
		uninstall_program($program);
		echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
	}else{
		echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
	}
		
}


