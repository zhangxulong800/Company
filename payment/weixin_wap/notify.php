<?php
header('Content-Type:text/html;charset=utf-8');
/**
 *	
 * 功能：接收处理 JSAPI（微信浏内部览器）发起的支付 返回通知结果
 * 改者：【梦行Monxin】积木式建站系统 www.monxin.com
 * 日期：2015-07-14
 *	
 */
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);

require_once "./lib/WxPay.Api.php";
require_once './lib/WxPay.Notify.php';

/*
require_once 'log.php';
//初始化日志
$logHandler= new CLogFileHandler("./logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);
*/
class PayNotifyCallBack extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		//Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		//Log::DEBUG("call back:" . json_encode($data));
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}
		
		//===============================================================================================================================更新充值状态 start	
		$config=require("./config.php");
		if($config['state']!='opening'){exit('closed');}
		$config=require('../../config.php');
		$timeoffset=($config['other']['timeoffset']>0)? "-".$config['other']['timeoffset']:str_replace("-","+",$config['other']['timeoffset']);
		date_default_timezone_set("Etc/GMT$timeoffset");
		$language=require('../../language/'.$config['web']['language'].'.php');
		require_once '../../config/functions.php';
		require_once '../../lib/ConnectPDO.class.php';
		$pdo=new  ConnectPDO();
		$r=$data;
		$id=$data["out_trade_no"];
		//file_put_contents('./rr.txt',$id);
		file_put_contents('w2.txt',$r['total_fee']);
		update_recharge($pdo,$config,$language,$id,$r['total_fee']/100);
		//===============================================================================================================================更新充值状态 end	
		return true;
	}
}

//Log::DEBUG("begin notify");
$notify = new PayNotifyCallBack();
$notify->Handle(false);
