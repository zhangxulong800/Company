<?php
$act=@$_GET['act'];

if($act=='del'){
	$id=intval(@$_GET['id']);
	if($id==0){exit('id err');}
	$sql="delete from ".self::$table_pre."my_coupon where `coupon_id`='".$id."' and `username`='".$_SESSION['monxin']['username']."'";
	if($pdo->exec($sql)){
		$sql="update ".self::$table_pre."coupon set `draws`=`draws`-1 where `id`=".$id;
		$pdo->exec($sql);	
	}
	exit;	
}
