<?php
$module['module_name']=str_replace("::","_",$method);

$sql="select `money`,`credits` from ".$pdo->index_pre."user where `id`='".$_SESSION['monxin']['id']."'";
$r=$pdo->query($sql,2)->fetch(2);
$module['user_money']=$r['money'];
$module['credits']=$r['credits'];

$sql="select `id` from ".$pdo->index_pre."user_login where `userid`=".$_SESSION['monxin']['id']." order by `id` desc limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']==''){$r['id']=0;}
$sql="select * from ".$pdo->index_pre."user_login where `userid`=".$_SESSION['monxin']['id']." and `id`<".$r['id']." order by `id` desc limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
$module['last_login_time']=get_time(self::$config['other']['date_style'].' H:i',self::$config['other']['timeoffset']." H:i",self::$language,$r['time']);
$module['last_login_position']=$r['position'];

$sql="select count(id) as c from ".$pdo->index_pre."site_msg where `addressee_state`=1 and `addressee`='".$_SESSION['monxin']['username']."'";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']>0){$module['unread_site_msg']=$r['c'];}else{$module['unread_site_msg']=0;}


$sql="select sum(`money`) as c from ".$pdo->index_pre."recharge where `username`='".$_SESSION['monxin']['username']."' and `state`=4";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['recharge']=$r['c'];

$sql="select sum(`money`) as c from ".$pdo->index_pre."withdraw where `username`='".$_SESSION['monxin']['username']."' and `state`=3";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['withdraw']=$r['c'];


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);