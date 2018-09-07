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
		$id=$r['parent'];	
	}
	if($id!=0){
		$sql="select `name` from ".self::$table_pre."img_type where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$r=de_safe_str($r);
		$attribute['title']=$r['name'];
	}
}


$ids=$this->get_type_ids($pdo,$id);
$sql="select `id`,`name` from ".self::$table_pre."img_type where `visible`=1 and `id` in(".$ids.") and `id`!=".$id." order by `".$attribute['sequence_field']."` ".$attribute['sequence_type']." limit 0,".$attribute['quantity'];
	//echo $sql;
	$r=$pdo->query($sql,2);
	$list='';
	foreach($r as $v){
		$v=de_safe_str($v);
		$list.="<a href=./index.php?monxin=image.show_thumb&type=".$v['id']." ><img src=./program/image/type_icon/".$v['id'].".png /><span>".$v['name']."</span></a>";
	}
	if($list==''){$list='<a href="#">'.self::$language['no_content'].'</a>';}
	$module['list']=$list;
	
	
	
	$module['title']=$attribute['title'];
	$module['scroll']=$attribute['scroll'];
	$module['module_width']=$attribute['width'];
	$module['module_height']=$attribute['height'];
	$module['sub_module_width']=$attribute['sub_module_width'];
	$module['image_height']=$attribute['image_height'];
	//$module['module_name']=str_replace("::","_",$method.'_'.$id);
	$module['module_name']=str_replace("::","_",$method.'_'.$id.'_append_'.$attribute['sequence_field'].'_'.$attribute['sequence_type']);
	$module['module_save_name']=str_replace("::","_",$method.$args[1]);
			$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
