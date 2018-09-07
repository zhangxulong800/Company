<?php
$act=@$_GET['act'];
$v=safe_str(@$_POST['v']);
if($act=='recommendation_discount'){
	$v=floatval($v);
	$v=max(1,$v);
	$v=min(9.9,$v);	
	$sql="update ".self::$table_pre."shop set `recommendation_discount`='".$v."' where `id`=".SHOP_ID;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='recommendation_rebate'){
	$v=intval($v);
	$v=max(1,$v);
	$v=min(70,$v);	
	$sql="update ".self::$table_pre."shop set `recommendation_rebate`='".$v."' where `id`=".SHOP_ID;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='recommendation_slogan'){
	$id=intval(@$_POST['id']);
	$sql="update ".self::$table_pre."goods set `recommendation_slogan`='".$v."' where `id`=".$id." and `shop_id`=".SHOP_ID;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

