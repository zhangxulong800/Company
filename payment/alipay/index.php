<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>支付宝即时到账交易接口接口</title>
</head>
<?php
/* *
 * 功能：即时到账交易接口接入页
 * 改者：【梦行Monxin】积木式建站系统 www.monxin.com
 * 日期：2015-07-14
 */
header('Content-Type:text/html;charset=utf-8');
require_once("alipay.config.php");
require_once("lib/alipay_submit.class.php");

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

//服务器异步通知页面路径
$notify_url = (@$_POST['notify_url']!='')?$_POST['notify_url']:'http://'.$web_config['web']['domain'].'/'.$config['notify_url'];
//需http://格式的完整路径，不能加?id=123这类自定义参数

//页面跳转同步通知页面路径
$return_url = (@$_POST['return_url']!='')?$_POST['return_url']:'http://'.$web_config['web']['domain'].'/'.$config['return_url'];
//需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

//==================================================================================================================配置订单(充值)标题、价格、状态通知链接 end


/**************************请求参数**************************/

        //支付类型
        $payment_type = "1";
        //必填，不能修改
        
        //卖家支付宝帐户
        $seller_email = $config['username'];
        //必填

        //商户订单号
        $out_trade_no = $_POST['id'];
        //商户网站订单系统中唯一订单号，必填

        //订单名称
        $subject = $_POST['title'];
        //必填

        //付款金额
        $total_fee = $_POST['money'];
        //必填

        //订单描述

        $body = $_POST['title'];
        //商品展示地址
        $show_url = '';
        //需以http://开头的完整路径，例如：http://www.xxx.com/myorder.html

        //防钓鱼时间戳
        $anti_phishing_key = "";
        //若要使用请调用类文件submit中的query_timestamp函数

        //客户端的IP地址
        $exter_invoke_ip = "";
        //非局域网的外网IP地址，如：221.0.0.1


/************************************************************/

//构造要请求的参数数组，无需改动
$parameter = array(
		"service" => "create_direct_pay_by_user",
		"partner" => trim($alipay_config['partner']),
		"payment_type"	=> $payment_type,
		"notify_url"	=> $notify_url,
		"return_url"	=> $return_url,
		"seller_email"	=> $seller_email,
		"out_trade_no"	=> $out_trade_no,
		"subject"	=> $subject,
		"total_fee"	=> $total_fee,
		"body"	=> $body,
		"show_url"	=> $show_url,
		"anti_phishing_key"	=> $anti_phishing_key,
		"exter_invoke_ip"	=> $exter_invoke_ip,
		"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
);

//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
echo $html_text;

?>
</body>
</html>