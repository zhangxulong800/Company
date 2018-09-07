<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);	
$module['list']=self::get_sub_name($pdo,$_SESSION['monxin']['username'],1);
if(isset($_POST['sum'])){
	$sql="update ".self::$table_pre."distributor set `subordinate`=".intval($_POST['sum'])." where `username`='".$_SESSION['monxin']['username']."' limit 1";
	$pdo->exec($sql);
}

$module['my_icon']=$_SESSION['monxin']['icon'];

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
