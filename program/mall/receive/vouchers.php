<?php

foreach($_GET as $key=>$v){
	if($v==''){exit("{'state':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");}
}
$act=@$_GET['act'];
if($act=='add'){
	$_GET['name']=safe_str($_GET['name']);
	$_GET['number']=safe_str($_GET['number']);
	$_GET['amount']=floatval($_GET['amount']);
	$_GET['min_money']=floatval($_GET['min_money']);
	$_GET['start_time']=get_unixtime($_GET['start_time'],self::$config['other']['date_style']);
	$_GET['end_time']=get_unixtime($_GET['end_time'],self::$config['other']['date_style'])+86399;
	$_GET['sum_quantity']=intval($_GET['sum_quantity']);
	if($_GET['end_time']<=$_GET['start_time']){exit("{'state':'fail','info':'<span class=fail>".self::$language['the_end_time_must_be_greater_than_the_start_time']."</span>'}");}
	
	$sql="select count(id) as c from ".self::$table_pre."vouchers where `shop_id`=".SHOP_ID." and `number`='".$_GET['number']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist_same'].self::$language['vouchers_number']."</span>'}");}
	
	$sql="insert into ".self::$table_pre."vouchers (`name`,`number`,`amount`,`min_money`,`start_time`,`end_time`,`shop_id`,`time`,`username`,`sum_quantity`,`join_goods`) values ('".$_GET['name']."','".$_GET['number']."','".$_GET['amount']."','".$_GET['min_money']."','".$_GET['start_time']."','".$_GET['end_time']."','".SHOP_ID."','".time()."','".$_SESSION['monxin']['username']."','".$_GET['sum_quantity']."','".intval(@$_GET['join_goods'])."')";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}


if($act=='del'){
	$id=intval(@$_GET['id']);
	if($id<1){exit();}
	$sql="delete from ".self::$table_pre."vouchers where `id`='$id' and `shop_id`=".SHOP_ID;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}

}

