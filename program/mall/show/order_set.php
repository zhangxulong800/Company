<?php
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['ad_fees']=self::$config['ad_fees'];
$sql="select * from ".self::$table_pre."shop_order_set where `shop_id`=".SHOP_ID;
$module['config']=$pdo->query($sql,2)->fetch(2);
$module['print_supplier_option']='';
foreach(self::$language['print_supplier_array'] as $k=>$v){
	$module['print_supplier_option'].='<option value="'.$k.'">'.$v.'</option>';
}

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
