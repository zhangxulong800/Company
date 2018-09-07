<?php
	  $_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
	  $module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
	  $module['class_name']=self::$config['class_name'];
	  $module['web_language']=self::$config['web']['language'];
	  if(!self::$config['web']['diy_phone_home_page']){echo self::$language['turn_on_this_function'].' <a href=index.php?monxin=index.config&id=web&#web>'.self::$language['click'].self::$language['set'].'</a>';return false;}
	  
	  $module['data']=de_safe_str(@file_get_contents('./program/index/diy_phone_home_page_data.txt'));

	  		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
