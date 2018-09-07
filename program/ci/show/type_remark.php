<?php
$id=intval(@$_GET['id']);
if($id==0){echo (self::$language['need_params']);	return false;}


$sql="select * from ".self::$table_pre."type where `id`='$id'";
$module=$pdo->query($sql,2)->fetch(2);
$module=de_safe_str($module);

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['class_name']=self::$config['class_name'];
$module['web_language']=self::$config['web']['language'];

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);

