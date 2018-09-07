<?php
$act=@$_GET['act'];
$id=intval(@$_POST['id']);
if($act=='update'){
	$sql="update ".self::$table_pre."account set `sequence`='".intval($_POST['sequence'])."' where `id`='$id'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='del'){
	$sql="select `banner`,`username` from ".self::$table_pre."account where `id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['username']!=$_SESSION['monxin']['username']){exit("{'state':'fail','info':'<span class=fail>is not your account</span>'}");}
	
	$sql="delete from ".self::$table_pre."account where `id`='$id'";
	if($pdo->exec($sql)){
		self::del_account_receive_data($pdo,$id);
		@safe_unlink("./program/scanpay/banner/".$r['banner']);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}