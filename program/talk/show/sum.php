<?php
$module['module_name']=str_replace("::","_",$method);

$sql="select count(id) as c from ".self::$table_pre."title";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['title']=$r['c'];

$sql="select count(id) as c from ".self::$table_pre."content where `for`=0";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['answer']=$r['c'];

$sql="select count(id) as c from ".self::$table_pre."content where `for`!=0";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['comment']=$r['c'];


$sql="select `id`,`title`,`visit`,`contents` from ".self::$table_pre."title order by `id` desc limit 0,4";
$r=$pdo->query($sql,2);
$module['top']='';
foreach($r as $v){
	$v=de_safe_str($v);
	$module['top'].='<div><a href="./index.php?monxin=talk.content&id='.$v['id'].'" target=_blank>'.$v['title'].'</a><span>'.$v['contents'].'/'.$v['visit'].'</span></div>';	
}


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);