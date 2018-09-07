<?php
//echo $args[1];

$attribute=format_attribute($args[1]);
$id=$attribute['id'];
if($attribute['follow_type']=='true' && intval(@$_GET['type'])!=0){
	$id=intval($_GET['type']);
	$sql="select `id` from  ".self::$table_pre."img_type where `parent`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	
	if($r['id']==''){
		$sql="select `parent` from ".self::$table_pre."img_type where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['parent']!=0){$id=$r['parent'];	}
		
	}
	
	if($id!=0){
		$sql="select `name` from ".self::$table_pre."img_type where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$r=de_safe_str($r);
		$attribute['title']=$r['name'];
	}
}
$list=$this->get_type_names($pdo,$id,$attribute['target'],$attribute['title'],@$_GET['detail_show_method']);
if($list==''){$list='<a href="#">'.self::$language['no_content'].'</a>';}
$module['list']=$list;

$module['image_type_deep_3']='none';
$module['image_type_deep_2']='none';

if($attribute['show_deep']==3){
	$module['image_type_deep_3']='block';
	$module['image_type_deep_2']='block';
}elseif($attribute['show_deep']==2){
	$module['image_type_deep_2']='block';
}

$module['module_width']=$attribute['width'];
$module['module_height']=$attribute['height'];
$module['module_name']=str_replace("::","_",$method.'_'.$id);
$module['module_save_name']=str_replace("::","_",$method.$args[1]);
$module['count_url']="receive.php?target=".$method."&id=".$id;
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
