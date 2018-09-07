<?php
//echo $args[1];
$cache_path='./program/mall/cache/'.md5($args[1]).'.txt';
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
$attribute=format_attribute($args[1]);
$id=$attribute['id'];
if($attribute['follow_type']=='true' && intval(@$_GET['type'])!=0){
	$id=intval($_GET['type']);
	$sql="select `id` from  ".self::$table_pre."type where `parent`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){
		$sql="select `parent` from ".self::$table_pre."type where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$id=$r['parent'];	
	}
		
	if($id!=0){
		$sql="select `name` from ".self::$table_pre."type where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$r=de_safe_str($r);
		$attribute['title']=$r['name'];
	}
}



$list=$this->get_type_names($pdo,$id,$attribute['target'],$attribute['title']);
if($list==''){$list='<a href="#">'.self::$language['no_content'].'</a>';}
$module['list']=$list;

$module['type_deep_3']='none';
$module['type_deep_2']='none';

if($attribute['show_deep']==3){
	$module['type_deep_3']='block';
	$module['type_deep_2']='block';
}elseif($attribute['show_deep']==2){
	$module['type_deep_2']='block';
}

$module['module_width']=$attribute['width'];
$module['module_height']=$attribute['height'];
$module['module_name']=str_replace("::","_",$method.'_'.$id);
$module['module_save_name']=str_replace("::","_",$method.$args[1]);
$module['count_url']="receive.php?target=".$method."&id=".$id;
file_put_contents($cache_path,serialize($module));
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
