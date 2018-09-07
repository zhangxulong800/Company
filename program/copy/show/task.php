<?php
$regular_id=intval(@$_GET['regular_id']);
$id=intval(@$_GET['id']);

if($regular_id!=0){
	$sql="select `id`,`name` from ".self::$table_pre."regular where `id`=".$regular_id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r==''){exit('regular_id err');}
	echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=copy.regular&id='.$id.'">'.$r['name'].'</a><span class=text>'.self::$language['pages']['copy.task']['name'].'</span></div>';

	$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&show_result=1&regular_id='.$regular_id;
}elseif($id!=0){
	$sql="select * from ".self::$table_pre."task where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit('id err');}
	$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&show_result=1&id='.$id;
}else{
	$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&show_result=1';
}

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
