<?php
$module['module_name']=str_replace("::","_",$method);

$sql="select count(id) as c from ".self::$table_pre."msg";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['sum']=$r['c'];

$sql="select count(id) as c from ".self::$table_pre."msg where `state`=0";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['sum_0']=$r['c'];

$sql="select count(id) as c from ".self::$table_pre."msg where `state`=1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['sum_1']=$r['c'];

$sql="select count(id) as c from ".self::$table_pre."msg where `answer`!=''";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['sum_2']=$r['c'];

$sql="select count(id) as c from ".self::$table_pre."msg where `answer`=''";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['sum_3']=$r['c'];



$sql="select `time`,`sender` from ".self::$table_pre."msg order by `id` desc limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
$module['time']=get_time(self::$config['other']['date_style'].' H:i',self::$config['other']['timeoffset']." H:i",self::$language,$r['time']);
$module['sender']=$r['sender'];

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);