<?php
header('Content-Type:text/html;charset=utf-8');
/* * 
 * 功能：支付宝页面跳转同步通知页面
 * 改者：【梦行Monxin】积木式建站系统 www.monxin.com
 * 日期：2015-07-14
 * 说明：
 */

require_once("alipay.config.php");
require_once("lib/alipay_notify.class.php");
$config=require("./config.php");
if($config['state']!='opening'){exit('closed');}

?>
<!DOCTYPE HTML>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代码
	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

	//商户订单号

	$out_trade_no = $_GET['out_trade_no'];

	//支付宝交易号

	$trade_no = $_GET['trade_no'];

	//交易状态
	$trade_status = $_GET['trade_status'];


    if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
		//判断该笔订单是否在商户网站中已经做过处理
			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
			//如果有做过处理，不执行商户的业务程序
		
		//===============================================================================================================================更新充值状态 start	
			$config=require('../../config.php');
			$timeoffset=($config['other']['timeoffset']>0)? "-".$config['other']['timeoffset']:str_replace("-","+",$config['other']['timeoffset']);
			date_default_timezone_set("Etc/GMT$timeoffset");
			$language=require('../../language/'.$config['web']['language'].'.php');
			require_once '../../config/functions.php';
			require_once '../../lib/ConnectPDO.class.php';
			$pdo=new  ConnectPDO();
			$id=$out_trade_no;
			if(update_recharge($pdo,$config,$language,$id,$_GET['total_fee'])){
				
			}else{
				
			}
		//===============================================================================================================================更新充值状态 end	
    }
    else {
      echo "trade_status=".$_GET['trade_status'];
    }
		header('location:../../index.php?monxin=index.financial_center');	
	
	//echo "验证成功<br />";

	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
    //验证失败
    //如要调试，请看alipay_notify.php页面的verifyReturn函数
    echo "验证失败";
}
?>
        <title>支付宝即时到账交易接口</title>
	</head>
    <body>
    </body>
</html>