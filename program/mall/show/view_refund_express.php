<?php
$id=intval(@$_GET['id']);
if($id==0){echo 'id err';return false;}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token']['mall::order_admin']=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token']['mall::order_admin']."&target=mall::order_admin&act=confirm_refund&id=".$id;
$module['cancel_option']='';
foreach(self::$language['order_return_option'] as $v){
	$module['cancel_option'].='<option value="'.$v.'">'.$v.'</option>';	
}
$sql="select `express_voucher`,`shop_id`,`id` from ".self::$table_pre."order where `id`=".$id;
$r=$pdo->query($sql,2)->fetch(2);
$r=de_safe_str($r);
if(@$r['id']==''){echo self::$language['inoperable']; return false;}
if($r['shop_id']!=SHOP_ID){echo self::$language['inoperable'].'df'; return false;}
if($r['express_voucher']!=''){
	$module['express_voucher']='<a href="./program/mall/img/'.$r['express_voucher'].'" target="_blank"><img class=voucher_img src="./program/mall/img/'.$r['express_voucher'].'" /></a>';
}else{
	$module['express_voucher']=self::$language['no_refund_voucher'];
}


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
