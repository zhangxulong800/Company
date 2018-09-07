<?php
$act=@$_GET['act'];
$v=@$_GET['v'];
$v=str_replace('|||','&',$v);
$config=require('./program/im/config.php');
switch($act){
	case 'sms_fees':
		$v=floatval($v);
		break;
	case 'online_pay_fees':
		$v=floatval($v);
		break;
	case 'shop_year_fees':
		$v=floatval($v);
		break;
	case 'annual_shop_order_fees':
		$v=floatval($v);
		break;
	case 'times_shop_order_fees':
		$v=floatval($v);
		break;
	case 'ad_fees':
		$v=floatval($v);
		break;
	case 'manage_fees':
		$v=floatval($v);
		break;
	case 'agent_add_shop_fedds':
		$v=floatval($v);
		break;
	case 'agent_annual_percentage':
		$v=floatval($v);
		break;
	case 'agent_trading_volume_percentage':
		$v=floatval($v);
		break;
	case 'receipt_time_limit':
		$v=intval($v);
		break;
	case 'refund_time_limit':
		$v=intval($v);
		break;
	case 'comment_time_limit':
		$v=intval($v);
		break;
	case 'pay_time_limit':
		$v=intval($v);
		break;
	case 'show_sold':
		$v=($v=='true')?true:false;
		break;
	case 'show_comment':
		$v=($v=='true')?true:false;
		break;
	case 'checkout_order_notice_email':
		$v=($v=='true')?true:false;
		break;
	case 'checkout_order_notice_sms':
		$v=($v=='true')?true:false;
		break;
	case 'phone_goods_list_show_buy_button':
		$v=($v=='true')?true:false;
		break;
	case 'unlogin_buy':
		$v=($v=='true')?true:false;
		break;

	case 'send_notice_email':
		$v=($v=='true')?true:false;
		break;
	case 'send_notice_sms':
		$v=($v=='true')?true:false;
		break;



	case 'comment_check':
		$v=($v=='true')?true:false;
		break;
	case 'cart_show_independent':
		$v=intval($v);
		break;
	case 'order_get_interval':
		$v=intval($v);
		break;
	case 'order_auto_print_max':
		$v=intval($v);
		break;
	case 'order_auto_print_quantiy':
		$v=intval($v);
		break;
		
			
}
if(isset($config[$act])){
	$config[$act]=$v;
	if(file_put_contents('./program/im/config.php','<?php return '.var_export($config,true).'?>')){
		echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
	}else{
		echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
	}	
}