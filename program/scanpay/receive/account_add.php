<?php
//var_dump($_POST);exit;
$time=time();
foreach($_POST as $key=>$v){
	if($v=='' && $key!='operator'){
		$r="{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'".$key."'}";
		exit($r);
	}
}
$_POST=safe_str($_POST);

$sql="select `id` from ".self::$table_pre."account where `name`='".$_POST['name']."' and `username`!='".$_SESSION['monxin']['username']."' limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>','id':'name'}");}

if(file_exists('./temp/'.$_POST['banner'])){
	$path='./program/scanpay/banner/'.$_POST['banner'];
	get_date_dir('./program/scanpay/banner/');	
	if(safe_rename('./temp/'.$_POST['banner'],$path)==false){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['account_banner'].self::$language['is_null']."</span>','id':'banner'}");
	}
}else{exit("{'state':'fail','info':'<span class=fail>".self::$language['account_banner'].self::$language['is_null']."</span>','id':'banner'}");}	
if($_POST['operator']!=''){$_POST['operator'].=',';$_POST['operator']=str_replace(',,',',',$_POST['operator']);}

$sql="insert into ".self::$table_pre."account (`username`,`name`,`banner`,`data`,`time`,`type`,`operator`,`account_defalt_state`) values ('".$_SESSION['monxin']['username']."','".$_POST['name']."','".$_POST['banner']."','".$_POST['data']."','".$time."','".$_POST['type']."','".$_POST['operator']."','".self::$config['account_defalt_state']."')";
file_put_contents('t.txt',$sql);
if($pdo->exec($sql)){
	$id=$pdo->lastInsertId();
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','data_id':'".$id."'}");
}else{
	exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
}
	
