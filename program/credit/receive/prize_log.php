<?php
$act=@$_GET['act'];
if($act=='update'){
	$_POST=safe_str($_POST);
	$id=intval($_POST['id']);
	$sql="update ".self::$table_pre."prize_log set `s_info`='".$_POST['s_info']."',`state`=1 where `id`=".$id;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='del'){
	$id=intval($_GET['id']);
	$sql="delete from ".self::$table_pre."prize_log where `id`=".$id;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
