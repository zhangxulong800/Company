<?php

$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$sql="select * from ".self::$table_pre."discount where `shop_id`=".SHOP_ID;
$module['data']=$pdo->query($sql,2)->fetch(2);
if($module['data']['id']==''){
	$module['data']['rate']='';
	$module['data']['start_time']='';
	$module['data']['end_time']='';
}else{
	$module['data']['start_time']=get_date($module['data']['start_time'],self::$config['other']['date_style']." H:i:s",self::$config['other']['timeoffset']);
	$module['data']['end_time']=get_date($module['data']['end_time'],self::$config['other']['date_style']." H:i:s",self::$config['other']['timeoffset']);
}
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
