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
	
	$reason=self::$language['administrator'].'('.$_SESSION['monxin']['username'].')'.self::$language['execute'].self::$language['pages']['index.user_recharge_credits']['name'].','.self::$language['reason'].':'.safe_str($_POST['reason']);
	
	
	$sql="insert into ".$pdo->index_pre."recharge_credits (`username`,`money`,`time`,`state`,`title`,`return_url`,`pay_info`,`pay_photo`,`method`) values ('".$username."','".$money."','".time()."','4','".$reason."','','','','offline_payment')";
	if($pdo->exec($sql)){
		$new_id=$pdo->lastInsertId();
		$in_id=date('Ymdh',time()).$new_id;
		$sql="update ".$pdo->index_pre."recharge_credits set `in_id`='".$in_id."' where `id`=".$new_id;
		$pdo->exec($sql);
		if(operation_credits($pdo,self::$config,self::$language,$username,$money,$reason,'recharge')){
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span> <a href=./index.php?monxin=index.credits_admin&username=".$username." target=_blank>".self::$language['view']."</a>'}");
		}else{
			exit("{'state':'success','info':'<span class=fail>".self::$language['fail']."</span>'}");	
		}	
	}
	
	exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");


}
