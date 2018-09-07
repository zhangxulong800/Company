<?php 
function ali_transfer($id,$PrivateKey,$PublicKey,$account,$money){
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
	$request = new AlipayFundTransToaccountTransferRequest ();
	//收款方账户类型为：ALIPAY_LOGONID：支付宝登录号，支持邮箱和手机号格式。
	$request->setBizContent("{" .
		"\"out_biz_no\":\"".$date.$arr[0]."\"," .
		"\"payee_type\":\"ALIPAY_LOGONID\"," .
		"\"payee_account\":\"".$account."\"," .
		"\"amount\":\"".$money."\"," .
		"\"remark\":\"\"" .
		"}");
	$result = $aop->execute ($request);

	$responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
	$resultCode = $result->$responseNode->code;
	if(!empty($resultCode)&&$resultCode == 10000){return true;} else {return false;}

	
}




?>