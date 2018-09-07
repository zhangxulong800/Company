<?php
header('Content-Type:text/html;charset=utf-8');
$key='01520109014125000';
$merchantid='A52E53D3B6FE39EF33326C297BB05AA9305E8C7042E2DD62';
if ($merchantid!=null)
		{	
				if($p=1) {
						$merid='';
						$ordid = "00" . date('YmdHis'); # Order ID
						//$ordid = '0020141119113004'; # Order ID
						$attachamount = "0.00"; # Payment Version
						$productamount='0.01';
						$orderamount =$attachamount+$productamount; # Amount
					
						$orderdate=date('YmdHis');
						//$orderdate='20141119112328';
						//md5 mac
						$macmd5="MERCHANTID=$merchantid&ORDERSEQ=$ordid&ORDERDATE=$orderdate&ORDERAMOUNT=$orderamount&KEY=$key";
						//$mac='c612179b6364333aa91afcba75c2479e';
						
						$mac=md5($macmd5);
						
						$curtype='RMB';
						$orderreqtranseq="99" . date('YmdHis'); # Order ID
						$encodetype = "1"; # Currency Type, Use CNY
						$transdate = date('Ymd'); # Order Date
						$busicode = "0001"; # Transaction type, Consume
						
						$pagereturl = "http://www.Bestpay.com/mobile.backurl.php"; # Feedback Url
						$bgreturl = "http://www.Bestpay.cc/mobile.backurl.php";
						$productdesc='Iphone6 plus';
						
						$productid='20';
						$tmnum='02';
						$customerid='08';
				?>
				<html>
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
				<?php
				}
				else {
						die('Failed');
				}
				exit();
		}

?>