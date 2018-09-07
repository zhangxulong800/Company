<?php
$act=$_GET['act'];
if($act=='check'){	
	$code=safe_str($_GET['code']);
	$url=$_GET['url'];
	$t=explode('monxin=',$url);
	$t2=explode('|||',$t[1]);
	$page=$t2[0];
	$sql="select `authorize` from ".$pdo->index_pre."page where `url`='".safe_str($page)."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['authorize']==$code){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['authorize_code'].self::$language['err']."</span>'}");
	}
}