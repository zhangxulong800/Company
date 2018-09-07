<?php
if(SHOP_ID==0){return false;}

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$sql="select `keyword` from ".self::$table_pre."shop_search_log where `shop_id`=".SHOP_ID." order by `sum` desc limit 0,5";
$r=$pdo->query($sql,2);
$module['hot_search']='';
foreach($r as $v){
	$module['hot_search'].='<a href="./index.php?monxin=mall.shop_goods_list&search='.urlencode($v['keyword']).'&click=true&shop_id='.SHOP_ID.'">'.$v['keyword'].'</a> ';	
}
if($module['hot_search']==''){
	$temp=explode('|',self::$config['hot_search']);
	$module['hot_search']='';
	foreach($temp as $v){
		if($v==''){continue;}
		$module['hot_search'].='<a href="./index.php?monxin=mall.goods_list&search='.urlencode($v).'&click=true">'.$v.'</a> ';	
	}
}

$module['hot_search_html']='';
if($module['hot_search']!=''){
	$module['hot_search_html']='<div class=search_hot_div>'.self::$language['hot_search'].'：'.$module['hot_search'].'</div>';
}

$module['shop_id']=SHOP_ID;
$m_require_login=0;
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);