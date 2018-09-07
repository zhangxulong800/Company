<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
if(!isset($_GET['show_time'])){header('location:./index.php?monxin=mall.interest_user&show_time=day');exit;}
$username=safe_str(@$_GET['username']);
$module['days']='<a href="./index.php?monxin=mall.interest_user&show_time=day&username='.$username.'" data="day">'.self::$language['this_day'].'</a>';
$module['days'].='<a href="./index.php?monxin=mall.interest_user&show_time=week&username='.$username.'" data="week">'.self::$language['this_week'].'</a>';
$module['days'].='<a href="./index.php?monxin=mall.interest_user&show_time=month&username='.$username.'" data="month">'.self::$language['this_month'].'</a>';
$module['days'].='<a href="./index.php?monxin=mall.interest_user&show_time=year&username='.$username.'" data="year">'.self::$language['this_year'].'</a>';
$module['days'].='<a href="./index.php?monxin=mall.interest_user&show_time=sum&username='.$username.'" data="sum">'.self::$language['all'].'</a>';


$show_time=safe_str($_GET['show_time']);
if($show_time==''){$show_time='day';}

$where='';


$sql="select * from ".self::$table_pre."interest_group".$where." order by `".$show_time."` desc ";

$r=$pdo->query($sql,2);
$module['group']='';
$i=1;
$module['sum']=0;
//echo $sql;
foreach($r as $v){
	if($v[$show_time]==0){continue;}
	if($i==1){
		$module['group'].="{value:".$v[$show_time].",name:'".$v['name']."',selected:true},";	
	}else{
		$module['group'].="{value:".$v[$show_time].",name:'".$v['name']."'},";	
	}
	$module['sum']+=$v[$show_time];
	
	$i++;
}
$module['group']=trim($module['group'],',');


$sql="select * from ".self::$table_pre."interest_word".$where." order by `".$show_time."` desc limit 0,100";
$r=$pdo->query($sql,2);
$module['word_name']='';
$module['word_value']='';
$i=1;
foreach($r as $v){
	if($v[$show_time]==0){continue;}
	$module['word_name']="'".$v['name']."',".$module['word_name'];	
	$module['word_value']=$v[$show_time].",".$module['word_value'];	
	
	$i++;
}
$module['word_name']=trim($module['word_name'],',');
$module['word_value']=trim($module['word_value'],',');


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);