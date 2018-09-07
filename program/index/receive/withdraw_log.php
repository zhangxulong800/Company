<?php
$act=@$_GET['act'];
$id=intval(@$_GET['id']);
/*
if($act=='del'){
	$sql="delete from ".$pdo->index_pre."withdraw where `id`='$id' and `username`='".$_SESSION['monxin']['username']."' and (`state`='1' or `state`='2')";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
*/
