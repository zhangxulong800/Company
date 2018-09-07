<?php
//echo $args[1];

$attribute=format_attribute($args[1]);
$id=$attribute['id'];

$list=$this->get_type_names($pdo,$id,$attribute['target'],$attribute['title']);
if($list==''){$list='<a href="#">'.self::$language['no_content'].'</a>';}
$module['list']=$list;

$module['page_type_deep_3']='none';
$module['page_type_deep_2']='none';

if($attribute['show_deep']==3){
	$module['page_type_deep_3']='block';
	$module['page_type_deep_2']='block';
}elseif($attribute['show_deep']==2){
	$module['page_type_deep_2']='block';
}

$module['module_width']=$attribute['width'];
$module['module_height']=$attribute['height'];
$module['module_name']=str_replace("::","_",$method.'_'.$id);
$module['module_save_name']=str_replace("::","_",$method.$args[1]);
$module['count_url']="receive.php?target=".$method."&id=".$id;
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
