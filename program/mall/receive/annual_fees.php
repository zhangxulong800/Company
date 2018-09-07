<?php

$act=@$_GET['act'];
if($act=='renew'){	
	$year=intval($_GET['year']);
	if($year<1){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." year err</span>'}");}
	$money=self::$config['shop_year_fees']*$year;
	
	$sql="select `money` from ".$pdo->index_pre."user where `username`='".$_SESSION['monxin']['username']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['money']<$money){exit("{'state':'fail','info':'<span class=fail>".self::$language['insufficient_balance'].",".self::$language['please'].' <a href=./index.php?monxin=index.recharge target=_blank>'.self::$language['recharge']."</a> </span>'}");}
	
	$sql="select * from ".self::$table_pre."shop where `id`='".SHOP_ID."'";
	$r=$pdo->query($sql,2)->fetch(2);
	$end_time=max(time(),$r['annual_fees'])+$year*365*86400;
	$reason=str_replace('{year}',$year,self::$language['pay_annual_reason']);
	if(operator_money(self::$config,self::$language,$pdo,$_SESSION['monxin']['username'],'-'.$money,$reason,'mall')){
		
		self::operation_finance(self::$language,$pdo,self::$table_pre,SHOP_ID,$money,1,'');
		self::operation_shop_finance(self::$language,$pdo,self::$table_pre,SHOP_ID,'-'.$money,1,'');
		if($r['agent']!=''){
			$agent=$r['agent'];
			$reason=$agent.' '.self::$language['agent_annual_percentage'].self::$config['agent_annual_percentage'].'%';
			$money=$money*(self::$config['agent_annual_percentage']/100);
			if(operator_money(self::$config,self::$language,$pdo,$agent,$money,$reason,'mall')){
				self::operation_agent_finance(self::$language,$pdo,self::$table_pre,SHOP_ID,$money,1,$reason,$r['name'],$agent);
				self::operation_finance(self::$language,$pdo,self::$table_pre,SHOP_ID,'-'.$money,7,$reason);
			}
		}
		
		$sql="update ".self::$table_pre."shop set `annual_fees`='".$end_time."' where `id`=".SHOP_ID;
		if($pdo->exec($sql)){
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','date':'".date('Y-m-d',$end_time)."'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
		
}