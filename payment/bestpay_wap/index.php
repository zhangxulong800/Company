<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>翼支付PC接口</title>
</head>
<?php
header('Content-Type:text/html;charset=utf-8');
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

$key=$config['key'];
$merchantid=$config['id'];
		if ($merchantid!=null)
		{	
			$order_amount=222;
				if($p=1) {
						$merid=$config['id'];
						$ordid = $_POST['id']; # Order ID
						//$ordid = '0020141119113004'; # Order ID
						$attachamount = "0"; # Payment Version
						$productamount=$_POST['money']*100;
						$orderamount =$attachamount+$productamount; # Amount
						
						$orderdate=date('YmdHis');
						//$orderdate='20141119112328';
						//md5 mac
						$macmd5="MERCHANTID=$merchantid&ORDERSEQ=$ordid&ORDERDATE=$orderdate&ORDERAMOUNT=$orderamount&KEY=$key";
						//$mac='c612179b6364333aa91afcba75c2479e';
						$mac=md5($macmd5);
						
						$curtype='RMB';
						$orderreqtranseq=$_POST['id']; # Order ID
						$encodetype = "1"; # Currency Type, Use CNY
						$transdate = date('Ymd'); # Order Date
						$busicode = "0001"; # Transaction type, Consume
						
						$pagereturl = $return_url; # Feedback Url
						$bgreturl = $notify_url;
						$productdesc=$_POST['title'];
						
						$productid='08';
						$tmnum='08';
						$customerid='08';

				}
		}else{
			exit('Failed');
		}

?>
<body onLoad="document.getElementById('form').submit();">
<form id="form" action="https://wappaywg.bestpay.com.cn/payWap.do" method="post">
    <input type=hidden name="MERCHANTID" value="<?php echo $merid; ?>"/>
    <input type=hidden name="ORDERSEQ" value="<?php echo $ordid; ?>"/>
    <input type=hidden name="ORDERREQTRANSEQ" value="<?php echo $orderreqtranseq; ?>"/>
    <input type=hidden name="ORDERDATE" value="<?php echo $orderdate; ?>"/>
    <input type=hidden name="ORDERAMOUNT" value="<?php echo $orderamount; ?>"/>
    <input type=hidden name="PRODUCTAMOUNT" value="<?php echo $productamount; ?>"/>
    <input type=hidden name="ATTACHAMOUNT" value="<?php echo $attachamount; ?>"/>
    
    <input type=hidden name="CURTYPE" value="<?php echo $curtype; ?>"/>
    <input type=hidden name="ENCODETYPE" value="<?php echo $encodetype; ?>"/>
    <input type=hidden name="MERCHANTURL" value="<?php echo $pagereturl; ?>"/>
    <input type=hidden name="BACKMERCHANTURL" value="<?php echo $bgreturl; ?>"/>
    <input type=hidden name="BUSICODE" value="<?php echo $busicode; ?>"/>
    <input type=hidden name="PRODUCTDESC" value="<?php echo $productdesc; ?>"/>
    <input type=hidden name="PRODUCTID" value="<?php echo $productid; ?>"/>
    <input type=hidden name="TMNUM" value="<?php echo $tmnum?>"/>
    <input type=hidden name="CUSTOMERID" value="<?php echo $customerid?>"/>
    <input type=hidden name="MAC" value="<?php echo $mac; ?>"/>
</form>
</body>
</html>
