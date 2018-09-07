<?php
if(SHOP_ID==0){echo self::$language['forbidden_modify'];return false;}
$sql="select * from ".self::$table_pre."express_consignor where `shop_id`=".SHOP_ID." limit 0,1";
$module=$pdo->query($sql,2)->fetch(2);
if($module['id']==''){
	$sql="insert into ".self::$table_pre."express_consignor (`shop_id`) values ('".SHOP_ID."')";
	$pdo->exec($sql);
	$sql="select * from ".self::$table_pre."express_consignor where `shop_id`=".SHOP_ID." limit 0,1";
	$module=$pdo->query($sql,2)->fetch(2);
	
}
$module=de_safe_str($module);

$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);




$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
