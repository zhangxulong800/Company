<?php

foreach($_GET as $key=>$v){
	if($v==''){exit("{'state':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");}
}
$act=@$_GET['act'];
if($act=='add'){
	$_GET['name']=safe_str($_GET['name']);
	$_GET['open']=safe_str($_GET['open']);
	$_GET['amount']=floatval($_GET['amount']);
	$_GET['min_money']=floatval($_GET['min_money']);
	$_GET['start_time']=get_unixtime($_GET['start_time'],self::$config['other']['date_style']);
	$_GET['end_time']=get_unixtime($_GET['end_time'],self::$config['other']['date_style'])+86399;
	$_GET['sum_quantity']=intval($_GET['sum_quantity']);
	if($_GET['end_time']<=$_GET['start_time']){exit("{'state':'fail','info':'<span class=fail>".self::$language['the_end_time_must_be_greater_than_the_start_time']."</span>'}");}
	
	
		$sql="select `name` from ".self::$table_pre."shop where `id`=".SHOP_ID;
		$r=$pdo->query($sql,2)->fetch(2);
		$shop_name=$r['name'];
	
	
	$sql="select count(id) as c from ".self::$table_pre."coupon where `shop_id`=".SHOP_ID." and `open`='".$_GET['open']."' and `amount`=".$_GET['amount']." and `name`='".$_GET['name']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist_same']."</span>'}");}
	
	
	
	$sql="insert into ".self::$table_pre."coupon (`name`,`open`,`amount`,`min_money`,`start_time`,`end_time`,`shop_id`,`time`,`username`,`sum_quantity`,`join_goods`,`shop_name`) values ('".$_GET['name']."','".$_GET['open']."','".$_GET['amount']."','".$_GET['min_money']."','".$_GET['start_time']."','".$_GET['end_time']."','".SHOP_ID."','".time()."','".$_SESSION['monxin']['username']."','".$_GET['sum_quantity']."','".intval(@$_GET['join_goods'])."','".$shop_name."')";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}


if($act=='update'){
	$id=intval(@$_GET['id']);
	$sql="update ".self::$table_pre."coupon set `open`='".intval($_GET['open'])."' where `id`='$id' and `shop_id`=".SHOP_ID;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}

}

if($act=='del'){
	$id=intval(@$_GET['id']);
	if($id<1){exit();}
	$sql="select `draws` from ".self::$table_pre."coupon where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['draws']!=0){exit("{'state':'fail','info':'<span class=fail>".self::$language['has_draw']."</span>'}");}
	
	$sql="delete from ".self::$table_pre."coupon where `id`='$id' and `shop_id`=".SHOP_ID;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}

}

