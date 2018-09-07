<?php


$act=@$_GET['act'];
if($act=='update'){
	$_GET['first_price']=floatval($_GET['first_price']);
	$_GET['continue_price']=floatval($_GET['continue_price']);
	$id=intval(@$_GET['id']);
	$area_id=intval(@$_GET['area_id']);
	if($id==0){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
	if($area_id==0){exit("{'state':'fail','info':'<span class=fail>area_id err</span>'}");}
	$sql="select * from ".self::$table_pre."express_price where `area_id`=".$area_id." and `express_id`='".$id."' and `shop_id`=".SHOP_ID;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){
		$sql="insert into ".self::$table_pre."express_price (`shop_id`,`area_id`,`express_id`,`first_price`,`continue_price`) values ('".SHOP_ID."','".$area_id."','".$id."','".$_GET['first_price']."','".$_GET['continue_price']."')";	
	}else{
		$sql="update ".self::$table_pre."express_price set `first_price`='".$_GET['first_price']."',`continue_price`='".$_GET['continue_price']."' where `area_id`='".$area_id."' and `express_id`='".$id."' and `shop_id`=".SHOP_ID;
	}
	
	//echo $sql;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
	}
}
