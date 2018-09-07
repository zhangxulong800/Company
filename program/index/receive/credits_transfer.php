<?php

$act=@$_GET['act'];

if($act=='show_name'){
	$payee=safe_str(@$_POST['payee']);
	$sql="select `real_name` from ".$pdo->index_pre."user where `username`='$payee' limit 0,1";
	$phone_country=self::$config['reg_set']['phone_country'];
	if(is_match(self::$config['phone_country_reg'][$phone_country],$payee)){
		$sql="select `real_name` from ".$pdo->index_pre."user where `phone`='$payee' limit 0,1";
	}
	
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['real_name']!=''){exit('*'.mb_substr($r['real_name'],1,100,'utf-8'));	}
	
	
}


if($act=='submit'){
	$money=floatval(@$_POST['money']);
	$remark=safe_str(@$_POST['remark']);
	$payee=safe_str(@$_POST['payee']);
	$transaction_password=md5(@$_POST['transaction_password']);
	if($payee==$_SESSION['monxin']['username']){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['can_not_be_yourself']."','key':'payee'}");}
	
	$phone_country=self::$config['reg_set']['phone_country'];
	if(is_match(self::$config['phone_country_reg'][$phone_country],$payee)){
		$sql="select `username`,`id` from ".$pdo->index_pre."user where `phone`='$payee' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){$payee=$r['username'];}
	}
	
	if(!check_username($pdo,$payee)){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['username_err']."','key':'payee'}");}

	if($money<1){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['less_than']."1','key':'money'}");}
	$sql="select `transaction_password`,`credits` from ".$pdo->index_pre."user where `username`='".$_SESSION['monxin']['username']."'";
	
	
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['transaction_password']!=$transaction_password){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['transaction_password'].self::$language['err']."','key':'transaction_password'}");}
	if($r['credits']<$money){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['must_be_less_than'].$r['credits']."','key':'money'}");}
		$reason=self::$language['transfer_out'];
		$reason=str_replace("{v}",$payee,$reason);
		if(operation_credits($pdo,self::$config,self::$language,$_SESSION['monxin']['username'],'-'.$money,$reason,'other')){
			$reason=self::$language['transfer_in'];
			$reason=str_replace("{v}",$_SESSION['monxin']['username'],$reason);
			if(operation_credits($pdo,self::$config,self::$language,$payee,$money,$reason,'other')){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");	
			}	
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");	
		}
	
	
}