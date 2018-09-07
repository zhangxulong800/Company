<?php
$module['username']='';
$module['money']='';
if(isset($_GET['id'])){
	$id=intval($_GET['id']);
	if($id==0){echo 'id err';return false;}
	$sql="select `username`,`money` from ".$pdo->index_pre."user where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	$module['username']=de_safe_str($r['username']);
	$module['money']=$r['money'];
}


$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);

