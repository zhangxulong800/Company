<?php
include 'wxh5.php';
$config=require_once '../../config.php';
$obj = new wxh5();

$data = array(
'title'=>$_POST['title'],
'out_trade_no'=>$_POST['id'],//自定义的订单号
'total_fee'=>$_POST['money']*100,//订单金额 只能为整数 单位为分
'domain'=>'http://'.$config['web']['domain'],
'web_name'=>$config['web']['name'],
'redirect_url'=>$_POST['return_url'],
'notify'=>'http://'.$config['web']['domain'].'/payment/wxh5_wap/notify.php',
	);

$jsApiParameters = $obj->wxh5Request($data);
if($jsApiParameters!=''){
	file_put_contents('tt.txt',$jsApiParameters );
	echo '<script>window.location.href="'.$jsApiParameters .'";</script>';exit;

}
?>
