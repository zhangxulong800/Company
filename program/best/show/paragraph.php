<?php
$id=intval(@$_GET['id']);
$index=intval(@$_GET['index']);
$_GET['device']=safe_str(@$_GET['device']);
$module['c']='';
$module['is_full']=1;
if($id>0){
	$sql="select `content_".$_GET['device']."`,`is_full` from ".self::$table_pre."paragraph where `id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	$module['c']=de_safe_str($r['content_'.$_GET['device']]);
	$module['is_full']=$r['is_full'];
}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&id=".$id."&device=".$_GET['device'];
$module['class_name']=self::$config['class_name'];
$module['web_language']=self::$config['web']['language'];

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);

