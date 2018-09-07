<?php
$order_id=intval(@$_GET['order_id']);
if($order_id==0){echo 'order_id null';return false;}
$goods_id=intval(@$_GET['goods_id']);
if($goods_id==0){echo 'goods_id null';return false;}

$sql="select * from ".self::$table_pre."order where `id`=".$order_id;
$r=$pdo->query($sql,2)->fetch(2);
if(@$r['id']==''){echo 'order_id err'; return false;}
if($r['buyer']!=$_SESSION['monxin']['username']){echo self::$language['inoperable'];return false;}
if((time()-$r['send_time'])/86400>self::$config['comment_time_limit']){echo str_replace('{v}',self::$config['comment_time_limit'],self::$language['comment_time_limit_alert']); return false;}

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&order_id=".$order_id."&goods_id=".$goods_id;

$sql="select * from ".self::$table_pre."comment where `order_id`='".$order_id."' and `goods_id`='".$goods_id."' and `buyer`='".$_SESSION['monxin']['username']."' limit 0,1";
$module['data']=$pdo->query($sql,2)->fetch(2);

//echo $sql;
if($module['data']['id']==''){$module['data']['id']=0;}

$sql="select `title` from ".self::$table_pre."order_goods where `order_id`='".$order_id."' and `goods_id`='".$goods_id."' limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
$module['data']['title']=$r['title'];
$module['data']=de_safe_str($module['data']);

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
