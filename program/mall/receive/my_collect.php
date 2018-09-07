<?php
$act=@$_GET['act'];
if($act=='del'){
	$id=intval(@$_GET['id']);
	$sql="delete from ".self::$table_pre."favorite where `goods_id`='".$id."' and `username`='".$_SESSION['monxin']['username']."'";
	$pdo->exec($sql);
	exit;
}
