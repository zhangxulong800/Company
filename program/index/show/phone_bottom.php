<?php
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;

if(self::$config['web']['phone_show_monxin_bottom']){$module['phone_show_monxin_bottom']=1;}else{$module['phone_show_monxin_bottom']=0;}
if(self::$config['web']['request_geolocation'] && !isset($_SESSION['monxin']['geo']) && isset($_SESSION['monxin']['username'])){$module['request_geolocation']=1;}else{$module['request_geolocation']=0;}


$module['data']=file_get_contents('./program/index/phone_bottom_data.txt');
$module['search_url']=self::$config['web']['search_url'];
$module['search_placeholder']=self::$config['web']['search_placeholder'];
$module['gps_x']=self::$config['web']['gps_x'];
$module['gps_y']=self::$config['web']['gps_y'];

if(self::$config['web']['circle']){
	if($_COOKIE['circle']>0){
		$sql="select `name` from ".$pdo->index_pre."circle where `id`=".intval($_COOKIE['circle']);
		$r=$pdo->query($sql,2)->fetch(2);
		$circle_name=de_safe_str($r['name']);
	}else{
		$circle_name=self::$language['location'];
	}
	$module['search_left']='<a href=index.php?monxin=index.circle class=go_circle>'.$circle_name.'</a>';
}else{
	$module['search_left']='<img src=./phone_logo.png />';
}

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
