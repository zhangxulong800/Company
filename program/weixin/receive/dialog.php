<?php
if(!$this->check_wid_power($pdo,self::$table_pre)){exit("{'state':'fail','info':'<span class=fail>".self::$language['act_noPower']."</span>'}");}
$wid=safe_str(@$_GET['wid']);

$act=@$_GET['act'];
$id=intval(@$_GET['id']);

if($act=='del'){
	$sql="select * from ".self::$table_pre."dialog where `id`='".$id."' and `wid`='".$wid."'";
	$r=$pdo->query($sql,2)->fetch(2);
	$sql="delete from ".self::$table_pre."dialog where `id`='".$id."' and `wid`='".$wid."'";
	if($pdo->exec($sql)){
		self::del_dialog_file($r,$wid);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

