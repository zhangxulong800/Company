<?php
$id=intval(@$_GET['id']);
if($id==0){exit("{'state':'fail','info':'id err'}");}
//var_dump($_POST);

$null_able=array('area','if_email','if_weixin','keyword','qr_code','qr_code_file','receive_if_email','no_keyword_if_email','no_search_if_email','receive_if_weixin','no_keyword_if_weixin','no_search_if_weixin','smtp_password','smtp_account','smtp_url','AppId','AppSecret','open_search','manager');
foreach($_POST as $key=>$v){
	if($v=='' && !in_array($key,$null_able)){
		$r="{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'".$key."'}";
		exit($r);
	}
}
if(!is_email($_POST['if_email']) && $_POST['if_email']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['email_pattern_err']."</span>','id':'if_email'}");}

$sql="select `username` from ".self::$table_pre."account where `id`='".$id."'";
$r=$pdo->query($sql,2)->fetch(2);
if($r['username']!=$_SESSION['monxin']['username']){exit("{'state':'fail','info':'<span class=fail>is not your account</span>'}");}


if($_POST['smtp_account']!=''){
	if(!is_email($_POST['smtp_account'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['email_pattern_err']."</span>','id':'smtp_account'}");}
}

$_POST=safe_str($_POST);

$sql="select count(id) as c from ".self::$table_pre."account where `account`='".$_POST['account']."' and `id`!=".$id;
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>','id':'account'}");}


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
	if(self::get_access_token($pdo,$_POST['AppId'],$_POST['AppSecret'])===false){exit("{'state':'fail','info':'<span class=fail>".self::$language['AppId'].self::$language['or'].self::$language['AppSecret'].self::$language['err']." </span>'}");}	
}


$sql="select `qr_code` from ".self::$table_pre."account where `id`=".$id;
$r=$pdo->query($sql,2)->fetch(2);
if($_POST['qr_code']!=''){$qr_code=$_POST['qr_code'];}else{$qr_code=$r['qr_code'];}
if($_POST['manager']!=''){$_POST['manager']=','.trim($_POST['manager'],',').',';}

$sql="update ".self::$table_pre."account set `open_search`='".$_POST['open_search']."',`qr_code`='".$qr_code."',`name`='".$_POST['name']."',`account`='".$_POST['account']."',`area`='".$_POST['area']."',`if_email`='".$_POST['if_email']."',`if_weixin`='".$_POST['if_weixin']."',`keyword`='".$_POST['keyword']."',`AppId`='".$_POST['AppId']."',`AppSecret`='".$_POST['AppSecret']."',`token`='".$_POST['token']."',`receive_if_email`='".intval($_POST['receive_if_email'])."',`no_keyword_if_email`='".intval($_POST['no_keyword_if_email'])."',`no_search_if_email`='".intval($_POST['no_search_if_email'])."',`receive_if_weixin`='".intval($_POST['receive_if_weixin'])."',`no_keyword_if_weixin`='".intval($_POST['no_keyword_if_weixin'])."',`no_search_if_weixin`='".intval($_POST['no_search_if_weixin'])."',`smtp_url`='".$_POST['smtp_url']."',`smtp_account`='".$_POST['smtp_account']."',`smtp_password`='".$_POST['smtp_password']."',`receptionist_power`='".intval($_POST['receptionist_power'])."',`receptionist_open`='".intval($_POST['receptionist_open'])."',`receptionist_where`='".intval($_POST['receptionist_where'])."',`manager`='".str_replace('，',',',$_POST['manager'])."' where `id`='".$id."' and `username`='".$_SESSION['monxin']['username']."' and `state`=1";

if($pdo->exec($sql)){
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
}else{
	exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
}
	
