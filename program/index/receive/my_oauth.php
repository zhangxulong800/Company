<?php
$id=intval(@$_GET['id']);
$act=@$_GET['act'];
if($act=='del'){
	$sql="select `reg_oauth` from ".$pdo->index_pre."user where `id`=".$_SESSION['monxin']['id'];
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['reg_oauth']){exit("{'state':'fail','info':'<span class=fail>".self::$language['oauth_auto_crate_forbidden_del']."</span>'}");}
	$sql="delete from ".$pdo->index_pre."oauth where `id`='$id' and `user_id`=".$_SESSION['monxin']['id'];
	if($pdo->exec($sql)){		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

