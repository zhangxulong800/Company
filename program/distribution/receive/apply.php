<?php
$act=@$_GET['act'];
if($act=='submit'){	
	$_POST['real_name']=safe_str($_POST['real_name']);
	$sql="update ".$pdo->index_pre."user set `real_name`='".$_POST['real_name']."' where `username`='".$_SESSION['monxin']['username']."' limit 1";
	$pdo->exec($sql);
	
	$sql="select * from ".$pdo->index_pre."user where `username`='".$_SESSION['monxin']['username']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	
	$sql="select * from ".self::$table_pre."distributor where `username`='".$_SESSION['monxin']['username']."' limit 0,1";
	$d=$pdo->query($sql,2)->fetch(2);
	if($d['id']==''){
		$sql="insert into ".self::$table_pre."distributor (`username`,`phone`,`time`,`state`,`superior`) values ('".$_SESSION['monxin']['username']."','".$r['phone']."','".time()."',0,'".$r['introducer']."')";
		$pdo->exec($sql);
	}
	exit("{'state':'success','info':'<span class=success>".self::$language['success'].','.self::$language['distributor_state'][0]."</span>'}");
		
}