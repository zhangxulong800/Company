<?php
$module['module_name']=str_replace("::","_",$method);

$sql="select count(id) as c ,sum(`visit`) as s_visit from ".self::$table_pre."content";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
if($r['s_visit']==''){$r['s_visit']=0;}
$module['sum']=$r['c'];
$module['s_visit']=$r['s_visit'];

$sql="select count(id) as c from ".self::$table_pre."content where `state`=0";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['state_0']=$r['c'];

$sql="select count(id) as c from ".self::$table_pre."content group by `username`";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['usernames']=$r['c'];

$sql="select sum(money) as c from ".$pdo->index_pre."money_log where `program`='ci'";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['money']=-$r['c'];

$sql="select sum(`sum`) as c from ".self::$table_pre."search_log";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['search_sum']=$r['c'];


$sql="select `last_time`,`username` from ".self::$table_pre."content order by `last_time` desc limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
$module['last_edit']=get_time(self::$config['other']['date_style'].' H:i',self::$config['other']['timeoffset']." H:i",self::$language,$r['last_time']);
$module['last_username']=$r['username'];


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);