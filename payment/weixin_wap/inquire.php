<?php
header('Content-Type:text/html;charset=utf-8');
/**
 *	
 * 功能：查询支付结果
 * 改者：【梦行Monxin】积木式建站系统 www.monxin.com
 * 日期：2015-07-14
 *	
 */

ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);

require_once "./lib/WxPay.Api.php";
//require_once "WxPay.NativePay.php";
//require_once 'log.php';


//==================================================================================================================配置订单(充值)标题、价格、状态通知链接 start
$config=require("./config.php");
$web_config=require("../../config.php");
$timeoffset=($web_config['other']['timeoffset']>0)? "-".$web_config['other']['timeoffset']:str_replace("-","+",$web_config['other']['timeoffset']);
date_default_timezone_set("Etc/GMT$timeoffset");
if($config['state']!='opening'){exit('closed');}

if(isset($_GET["in_id"]) && $_GET["in_id"] != ""){
	$out_trade_no = floatval($_GET["in_id"]);
	$input = new WxPayOrderQuery();
	$input->SetOut_trade_no($out_trade_no);
	$r=WxPayApi::orderQuery($input);
	if($r['trade_state']=='SUCCESS'){
		//===============================================================================================================================更新充值状态 start	
		$config=require('../../config.php');
		$timeoffset=($config['other']['timeoffset']>0)? "-".$config['other']['timeoffset']:str_replace("-","+",$config['other']['timeoffset']);
		date_default_timezone_set("Etc/GMT$timeoffset");
		$language=require('../../language/'.$config['web']['language'].'.php');
		require_once '../../config/functions.php';
		require_once '../../lib/ConnectPDO.class.php';
		$pdo=new  ConnectPDO();
		file_put_contents('w.txt',$r['total_fee']);
		if(update_recharge($pdo,$config,$language,$out_trade_no,$r['total_fee']/100)){exit('success');}else{exit('fail');}
		//===============================================================================================================================更新充值状态 end	
	}else{
		exit('fail');	
	}
	exit();
}

