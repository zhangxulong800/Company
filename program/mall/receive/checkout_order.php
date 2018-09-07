<?php
$act=@$_GET['act'];

if($act=='cancel'){
	$id=intval(@$_GET['id']);
	if($id==0){exit("{'state':'fail','info':'<span class=fail>id is 0</span>'}");}
	$sql="select * from ".self::$table_pre."order where `shop_id`=".SHOP_ID." and `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>id is err</span>'}");}
	if($r['cashier']=='monxin'){exit("{'state':'fail','info':'<span class=fail>the order not is checkout add</span>'}");}
	if($r['state']!=6){exit("{'state':'fail','info':'<span class=fail>order state is not 6</span>'}");}
	if($r['pay_method']!='balance' && $r['pay_method']!='cash' && $r['pay_method']!='credit' && $r['pay_method']!='weixin' && $r['pay_method']!='alipay'){exit("{'state':'fail','info':'<span class=fail>the order not is checkout add</span>'}");}

	if($r['receipt']==1 || $r['cashier']!='monxin'){
		self::introducer_return_fees($pdo,$r);	
	}
	
	if($r['pay_method']=='balance'){
		$reason=str_replace('{order_id}',$r['out_id'],self::$language['return_order_money_template']);
		$reason=str_replace('{sum_money}',$r['actual_money'],$reason);
		if(!operator_money(self::$config,self::$language,$pdo,$r['buyer'],$r['actual_money'],$reason,'mall')){
			exit("{'state':'fail','info':'<span class=fail>return money err</span>'}");
		}
	}
	
	$result=$pdo->exec("update ".self::$table_pre."order set `state`=10 where `id`=".$id);
	if($result){
		self::return_goods_quantity($pdo,self::$table_pre,$id,$r['inventory_decrease']);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");	
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}