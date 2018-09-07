<?php
$act=@$_GET['act'];

if($act=='repayment_remark'){
	$_POST=safe_str($_POST);
	$sql="update ".self::$table_pre."shop_buyer set `repayment_remark`='".$_POST['repayment_remark']."' where `username`='".$_POST['username']."' and `shop_id`=".SHOP_ID;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','username':'".$_POST['username']."'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."','username':'".$_POST['username']."'}");
	}
}

if($act=='full_settlement'){
	$_POST=safe_str($_POST);
	$sql="update ".self::$table_pre."order set `credit_state`=1 where `shop_id`=".SHOP_ID." and `buyer`='".$_POST['username']."' and `pay_method`='credit'";
	if($pdo->exec($sql)){
		$sql="update ".self::$table_pre."shop_buyer set `repayment_remark`='' where `username`='".$_POST['username']."' and `shop_id`=".SHOP_ID;
		$pdo->exec($sql);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','username':'".$_POST['username']."'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."','username':'".$_POST['username']."'}");
	}
	
	
}
