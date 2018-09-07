<?php
$_SESSION['token'][$method]='123';$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);


if(!isset($_GET['geo'])){
	if(isset($_SESSION['monxin']['id'])){
		$sql="select `geolocation` from ".$pdo->index_pre."user where `id`=".$_SESSION['monxin']['id'];
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['geolocation']!=''){
			$temp=explode(',',$r['geolocation']);
			$geo=$temp[0].','.$temp[1];
		}
	}
}else{
	$geo=safe_str($_GET['geo']);
}
if(!isset($geo)){
	$ip=get_ip();
	$sql="select `latlng` from ".$pdo->index_pre."ip_latlng where `ip`='".$ip."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['latlng']!=''){
		$geo=$r['latlng'];
	}else{
		$r=file_get_contents('http://api.map.baidu.com/location/ip?ak='.self::$config['web']['map_secret'].'&ip=&'.$ip.'&coor=bd09ll');
		$r=(json_decode($r,1));
		if(isset($r['content']['point'])){
			$geo=$r['content']['point']['y'].','.$r['content']['point']['x'];
			$sql="insert into ".$pdo->index_pre."ip_latlng (`ip`,`latlng`,`time`) values ('".$ip."','".$geo."','".time()."')";
			$pdo->exec($sql);
		}
	}
}
$module['my_latlng']=$geo;
$temp=explode(',',$geo);

$module['point']=$temp[1].','.$temp[0];
$module['zoom']=10;

$module['gps_x']=self::$config['web']['gps_x'];
$module['gps_y']=self::$config['web']['gps_y'];
$module['map_secret']=self::$config['web']['map_secret'];

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);

