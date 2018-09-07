<?php
$module['module_name']=str_replace("::","_",$method);

$sql="select count(id) as c from ".self::$table_pre."account where `username`='".$_SESSION['monxin']['username']."'";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['sum']=$r['c'];

$sql="select `wid` from ".self::$table_pre."account where `username`='".$_SESSION['monxin']['username']."'";
$r=$pdo->query($sql,2);
$wid='';
$to='';
foreach($r as $v){
	$wid.="`wid`='".$v['wid']."' or ";	
	$to.="`to`='".$v['wid']."' or ";	
}
$wid=trim($wid,'or ');
$to=trim($to,'or ');
$sql="select sum(visit) as c from ".self::$table_pre."auto_answer";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['visit']=$r['c'];

$sql="select count(id) as c from ".self::$table_pre."user";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['user']=$r['c'];

$sql="select count(id) as c from ".self::$table_pre."dialog";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['dialog']=$r['c'];




$sql="select `time` from ".self::$table_pre."dialog order by `time` desc limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
$module['last_edit']=get_time(self::$config['other']['date_style'].' H:i',self::$config['other']['timeoffset']." H:i",self::$language,$r['time']);


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);