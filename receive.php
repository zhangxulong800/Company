<?php
/**
 *	网站数据接收 入口页 示例 ./receive.php?target=index::reg_user (target=类名::方法名)
 */
ob_start();
libxml_disable_entity_loader(true);
header('Content-Type:text/html;charset=utf-8');
require_once './config/functions.php';
session_start();
$_POST=monxin_trim($_POST);
$_GET=monxin_trim($_GET);

$config=require_once './config.php';
go_domain($config['web']['domain']);
$config['server_url']="http://www.monxin.com/";
$timeoffset=($config['other']['timeoffset']>0)? "-".$config['other']['timeoffset']:str_replace("-","+",$config['other']['timeoffset']);
date_default_timezone_set("Etc/GMT$timeoffset");
$language=require_once './language/'.$config['web']['language'].'.php';
$pdo=new  ConnectPDO();
update_user_last($pdo);
$_GET['target']=str_replace('.','::',@$_GET['target']);
$target=$_GET['target'];
$target=explode("::",$target);
$program=$target[0];
if(!isset($_SESSION['monxin']['function'])){
	if(!in_array($target[0].'.'.$target[1],$config['unlogin_function_power'])){exit($language['act_noPower']);}
}else{
	if(!in_array($target[0].'.'.$target[1],$config['unlogin_function_power']) && !in_array($target[0].'.'.$target[1],$_SESSION['monxin']['function'])){exit($language['act_noPower']);}	
}
if(!in_array($target[0].'.'.$target[1],$config['unlogin_function_power'])){
	$no_token=array('index::edit_page_layout','mall::edit_page_layout','trip::edit_page_layout','index::user','copy::file');
	if(!in_array($target[0].'::'.$target[1],$no_token) && @$_GET['act']!='update_img'){
		if(@$_GET['token']==''){exit("{'state':'fail','info':'<span class=fail>token null</span>'}");}
		if($_GET['token']!=@$_SESSION['token'][$target[0].'::'.$target[1]]){exit("{'state':'fail','info':'<span class=fail>token err</span>'}");}
	}
	
}

require "./program/{$target[0]}/receive.class.php";
$receive=new receive($pdo);
$receive->$target[1]($pdo);
?>