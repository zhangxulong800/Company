<?php
$id=intval(@$_GET['id']);
if($id==0){
	$sql="select `id` from ".$pdo->index_pre."group order by `deep` asc , `parent` asc limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	$id=$r['id'];
}


$language=array();
$path='./program/';
$r=scandir($path);
foreach($r as $v){
	if($v!='.' && $v!='..' && is_dir($path.$v)){
		if(!is_file($path.$v.'/config.php')){continue;}
		$config=require($path.$v.'/config.php');
		$l=require($path.$v.'/language/'.$config['program']['language'].'.php');
		//var_dump($l);
		if(!isset($config['dashboard_module'])){continue;}
		foreach($config['dashboard_module'] as $v2){
			if(!isset($l['functions'][$v2]['description'])){continue;}
			$language[$v2]=$l['functions'][$v2]['description'];
		}	
	} 	
}

//var_dump($language);

$sql="select `user_sum`,`function_power` from ".$pdo->index_pre."group where `id`='$id'";
$stmt=$pdo->query($sql,2);
$v=$stmt->fetch(2);
$module['user_sum']=$v['user_sum'];
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&id=".$id;

$temp=explode(',',$v['function_power']);
$sql="select * from ".$pdo->index_pre."sum_modules";
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	//echo $v['key'].'<br />';
	if(isset($language[$v['key']])){if(in_array($v['key'],$temp)){$list.='<div m_name="'.str_replace('.','__',$v['key']).'">'.$language[$v['key']].'</div>';}}
		
}



$module['list']=$list;
$module['groups']=index::get_groups($pdo,0,"index.php?monxin=index.sum_set&id=");
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);