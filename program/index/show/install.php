<?php
		$module['install_url']="receive.php?target=".$method;
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
		
		require "./plugin/html5Upfile/createHtml5.class.php";
		$html5Upfile=new createHtml5();
		echo "<span id='zip_file_ele'>";			   
		$html5Upfile->echo_input("zip",'500px','','./index/install_file/','false','true','zip',1024*get_upload_max_size(),'5');
		echo '</span>';