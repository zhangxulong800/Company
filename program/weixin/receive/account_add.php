<?php
function add_default_auto_answer($language,$pdo,$table_pre,$wid){
	$time=time();
	$key=$language['while'].':'.$language['receive_subscribe'].'|MsgType:event|Event:subscribe';
	$v=$language['while'].':'.$language['receive_subscribe'];
	$sql="insert into ".$table_pre."auto_answer (`wid`,`key`,`input_type`,`output_type`,`time`,`text`,`author`) values ('".$wid."','".$key."','text','text','".$time."','".$v."','monxin')";
	$pdo->exec($sql);
		
	$key=$language['while'].':'.$language['receive_unsubscribe'].'|MsgType:event|Event:unsubscribe';
	$v=$language['while'].':'.$language['receive_unsubscribe'];
	$sql="insert into ".$table_pre."auto_answer (`wid`,`key`,`input_type`,`output_type`,`time`,`text`,`author`) values ('".$wid."','".$key."','text','text','".$time."','".$v."','monxin')";
	$pdo->exec($sql);	
	
	$key=$language['while'].':'.$language['receive_location'].'|MsgType:location';
	$v=$language['while'].':'.$language['receive_location'];
	$sql="insert into ".$table_pre."auto_answer (`wid`,`key`,`input_type`,`output_type`,`time`,`text`,`author`) values ('".$wid."','".$key."','text','text','".$time."','".$v."','monxin')";
	$pdo->exec($sql);	
	
	$key=$language['while'].':'.$language['receive_image'].'|MsgType:image';
	$v=$language['while'].':'.$language['receive_image'];
	$sql="insert into ".$table_pre."auto_answer (`wid`,`key`,`input_type`,`output_type`,`time`,`text`,`author`) values ('".$wid."','".$key."','text','text','".$time."','".$v."','monxin')";
	$pdo->exec($sql);	

	$key=$language['while'].':'.$language['receive_voice'].'|MsgType:voice';
	$v=$language['while'].':'.$language['receive_voice'];
	$sql="insert into ".$table_pre."auto_answer (`wid`,`key`,`input_type`,`output_type`,`time`,`text`,`author`) values ('".$wid."','".$key."','text','text','".$time."','".$v."','monxin')";
	$pdo->exec($sql);	

	$key=$language['while'].':'.$language['receive_video'].'|MsgType:video';
	$v=$language['while'].':'.$language['receive_video'];
	$sql="insert into ".$table_pre."auto_answer (`wid`,`key`,`input_type`,`output_type`,`time`,`text`,`author`) values ('".$wid."','".$key."','text','text','".$time."','".$v."','monxin')";
	$pdo->exec($sql);	

	$key=$language['while'].':'.$language['receive_link'].'|MsgType:link';
	$v=$language['while'].':'.$language['receive_link'];
	$sql="insert into ".$table_pre."auto_answer (`wid`,`key`,`input_type`,`output_type`,`time`,`text`,`author`) values ('".$wid."','".$key."','text','text','".$time."','".$v."','monxin')";
	$pdo->exec($sql);	
	
	$key=$language['no_keyword_and_no_search_then_answer'].':no_keyword_and_no_search_then_answer';
	$v='';
	$sql="insert into ".$table_pre."auto_answer (`wid`,`key`,`input_type`,`output_type`,`time`,`text`,`author`) values ('".$wid."','".$key."','text','text','".$time."','".$v."','monxin')";
	$pdo->exec($sql);	

}

$time=time();
$null_able=array('area','keyword','qr_code_file','AppId','AppSecret');
foreach($_POST as $key=>$v){
	if($v=='' && !in_array($key,$null_able)){
		$r="{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'".$key."'}";
		exit($r);
	}
}
$_POST=safe_str($_POST);

$sql="select count(id) as c from ".self::$table_pre."account where `account`='".$_POST['account']."'";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>','id':'account'}");}

$sql="select count(id) as c from ".self::$table_pre."account where `wid`='".$_POST['wid']."'";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>','id':'wid'}");}



if($_POST['qr_code']!=''){
	if(file_exists('./temp/'.$_POST['qr_code'])){
		$path='./program/weixin/qr_code/'.$_POST['qr_code'];
		get_date_dir('./program/weixin/qr_code/');	
		if(safe_rename('./temp/'.$_POST['qr_code'],$path)==false){
			exit("{'state':'fail','info':'<span class=fail>".self::$language['qr_code']." up failed</span>','id':'qr_code'}");
		}
	}	
}
if($_POST['AppId']!='' && $_POST['AppSecret']!=''){
	$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$_POST['AppId']."&secret=".$_POST['AppSecret'];
	$content = file_get_contents($url);
	$info = json_decode($content,1);	
	if(!isset($info['access_token'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['AppId'].self::$language['or'].self::$language['AppSecret'].self::$language['err']." </span>'}");}	
}


$sql="insert into ".self::$table_pre."account (`qr_code`,`username`,`name`,`wid`,`account`,`area`,`keyword`,`AppId`,`AppSecret`,`token`,`time`,`if_weixin`) values ('".$_POST['qr_code']."','".$_SESSION['monxin']['username']."','".$_POST['name']."','".$_POST['wid']."','".$_POST['account']."','".intval($_POST['area'])."','".$_POST['keyword']."','".$_POST['AppId']."','".$_POST['AppSecret']."','".$_POST['token']."','".$time."','".$_SESSION['monxin']['username']."')";
if($pdo->exec($sql)){
	$id=$pdo->lastInsertId();
	add_default_auto_answer(self::$language,$pdo,self::$table_pre,$_POST['wid']);
	
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
}else{
	exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
}
	
