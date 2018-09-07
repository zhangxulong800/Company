<?php
$act=@$_GET['act'];
if($act=='add_deposit'){
	$money=intval(@$_GET['money']);	
	if($money<1){exit("{'state':'fail','info':'<span class=fail>".self::$language['less_than']." 1</span>'}");}
	
	$sql="select `money` from ".$pdo->index_pre."user where `username`='".$_SESSION['monxin']['username']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['money']<$money){exit("{'state':'fail','info':'<span class=fail>".self::$language['insufficient_balance'].",".self::$language['please'].' <a href=./index.php?monxin=index.recharge target=_blank>'.self::$language['recharge']."</a> </span>'}");}
	
	$sql="select * from ".self::$table_pre."shop where `id`='".SHOP_ID."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['deposit']+$money<self::$config['min_deposit']){exit("{'state':'fail','info':'<span class=fail>".self::$language['less_than']." ".self::$config['min_deposit']."</span>'}");}
	
	$reason=self::$language['add_deposit'];
	if(operator_money(self::$config,self::$language,$pdo,$_SESSION['monxin']['username'],'-'.$money,$reason,'mall')){
		$sql="update ".self::$table_pre."shop set `deposit`=`deposit`+".$money." where `id`=".SHOP_ID;
		if($pdo->exec($sql)){
			$sql="select `deposit` from ".self::$table_pre."shop where `id`=".SHOP_ID;
			$r=$pdo->query($sql,2)->fetch(2);
			$sql="update ".self::$table_pre."goods set `deposit`=".$r['deposit']." where `shop_id`=".SHOP_ID;
			$pdo->exec($sql);
			
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
		
}