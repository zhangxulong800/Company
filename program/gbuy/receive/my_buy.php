<?php
$act=@$_GET['act'];

if($act=='del'){
	$id=intval($_GET['id']);
	$sql="update ".self::$table_pre."order set `buyer_delete`=1 where `id`=".$id." and `username`='".$_SESSION['monxin']['username']."' and `state`!=1";
	
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
