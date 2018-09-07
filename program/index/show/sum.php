<?php
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;

$sql="select count(`id`) as c from ".$pdo->index_pre."user";
$r=$pdo->query($sql,2)->fetch(2);
$module['user']=$r['c'];

$sql="select `money`,`credits` from ".$pdo->index_pre."user";
$r=$pdo->query($sql,2)->fetch(2);
$module['user_money']=$r['money'];
$module['credits']=$r['credits'];

$module['click_sum']='请另装统计代码';
$sql="select `id` from ".$pdo->index_pre."user_login where `userid`=".$_SESSION['monxin']['id']." order by `id` desc limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']==''){$r['id']=0;}
$sql="select * from ".$pdo->index_pre."user_login where `userid`=".$_SESSION['monxin']['id']." and `id`<".$r['id']." order by `id` desc limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
$module['last_login_time']=get_time(self::$config['other']['date_style'].' H:i',self::$config['other']['timeoffset']." H:i",self::$language,$r['time']);
$module['last_login_position']=$r['position'];

$sql="select count(id) as c from ".$pdo->index_pre."site_msg";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']>0){$module['site_msg']=$r['c'];}else{$module['site_msg']=0;}


$sql="select sum(`money`) as c from ".$pdo->index_pre."recharge where `state`=4";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['recharge']=$r['c'];

$sql="select sum(`money`) as c from ".$pdo->index_pre."withdraw where `state`=1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['withdraw']=$r['c'];


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);