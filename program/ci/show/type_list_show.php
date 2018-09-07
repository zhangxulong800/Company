<?php
$id=intval(@$_GET['id']);
if($id==0){echo (self::$language['need_params']);	return false;}


$sql="select `list_show` from ".self::$table_pre."type where `id`='$id'";
$module=$pdo->query($sql,2)->fetch(2);
$module=de_safe_str($module);
$sql="select `id`,`name`,`postfix` from ".self::$table_pre."type_attribute where `type_id`=".$id." order by `sequence` desc,`id` asc";
$r=$pdo->query($sql,2);
$module['checkbox']='';
foreach($r as $v){
	$module['checkbox'].='<span><input type=checkbox id='.$v['id'].' />'.$v['name'].' '.$v['postfix'].'</span>';	
}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&id='.$id;

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);

