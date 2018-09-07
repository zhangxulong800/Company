<?php
include 'wechatH5Pay.php';
include 'wechatPayConf.php';
class wxh5{
	//$data 金额和订单号
	public function wxh5Request($data = array()){
		
		$wechatAppPay = new \wechatAppPay(wechatPayConf::APPID, wechatPayConf::MCH_ID, $data['notify'], wechatPayConf::KEY);
		$params['body'] =  $data['title'];                       //商品描述
		$params['out_trade_no'] = $data['out_trade_no'];    //自定义的订单号
		$params['total_fee'] = $data['total_fee'];                       //订单金额 只能为整数 单位为分
		$params['trade_type'] = 'MWEB';                   //交易类型 JSAPI | NATIVE | APP | WAP 
		$params['scene_info'] = '{"h5_info": {"type":"Wap","wap_url": "'. $data['domain'].'","wap_name": "'. $data['web_name'].'"}}';
		$result = $wechatAppPay->unifiedOrder( $params );
		$url = $result['mweb_url'].'&redirect_url='.urlencode($data['redirect_url']);//redirect_url 是支付完成后返回的页面
		return $url;
	}
}    
?>