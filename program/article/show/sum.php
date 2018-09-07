<?php
$module['module_name']=str_replace("::","_",$method);

$sql="select sum(`visit`) as c from ".self::$table_pre."article";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['visit']=$r['c'];
$module['visit_remark']=self::$language['program_name'].' '.self::$language['sum_visit'];
$sql="select count(`id`) as c from ".self::$table_pre."article";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['content_sum']=$r['c'];

$sql="select `time` from ".self::$table_pre."article order by `time` desc limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
$module['last_edit']=get_time(self::$config['other']['date_style'].' H:i',self::$config['other']['timeoffset']." H:i",self::$language,$r['time']);

$sql="select `id`,`title`,`visit` from ".self::$table_pre."article order by `visit` desc limit 0,4";
$r=$pdo->query($sql,2);
$module['top']='';
foreach($r as $v){
	$v=de_safe_str($v);
	$module['top'].='<div><a href="./index.php?monxin=article.show&id='.$v['id'].'" target=_blank>'.$v['title'].'</a><span>'.$v['visit'].'</span></div>';	
}


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);