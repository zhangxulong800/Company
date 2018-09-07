<?php
$module['module_name']=str_replace("::","_",$method);

$sql="select count(id) as c from ".self::$table_pre."regular";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['regular']=$r['c'];

$sql="select `id`,`name` from ".self::$table_pre."regular order by `list_update_cycle` asc limit 0,6";
$r=$pdo->query($sql,2);
$module['top']='';
foreach($r as $v){
	$v=de_safe_str($v);
	$sql="select count(id) as c from ".self::$table_pre."task where `regular_id`=".$v['id']." and `state`=0";
	$r2=$pdo->query($sql,2)->fetch(2);
	if($r2['c']==''){$r2['c']=0;}
	
	$sql="select count(id) as c from ".self::$table_pre."task where `regular_id`=".$v['id']." and `state`=1";
	$r3=$pdo->query($sql,2)->fetch(2);
	if($r3['c']==''){$r3['c']=0;}
	$module['top'].='<div><a href="./index.php?monxin=copy.task_list&id='.$v['id'].'" target=_blank>'.$v['name'].'</a><span>'.$r2['c'].'/'.$r3['c'].'</span></div>';	
}


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);