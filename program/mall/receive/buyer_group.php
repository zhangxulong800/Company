<?php

$_GET['id']=intval(@$_GET['id']);
$_GET['credits']=floatval(@$_GET['credits']);
$_GET['discount']=floatval(@$_GET['discount']);
$_GET['name']=safe_str(@$_GET['name']);
$act=$_GET['act'];
if($act=='add'){
	$sql="insert into ".self::$table_pre."shop_buyer_group (`shop_id`,`name`,`credits`,`discount`) values ('".SHOP_ID."','".$_GET['name']."','".$_GET['credits']."','".$_GET['discount']."')";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}


if($act=='update'){
	$sql="update ".self::$table_pre."shop_buyer_group set `name`='".$_GET['name']."',`discount`='".$_GET['discount']."',`credits`='".$_GET['credits']."' where `id`='".$_GET['id']."' and `shop_id`=".SHOP_ID;
	//echo $sql;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
	}
}


if($act=='del'){
	if(!is_numeric($_GET['id'])){exit();}
	$sql="select count(id) as c from ".self::$table_pre."shop_buyer where `group_id`='".$_GET['id']."' and `shop_id`=".SHOP_ID;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['there_are_members_can_not_be_deleted']."'}");}

	$sql="delete from ".self::$table_pre."shop_buyer_group where `id`='".$_GET['id']."' and `shop_id`=".SHOP_ID;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}

}