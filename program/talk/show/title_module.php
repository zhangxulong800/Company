<?php
//echo $args[1];

$attribute=format_attribute($args[1]);
$id=$attribute['id'];
$sql="select `id`,`title` from ".self::$table_pre."title where `visible`=1 and `type`=".$id." order by `".$attribute['sequence_field']."` ".$attribute['sequence_type']." limit 0,".$attribute['quantity'];
if($id=='' || $id==0){
	$sql="select `id`,`title` from ".self::$table_pre."title where `visible`=1 order by `".$attribute['sequence_field']."` ".$attribute['sequence_type']." limit 0,".$attribute['quantity'];
}

$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$v=de_safe_str($v);		
	$list.="<a href='./index.php?monxin=talk.content&id=".$v['id']."' class='title_module' target='".$attribute['target']."'>".$v['title']."</a>";
}
if($list==''){$list='<a href="#">'.self::$language['no_content'].'</a>';}
$module['list']=$list;



$module['title']=$attribute['title'];
$module['module_width']=$attribute['width'];
$module['module_height']=$attribute['height'];
$module['module_name']=str_replace("::","_",$method.'_'.$id);
$module['module_save_name']=str_replace("::","_",$method.$args[1]);
$module['count_url']="receive.php?target=".$method."&id=".$id;
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
