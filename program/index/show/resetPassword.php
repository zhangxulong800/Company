<?php
		//if(isset($_SESSION['monxin']['id']) && $_GET['field']!='transaction_password'){header("location:index.php?monxin=index.user");}
		$module['send_url']="receive.php?target=".$method."&act=sendCheckCode";
		$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&act=reset&field=".$_GET['field'];
		$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
		$module['field_name']=self::$language['new_'.@$_GET['field']];
		echo '<div style="display:none;" id="visitor_position_append"><append>'.self::$language['get_password'].'</append></div>';
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);