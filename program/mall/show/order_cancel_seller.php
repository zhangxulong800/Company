<?php
$id=intval(@$_GET['id']);
if($id==0){echo 'id err';return false;}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
if(!in_array('mall.order_admin',$_SESSION['monxin']['page'])){
	$_SESSION['token']['mall::stocking_order']=get_random(8);
	$module['action_url']="receive.php?token=".$_SESSION['token']['mall::stocking_order']."&target=mall::stocking_order&act=cancel&id=".$id;
}else{
	$_SESSION['token']['mall::order_admin']=get_random(8);
	$module['action_url']="receive.php?token=".$_SESSION['token']['mall::order_admin']."&target=mall::order_admin&act=cancel&id=".$id;
}

$module['cancel_option']='';
foreach(self::$language['order_cancel_seller_option'] as $v){
	$module['cancel_option'].='<option value="'.$v.'">'.$v.'</option>';	
}

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);