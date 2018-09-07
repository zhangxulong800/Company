<?php
class WxPay
{
	function __construct()
	{

	}
	
	function pay($url, $obj,$config) 
	{
		$obj['nonce_str'] = $this->create_noncestr();
		$stringA = $this->formatQueryParaMap($obj, false);
		$stringSignTemp = $stringA . "&key=" . $config['key'];
		$sign = strtoupper(md5($stringSignTemp));
		$obj['sign'] = $sign;
		
		$postXml = $this->arrayToXml($obj);
		$responseXml = $this->curl_post_ssl($url, $postXml,$config);
		return $responseXml;
	}

	function create_noncestr($length = 32) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for ( $i = 0; $i < $length; $i++ )  {
			$str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);
		}
		return $str;
	}

	function formatQueryParaMap($paraMap, $urlencode)
	{
		$buff = "";
		ksort($paraMap);
		foreach ($paraMap as $k => $v){
			if (null != $v && "null" != $v && "sign" != $k) {
			    if($urlencode){
				   $v = urlencode($v);
				}
				$buff .= $k . "=" . $v . "&";
			}
		}
		$reqPar;
		if (strlen($buff) > 0) {
			$reqPar = substr($buff, 0, strlen($buff)-1);
		}
		return $reqPar;
	}

	//数组转XML
	function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
			if (is_numeric($val)){
				$xml.="<".$key.">".$val."</".$key.">";
        	}else{
        	 	$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
			}
		}
        $xml.="</xml>";
        return $xml;
    }

	function curl_post_ssl($url, $vars,$config, $second=30)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
		
		$config['sslcert_path']=str_replace('./','payment/weixin/',$config['sslcert_path']);
		$config['sslkey_path']=str_replace('./','payment/weixin/',$config['sslkey_path']);
		
		
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {	//Windows
			curl_setopt($ch, CURLOPT_SSLCERT, str_replace("lib\\",'',dirname(__FILE__)."\\".str_replace("/","\\",$config['sslcert_path'])));
			curl_setopt($ch, CURLOPT_SSLKEY, str_replace("lib\\",'',dirname(__FILE__)."\\".str_replace("/","\\",$config['sslkey_path'])));
        }else{                        //LINUX
            curl_setopt($ch, CURLOPT_SSLCERT, $config['sslcert_path']);
			curl_setopt($ch, CURLOPT_SSLKEY, $config['sslkey_path']);
        }

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
		$data = curl_exec($ch);
		if($data){
			curl_close($ch);
			return $data;
		}else {
			$error = curl_errno($ch);
			echo "call faild, errorCode:$error\n";
			curl_close($ch);
			return false;
		}
	}
}

?>