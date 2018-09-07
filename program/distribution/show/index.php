<?php
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$id=intval(@$_GET['id']);

if($id<1){
	if(isset($_SESSION['monxin']['username'])){
		$sql="select `id` from ".self::$table_pre."distributor where `username`='".$_SESSION['monxin']['username']."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		$id=$r['id'];
		$_GET['id']=$id;
		header('location:./index.php?monxin=distribution.index&id='.$id);exit;
	}else{
		echo '<div class=return_false> ID '.self::$language['err'].' <a href=index.php class=go_home>'.self::$language['go_home'].'</a></div>';exit;
	}
}
$sql="select * from ".self::$table_pre."distributor where `id`='".$id."'";
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']!='' && $r['state']!=1){
	echo '<div class=return_false>'.self::$language['distributor_state'][$r['state']].'</div>';return false;
}
if(!isset($_SESSION['share'])){$_SESSION['share']=$r['username'];}
$sql="select * from ".$pdo->index_pre."user where `username`='".$r['username']."' limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
$module['data']=$r;
if(!is_url($module['data']['icon'])){$module['data']['icon']='./program/index/user_icon/'.$module['data']['icon'];}

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);

