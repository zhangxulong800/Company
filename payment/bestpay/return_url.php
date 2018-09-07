<?php
header('Content-Type:text/html;charset=utf-8');
$config=require("./config.php");
if($config['state']!='opening'){exit('closed');}
?>
<?php

//==========================================================================================================================配置更新充值状态所需变量 start
$config=require('../../config.php');
$timeoffset=($config['other']['timeoffset']>0)? "-".$config['other']['timeoffset']:str_replace("-","+",$config['other']['timeoffset']);
date_default_timezone_set("Etc/GMT$timeoffset");
$language=require('../../language/'.$config['web']['language'].'.php');
require_once '../../config/functions.php';
require_once '../../lib/ConnectPDO.class.php';
$pdo=new  ConnectPDO();
//==========================================================================================================================配置更新充值状态所需变量 end
$config=require("./config.php");
$key=$config['key'];
$merchantid=$config['id'];
if($_POST['UPTRANSEQ']!=null){
			$UPTRANSEQ=$_POST['UPTRANSEQ'];
			$TRANDATE=$_POST['TRANDATE'];
			$RETNCODE=$_POST['RETNCODE'];
			$RETNINFO=$_POST['RETNINFO'];
			$ORDERREQTRANSEQ=$_POST['ORDERREQTRANSEQ'];
			$ORDERSEQ=$_POST['ORDERSEQ'];
			$ORDERAMOUNT=$_POST['ORDERAMOUNT'];
			$PRODUCTAMOUNT=$_POST['PRODUCTAMOUNT'];
			$ATTACHAMOUNT=$_POST['ATTACHAMOUNT'];
			$CURTYPE=$_POST['CURTYPE'];
			$ENCODETYPE=$_POST['ENCODETYPE'];
			$BANKID=$_POST['BANKID'];
			$SIGN=$_POST['SIGN'];
			//compare sign
			$originalsign="UPTRANSEQ=$UPTRANSEQ&MERCHANTID=$merchantid&ORDERID=$ORDERSEQ&PAYMENT=$ORDERAMOUNT&RETNCODE=$RETNCODE&RETNINFO=$RETNINFO&PAYDATE=$TRANDATE&KEY=$key";
			
			$md5_originalsign=strtoupper(md5($originalsign));
			//$sub_originalsign=str_replace(array("\t","\n","\r"),'',stripcslashes($md5_originalsign));
			if($SIGN==$md5_originalsign){
				$id=$ORDERSEQ;
				update_recharge($pdo,$config,$language,$id);//更新充值状态
				header('location:../../index.php?monxin=index.financial_center');
				
			}
			else{
				echo '<!DOCTYPE HTML>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>翼支付结果返回</title>
	</head>
    <body>
		<div align="center">'.$language['pay'].$language['fail'].'<a href=./index.php?monxin=index.recharge_log>'.$language['return'].'</a></div>
    </body>
</html>';			
			}
			
		}


?>