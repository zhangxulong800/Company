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
		$r=file_get_contents('http://api.map.baidu.com/location/ip?ak='.self::$config['web']['map_secret'].'&ip='.$ip.'&coor=bd09ll');
		$r=(json_decode($r,1));
		if(isset($r['content']['point'])){
			$geo=$r['content']['point']['y'].','.$r['content']['point']['x'];
			$sql="insert into ".$pdo->index_pre."ip_latlng (`ip`,`latlng`,`time`) values ('".$ip."','".$geo."','".time()."')";
			$pdo->exec($sql);
		}
	}
}
if(!isset($geo)){$geo='39.923789,116.401394';}
$module['my_latlng']=@$geo;


$temp=explode(',',$geo);

$module['point']=$temp[1].','.$temp[0];
$module['zoom']=10;
foreach(self::$config['map_zoom_geo'] as $k=>$v){if($v==self::$config['near_default']){$module['zoom']=$k;}}

$module['circle_list']='';
$module['circle_list_sub']='';
$sql="select `id`,`name` from ".$pdo->index_pre."circle where `parent_id`=0 and `visible`=1 order by `sequence` desc,`id` asc";
$r=$pdo->query($sql,2);
$module['circle_list']='<a href="#" circle=0>'.self::$language['unlimited'].'</a>';
foreach($r as $v){
	$sub='';
	$sql="select `id`,`name` from ".$pdo->index_pre."circle where `parent_id`='".$v['id']."' and `visible`=1 order by `sequence` desc,`id` asc";
	$r2=$pdo->query($sql,2);
	foreach($r2 as $v2){
		$sub.='<a href="#" circle='.$v2['id'].'>'.de_safe_str($v2['name']).'</a>';	
	}
	if($sub!=''){$sub='<div upid='.$v['id'].' >'.$sub.'</div>';}
	$module['circle_list_sub'].=$sub;
	$module['circle_list'].='<a href="#"  circle='.$v['id'].'>'.de_safe_str($v['name']).'</a>';
}

$module['tag']='<a href="#" tag=0>'.self::$language['unlimited'].'</a>';
$sql="select `name`,`id` from ".self::$table_pre."store_tag order by `sequence` desc,`id` asc";
$r=$pdo->query($sql,2);
foreach($r as $v){
	$v['name']=de_safe_str($v['name']);
	$module['tag'].='<a href=# tag='.$v['id'].'>'.$v['name'].'</a>';	
}

$module['near_option']='';
foreach(self::$language['near_option'] as $k=>$v){
	$module['near_option'].='<a href="#" near="'.$k.'">'.$v.'</a>';	
}
$module['near_default']=self::$config['near_default'];

$module['gps_x']=self::$config['web']['gps_x'];
$module['gps_y']=self::$config['web']['gps_y'];
$module['map_secret']=self::$config['web']['map_secret'];

if(@$_GET['near']==100){
	$module['list']=file_get_contents('./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/shop_map.php');
}

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'_'.self::$config['web']['map_api'].'.php';
require($t_path);
echo '<div style="display:none;" id="visitor_position_append">'.self::$language['pages']['mall.shop_list']['name'].'</div>';

