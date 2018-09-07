<?php
$act=@$_GET['act'];
if($act=='del'){
	$id=intval(@$_GET['id']);
	$sql="delete from ".self::$table_pre."visit where `goods_id`='".$id."' and `username`='".$_SESSION['monxin']['username']."'";
	$pdo->exec($sql);
	exit;
}
if($act=='clear_all'){
	$sql="delete from ".self::$table_pre."visit where `username`='".$_SESSION['monxin']['username']."'";
	$pdo->exec($sql);	
}
