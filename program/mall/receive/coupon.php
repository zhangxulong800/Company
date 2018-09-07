<?php
$id=intval(@$_GET['id']);
$sql="select `name`,`sum_quantity`,`draws` from ".self::$table_pre."coupon where `id`=".$id;
$r=$pdo->query($sql,2)->fetch(2);
if($r['name']==''){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
$balance=$r['sum_quantity']-$r['draws'];
$draws=$r['draws'];
	if($balance<1){exit("{'state':'fail','info':'<span class=fail>".self::$language['draws_none']."</span>'}");}
	if(!isset($_SESSION['monxin']['username'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['please_login']."</span>'}");}
	$username=$_SESSION['monxin']['username'];
	$sql="select `id` from ".self::$table_pre."my_coupon where `username`='".$username."' and `coupon_id`=".$id." and `order_id`=0 limit 0,1";
	$r2=$pdo->query($sql,2)->fetch(2);
	if($r2['id']==''){
		$sql="insert into ".self::$table_pre."my_coupon (`coupon_id`,`username`,`draws_time`) values ('".$id."','".$username."','".time()."')";
		if($pdo->exec($sql)){
			$sql="update ".self::$table_pre."coupon set `draws`=`draws`+1 where `id`=".$id;	
			if($pdo->exec($sql)){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		}	
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['draws_repeat']."</span>'}");
	}	
