<?php
$act=@$_GET['act'];
if($act=='update'){
	$id=intval($_POST['id']);
	$v=floatval($_POST['v']);
	$sql="update ".self::$table_pre."goods_batch set `price`=".$v." where `id`=".$id." and `shop_id`=".SHOP_ID;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='update_payment'){
	$id=intval($_POST['id']);
	$v=floatval($_POST['v']);
	$sql="update ".self::$table_pre."goods_batch set `payment`=".$v." where `id`=".$id." and `shop_id`=".SHOP_ID;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='purchase_name'){
	$id=intval($_POST['id']);
	$v=safe_str($_POST['v']);
	
	$sql="select `id` from ".self::$table_pre."purchase where `shop_id`=".SHOP_ID." and `name`='".$v."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){
		$sql="insert into ".self::$table_pre."purchase (`name`,`shop_id`,`time`) values ('".$v."',".SHOP_ID.",".time().")";
		$pdo->exec($sql);	
	}
	$sql="update ".self::$table_pre."goods_batch set `purchase_name`=".$v." where `id`=".$id." and `shop_id`=".SHOP_ID;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
