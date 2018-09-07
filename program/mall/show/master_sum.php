<?php
$module['module_name']=str_replace("::","_",$method);


$sql="select sum(`actual_money`) as c from ".self::$table_pre."order where  `state` in (1,2,6)";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['turnover']=$r['c'];

$time=time();
$today=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);
$time=get_unixtime($today,'y-m-d')-86400;
$yesterday=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);

$start_time=get_unixtime($today,self::$config['other']['date_style']);
$end_time=get_unixtime($today,self::$config['other']['date_style'])+86400;
$time_limit=" `add_time`>$start_time and `add_time`<$end_time ";

$sql="select sum(actual_money) as c from ".self::$table_pre."order where ".$time_limit." and `state` in (1,2,6)";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['today_turnover']=$r['c'];

$start_time=get_unixtime($yesterday,self::$config['other']['date_style']);
$end_time=get_unixtime($yesterday,self::$config['other']['date_style'])+86400;
$time_limit=" `add_time`>$start_time and `add_time`<$end_time ";

$sql="select sum(actual_money) as c from ".self::$table_pre."order where ".$time_limit." and `state` in (1,2,6)";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['yesterday_turnover']=$r['c'];

$sql="select count(`id`) as c from ".self::$table_pre."shop where `state`=0";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['shop']=$r['c'];

$sql="select count(`id`) as c from ".self::$table_pre."order where `state` in (1,2,6)";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['order_6']=$r['c'];

$sql="select count(`id`) as c from ".self::$table_pre."goods";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['goods']=$r['c'];

$sql="select count(`id`) as c from ".self::$table_pre."comment";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['comment']=$r['c'];



$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);