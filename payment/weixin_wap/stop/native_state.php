<?php
header('Content-Type:text/html;charset=utf-8');
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
$id=intval(@$_GET['id']);
if($id==0){exit("{'state':'fail','info':'<span class=fail>fail</span>'}");}

$config=require("./config.php");
if($config['state']!='opening'){exit('closed');}
$config=require('../../config.php');
$language=require('../../language/'.$config['web']['language'].'.php');
require_once '../../config/functions.php';
require_once '../../lib/ConnectPDO.class.php';
$pdo=new  ConnectPDO();

$sql="select `state`,`return_url` from ".$pdo->index_pre."recharge where id=".$id;
//echo $sql;
$r=$pdo->query($sql,2)->fetch(2);

if($r['state']==4){exit("{'state':'success','info':'<span class=success>".$language['success']."</span>','url':'".$r['return_url']."'}");}


require_once "./lib/WxPay.Api.php";
require_once 'log.php';

//初始化日志
$logHandler= new CLogFileHandler("./logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

function printf_info($data)
{
    foreach($data as $key=>$value){
        echo "<font color='#f00;'>$key</font> : $value <br/>";
    }
}
	$out_trade_no=$id;
	$input = new WxPayOrderQuery();
	$input->SetOut_trade_no($out_trade_no);
	$r=WxPayApi::orderQuery($input);
	//var_dump($r);
	//$r['trade_state']='USERPAYING';
	exit("{'state':'".$r['trade_state']."','info':'".$r['trade_state']."'}");
	exit();

?>