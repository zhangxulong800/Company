<?php

function goods_move($url){
	$r=array();
	if($url==''){
		$r['state']='fail';
		$r['info']='is_null';
		return $r;	
	}
	if(!is_url($url)){
		$r['state']='fail';
		$r['info']='pattern_err';
		return $r;	
	}
	
	if(strpos($url,'jd.com')!==false){
		return get_jd_com($url);
	}
	if(strpos($url,'taobao.com')!==false){
		return get_taobao_com($url);
	}
	if(strpos($url,'tmall.com')!==false){
		return get_tmall_com($url);
	}
	if(strpos($url,'1688.com')!==false){
		return get_1688_com($url);
	}
	
	$r['state']='fail';
	$r['info']='temporarily_not_supported';
	$r['info']='目前只支持：天猫、淘宝、京东 阿里的商品';
	return $r;	
}

function get_jd_com($url){
	$id=get_match_single('#http://item\.jd\.com/(.*)\.html#iU',$url);
	$r=array();
	$str=curl_open($url);
	
	$str=mb_convert_encoding($str, "UTF-8", "GBK");
	$update_icon='';
	$r['icon']='http:'.get_match_single("#<div id=\"spec-n1\".*>.*<img.*=\"(//.*)\".*/>.*</div>#iUs",$str);
	if($r['icon']=='http:'){
		$r['state']='fail';
		$r['info']='不是商品详情页或网络不稳定(可重试)';
		return $r;	
	}
	$r['sold_price']=0;
	$r['name']=get_match_single("#<div class=\"p-name\">(.*)</div>.*<div class=\"p-price\">#iUs",$str);
	$r['name']=trim(strip_tags($r['name']));
	$r['name']=str_replace('包邮','',$r['name']);
	$r['advantage']=get_match_single("# <div class=nonenone>(.*)</div>#iU",$str);
	$r['advantage']=str_replace('包邮','',$r['advantage']);
	
	$temp=get_match_single('#<div.*class="spec-items">.*<ul class="lh">(.*)</ul>.*</div>#iUs',$str);
	$temp=get_match_all("#<li.*><img.*src='(.*)'.*></li>#iUs",$temp);
	unset($temp[0]); 
	//var_dump($temp);exit;
	$temp=implode(',http:',$temp);
	$temp=str_replace('/n5/','/n1/',$temp);
	$temp=preg_replace('/\/s.*_jfs\//iU','/jfs/',$temp);
	if($temp!=''){$r['multi_angle_img']='http:'.$temp;}else{$r['multi_angle_img']='';}
	
	//var_dump($r);exit;	
	$r['detail']=get_match_single('#<ul.*class=\"p-parameter-list\">(.*)</ul>#iUs',$str);
	$r['detail']='<ul class=attribute>'.$r['detail'].'</ul>';
	$detail_url="http:".get_match_single("#desc: '(.*)',#iUs",$str).'?callback=showdesc';
	$str=curl_open($detail_url);
	$str=mb_convert_encoding($str, "UTF-8", "GBK");
	$str=str_replace('showdesc(','',$str);
	$str=trim($str,')');
	$str=json_decode($str,true);
	$str=str_replace('data-lazyload','src',$str['content']);
	$str=str_replace(' class="formwork_img"','',$str);
	$str=str_replace('class="formwork"','',$str);
	$r['detail'].=$str;
	$r['detail']=preg_replace('/<a([^>]*)>([^<]*)<\/a>/','\\2',$r['detail']);
	//$r['detail']=preg_replace('/<div.*background:url\([http:]?(\/\/.*\.360buyimg\.com.*)\);.*">/iUs','<img src=http:\\1 />',$r['detail']);
	//$r['detail']=preg_replace('/<div.*background.*:url\((http:)?(\/\/.*\.360buyimg\.com.*)\);.*">/iUs','<img src=http:\\2 />',$r['detail']);
	//$r['detail']=preg_replace('/(img[0-9]{1,10}\.360buyimg\.com.*\.jpg)/iUs','<img src=http://\\1 />',$r['detail']);
	//$temp=get_match_all("#<img.*src=\"(.*)\".*>#iUs",$str);
	$temp=get_match_all('/(img[0-9]{1,10}\.360buyimg\.com.*\.(jpg|png|gif))/iU',$str);
	//$temp=get_match_all('/(img[0-9]{1,10}\.360buyimg\.com.*\.jpg)/iU',$str);
	$detail_img='';
	$r['detail']='';
	foreach($temp as $v){
		$v=trim($v);
		if($v!=''){
			$v=trim($v);
			$v=trim($v,'"');
			$v=trim($v,"'");
			$v=trim($v,"&quot;");
			$detail_img.='http://'.$v.',';
			$r['detail'].='<img src=http://'.$v.' />';
		}
	}
	$r['detail_img']=trim($detail_img,',');
	$r['m_detail']='';
	$r['m_detail_img']='';
	//echo $url;
	//echo $detail_url;
	//var_dump($r['detail_img']);
	$r['detail']=str_replace('<ul','<div',$r['detail']);
	$r['detail']=str_replace('</ul','</div',$r['detail']);
	$r['detail']=str_replace('<li','<p',$r['detail']);
	$r['detail']=str_replace('</li','</p',$r['detail']);
	$r['detail']=str_replace('</li','</p',$r['detail']);
	$r['detail']=str_replace('class=attribute',' ',$r['detail']);
	$r['detail']=str_replace('包邮','',$r['detail']);

	//var_dump($r['detail']);	
	$r['state']='success';
	$r['info']='success';
	//file_put_contents('t.txt',var_export($r,1));
	return $r;
}

function get_taobao_com($url){
	$id=get_match_single('#https://item.taobao.com/item.htm?.*id=([0-9]*).*#iU',$url);
	$r=array();
	$str=curl_open($url);
	
	$str=mb_convert_encoding($str, "UTF-8", "GBK");
	//echo $str;
	
	$update_icon='';
	$r['icon']='http:'.get_match_single("#auctionImages\\s+:\\s+\[.*\"(.*)\".*,#iUs",$str);
	if($r['icon']=='http:'){
		$r['state']='fail';
		$r['info']='不是商品详情页或网络不稳定(可重试)';
		return $r;	
	}
	
	$r['sold_price']=get_match_single('#<em class="tb-rmb-num">(.*)</em>#iUs',$str);
	$temp=explode("-",$r['sold_price']);
	$r['sold_price']=$temp[0];
	//$r['sold_price']=$r['sold_price']/100;
	$r['name']=get_match_single('#<title>(.*)-淘宝网</title>#iUs',$str);
	$r['advantage']=get_match_single("#<p class=\"tb-subtitle\">(.*)</p>#iUs",$str);
	$r['advantage']=trim($r['advantage']);
	$temp=get_match_single('#auctionImages\\s+:\\s+\[(.*)},#iUs',$str);
	$temp=get_match_all('#"(.*)"#iUs',$temp);
	unset($temp[0]); 
	$temp=implode(',http:',$temp);
	//$temp=str_replace('/n5/','/n1/',$temp);
	if($temp!=''){$r['multi_angle_img']='http:'.$temp;}else{$r['multi_angle_img']='';}
	
	
	$r['detail']=get_match_single('# <ul class="attributes-list">(.*)</ul>#iUs',$str);
	$r['detail']='<ul class=attribute>'.$r['detail'].'</ul>';
	$detail_url="https:".get_match_single('#descUrl\\s+:\\s+.*\'(//desc\.alicdn\.com.*)\'#iUs',$str);
	$str=curl_open($detail_url);
	$str=mb_convert_encoding($str, "UTF-8", "GBK");
	$str=str_replace("var desc='",'',$str);
	$str=trim($str,"';");
	$r['detail'].=$str;
	$r['detail']=@ereg_replace('<a([^>]*)>([^<]*)</a>','\\2',$r['detail']);
	$r['detail']=preg_replace('#href=".*"#iUs','',$r['detail']);
	$r['detail']=preg_replace("#href='.*'#iUs",'',$r['detail']);
	$r['detail']=str_replace('\\'," ",$r['detail']);
	//$r['detail']=str_replace(array("\r\n", "\r", "\n"), "", $r['detail']); 
	
	$temp=get_match_all("#<img.*src=\"(.*)\".*>#iUs",$str);
	$r['detail_img']=implode(',',$temp);
	$r['m_detail']='';
	$r['m_detail_img']='';
	$r['state']='success';
	$r['info']='success';
	return $r;
}


function get_tmall_com($url){
		function get_tmall_again($str,$old_url){
			$url=get_match_single("#(https.*)\r#iU",$str);
			//var_dump($url);
			if($url==NULL || $url==''){$url=$old_url;}
			//echo $url.'<hr />';
			$str= curl_open2($url);
			return $str;
		}

		function curl_open2($url){
			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_URL, $url);  
			curl_setopt($ch, CURLOPT_HEADER, false);  
			//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//重点区别
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
			curl_setopt($ch, CURLOPT_NOBODY, 0);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
			curl_setopt($ch, CURLOPT_MAXREDIRS,30);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.1 Safari/537.11');  	  
			$res = curl_exec($ch);  
			$rescode = curl_getinfo($ch, CURLINFO_HTTP_CODE);   
			curl_close($ch) ;  
			return $res;  
		}

		
	
	$id=get_match_single('#https://detail.tmall.com/item.htm?.*id=([0-9]*).*#iU',$url);
	$r=array();
	$str=curl_open2($url);
	
	$old_url=$url;

				
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_tmall_again($str,$old_url);}
						
	
	
	
	$str=mb_convert_encoding($str, "UTF-8", "GBK");
	//file_put_contents('t.txt',$str);
	$update_icon='';
	$r['icon']='http:'.get_match_single('#<img src="(.*)_60.*".*/>#iUs',$str);
	if($r['icon']=='http:'){
		$r['state']='fail';
		$r['info']='不是商品详情页或网络不稳定(可重试)';
		return $r;	
	}
	
	$r['sold_price']=get_match_single('#,"price":"(.*)"#iUs',$str);
	$r['name']=get_match_single('#,"title":"(.*)"#iUs',$str);
	$r['advantage']=get_match_single("#<p>(.*)</p>.*</div>.*<!--引入normalBasic-->#iUs",$str);
	$r['advantage']=trim($r['advantage']);
	$temp=get_match_single('#<ul id="J_UlThumb".*>(.*)</ul>#iUs',$str);
	$temp=get_match_all('#<img src="(.*)_60.*".*/>#iUs',$temp);
	unset($temp[0]); 
	$temp=implode(',http:',$temp);
	//$temp=str_replace('/n5/','/n1/',$temp);
	if($temp!=''){$r['multi_angle_img']='http:'.$temp;}else{$r['multi_angle_img']='';}
	
	
	$r['detail']=get_match_single('#<ul id="J_AttrUL">(.*)</ul>#iUs',$str);
	$r['detail']='<ul class=attribute>'.$r['detail'].'</ul>';
	$detail_url="http:".get_match_single('#"descUrl":"(.*)",#iUs',$str);
	$str=curl_open($detail_url);
	$str=mb_convert_encoding($str, "UTF-8", "GBK");
	$str=str_replace("var desc='",'',$str);
	$str=trim($str,"';");
	$r['detail'].=$str;
	$r['detail']=@ereg_replace('<a([^>]*)>([^<]*)</a>','\\2',$r['detail']);
	$r['detail']=preg_replace('#href=".*"#iUs','',$r['detail']);
	$r['detail']=preg_replace("#href='.*'#iUs",'',$r['detail']);
	
	$temp=get_match_all("#<img.*src=\"(.*)\".*>#iUs",$str);
	$r['detail_img']=implode(',',$temp);
	$r['m_detail']='';
	$r['m_detail_img']='';
	//echo $url;
	//echo $detail_url;
	//var_dump($r);
	//$r=array();
	$r['state']='success';
	$r['info']='success';
	//file_put_contents('ttt.txt',var_export($r,1));
	return $r;
}

function get_1688_com($url){
	return get_1688_com_phone($url);
		function get_1688_com_again($str,$old_url){
			$url=get_match_single("#(https.*)\r#iU",$str);
			//var_dump($url);
			if($url==NULL || $url==''){$url=$old_url;}
			//echo $url.'<hr />';
			$str= curl_open2($url);
			return $str;
		}

		function curl_open2($url){
			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_URL, $url);  
			curl_setopt($ch, CURLOPT_HEADER, false);  
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//重点区别
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
			curl_setopt($ch, CURLOPT_NOBODY, 0);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
			curl_setopt($ch, CURLOPT_MAXREDIRS,30);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.1 Safari/537.11');  	  
			$res = curl_exec($ch);  
			$rescode = curl_getinfo($ch, CURLINFO_HTTP_CODE);   
			curl_close($ch) ;  
			return $res;  
		}

		
	
	$id=get_match_single('#https://detail.1688.com/offer/?.*id=([0-9]*).*#iU',$url);
	$r=array();
	$str=curl_open2($url);
	
	$old_url=$url;

				
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
						
	
	
	
	$str=mb_convert_encoding($str, "UTF-8", "GBK");
	file_put_contents('1688_pc.txt',$str);
	$update_icon='';
	$r['icon']=get_match_single('#<meta property="og:image" content="(.*)"/>#iUs',$str);
	if($r['icon']==''){
		$r['state']='fail';
		$r['info']='不是商品详情页或网络不稳定(可重试)';
		return $r;	
	}
	
	$r['sold_price']=get_match_single('#{"price":"(.*)"#iUs',$str);
	$r['name']=get_match_single('#<title>(.*) - 阿里巴巴</title>#iUs',$str);
	$r['advantage']=get_match_single("#<p>(.*)</p>.*</div>.*<!--引入normalBasic-->#iUs",$str);
	$r['advantage']=trim($r['advantage']);
	$temp=get_match_single('#<ul class="nav nav-tabs fd-clr">(.*)</ul>#iUs',$str);
	$temp=get_match_all('#<img src="https:(.*)".*/>#iUs',$temp);
	unset($temp[0]); 
	$temp=implode(',https:',$temp);
	//$temp=str_replace('/n5/','/n1/',$temp);
	if($temp!=''){$r['multi_angle_img']='https:'.$temp;}else{$r['multi_angle_img']='';}
	$r['multi_angle_img']=str_replace('.60x60','',$r['multi_angle_img']);
	//var_dump($r['multi_angle_img']);
	
	$r['detail']=get_match_single('#<div id="mod-detail-attributes".*>.*<div.*>.*<table>.*<tbody>(.*)</tbody>.*</table>.*</div>#iUs',$str);
	$r['detail']=str_replace('tr>','li>',$r['detail']);
	$r['detail']=str_replace('<td class="de-feature">','',$r['detail']);
	$r['detail']=str_replace('<td class="de-value">',':',$r['detail']);
	$r['detail']=str_replace('</td>','',$r['detail']);
	$r['detail']='<ul class=attribute>'.$r['detail'].'</ul>';
	$detail_url=get_match_single('#\[\{&quot;contentUrl&quot;:&quot;(.*)&quot;#iUs',$str);
	$str=curl_open($detail_url);
	$str=mb_convert_encoding($str, "UTF-8", "GBK");
	$str=str_replace('var offer_details={"content":"','',$str);
	$str=trim($str,'"};');
	$str=str_replace('\\','',$str);
	
	//file_put_contents('t.txt',$str);
	
	$r['detail'].=$str;
	$r['detail']=@ereg_replace('<a([^>]*)>([^<]*)</a>','\\2',$r['detail']);
	$r['detail']=preg_replace('#href=".*"#iUs','',$r['detail']);
	$r['detail']=preg_replace("#href='.*'#iUs",'',$r['detail']);
	
	$temp=get_match_all("#<img.*src=\"(.*)\".*>#iUs",$str);
	$r['detail_img']=implode(',',$temp);
	$r['m_detail']='';
	$r['m_detail_img']='';
	//echo $url;
	//echo $detail_url;
	//var_dump($r);
	//$r=array();
	$r['state']='success';
	$r['info']='success';
	//file_put_contents('ttt.txt',var_export($r,1));
	return $r;
}


function get_1688_com_phone($url){
	$url=str_replace('https://detail.1688.com','https://m.1688.com',$url);
		function get_1688_com_again($str,$old_url){
			$url=get_match_single("#(https.*)\r#iU",$str);
			//var_dump($url);
			if($url==NULL || $url==''){$url=$old_url;}
			//echo $url.'<hr />';
			$str= curl_open2($url);
			return $str;
		}

		function curl_open2($url){
			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_URL, $url);  
			curl_setopt($ch, CURLOPT_HEADER, false);  
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//重点区别
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
			curl_setopt($ch, CURLOPT_NOBODY, 0);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
			curl_setopt($ch, CURLOPT_MAXREDIRS,30);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.1 Safari/537.11');  	  
			$res = curl_exec($ch);  
			$rescode = curl_getinfo($ch, CURLINFO_HTTP_CODE);   
			curl_close($ch) ;  
			return $res;  
		}

		
	
	$id=get_match_single('#https://m.1688.com/offer/?.*id=([0-9]*).*#iU',$url);
	$r=array();
	$str=curl_open2($url);
	
	$old_url=$url;

				
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
						
	
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
			if(strlen($str)<2000){$str=get_1688_com_again($str,$old_url);}
						
	
	//$str=mb_convert_encoding($str, "UTF-8", "GBK");
	$update_icon='';
	file_put_contents('1688_phone.txt',$str);
	$r['icon']=get_match_single('#<div class="swipe-content">\s*<div class="swipe-pane">\s*<img src="(.*)_200x200x.*".*/>#iUs',$str);
	if($r['icon']==''){
		$r['state']='fail';
		$r['info']='不是商品详情页或网络不稳定(可重试)';
		return $r;	
	}
	
	$r['sold_price']=get_match_single('#{"price":"(.*)"#iUs',$str);
	$r['name']=get_match_single('#<title>(.*) - 阿里巴巴</title>#iU',$str);
	$r['advantage']=get_match_single("#<p>(.*)</p>.*</div>.*<!--引入normalBasic-->#iUs",$str);
	$r['advantage']=trim($r['advantage']);
	$temp=get_match_single('#<div id="d-swipe" class="d-swipe">\s*<div class="swipe-content">(.*)</div>\s*</div>#iUs',$str);
	$temp=get_match_all('#<img.*src="https:(.*)".*/>#iUs',$temp);
	unset($temp[0]); 
	$temp=implode(',https:',$temp);
	//$temp=str_replace('/n5/','/n1/',$temp);
	if($temp!=''){$r['multi_angle_img']='https:'.$temp;}else{$r['multi_angle_img']='';}
	$r['multi_angle_img']=str_replace('.60x60','',$r['multi_angle_img']);
	//var_dump($r['multi_angle_img']);
	$r['detail']=get_match_single('#"productFeatureList":\[(.*)\],.*"rateAverageStarLevel"#iU',$str);
	//file_put_contents('t.txt',$r['detail']);exit;
	
	$at_str='['.$r['detail'].']';
	$a=json_decode($at_str,1);
	$at='';
	if($a){
		foreach($a as $k=>$v){
			$at.='<div><span class=a_label>'.$v['name'].'</span><span class=a_value>'.$v['value'].'</span></div>';	
		}
	}
	if($at!=''){$at='<div id=goods_attribute>'.$at.'</div>';}
	
	
	$d_url=get_match_single('#"detailUrl":"//(.*)"#iU',$str);
	$str=curl_open2($d_url);
	$str=mb_convert_encoding($str, "UTF-8", "GBK");
	$str=explode('var offer_details',$str);
	$str=$str[1];
	$str=str_replace('={"content":"','',$str);
	$str=trim($str,'"};');
	$str=str_replace('\\','',$str);
	$str=str_replace(' alt="undefined"',' ',$str);
	
	
	
	$r['detail']=$at.$str;
	$r['detail']=@ereg_replace('<a([^>]*)>([^<]*)</a>','\\2',$r['detail']);
	$r['detail']=preg_replace('#href=".*"#iUs','',$r['detail']);
	$r['detail']=preg_replace("#href='.*'#iUs",'',$r['detail']);
	
	$temp=get_match_all("#<img.*src=\"(.*)\".*>#iUs",$str);
	$r['detail_img']=implode(',',$temp);
	$r['m_detail']='';
	$r['m_detail_img']='';
	//echo $url;
	//echo $detail_url;
	//var_dump($r);
	//$r=array();
	$r['state']='success';
	$r['info']='success';
	return $r;
}

