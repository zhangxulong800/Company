<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;

$sql="select `id`,`title`,`time` from ".$pdo->sys_pre."article_article where `type`=".intval(self::$config['invoking_article_type'])." and `visible`=1  order by `sequence` desc,`id` desc limit 0,10";
$r=$pdo->query($sql,2);
$module['article']='';
foreach($r as $v){
	$module['article'].='<li><a href=./index.php?monxin=article.show&id='.$v['id'].'>'.de_safe_str($v['title']).'</a></li>';
}

$sql="select `id`,`name`,`url` from ".$pdo->sys_pre."menu_menu where `parent_id`=".intval(self::$config['invoking_menu_type'])." and `visible`=1  order by `sequence` desc,`id` desc limit 0,6";
$r=$pdo->query($sql,2);
$module['menu']='';
foreach($r as $v){
	$v=de_safe_str($v);
	$module['menu'].='<a href='.$v['url'].'><img src=./program/menu/icon/'.$v['id'].'.png><span>'.$v['name'].'</span></a>';
}

$module['welcome_to_come']=self::$language['welcome_to_come'].self::$config['web']['name'];

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
