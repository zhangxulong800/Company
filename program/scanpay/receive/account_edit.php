<?php
//var_dump($_POST);exit;
$id=intval(@$_GET['id']);
if($id==0){exit("{'state':'fail','info':'id err'}");}
//var_dump($_POST);

$sql="select * from ".self::$table_pre."account where `id`='".$id."'";
$old=$pdo->query($sql,2)->fetch(2);
if($old['username']!=$_SESSION['monxin']['username']){exit("{'state':'fail','info':'<span class=fail>is not your account</span>'}");}



$time=time();
foreach($_POST as $key=>$v){
	if($v=='' && $key!='operator'){
		$r="{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'".$key."'}";
		exit($r);
	}
}
$_POST=safe_str($_POST);

$sql="select `id`,`banner` from ".self::$table_pre."account where `name`='".$_POST['name']."' and `username`!='".$_SESSION['monxin']['username']."' limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>','id':'name'}");}

if(file_exists('./temp/'.$_POST['banner'])){
	$path='./program/scanpay/banner/'.$_POST['banner'];
	get_date_dir('./program/scanpay/banner/');	
	if(safe_rename('./temp/'.$_POST['banner'],$path)==false){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['account_banner'].self::$language['is_null']."</span>','id':'banner'}");
	}
}	

if($_POST['operator']!=''){$_POST['operator'].=',';$_POST['operator']=str_replace(',,',',',$_POST['operator']);}

$sql="update ".self::$table_pre."account set `name`='".$_POST['name']."',`banner`='".$_POST['banner']."',`data`='".$_POST['data']."',`time`='".$time."',`type`='".$_POST['type']."',`operator`='".$_POST['operator']."' where `id`=".$id;

if($pdo->exec($sql)){
	if($old['banner']!=$_POST['banner']){safe_unlink('./program/scanpay/banner/'.$old['banner']);}
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','data_id':'".$id."'}");
}else{
	exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
}
	
