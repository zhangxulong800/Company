<?php
$is_shopowner=false;
self::$config['shop_template']='';
if(intval(@$_GET['shop_id'])==0 && isset($_SESSION['monxin']['username'])){
	$sql="select `id` from ".self::$table_pre."shop where `username`='".$_SESSION['monxin']['username']."' and `state`=2 order by `id` desc limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	$is_shopowner=true;
}
if(SHOP_ID==0){ header('location:./index.php'); return false;}

if(!$is_shopowner){
	$sql="select `name`,`username`,`template`,`".$_COOKIE['monxin_device']."_menu`,`phone_menu_show`,`state` from ".self::$table_pre."shop where `id`=".SHOP_ID;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['username']==@$_SESSION['monxin']['username']){$is_shopowner=true;}
	self::$config['shop_template']=$r['template'];	
	self::$config['shop_name']=$r['name'];	
	self::$config['shop_'.$_COOKIE['monxin_device'].'_menu']=$r[$_COOKIE['monxin_device'].'_menu'];	
}else{
	$sql="select `template`,`".$_COOKIE['monxin_device']."_menu`,`phone_menu_show`,`name`,`state` from ".self::$table_pre."shop where `id`=".SHOP_ID;
	$r=$pdo->query($sql,2)->fetch(2);
	self::$config['shop_template']=$r['template'];	
	self::$config['shop_'.$_COOKIE['monxin_device'].'_menu']=$r[$_COOKIE['monxin_device'].'_menu'];	
	self::$config['shop_name']=$r['name'];	
}
if($r['state']==''){echo '<div style="line-height:100px;text-align:center;font-size:30px; font-weight:bold;">'.self::$language['shop'].self::$language['not_exist'].'</div>';return false;}
if($r['state']!=2){echo '<div style="line-height:100px;text-align:center;font-size:30px; font-weight:bold;">'.self::$language['shop'].self::$language['shop_state'][$r['state']].'</div>';return false;}

$phone_menu_show=$r['phone_menu_show'];
if($is_shopowner){echo "<a href=# class=edit_mall_layout_button title=".self::$language['edit'].self::$language['this_page'].">&nbsp;</a>
<script>\$(document).ready(function(){\$('.edit_mall_layout_button').attr('href',window.location.href+'&edit_mall_layout=true');});</script>";}
$url=safe_str(@$_GET['monxin']);

$sql="select * from ".self::$table_pre."page where `shop_id`='".SHOP_ID."' and  url='".$url."' limit 0,1";
$v=$pdo->query($sql,2)->fetch(2);
if($v || isset($_GET['edit_page_malllayout_view_module'])){

if(self::$config['agency'] && $_GET['monxin']=='mall.goods' && isset($_GET['store_id'])){
	
	$v['layout']='full';
	$v['head']='';
	$v['bottom']='';
	$agency_css=file_get_contents('./program/mall/agency.css');
	echo $agency_css;
}

define("PAGE_LAYOUT", $v['layout']);

function get_shop_moudule($str,$pdo,$mall_layout_modules,$obj){
  
  $module=explode(",",$str);
  $module=array_filter($module);
  foreach($module as $v){
	  //echo $str;
	  $v2=explode(".",$v);
	  $args=get_match_single("/(\(.*\))/",$v2[1]);
	  $v2[1]=preg_replace("/(\(.*\))/",'',$v2[1]);
	  $temp=explode('diymodule_show_',$v2[1]);
	  if(count($temp)==2){$v2[1]='diymodule_show';$args=$temp[1];};
		  
	  $temp=explode('slider_show_',$v2[1]);
	  if(count($temp)==2){$v2[1]='slider_show';$args=$temp[1];};
	  
	  //$v2[1]=preg_replace('#(_[0-9]{1,})#','',$v2[1]);
	  
	  //echo $args.'<br />';
	  //var_dump($temp01);
	  $temp_v=preg_replace('#(_[0-9]{1,})#','',$v);
	  $temp_v=preg_replace("/(\(.*\))/",'',$temp_v);
	  //echo $temp_v.'<br>';
	  //if(!in_array($temp_v,$mall_layout_modules)){continue;}	
	  $temp=array('object'=>$obj,'method'=>$v2[1],'pdo'=>$pdo,'args'=>$args);
	  $modules[]=$temp;	
  }
  if(!isset($modules)){$modules=array();}
  return $modules;	
}
	
	$edit_page_layout=(@$_GET['edit_mall_layout']=='true')?true:false;
	$modules['head']=array();
	$modules['full']=array();
	$modules['left']=array();
	$modules['right']=array();
	$modules['bottom']=array();
	if($_COOKIE['monxin_device']=='phone'){				
		if($v['layout']=='right'){
			$v['full']=$v['right'];
		}elseif($v['layout']=='left'){
			$v['full']=$v['left'];
		}
		$v['head']='';$v['bottom']='';
		if($v['url']=='mall.shop_index' || $v['url']=='mall.shop_goods_list' || $v['url']=='mall.diypage_show'){
			/*
			$sql="select `id` from ".self::$table_pre."slider where `shop_id`=".SHOP_ID." and `for_device`='phone' limit 0,1";
			$temp=$pdo->query($sql,2)->fetch(2);
			if($temp['id']!=''){$v['head']='mall.slider_show_'.$temp['id'];}
			*/
			$v['head']='mall.head_phone';
			
			
		}
		if($v['phone']!=''){
			$v['full']=$v['phone'];
			$v['head']='';$v['bottom']='';
		}else{
			$v['full']=preg_replace('/mall\.slider_show_[0-9]*/i','',$v['full']);
		}
		if($edit_page_layout){$v['full']=$v['phone'];$v['head']='';$v['bottom']='';}
		$v['layout']='full';
	}
	if(isset($_GET['edit_page_malllayout_view_module'])){
		$v['head']='';
		$v['full']=preg_replace('/_/','.',$_GET['edit_page_malllayout_view_module'],1);
		//var_dump($v['full']);
		$v['layout']='full';
		$v['bottom']='';
	}
	//if($phone_menu_show && $_COOKIE['monxin_device']=='phone' && $v['url']!='mall.goods'){$v['bottom'].=',mall.menu';}
	//if($phone_menu_show && $_COOKIE['monxin_device']=='phone'){$v['bottom'].=',mall.menu';}
	require_once("./program/mall/mall.class.php");
	$obj=new mall($pdo);
	
	if(!empty($v['head'])){ $modules['head']=get_shop_moudule($v['head'],$pdo,self::$config['mall_layout_modules'],$obj);}
	if(!empty($v['bottom'])){$modules['bottom']=get_shop_moudule($v['bottom'],$pdo,self::$config['mall_layout_modules'],$obj);}
	if($v['layout']=='full'){
		if(!empty($v['full'])){$modules['full']=get_shop_moudule($v['full'],$pdo,self::$config['mall_layout_modules'],$obj);}
	}else{
		if(!empty($v['left'])){$modules['left']=get_shop_moudule($v['left'],$pdo,self::$config['mall_layout_modules'],$obj);}
		if(!empty($v['right'])){$modules['right']=get_shop_moudule($v['right'],$pdo,self::$config['mall_layout_modules'],$obj);}
	}
	$css_path="./templates/0/mall_shop/".self::$config['shop_template']."/".$_COOKIE['monxin_device']."/shop_main.css";
	
	if($edit_page_layout){
		require './program/mall/edit_layout_'.$v['layout'].'.php';
	}else{
		require './program/mall/layout_'.$v['layout'].'.php';
	}
	
}
