<?php
$act=@$_GET['act'];

if($act=='get_url'){
	if(intval(@$_GET['id'])==0){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
	$id=intval(@$_GET['id']);
	$bar_code=safe_str(@$_GET['bar_code']);
	if($bar_code==''){exit("{'state':'fail','info':'<span class=fail>bar_code err</span>'}");}

	if(self::$config['web']['monxin_username']=='' || self::$config['web']['monxin_password']=='' ){
		$err=array();
		$err['state']='fail';
		$err['info']='monxin.com '.self::$language['account'].self::$language['password'].self::$language['is_null'].' , <a href=./index.php?monxin=index.config>'.self::$language['set'].'</a>';
		exit(json_encode($err));
	}
	$barcode=$bar_code;
	$r=file_get_contents('http://www.monxin.com/receive.php?target=server.goods&username='.urlencode(self::$config['web']['monxin_username']).'&password='.urlencode(self::$config['web']['monxin_password']).'&act=get_goods_name&barcode='.$barcode);
	//file_put_contents('url.txt','http://www.monxin.com/receive.php?target=server.goods&username='.urlencode(self::$config['web']['monxin_username']).'&password='.urlencode(self::$config['web']['monxin_password']).'&act=get_goods_name&barcode='.$barcode);
	$r=trim($r);
	$old_title=0;
	if($r==''){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		$sql="select `title` from ".self::$table_pre."goods where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$r=$r['title'];
		$old_title=1;
	}
	$url="https://search.jd.com/Search?enc=utf-8&keyword=".urlencode($r);
	$c=curl_open($url);
	$c=trim($c);
	if($c==''){$c=file_get_contents($url);}
	$c=get_match_single('#(//item\.jd\.com/.*\.html)#iU',$c);
		
	if($c!=''){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','c_url':'https:".$c."','old_title':'".$old_title."'}");
	}else{
		
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
