<?php 
header('Content-Type:text/html;charset=utf-8');
/**
 *	
 * 功能：JSAPI（微信浏内部览器）发起支付
 * 改者：【梦行Monxin】积木式建站系统 www.monxin.com
 * 日期：2015-07-14
 *	
 */
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);

//==================================================================================================================配置订单(充值)标题、价格、状态通知链接 start
$config=require("./config.php");
if($config['state']!='opening'){exit('closed');}
if(!isset($_GET['code'])){
	$_POST['title'].=' '.$_POST['money'].'元';
	if($config['rate']>0){
		$rate_fees=sprintf("%.2f", $_POST['money']*$config['rate']/100);
		if($rate_fees>0){
			$_POST['money']+=$rate_fees;
			$_POST['title'].=',+'.$config['rate'].'%手续费'.$rate_fees.'元';		
		}	
	}
	$_POST['money']=sprintf("%.0f", $_POST['money']*100);
}
$web_config=require("../../config.php");
$timeoffset=($web_config['other']['timeoffset']>0)? "-".$web_config['other']['timeoffset']:str_replace("-","+",$web_config['other']['timeoffset']);
date_default_timezone_set("Etc/GMT$timeoffset");
$notify_url = 'http://'.$web_config['web']['domain'].'/'.$config['notify_url'];
//==================================================================================================================配置订单(充值)标题、价格、状态通知链接 end


require_once "./lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";

/*
require_once 'log.php';
//初始化日志
$logHandler= new CLogFileHandler("./logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);
*/

//①、获取用户openid
$tools = new JsApiPay();

$openId = $tools->GetOpenid();
//②、统一下单

$input = new WxPayUnifiedOrder();
$input->SetBody($_GET['title']);
$input->SetAttach($_GET['title']);
$input->SetOut_trade_no($_GET['id']);
$input->SetTotal_fee($_GET['money']);
$input->SetTime_start(date("YmdHis"));
//$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag($_GET['title']);
$input->SetNotify_url($notify_url);
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);
//echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
//printf_info($order);
if($order['return_code']=='FAIL'){exit($order['return_msg']);}
$jsApiParameters = $tools->GetJsApiParameters($order);

//获取共享收货地址js函数参数
$editAddress = $tools->GetEditAddressParameters();

//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
/**
 * 注意：
 * 1、当您的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
 */
 
//==================================================================================================================配置支付成功后的返回链接 start 
require_once '../../config/functions.php';
require_once '../../lib/ConnectPDO.class.php';
$pdo=new  ConnectPDO();
$sql="select `return_url` from ".$pdo->index_pre."recharge where `in_id`=".floatval($_GET['id']);
//echo $sql;
$r=$pdo->query($sql,2)->fetch(2);
if($r['return_url']==''){$return_url='../../index.php?monxin=index.financial_center';}else{$return_url=de_safe_str($r['return_url']);}
//==================================================================================================================配置支付成功后的返回链接 end 
?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/> 
	<script src="../../public/jquery.js"></script>
    <title>微信支付</title>
    <script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $jsApiParameters; ?>,
			function(res){
				WeixinJSBridge.log(res.err_msg);
				//alert(res.err_code+','+res.err_desc+','+res.err_msg);
				if(res.err_msg=='get_brand_wcpay_request:ok'){	
					window.location='<?php echo $return_url;?>';	
					$(".act").html('<img src=./done.png /><br >支付完成，<a href=<?php echo $return_url;?> >返回</a>');
				}
				if(res.err_msg=='get_brand_wcpay_request:cancel'){
					$('button').css('opacity',1);	
				}
				if(res.err_msg=='get_brand_wcpay_request:fail'){
					$('button').css('opacity',1);
					alert(res.err_code+','+res.err_desc+','+res.err_msg);				
					
				}
			}
		);
	}

	function callpay()
	{
		//alert($('button').css('opacity'));
		if($('button').css('opacity')!=1){return false;}
		$('button').css('opacity','0.1');
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	
	
	$(document).ready(function(){
		callpay();
	});
	</script>

	<style>
	*{margin:0px;padding:0px;  font-weight:bold;}
	.inner_div{text-align:center; margin:auto; overflow:hidden; padding:10px; }
	.top{ padding-top:20px; border-bottom:2px  #CCCCCC solid; padding-bottom:20px;}
	.top .logo{ }
	.top .logo img{ width:100%; border:none;}
	.top .return{ text-decoration:none;}
	.top .return:hover{ color:#000;}
	.middle{ text-align:center;}
	.middle .title{ font-size:24px; line-height:40px;}
	.act{text-align:center; }
	.act img{width:50%; }
	</style>
</head>
<body>

	<div class=out_div>
		<div class=inner_div>
			<div class=top><a href=../../index.php target=_blank class=logo><img src=../../logo.png /></a></div>
			<div class=middle>
				<div class=title><?php echo $_GET['title'];?></div>
				<div class=act>
					<br /><button style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onClick="callpay()" >微信立即支付</button>
					<br /><br /><br /><a href="javascript:history.go(-1);" target=_blank class=return>选择其它支付方式</a>
				</div>
			</div>

		</div>
	</div>
	
	
</body>
</html>


