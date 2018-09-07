<?php
$id=intval($args[1]);
if($id>0){
	$sql="select `id`,`width`,`height`,`content`,`title`,`title_visible` from ".self::$table_pre."module where `id`='$id'";
	//echo $sql;
	$module=$pdo->query($sql,2)->fetch(2);
	$module['title']=de_safe_str($module['title']);
	$module['content']=de_safe_str($module['content']);
	$module['module_name']=str_replace("::","_",$method).'_'.$id;
	//require('./templates/0/'.$class.'_shop/'.self::$config['shop_template'].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php');	
	$t_path='./templates/0/'.$class.'_shop/'.self::$config['shop_template'].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
	if(!is_file($t_path)){$t_path='./templates/0/'.$class.'_shop/'.self::$config['shop_template'].'/pc/'.str_replace($class."::","",$method).'.php';}
	require($t_path);
}else{
	echo (self::$language['need_params']);
}
