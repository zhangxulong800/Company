<?php
if($_COOKIE['monxin_device']=='phone'){
	//var_dump( $args);
	$method='mall::type_module_left';
	require('./program/mall/show/type_module_left.php');
	return false;	
}
$cache_path='./program/mall/cache/type_module_two.txt';
if(is_file($cache_path) ){
	$cache_file_time=@filemtime($cache_path);
	if($cache_file_time>self::$config['type_update_time']){
		$module=unserialize(file_get_contents($cache_path));
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);	
		return false;
	}
}

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$sql="select * from ".self::$table_pre."type where `parent`=0 and visible=1 order by `sequence` desc limit 0,5";
$r=$pdo->query($sql,2);
$module['html']='';
foreach($r as $v){
	$v=de_safe_str($v);
	if($v['url']==''){$v['url']='./index.php?monxin=mall.goods_list&type='.$v['id'];}
	$module['html'].='<div class=parent><div class=level_1_div><div class=level_1><a href="'.$v['url'].'" id="'.$v['id'].'">'.$v['name'].'</a></div>';	
	$sql="select * from ".self::$table_pre."type where `parent`='".$v['id']."' and visible=1 order by `sequence` desc";
	$r2=$pdo->query($sql,2);
	$count=0;
	
	$part_a_div='';
	$part_b_div='';
	foreach($r2 as $v2){
		$v2=de_safe_str($v2);
		if($v2['url']==''){$v2['url']='./index.php?monxin=mall.goods_list&type='.$v2['id'];}
		if($count<3){
			$part_a_div.='<a href="'.$v2['url'].'" class=level_2>'.$v2['name'].'</a>';
		}else{
			$part_b_div.='<a href="'.$v2['url'].'" class=level_2>'.$v2['name'].'</a>';
		}
		$count++;
	}
	$part_a_div='<div class=part_a_div>'.$part_a_div.'</div></div>';
	if($part_b_div!=''){$part_b_div='<div class=part_b_div>'.$part_b_div.'</div>';}
	
	$module['html'].=$part_a_div.$part_b_div.'</div>';
}
file_put_contents($cache_path,serialize($module));
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
