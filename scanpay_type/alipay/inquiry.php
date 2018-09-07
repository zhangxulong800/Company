<?php 
header("Content-type: text/html; charset=utf-8");
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

$account['data']=de_safe_str($account['data']);
$account['data']=str_replace("\n","111",$account['data']);
$account['data']=str_replace("- ","-",$account['data']);
$account['data']=str_replace(" -","-",$account['data']);
$r=json_decode($account['data'],1);
$r['private_key']=str_replace("111","\n",$r['private_key']);
define("APP_ID", $r['app_id'], true);
define("PRIVATE_KEY", $r['private_key'], true);




$time=time();
$p_id=intval(@$_GET['p_id']);
if($p_id==0){echo 'p_id err';exit;}
$sql="select * from ".$pdo->sys_pre."scanpay_pay where `id`='".$p_id."'";
$r=$pdo->query($sql,2)->fetch();
if($r['id']==''){exit('p_id not exitst');}
if($r['state']!=0){header('location:../../index.php?monxin=scanpay.pay&id='.$id.'&p_id='.$p_id);exit('state!=0');}
if($r['operator']!=$_SESSION['monxin']['username']){exit('no power this p_id');}
if($r['time']<time()-60){
	$sql="update ".$pdo->sys_pre."scanpay_pay set `state`=2 where `id`=".$r['id']." limit 1";
	$pdo->exec($sql);
	exit('条码过期,<a href="javascript:history.go(-1);">返回</a>');
}
$r=de_safe_str($r);

function alipay_inquiry($r){
	//print_r($r);
	$r_state=$r->alipay_trade_query_response->trade_status;
	$fail_reason='';
	switch($r_state){
		case 'TRADE_SUCCESS':
			$state=3;
			break;
		case 'WAIT_BUYER_PAY':
			$state=4;
			break;
		default:
			$state=1;	
	}
	return $state;
}

require_once 'F2fpay.php';
	$f2fpay = new F2fpay();
	
	$out_trade_no = $r["out_id"];
	$auth_code = $r["barcode"];
	$total_amount = $r["money"];
	$subject =$r["out_id"];
	$r = 	$f2fpay->barpay($out_trade_no, $auth_code, $total_amount, $subject);
	//print_r($r);
	$r_state=$r->alipay_trade_pay_response->code;
	$fail_reason='';
	switch($r_state){
		case '10000':
			$re=$f2fpay->query($out_trade_no);
			$state=alipay_inquiry($re);
			break;
		case '10003':
			$re=$f2fpay->query($out_trade_no);
			$state=alipay_inquiry($re);
			break;
		case '40004':
			$state=1;
			$fail_reason=$r->alipay_trade_pay_response->msg.' '.$r->alipay_trade_pay_response->sub_desc;
			break;
		default:
		  $state=1;	
		  $fail_reason=$r->alipay_trade_pay_response->msg;
			
	}
	
	$sql="update ".$pdo->sys_pre."scanpay_pay set `state`='".$state."',`fail_reason`='".$fail_reason."' where `id`=".$p_id;
	$pdo->exec($sql);
	header('location:../../index.php?monxin=scanpay.pay&id='.$id.'&p_id='.$p_id);exit;
	
	return ;
	exit;

?>
