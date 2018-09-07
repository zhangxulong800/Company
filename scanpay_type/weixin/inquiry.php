<?php
header('Content-Type:text/html;charset=utf-8');
ini_set('session.save_path', '../../config/session/');
session_start();
require_once '../../config/functions.php';
require_once '../../lib/ConnectPDO.class.php';
$pdo=new  ConnectPDO();
$id=intval(@$_GET['id']);
if($id<0){exit('account id err');}
$sql="select * from ".$pdo->sys_pre."scanpay_account where `id`='".$id."' limit 0,1";
$account=$pdo->query($sql,2)->fetch(2);
if($account['id']==''){exit('account id not exitst');}
if($account['state']!=1){exit('account state err');}
$account['data']=json_decode(de_safe_str($account['data']),1);
define("ACCOUNT_APPID", $account['data']['appid'], true);
define("ACCOUNT_APPSECRET", $account['data']['appsecret'], true);
define("ACCOUNT_MCHID", $account['data']['mchid'], true);
define("ACCOUNT_KEY", $account['data']['key'], true);
$time=time();
$p_id=intval(@$_GET['p_id']);
if($p_id==0){echo 'p_id err';exit;}
$sql="select * from ".$pdo->sys_pre."scanpay_pay where `id`='".$p_id."'";
$r=$pdo->query($sql,2)->fetch();
if($r['id']==''){exit('p_id not exitst');}
if($r['state']!=4){header('location:../../index.php?monxin=scanpay.pay&id='.$id.'&p_id='.$p_id);exit('state!=4');}
if($r['operator']!=$_SESSION['monxin']['username']){exit('no power this p_id');}
$r=de_safe_str($r);
require_once "./lib/WxPay.Api.php";
//require_once "WxPay.MicroPay.php";
require_once 'log.php';

//初始化日志
$logHandler= new CLogFileHandler("./logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

$input = new WxPayOrderQuery();
$input->SetOut_trade_no($r['out_id']);
$r=WxPayApi::orderQuery($input);
switch(@$r['result_code']){
	case 'SUCCESS':
		$state=3;
		break;
	case 'FAIL':
		$state=1;
		break;
	case '':
		$state=1;
		break;
	default:
		$state=4;
}
$sql="update ".$pdo->sys_pre."scanpay_pay set `state`='".$state."' where `id`=".$p_id;
$pdo->exec($sql);
header('location:../../index.php?monxin=scanpay.pay&id='.$id.'&p_id='.$p_id);exit;


/**
 * 注意：
 * 1、提交被扫之后，返回系统繁忙、用户输入密码等错误信息时需要循环查单以确定是否支付成功
 * 2、多次（一半10次）确认都未明确成功时需要调用撤单接口撤单，防止用户重复支付
 */

?>
