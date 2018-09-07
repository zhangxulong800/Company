<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$temp=explode('|',self::$config['hot_search']);
$module['hot_search']='';
foreach($temp as $v){
	if($v==''){continue;}
	$module['hot_search'].='<a href="./index.php?monxin=ci.list&search='.urlencode($v).'&click=true">'.$v.'</a> ';	
}
$module['hot_search_html']='';
if($module['hot_search']!=''){
	$module['hot_search_html']='<div class=search_hot_div>'.self::$language['hot_search'].'：'.$module['hot_search'].'</div>';
}	
$module['search_placeholder']=self::$config['search_placeholder'];
$module['search_placeholder_url']=self::$config['search_placeholder_url'];


$module['search_placeholder']=self::$config['search_placeholder'];
$module['search_placeholder_url']=self::$config['search_placeholder_url'];
$module['monxin_search_placeholder']=self::$config['web']['search_placeholder'];
$r=explode('|',self::$config['hot_search']);
$list='';
foreach($r as $v){
	$list.='<a href="./index.php?monxin=ci.list&search='.urldecode($v).'">'.$v.'</a>';	
}
$module['list']=$list;


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
