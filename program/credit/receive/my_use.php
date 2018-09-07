<?php
$act=@$_GET['act'];
if($act=='update'){
	$_POST=safe_str($_POST);
	$id=intval($_POST['id']);
	$sql="update ".self::$table_pre."prize_log set `r_info`='".$_POST['r_info']."' where `id`=".$id." and `username`='".$_SESSION['monxin']['username']."'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
