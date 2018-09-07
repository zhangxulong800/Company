<?php
$act=@$_GET['act'];
if($act=='add'){
	$_POST=safe_str($_POST);
	foreach($_POST as $k=>$v){
		if($v==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'".$k."'}");}	
	}
	
	$sql="select `id` from ".$pdo->index_pre."user where `username`='".$_POST['username']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['username'].self::$language['not_exist']."</span>'}");}
	$username=$_POST['username'];
	
	$money=floatval($_POST['money']);
	if($money<=0){exit("{'state':'fail','info':'<span class=fail>money err</span>'}");}
	
	$reason=self::$language['administrator'].'('.$_SESSION['monxin']['username'].')'.self::$language['execute'].self::$language['pages']['credit.increase']['name'].','.self::$language['reason'].':'.safe_str($_POST['reason']);
	
	if(operation_credits($pdo,self::$config,self::$language,$username,$money,$reason,'other')){
		$sql="select `id`,`credits` from ".$pdo->index_pre."user where `username`='".$_POST['username']."'";
		$r=$pdo->query($sql,2)->fetch(2);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','id':'".$r['id']."','value':".$r['credits']."}");
	}else{
		exit("{'state':'success','info':'<span class=fail>".self::$language['fail']."</span>'}");	
	}	


}
