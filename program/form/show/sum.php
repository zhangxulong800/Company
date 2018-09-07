<?php
$module['module_name']=str_replace("::","_",$method);

$sql="select count(id) as c from ".self::$table_pre."table";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['table']=$r['c'];

$sql="select `id`,`name`,`description` from ".self::$table_pre."table order by `id` desc limit 0,6";
$r=$pdo->query($sql,2);
$module['top']='';
foreach($r as $v){
	$v=de_safe_str($v);
	$sql="select count(id) as c from ".self::$table_pre.$v['name'];
	$r2=$pdo->query($sql,2)->fetch(2);
	if($r2['c']==''){$r2['c']=0;}
	
	$sql="select count(visit) as c from ".self::$table_pre.$v['name'];
	$r3=$pdo->query($sql,2)->fetch(2);
	if($r3['c']==''){$r3['c']=0;}
	$module['top'].='<div><a href="./index.php?monxin=form.data_admin&table_id='.$v['id'].'" target=_blank>'.$v['description'].'</a><span>'.$r2['c'].'/'.$r3['c'].'</span></div>';	
}


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);