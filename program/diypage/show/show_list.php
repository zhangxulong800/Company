<?php
//echo $args[1];

$attribute=format_attribute($args[1]);
$id=intval($attribute['id']);
if(@$_GET['monxin']=='diypage.show' && $attribute['id']=='auto'){
	$sql="select `type` from ".self::$table_pre."page where `id`=".intval(@$_GET['id']);
	$r=$pdo->query($sql,2)->fetch(2);
	$id=$r['type'];
	$sql="select `name` from ".self::$table_pre."page_type where `id`=".$id;
	//echo $sql;
	$r=$pdo->query($sql,2)->fetch(2);
	$attribute['title']=de_safe_str($r['name']);	
}
$ids=$this->get_type_ids($pdo,$id);
$sql="select ".$attribute['field'].",`id`,`link` from ".self::$table_pre."page where `visible`=1 and `type` in(".$ids.") order by `".$attribute['sequence_field']."` ".$attribute['sequence_type']." limit 0,".$attribute['quantity'];
//echo $sql;
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$v=de_safe_str($v);
	
	if($v['link']==''){$link='./index.php?monxin=diypage.show&id='.$v['id'];}else{$link=$v['link'];}
	$list.="<a href='".$link."' id='diypage_show_".$v['id']."'  target='".$attribute['target']."'>".$v['title']."</a>";
}
if($list==''){$list='<a href="#">'.self::$language['no_content'].'</a>';}
$module['list']=$list;



$module['title']=$attribute['title'];
$module['scroll']=$attribute['scroll'];
$module['module_width']=$attribute['width'];
$module['module_height']=$attribute['height'];
$module['sub_module_width']=$attribute['sub_module_width'];
//$module['module_name']=str_replace("::","_",$method.'_'.$id);
$module['module_name']=str_replace("::","_",$method.'_'.$id.'_append_'.$attribute['sequence_field'].'_'.$attribute['sequence_type']);
$module['module_save_name']=str_replace("::","_",$method.$args[1]);
$module['count_url']="receive.php?target=".$method."&id=".$id;
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
