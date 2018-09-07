<?php
$act=@$_GET['act'];
$type=@$_GET['type'];
$type=($type=='1')?'1':'0';
$_GET['type']=$type;

if($act=='up_new'){	
	$v=@$_POST['v'];
	$v=explode("|",$v);
	$v=$v[count($v)-1];
	if($v==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['is_null']."'}");}
	$path=extract_zip('./temp/'.$v);
	if($path==false){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['extract_fail']."'}");}
	
	$r=scandir($path);			
	if(!is_dir($path.'/'.$r[2]) || !is_file($path.'/'.$r[2].'/info.txt')){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['the_template_is_not_for_Monxin']."'}");}
	$template_info=get_txt_info($path.'/'.$r[2].'/info.txt');
	if($template_info['for']==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['the_template_is_not_for_Monxin']."'}");}
	if(!is_dir('./program/'.$template_info['for'])){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['corresponding_program_is_not_installed_can_not_use_this_template']."'}");}
	//echo $r[2].'/'.$r1[2];	
	
	
	$r2=check_template_files($path,$r[2]);
	if($r2!=''){exit("{'info':'<fieldset><legend>".self::$language['lack']."</legend>".$r2."</fieldset>','id':'installation_package'}");}			
		
	
	if(template_permissions(self::$config,self::$language,$template_info['for'],$r[2],$path.'/'.$r[2].'/')==false){
		exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['illegal_use']."'}");	
	}			
	$dir=new Dir();
	if(is_dir('./templates/'.$template_info['type'].'/'.$template_info['for'].'/'.$r[2])){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['already_exists']."'}");}
	
	
	if($dir->copy_dir($path.'/'.$r[2].'/','./templates/'.$template_info['type'].'/'.$template_info['for'].'/'.$r[2].'/')){$dir->del_dir($path);}	
	require_once('./lib/FilterTemplate.class.php');
	new FilterTemplate('./templates/'.$template_info['type'].'/'.$template_info['for'].'/'.$r[2].'/');
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a><br />".$_POST['FilterTemplate_result']."'}");
}



if($act=='apply'){
	$path=safe_str(@$_GET['path']);
	$path=str_replace('.','',$path);
	$path=explode('__',$path);
	$program=$path[0];
	$template=@$path[1];
	$path='./templates/'.$type.'/'.$program.'/'.$template.'/';
	//exit($path);
	if(!is_dir($path)){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");}
	$template_info=get_txt_info($path.'info.txt');
	
	$config=require('./program/'.$program.'/config.php');
	$compatible_template_version=explode(',',$config['compatible_template_version']);
	if(!in_array($template_info['version'],$compatible_template_version)){
		exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['version'].self::$language['incompatible']."'}");
	}
	
				
	$config['program']['template_'.$type]=$template;
	if(file_put_contents('./program/'.$program.'/config.php','<?php return '.var_export($config,true).'?>')){
		echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
	}else{
		echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
	}	
	exit;
	
}

if($act=='del'){
	$path=safe_str(@$_GET['path']);
	$path=str_replace('.','',$path);
	$path=explode('__',$path);
	$program=$path[0];
	$template=@$path[1];
	
	$config=require('./program/'.$program.'/config.php');
	if($template==$config['program']['template_'.$type]){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['being_used']."'}");}			
	
	$path='./templates/'.$type.'/'.$program.'/'.$template.'/';
	//exit($path);
	if(!is_dir($path)){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");}
	if($template=='default'){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['illegal']."'}");}
	$dir=new Dir();
	$dir->del_dir($path);
	if(!is_dir($path)){
		echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
	}else{
		echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
	}
	exit;	
}

