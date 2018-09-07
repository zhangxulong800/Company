<?php
$id=intval(@$_GET['id']);
if($id==0){echo 'id err';return false;}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&id=".$id;

$sql="select * from ".self::$table_pre."goods where `id`='".$id."' limit 0,1";
$module['data']=$pdo->query($sql,2)->fetch(2);
if($module['data']['id']==''){echo 'id err';return false;}
$module['data']=de_safe_str($module['data']);
$module['data']['type']=self::$language['bargain_type_option'][$module['data']['type']];
$module['data']['method']=self::$language['method_option'][$module['data']['method']];
$module['data']['new']=self::$language['new_option'][$module['data']['new']];

$module['data']['goods_price']=self::get_goods_price($pdo,$module['data']['g_id']);

foreach($module['data'] as $k=>$v){
	if($v=='0'){$module['data'][$k]='';}
}

	$module['data']['start_time']=get_date($module['data']['start_time'],self::$config['other']['date_style'],self::$config['other']['timeoffset']);
	$module['data']['end_time']=get_date($module['data']['end_time'],self::$config['other']['date_style'],self::$config['other']['timeoffset']);



$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);