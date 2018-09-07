<?php
$config = array (
	'provider_name' => '条码支付(支付宝)',
	'provider_icon' => 'logo.png',
	'state' => 'opening',
	'alipay_public_key_file' => dirname ( __FILE__ ) . "/key/alipay_rsa_public_key.pem",
	'merchant_private_key_file' =>@PRIVATE_KEY,
	'charset' => "UTF-8",
	'gatewayUrl' => "https://openapi.alipay.com/gateway.do",
	'app_id' => @APP_ID
);
return $config;
//var_dump($config);