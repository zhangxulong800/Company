<?php
$shop_id=intval(@$_GET['shop_id']);
if($shop_id==0){echo 'shop_id err';return false;}

$sql="select `name` from ".self::$table_pre."shop  where `id`=".$shop_id;
$r=$pdo->query($sql,2)->fetch(2);
if($r['name']==''){echo 'shop_id err';return false;}
$module['shop_name']=$r['name'];

$sql="select `transaction_password` from ".$pdo->index_pre."user where `username`='".$_SESSION['monxin']['username']."'";
$r=$pdo->query($sql,2)->fetch(2);
if($r['transaction_password']==''){echo ("<script>window.location.href='index.php?monxin=index.edit_user&field=transaction_password'</script>");return false;}

$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&shop_id=".$shop_id;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);



$sql="select `balance` from ".self::$table_pre."shop_buyer where `username`='".$_SESSION['monxin']['username']."'";
$r=$pdo->query($sql,2)->fetch(2);
$module['user_money']=$r['balance'];

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
		
