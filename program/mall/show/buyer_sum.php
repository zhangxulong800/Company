<?php
$module['module_name']=str_replace("::","_",$method);

$mall_cart=json_decode(@$_COOKIE['mall_cart'],true);
$module['cart']=count($mall_cart);


$sql="select count(`id`) as c from ".self::$table_pre."favorite where `username`='".$_SESSION['monxin']['username']."'";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['favorite']=$r['c'];

$sql="select count(`id`) as c from ".self::$table_pre."visit where `username`='".$_SESSION['monxin']['username']."'";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['visit']=$r['c'];

$sql="select count(`id`) as c from ".self::$table_pre."order where `buyer`='".$_SESSION['monxin']['username']."' and `state`=0";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['order_0']=$r['c'];

$sql="select count(`id`) as c from ".self::$table_pre."order where `buyer`='".$_SESSION['monxin']['username']."' and `state`=1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['order_1']=$r['c'];

$sql="select count(`id`) as c from ".self::$table_pre."order where `buyer`='".$_SESSION['monxin']['username']."' and `state`=2";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['order_2']=$r['c'];

$sql="select count(`id`) as c from ".self::$table_pre."order where `buyer`='".$_SESSION['monxin']['username']."' and `state`=6";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['order_6']=$r['c'];

$sql="select count(`id`) as c from ".self::$table_pre."my_coupon where `username`='".$_SESSION['monxin']['username']."' and `use_time`=0";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['coupon_usable']=$r['c'];

$sql="select `detail` from ".self::$table_pre."receiver where `username`='".$_SESSION['monxin']['username']."' order by `sequence` desc limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['detail']!=''){
	$module['receiver']=de_safe_str($r['detail']);
}else{
	$module['receiver']='';
}


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);