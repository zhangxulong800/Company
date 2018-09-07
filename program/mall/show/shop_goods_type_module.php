<?php
//echo $args[1];

$attribute=format_attribute($args[1]);
$id=$attribute['id'];
if($attribute['follow_type']=='true' && intval(@$_GET['type'])!=0){
	$id=intval($_GET['type']);
	$sql="select `id` from  ".self::$table_pre."shop_type where `shop_id`='".SHOP_ID."' and `parent`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){
		$sql="select `parent` from ".self::$table_pre."shop_type where `shop_id`='".SHOP_ID."' and `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$id=$r['parent'];	
	}
		
	if($id!=0){
		$sql="select `name` from ".self::$table_pre."shop_type where `shop_id`='".SHOP_ID."' and `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$r=de_safe_str($r);
		$attribute['title']=$r['name'];
	}
}



$list=$this->get_shop_type_names($pdo,$id,$attribute['target'],$attribute['title']);
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
require('./templates/0/'.$class.'_shop/'.self::$config['shop_template'].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php');	
