<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;

$sql="select * from ".$pdo->sys_pre."article_article_type where `visible`=1";
//echo $sql;
$r=$pdo->query($sql,2);
$module['article_type']='';
foreach($r as $v){
	$module['article_type'].='<option value='.$v['id'].'>'.de_safe_str($v['name']).'</option>';
}

$sql="select * from ".$pdo->sys_pre."menu_menu where `visible`=1 and `parent_id`=0";
$r=$pdo->query($sql,2);
$module['menu_type']='';
foreach($r as $v){
	$module['menu_type'].='<option value='.$v['id'].'>'.de_safe_str($v['name']).'</option>';
}

$module['invoking_article_type_set']=self::$config['invoking_article_type'];
$module['invoking_menu_type_set']=self::$config['invoking_menu_type'];

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
