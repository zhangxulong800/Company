<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
if(!isset($_GET['show_time'])){header('location:./index.php?monxin=mall.interest_user_detail&show_time=day');exit;}
$username=safe_str(@$_GET['username']);
$module['days']='<a href="./index.php?monxin=mall.interest_user_detail&show_time=day&username='.$username.'" data="day">'.self::$language['this_day'].'</a>';
$module['days'].='<a href="./index.php?monxin=mall.interest_user_detail&show_time=week&username='.$username.'" data="week">'.self::$language['this_week'].'</a>';
$module['days'].='<a href="./index.php?monxin=mall.interest_user_detail&show_time=month&username='.$username.'" data="month">'.self::$language['this_month'].'</a>';
$module['days'].='<a href="./index.php?monxin=mall.interest_user_detail&show_time=year&username='.$username.'" data="year">'.self::$language['this_year'].'</a>';


$show_time=safe_str($_GET['show_time']);
if($show_time==''){$show_time='day';}

$where='';


$sql="select `group_id`,`frequency` from ".self::$table_pre."interest_group_user where `username`='".$username."'  order by `frequency` desc ";
$r=$pdo->query($sql,2);
$module['group']='';
$i=1;
$module['sum']=0;
//echo $sql;
foreach($r as $v){
	$sql="select `name` from ".self::$table_pre."interest_group where `id`=".$v['group_id'];
	$g=$pdo->query($sql,2)->fetch(2);
	
	$module['group'].="{value:".$v['frequency'].",name:'".$g['name']."'},";	
	
	$module['sum']+=$v['frequency'];
	
	$i++;
}
$module['group']=trim($module['group'],',');


$sql="select `word_id`,`frequency` from ".self::$table_pre."interest_word_user where `username`='".$username."' order by `frequency` desc  limit 0,100";
$r=$pdo->query($sql,2);
$module['word_name']='';
$module['word_value']='';
$i=1;
$modult['sum']=0;
foreach($r as $v){
	$sql="select `name` from ".self::$table_pre."interest_word where `id`=".$v['word_id'];
	$word=$pdo->query($sql,2)->fetch(2);
	
	$module['word_name']="'".$word['name']."',".$module['word_name'];	
	$module['word_value']=$v['frequency'].",".$module['word_value'];	
	$i++;
}
$module['word_name']=trim($module['word_name'],',');
$module['word_value']=trim($module['word_value'],',');


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);