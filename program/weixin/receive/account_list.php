<?php
$act=@$_GET['act'];
$id=intval(@$_GET['id']);
if($act=='del'){
	$sql="select `wid`,`qr_code`,`username` from ".self::$table_pre."account where `id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['username']!=$_SESSION['monxin']['username']){exit("{'state':'fail','info':'<span class=fail>is not your account</span>'}");}
	
	$sql="delete from ".self::$table_pre."account where `id`='$id'";
	if($pdo->exec($sql)){
		self::del_account_receive_data($pdo,self::$table_pre,$r['wid']);
		@safe_unlink("./program/weixin/qr_code/".$r['qr_code']);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='reset_token'){
	$sql="select `wid`,`qr_code`,`username` from ".self::$table_pre."account where `id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['username']!=$_SESSION['monxin']['username']){exit("{'state':'fail','info':'<span class=fail>is not your account</span>'}");}
	$r=reset_weixin_info($r['wid'],$pdo);
	if($r){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}