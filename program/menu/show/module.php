<?php
//echo $args[1];

$attribute=format_attribute($args[1]);
$id=$attribute['id'];

$sql="select * from ".self::$table_pre."menu where `parent_id`='".intval($id)."' and `visible`=1 order by `sequence` desc";
//echo $sql;
$r=$pdo->query($sql,2);
$a=array();
$index=0;
foreach($r as $v){
	$v=de_safe_str($v);
	$a[$index]['id']=$v['id'];	
	$a[$index]['name']=$v['name'];	
	$a[$index]['url']=$v['url'];	
	$a[$index]['open_target']=$v['open_target'];	
	$index++;
}
$module['data']=json_encode($a);
$module['module_name']=str_replace("::","_",$method.'_'.$id);
$module['module_save_name']=str_replace("::","_",$method.$args[1]);
$module['bg']=str_replace('*','.',$attribute['bg']);

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.$attribute['template'].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.$attribute['template'].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);