<?php
header('Content-Type:text/html;charset=utf-8');
/**
 *	
 * 功能：扫码支付页面，生成支付二维码
 * 改者：【梦行Monxin】积木式建站系统 www.monxin.com
 * 日期：2015-07-14
 *	
 */

ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);

require_once "./lib/WxPay.Api.php";
require_once "WxPay.NativePay.php";
//require_once 'log.php';


//==================================================================================================================配置订单(充值)标题、价格、状态通知链接 start
$config=require("./config.php");
$web_config=require("../../config.php");
$timeoffset=($web_config['other']['timeoffset']>0)? "-".$web_config['other']['timeoffset']:str_replace("-","+",$web_config['other']['timeoffset']);
date_default_timezone_set("Etc/GMT$timeoffset");
if($config['state']!='opening'){exit('closed');}
$_POST['title'].=' '.$_POST['money'].'元';
if($config['rate']>0){
	$rate_fees=sprintf("%.2f", $_POST['money']*$config['rate']/100);
	if($rate_fees>0){
		$_POST['money']+=$rate_fees;
		$_POST['title'].=',+'.$config['rate'].'%手续费'.$rate_fees.'元';		
	}	
}
$_POST['money']=sprintf("%.0f", $_POST['money']*100);
//var_dump($_POST['money']);
$notify_url = 'http://'.$web_config['web']['domain'].'/'.$config['notify_url'];
//===================================================================================================================配置订单(充值)标题、价格、状态通知链接 end

//模式一
/**
 * 流程：
 * 1、组装包含支付信息的url，生成二维码
 * 2、用户扫描二维码，进行支付
 * 3、确定支付之后，微信服务器会回调预先配置的回调地址，在【微信开放平台-微信支付-支付配置】中进行配置
 * 4、在接到回调通知之后，用户进行统一下单支付，并返回支付信息以完成支付（见：native_notify.php）
 * 5、支付完成之后，微信服务器会通知支付成功
 * 6、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
 */
$notify = new NativePay();
//$url1 = $notify->GetPrePayUrl("123456789");

//模式二
/**
 * 流程：
 * 1、调用统一下单，取得code_url，生成二维码
 * 2、用户扫描二维码，进行支付
 * 3、支付完成之后，微信服务器会通知支付成功
 * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
 */
$input = new WxPayUnifiedOrder();
$input->SetBody($_POST['title']);
$input->SetAttach($_POST['title']);
$input->SetOut_trade_no($_POST['id']);
$input->SetTotal_fee($_POST['money']);
$input->SetTime_start(date("YmdHis"));
//$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag($_POST['title']);
$input->SetNotify_url($notify_url);
$input->SetTrade_type("NATIVE");
$input->SetProduct_id("123456789");
$result = $notify->GetPayUrl($input);
if(!isset($result["code_url"])){var_dump($result);exit;}
$url2 = $result["code_url"];
?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
	<script src="../../public/jquery.js"></script>
	
	
    <title><?php echo $_POST['title'];?></title>
	<style>
	*{margin:0px;padding:0px;  font-weight:bold;}
	.inner_div{width:1319px; text-align:center; margin:auto; overflow:hidden; }
	.top{ border-bottom:2px  #CCCCCC solid; padding-bottom:20px;}
	.top .logo{ padding-top:10px; display:inline-block; width:50%; overflow:hidden;text-align:left;}
	.top .logo img{ height:100px; border:none;}
	.top .return{ display:inline-block; width:45%; overflow:hidden; text-align:right; line-height:100px; padding-right:3%; font-size:24px; color:#F00; text-decoration:none;}
	.top .return:hover{ color:#000;}
	.middle{ text-align:center;}
	.middle .title{ font-size:24px; line-height:80px;}
	.middle .qr{ }
	.middle .qr img{ width:200px;}
	.bottom{ line-height:100px; text-align:center; font-size:24px;}
	.sum{display:none;}
	</style>
</head>
<body>
<script>
var t1 ;
var sum=0;
$(document).ready(function(){

	function update_native_state(){
		sum++;
		if(sum>600){window.clearInterval(t1);return false;}
		if(sum>180){
			m=sum % 10;
			if(m!=0){return false;}
		}	
		$(".sum").html(sum);
		$.get('./native_state.php?id=<?php echo $_POST['id'];?>',function(data){
//alert(data);			
			v=eval("("+data+")");
			if(v.state=='USERPAYING'){$(".bottom").html('微信扫描成功请在手机确认支持');}
			//alert(v.state);
			if(v.state=='success'){
				window.clearInterval(t1);
				//alert(data);
				//alert(v.url);
				if(v.url==''){
					$(".qr img").attr('src','done.png');
					$(".bottom").html('支付成功，<a href=../../index.php?monxin=index.financial_center>查看</a>');
				}else{
					window.location.href=v.url;	
				}				
			}		
		});		
	}
    t1 = window.setInterval(update_native_state,1000); 
	
	
	
	// window 失去焦点，停止输出
	window.onblur = function() {
		clearInterval(t1);
	};
		 
	// window 每次获得焦点
	window.onfocus = function() {
		// 每 1 秒在页面输出一个数
		t1 = setInterval(function() {
			update_native_state();
		}, 1000);
	}	
});
</script>

	<div class=out_div>
		<div class=inner_div>
			<div class=top><a href=../../index.php target=_blank class=logo><img src=../../logo.png /></a><a href="javascript:history.go(-1);" target=_blank class=return>选择其它支付方式</a></div>
			<div class=middle>
				<div class=title><?php echo $_POST['title'];?></div>
				<div class=qr><img alt="<?php echo $_POST['title'];?>" src="./qrcode/index.php?text=<?php echo urlencode($url2);?>&logo=1" /></div>
			</div>
			<div class=bottom>请使用微信扫描以上二维码完成支付</div>
			<div class=sum></div>
		</div>
	</div>
	
	
</body>
</html>