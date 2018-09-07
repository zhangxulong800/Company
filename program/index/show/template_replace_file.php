<?php
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$path=@$_GET['path'];
$path=trim($path,'/');
$path=trim($path,'.');

if(!is_file('./templates/'.$path)){echo(self::$language['not_exist_file']);return false;}

$module['path']=$path;
$postfix=strtolower(get_file_postfix($path));
$img_type=array('jpg','jpeg','gif','png',);
$temp=explode('/',$path);
if(in_array($postfix,$img_type)){
	$module['file']='<div ><a href="./templates/'.$path.'" class=name>'.$temp[count($temp)-1].'</a><span class=size>'.formatSize(filesize('./templates/'.$path)).'</span><span class=time>'.get_time(self::$config['other']['date_style'].' H:i',self::$config['other']['timeoffset'],self::$language,filemtime('./templates/'.$path)).'</span> <br /><a href="./templates/'.$path.'"><img src=./templates/'.$path.'?refresh='.time().' border=0></a></div>';	
}else{
	
	$module['file']='<div ><a href="./templates/'.$path.'" class=name>'.$temp[count($temp)-1].'</a><span class=size>'.formatSize(filesize('./templates/'.$path)).'</span><span class=time>'.get_time(self::$config['other']['date_style'].' H:i',self::$config['other']['timeoffset'],self::$language,filemtime('./templates/'.$path)).'</span></div>';	
}
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
