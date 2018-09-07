<?php
$id=intval(@$_GET['id']);
if($id==0){return not_find();}
if(!isset($_GET['type']) || $_GET['type']==''){echo '<div style="line-height:500px; text-align:center;"><a type="button" class="btn btn-primary" href=./index.php?monxin=mall.coupon_push&id='.$id.'&type=group>'.self::$language['push_group'].'</a> <a  type="button" class="btn btn-success" href=./index.php?monxin=mall.coupon_push&id='.$id.'&type=username>'.self::$language['push_username'].'</a></div>';return false;}

$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&id=".$id."&type=".$_GET['type'];
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$sql="select `name`,`sum_quantity`,`draws` from ".self::$table_pre."coupon where `id`=".$id." and `shop_id`=".SHOP_ID;
$r=$pdo->query($sql,2)->fetch(2);
if($r['name']==''){echo 'id err';return false;}
$module['name']=self::$language['pages']['mall.coupon_push']['name'].': '.$r['name'].'('.($r['sum_quantity']-$r['draws']).self::$language['sheet'].self::$language['available'].')';

$sql="select * from ".self::$table_pre."shop_buyer_group where `shop_id`=".SHOP_ID." order by `credits` asc";
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$v=de_safe_str($v);
	
	$sql="select count(id) as c from ".self::$table_pre."shop_buyer where `group_id`=".$v['id'];
	$r2=$pdo->query($sql,2)->fetch(2);
	
	$list.="<option value=".$v['id'].">".$v['name']."(".$r2['c'].")</option>";	
}
$module['list']=$list;
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);