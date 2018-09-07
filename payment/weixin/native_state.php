<?php
header('Content-Type:text/html;charset=utf-8');
/**
 *	
 * 功能：查询扫码支付状态，并返回给扫码支付前台页面
 * 改者：【梦行Monxin】积木式建站系统 www.monxin.com
 * 日期：2015-07-14
 *	
 */
header('Content-Type:text/html;charset=utf-8');
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
$id=floatval(@$_GET['id']);
if($id==0){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
//====================================================================================================================================查数据库检测充值状态 start
$config=require("./config.php");
if($config['state']!='opening'){exit('closed');}
$config=require('../../config.php');
$timeoffset=($config['other']['timeoffset']>0)? "-".$config['other']['timeoffset']:str_replace("-","+",$config['other']['timeoffset']);
date_default_timezone_set("Etc/GMT$timeoffset");
$language=require('../../language/'.$config['web']['language'].'.php');
require_once '../../config/functions.php';
require_once '../../lib/ConnectPDO.class.php';
$pdo=new  ConnectPDO();
$sql="select `state`,`return_url` from ".$pdo->index_pre."recharge where `in_id`=".$id;
$r=$pdo->query($sql,2)->fetch(2);
if($r['state']==4){exit("{'state':'success','info':'<span class=success>".$language['success']."</span>','url':'".$r['return_url']."'}");}
$return_url=$r['return_url'];
//====================================================================================================================================查数据库检测充值状态 end


require_once "./lib/WxPay.Api.php";

/*
require_once 'log.php';

//初始化日志
$logHandler= new CLogFileHandler("./logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);
*/
	$out_trade_no=$id;
	$input = new WxPayOrderQuery();
	$input->SetOut_trade_no($out_trade_no);
	$r=WxPayApi::orderQuery($input);
	//var_dump($out_trade_no);
	//$r['trade_state']='USERPAYING';
	if($r['trade_state']=='SUCCESS'){update_recharge($pdo,$config,$language,$id,$r['total_fee']/100);}
	$r['trade_state']=strtolower($r['trade_state']);
	exit("{'state':'".$r['trade_state']."','info':'".$r['trade_state']."','url':'".$return_url."'}");
	exit();

?>