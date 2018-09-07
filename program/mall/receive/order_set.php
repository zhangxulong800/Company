<?php
$act=@$_GET['act'];
$field=array('pay_ad_fees','credits_rate','decrease_quantity','order_notice_when','print_supplier','print_partner','print_apikey','print_machine_code','print_msign','phone_goods_list_show_buy_button','credit');
if(!in_array($act,$field)){echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']." act err</span>'}";}
$v=safe_str(@$_GET['v']);
if($act=='id' || $act=='shop_id'){echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";}
$sql="select `id` from ".self::$table_pre."shop_order_set where `shop_id`=".SHOP_ID;
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']==''){
	$sql="insert into ".self::$table_pre."shop_order_set (`shop_id`,`decrease_quantity`,`order_notice_when`,`order_notice_email`,`send_notice_email`,`send_notice_sms`,`checkout_order_notice_email`,`checkout_order_notice_sms`,`phone_goods_list_show_buy_button`,`cash_on_delivery`,`credit`,`pay_ad_fees`,`pay_ad_fees_open_time`) values('".SHOP_ID."','6','1','','1','1','1','1','1','1','0','0','0')";
	$pdo->exec($sql);
}
$sql="update ".self::$table_pre."shop_order_set set `".$act."`='".$v."' where `shop_id`=".SHOP_ID;
if($act=='pay_ad_fees'){
	$sql="select `pay_ad_fees_open_time`,`pay_ad_fees` from ".self::$table_pre."shop_order_set where `shop_id`=".SHOP_ID;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['pay_ad_fees']==1){if($r['pay_ad_fees_open_time']>(time()-30*86400)){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail'].",".self::$language['pay_ad_fees_open_time'].date('Y-m-d',$r['pay_ad_fees_open_time'])."</span>'}");}}
	
	$sql="update ".self::$table_pre."shop_order_set set `".$act."`='".$v."',`pay_ad_fees_open_time`=".time()." where `shop_id`=".SHOP_ID;	
}
if($pdo->exec($sql)){
	echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
}else{
	echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
}	
