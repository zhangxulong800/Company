<?php
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$path=@$_GET['path'];
$path=trim($path,'/');
$path=trim($path,'.');
$path=str_replace('templates/','',$path);
$path='templates/'.$path;
// echo $path;
if(!is_file($path)){echo(self::$language['not_exist_file']);return false;}

$module['path']=$path;
$module['content']=file_get_contents($path);
$module['content']=str_replace('</textarea>','<\/textarea>',$module['content']);

	$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
