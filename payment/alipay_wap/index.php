<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>支付宝手机网站支付接口接口</title>
</head>
<?php
header('Content-Type:text/html;charset=utf-8');

/* *
 * 功能：手机网站支付接口接入页
 * 改者：【梦行Monxin】积木式建站系统 www.monxin.com
 * 日期：2015-07-14
 */
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

        //商户订单号
        $out_trade_no =$_POST['id'];
        //商户网站订单系统中唯一订单号，必填

        //订单名称
        $subject  = $_POST['title'];
        //必填

        //付款金额
        $total_fee = $_POST['money'];
        //必填

        //商品展示地址
        $show_url = 'http://'.$web_config['web']['domain'];
        //必填，需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html

        //订单描述
        $body ='';
        //选填

        //超时时间
        $it_b_pay = '';
        //选填

        //钱包token
        $extern_token ='';
        //选填


/************************************************************/

//构造要请求的参数数组，无需改动
$parameter = array(
		"service" => "alipay.wap.create.direct.pay.by.user",
		"partner" => trim($alipay_config['partner']),
		"seller_id" => trim($alipay_config['seller_id']),
		"payment_type"	=> $payment_type,
		"notify_url"	=> $notify_url,
		"return_url"	=> $return_url,
		"out_trade_no"	=> $out_trade_no,
		"subject"	=> $subject,
		"total_fee"	=> $total_fee,
		"show_url"	=> $show_url,
		"body"	=> $body,
		"it_b_pay"	=> $it_b_pay,
		"extern_token"	=> $extern_token,
		"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
);

//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
//file_put_contents('./test.txt',$html_text);
//exit;

echo $html_text;

?>
</body>
</html>