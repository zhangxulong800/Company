<?php 
function alipay_refund($id,$PrivateKey,$PublicKey,$out_trade_no,$money){
	require_once('./aop/AopSdk.php');
	$aop = new AopClient ();
	$aop->appId = $id;
	$aop->rsaPrivateKey = $PrivateKey;
	$aop->alipayrsaPublicKey=$PublicKey;
	$aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
	$aop->apiVersion = '1.0';
	$aop->signType = 'RSA2';
	$aop->postCharset='utf-8';
	$aop->format='json';
	$date=date("YmdHis");
	$arr=range(1000,9999);
	shuffle($arr);
	$request = new AlipayTradeRefundRequest ();
	$request->setBizContent("{" .
	"\"out_trade_no\":\"".$out_trade_no."\"," .
	"\"trade_no\":\"\"," .
	"\"refund_amount\":".$money."," .
	"\"refund_currency\":\"\"," .
	"\"refund_reason\":\"\"," .
	"\"out_request_no\":\"\"," .
	"\"operator_id\":\"\"," .
	"\"store_id\":\"\"," .
	"\"terminal_id\":\"\"" .
	"  }");
	$result = $aop->execute ( $request); 

	$responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
	$resultCode = $result->$responseNode->code;
	if(!empty($resultCode)&&$resultCode == 10000){return true;} else {return false;}

	
}




?>