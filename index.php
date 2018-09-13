<?php
/**
 *	网站数据展示入口页 示例 ./index.php?monxin=index.user (monxin=类名.方法名)
 */
libxml_disable_entity_loader(true); 
header('Content-Type:text/html;charset=utf-8');
header("Set-Cookie: hidden=value; httpOnly");
require_once './config/functions.php';
$config=require_once './config.php';
//===梦行商城店家二级域名跳转
$root_domain=str_replace('www.','',$config['web']['domain']);
if(strtolower($_SERVER['HTTP_HOST'])!='www.'.$root_domain && strtolower($_SERVER['HTTP_HOST'])!='m.'.$root_domain ){
	$dr=explode('.',$root_domain);
	if(is_match( '/^(.*)\.'.$dr[0].'\.'.@$dr[1].'$/',strtolower($_SERVER['HTTP_HOST']))){header('location:http://'.$config['web']['domain'].'/index.php?monxin=mall.shop_index&domain='.$_SERVER['HTTP_HOST']);exit;}
}

$_POST['diy_meta']=de_safe_str($config['web']['diy_meta']);
go_domain($config['web']['domain']);
$config['server_url']="http://www.monxin.com/";
$timeoffset=($config['other']['timeoffset']>0)? "-".$config['other']['timeoffset']:str_replace("-","+",$config['other']['timeoffset']);
date_default_timezone_set("Etc/GMT$timeoffset");
if(set_device()){setcookie("monxin_device",$_COOKIE['monxin_device'],time()+(3600*24*365));}

if(@$_GET['monxin_device']!=''){setcookie("monxin_device_set",$_COOKIE['monxin_device'],time()+(3600*24*365));}
if(@$_GET['circle']!=''){setcookie("circle",intval($_GET['circle']),time()+(3600*24*30));$_COOKIE['circle']=intval($_GET['circle']);}
if(!isset($_COOKIE['circle'])){
	if(isset($_COOKIE['user_set_circle'])){
		setcookie("circle",$_COOKIE['user_set_circle'],time()+(3600*24*30));$_COOKIE['circle']=$_COOKIE['user_set_circle'];
	}else{
		
		setcookie("circle",0,time()+(3600*24*30));$_COOKIE['circle']=0;	
	}	
}else{
	if($_COOKIE['circle']==0 && isset($_COOKIE['user_set_circle']) && $_COOKIE['user_set_circle']!=0 && !isset($_GET['circle'])){
		setcookie("circle",$_COOKIE['user_set_circle'],time()+(3600*24*30));$_COOKIE['circle']=$_COOKIE['user_set_circle'];
	}
}
$cache_path='./cache/'.$_COOKIE['monxin_device'].'/'.md5(get_url()).'_'.$_COOKIE['circle'];

$page=isset($_GET['monxin']) && !empty($_GET['monxin'])?$_GET['monxin']:'index.index';
$temp=explode('.',$page);
//$program=$temp[0];
$program='';
if(!is_file("./program/".$temp[0]."/pages.php")){exit('program not exist');}
$pages=require("./program/".$temp[0]."/pages.php");
//echo $page."<hr/>";	
$require_login=true;
if(@$pages[$page]['require_login']==0 && @$pages[$page]['not_cache']==0 ){$require_login=false;}else{$require_login=true;}
//var_dump($require_login);


//判断是否调用缓存
if($config['cache']['cache_switch'] && $require_login==false){
	//echo 'cache<hr>';
	if($config['cache']['cache_type']=='file'){
		$cache_file_time=@filemtime($cache_path)+$config['cache']['cache_time'];
		if($cache_file_time>time()){/*echo 'I am cache<br/>';*/echo file_get_contents($cache_path);exit();}
	}else{
		$php_extensions=get_loaded_extensions();
		if(in_array('memcache',$php_extensions)){
			@$memcache=new Memcache;
			@$memcache->connect($config['cache']['memcache_host'],$config['cache']['memcache_port']);
			@$c=$memcache->get($cache_path);
			@$memcache->close();
			if(!empty($c)){echo $c;exit;}
			}
	}	
}





$language=require './language/'.$config['web']['language'].'.php';
define("C_CLOSE",$language['close']);
//echo get_unixtime("2012-09-06","Y-m-d");
ob_start();

$_POST['bootstrap']['js']='';
$_POST['bootstrap']['init']='';

//echo 'page='.$page.'<br/>';
@require "./plugin/set_magic_quotes_gpc_off/set_magic_quotes_gpc_off.php";
require_once('page.class.php');
new page();
$c=ob_get_contents();
//判断是否生成缓存
if($config['cache']['cache_switch'] && $require_login==false){
	if($config['cache']['cache_type']=='file'){
		if(!file_put_contents($cache_path,$c)){
			require_once 'lib/Dir.class.php';
			$dir=new Dir();
			$dir->del_dir('./cache/'.$_COOKIE['monxin_device']);
			mkdir('./cache/'.$_COOKIE['monxin_device']);
			file_put_contents($cache_path,$c);
		}
	}else{
		if(in_array('memcache',$php_extensions)){
			$memcache=new Memcache;
			$memcache->connect("localhost",11211);
			$memcache->add($cache_path,$c,MEMCACHE_COMPRESSED,$config['cache']['cache_time']);
			//$memcache->set($cache_path,$c,MEMCACHE_COMPRESSED,$config['cache']['cache_time']);
			$memcache->close();
			}
	}	
}
	
@ob_end_clean();
echo $c;
?>