<?php
set_time_limit(1800);
$act=@$_GET['act'];
$program=safe_str(@$_GET['program']);
$config=require('./program/'.$program.'/config.php');
$language=require('./program/'.$program.'/language/'.$config['program']['language'].'.php');


if($act=='backup'){
	$sql="select `id` from ".$pdo->index_pre."page where `url` like '".$program.".%'";
	$r=$pdo->query($sql,2);
	foreach($r as $v){update_pages_file($pdo,$v['id']);}
	
	$dir=new Dir();
	$dir->del_dir('./program/'.$program.'/install_sql');	
	mkdir('./program/'.$program.'/install_sql');
	$r=output_table($pdo,'./program/'.$program.'/install_sql',$program);
	if($r!==true){exit("{'state':'fail','info':'<span class=fail>".self::$language['backup'].self::$language['database'].self::$language['fail']."</span>'}");}
	$dir=new Dir();
	mkdir('./program/'.$program.'/install_templates/');
	mkdir('./program/'.$program.'/install_templates/0/');
	mkdir('./program/'.$program.'/install_templates/1/');
	$dir->copy_dir('./templates/0/'.$program.'/'.$config['program']['template_0'].'/','./program/'.$program.'/install_templates/0/'.$config['program']['template_0'].'/');
	$dir->copy_dir('./templates/1/'.$program.'/'.$config['program']['template_1'].'/','./program/'.$program.'/install_templates/1/'.$config['program']['template_1'].'/');
	@mkdir('./program_backup/'.$program.'/');
	$random=date('Y-m-d',time()).'_'.md5(rand(1,99999).time());
	@mkdir('./program_backup/'.$program.'/'.$random);
	$zip_path='./program_backup/'.$program.'/'.$random.'/'.$program.'.zip';
	require('./plugin/dir_to_zip/index.php');
	new dir_to_zip('./program/'.$program,$zip_path); 
	$dir->del_dir('./program/'.$program.'/install_templates/');	
	if(is_file($zip_path)){
		$view='<a href="./index.php?monxin=index.program_recovery&program='.$program.'" class="view">'.self::$language['view'].'</a>';
		exit("{'state':'success','info':'<span class=success>".self::$language['success'].' '.$view."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
	
	
	
}
