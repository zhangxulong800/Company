<?php
set_time_limit(1800);
$act=@$_GET['act'];
$program=safe_str(@$_GET['program']);
$config=require('./program/'.$program.'/config.php');
$language=require('./program/'.$program.'/language/'.$config['program']['language'].'.php');
$pdo2=new  ConnectPDO();

$program=@$_GET['program'];
if(program_permissions(self::$config,self::$language,$program,'./program/'.$program.'/')==false){
	exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['illegal_use']."'}");
}
if($act=='recover'){			
	$file=@$_GET['id'];
	$path='./program_backup/'.$program.'/'.$file.'/'.$program.'.zip';
	//exit($path);
	if(!is_file($path)){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."11</span>'}");}		
	$r=check_installation_files($path,$program);
	if($r!=''){exit("{'state':'fail','info':'<fieldset><legend>".self::$language['lack']."</legend>".$r."</fieldset>'}");}
	$dir=new Dir();
	if(is_dir('./program/'.$program.'_back')){$dir->del_dir('./program/'.$program.'_back');}
	$path2=extract_zip($path,false);
	safe_rename('./program/'.$program,'./program/'.$program.'_back');
	safe_rename($path2.'/'.$program,'./program/'.$program);
	

	@mkdir('./templates/0/'.$program.'/');	
	@mkdir('./templates/1/'.$program.'/');	
	if(is_dir('./templates/0/'.$program.'/'.$config['program']['template_0'])){$dir->del_dir('./templates/0/'.$program.'/'.$config['program']['template_0']);}
	if(is_dir('./templates/1/'.$program.'/'.$config['program']['template_1'])){$dir->del_dir('./templates/0/'.$program.'/'.$config['program']['template_1']);}

	$dir->copy_dir('./program/'.$program.'/install_templates/0/'.$config['program']['template_0'],'./templates/0/'.$program.'/'.$config['program']['template_0']);	
	$dir->copy_dir('./program/'.$program.'/install_templates/1/'.$config['program']['template_1'],'./templates/1/'.$program.'/'.$config['program']['template_1']);	
	$dir->del_dir('./program/'.$program.'/install_templates/');

	$dir->del_dir('./program/'.$program.'_back');
	
	//update page
	$pages=require('./program/'.$program.'/pages.php');
	foreach($pages as $v){
		$sql="select `id` from ".$pdo->index_pre."page where `url`='".$v['url']."'";
		$r=$pdo2->query($sql,2)->fetch(2);
		if($r['id']==''){
			$sql="insert into ".$pdo2->index_pre."page (`url`,`layout`,`head`,`left`,`right`,`full`,`bottom`,`require_login`,`target`,`tutorial`) values ('".$v['url']."','".$v['layout']."','".$v['head']."','".$v['left']."','".$v['right']."','".$v['full']."','".$v['bottom']."','".$v['require_login']."','".$v['target']."','".$v['tutorial']."')";	
		}else{
			$sql="update ".$pdo2->index_pre."page set `layout`='".$v['layout']."',`head`='".$v['head']."',`left`='".$v['left']."',`right`='".$v['right']."',`full`='".$v['full']."',`bottom`='".$v['bottom']."',`require_login`='".$v['require_login']."',`target`='".$v['target']."',`tutorial`='".$v['tutorial']."' where `url`='".$v['url']."'";	
		}
		$pdo2->exec($sql);	
	}


	
	$sql=$dir->show_dir('./program/'.$program.'/install_sql/',array('sql'),false,false);
	$r=input_table($pdo,$sql[0]);
	if($r){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");	
	}
}
		
if($act=='download'){
	$file=@$_GET['file'];
	if(is_file($file)){file_download($file,$filename='');}
	exit;
}
if($act=='del'){
	$file=@$_GET['id'];
	$path='./program_backup/'.$program.'/'.$file.'/'.$program.'.zip';
	
	if(!is_file($path)){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");}
	$r=safe_unlink($path);
	rmdir(str_replace($program.'.zip','',$path));
	if($r){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");	
	}
}

if($act=='upload'){
	$_POST['zip']=trim($_POST['zip'],'|');
	if(!is_file('./temp/'.$_POST['zip'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");}
	@mkdir('./program_backup/'.$program.'/');
	$random=date('Y-m-d',time()).'_'.md5(rand(1,99999).time());
	@mkdir('./program_backup/'.$program.'/'.$random);
	$zip_path='./program_backup/'.$program.'/'.$random.'/'.$program.'.zip';
		
	if(safe_rename('./temp/'.$_POST['zip'],$zip_path)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
		
