<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['module_save_name']=str_replace("::","_",$method.$args[1]);
$module['alert']=self::$config['alert'];
$module['admin_phone_msg']=($module['alert']['admin_phone_msg'])?'checked':'';
$module['admin_email_msg']=($module['alert']['admin_email_msg'])?'checked':'';
$module['phone_msg']=($module['alert']['phone_msg'])?'checked':'';
$module['email_msg']=($module['alert']['email_msg'])?'checked':'';


		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
