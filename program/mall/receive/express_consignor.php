<?php
$act=@$_GET['act'];
if($act=='update'){	
	$_POST=safe_str($_POST);
	$sql="update ".self::$table_pre."express_consignor set `shipper_name`='".$_POST['shipper_name']."',`shipper_tel`='".$_POST['shipper_tel']."',`shipper_phone`='".$_POST['shipper_phone']."',`shipper_company`='".$_POST['shipper_company']."',`shipper_address`='".$_POST['shipper_address']."',`shipper_city`='".$_POST['shipper_city']."',`shipper_postcode`='".$_POST['shipper_postcode']."',`shipper_signature`='".$_POST['shipper_signature']."' where `shop_id`='".SHOP_ID."' limit 1";
	if($pdo->exec($sql)){
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
		
}