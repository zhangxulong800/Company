<?php
$stocktake_id=intval($_GET['stocktake_id']);
if($stocktake_id==0){echo 'stocktake_id err';return false;}
$sql="select * from ".self::$table_pre."stocktake where `id`=".$stocktake_id;
$stocktake=$pdo->query($sql,2)->fetch(2);
if($stocktake['id']==''){echo 'stocktake_id err';return false;}
if($stocktake['shop_id']!=SHOP_ID){echo 'shop_id err';return false;}
$module['s_name']=de_safe_str($stocktake['name']);
if($stocktake['state']==1){echo self::$language['stocktake_end'].self::$language['inoperable'];return false;}

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&stocktake_id='.$stocktake_id;


$module['data']['inventory']=self::format_quantity(@$module['data']['inventory']);


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);