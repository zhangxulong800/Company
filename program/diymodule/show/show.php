<?php
$id=intval($temp[1]);
if($id>0){
	$sql="select `id`,`width`,`height`,`content`,`title`,`title_visible` from ".self::$table_pre."module where `id`='$id'";
	//echo $sql;
	$module=$pdo->query($sql,2)->fetch(2);
	if($module['id']==''){return false;}
	$module['title']=de_safe_str($module['title']);
	$module['content']=de_safe_str($module['content']);
	$sql="update ".self::$table_pre."module set `visit`=`visit`+1 where `id`=".$module['id'];
	$pdo->exec($sql);
	
	$module['module_name']=str_replace("::","_",$method).'_'.$id;
	$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);	
}else{
	echo (self::$language['need_params']);
}
