<?php

$act=@$_GET['act'];

if($act=='show_name'){
	$payee=safe_str(@$_POST['payee']);
	$sql="select `real_name` from ".$pdo->index_pre."user where `username`='$payee'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['real_name']!=''){exit('*'.mb_substr($r['real_name'],1,100,'utf-8'));	}
}


if($act=='submit'){
	$shop_id=intval(@$_GET['shop_id']);
	if($shop_id==0)exit("{'state':'fail','info':'<span class=fail>shop_id err</span>'}");	
	$money=floatval(@$_POST['money']);
	$remark=safe_str(@$_POST['remark']);
	$payee=safe_str(@$_POST['payee']);
	$transaction_password=md5(@$_POST['transaction_password']);
	if($payee==$_SESSION['monxin']['username']){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['can_not_be_yourself']."','key':'payee'}");}
	
	if(!check_username($pdo,$payee)){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['username_err']."','key':'payee'}");}

	if($money<1){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['less_than']."1','key':'money'}");}
	$sql="select `transaction_password` from ".$pdo->index_pre."user where `username`='".$_SESSION['monxin']['username']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['transaction_password']!=$transaction_password){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['transaction_password'].self::$language['err']."','key':'transaction_password'}");}
	
	$sql="select `id` from ".self::$table_pre."shop_buyer where `shop_id`=".$shop_id." and `username`='".$payee."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['remittee'].self::$language['not_shop_number']."</span>'}");	}
	
	$sql="select `balance` from ".self::$table_pre."shop_buyer where `shop_id`=".$shop_id." and `username`='".$_SESSION['monxin']['username']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['balance']<$money){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['must_be_less_than'].$r['balance']."','key':'money'}");}
	
	$reason=self::$language['transfer'].self::$language['to'].$payee.'('.$remark.')';;
	if(self::operator_shop_buyer_balance($pdo,$_SESSION['monxin']['username'],'-'.$money,$reason)){
		$reason=$_SESSION['monxin']['username'].self::$language['transfer'].'('.$remark.')';
		if(self::operator_shop_buyer_balance($pdo,$payee,$money,$reason)){
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}else{
			exit("{'state':'success','info':'<span class=fail>".self::$language['fail']."</span>'}");	
		}
		
	}else{
		exit("{'state':'success','info':'<span class=fail>".self::$language['fail']."</span>'}");	
	}	
	
	
}