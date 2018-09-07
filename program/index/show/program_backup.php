<?php

$program=@$_GET['program'];
if(program_permissions(self::$config,self::$language,$program,'./program/'.$program.'/')==false){
	echo(self::$language['illegal_use']);return false;	
}
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&program=".$program;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$config=require('./program/'.$program.'/config.php');
$language=require('./program/'.$program.'/language/'.$config['program']['language'].'.php');

echo ' <div id="user_position_reset" style="display:none;"><a href="index.php"><span id=user_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a><a href="index.php?monxin=index.user">'.self::$language['user_center'].'</a><a href="index.php?monxin=index.program_config">'.self::$language['program'].self::$language['admin'].'</a><span class=text>'.$language['program_name'].' '.self::$language['backup'].'</span></div>';	


		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
