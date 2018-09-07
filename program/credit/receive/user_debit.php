<?php
$act=@$_GET['act'];
if($act=='require'){
	$username=safe_str(@$_GET['username']);
	$sql="select `money` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	exit("{'state':'success','info':'<span class=fail>".self::$language['success']."</span>','money':'".$r['money']."'}");
}
if($act=='add'){
	$_POST=safe_str($_POST);
	foreach($_POST as $k=>$v){
		if($v==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'".$k."'}");}	
	}
	
	$sql="select `id`,`money` from ".$pdo->index_pre."user where `username`='".$_POST['username']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['username'].self::$language['not_exist']."</span>'}");}
	$username=$_POST['username'];
	
	$money=floatval($_POST['money']);
	if($money<=0){exit("{'state':'fail','info':'<span class=fail>money err</span>'}");}
	if($money>$r['money']){exit("{'state':'fail','info':'<span class=fail>".self::$language['insufficient_balance']."</span>'}");}
	
	$reason=self::$language['administrator'].'('.$_SESSION['monxin']['username'].')'.self::$language['execute'].self::$language['pages']['index.user_debit']['name'].','.self::$language['reason'].':'.safe_str($_POST['reason']);
	if(operator_money(self::$config,self::$language,$pdo,$username,'-'.$money,$reason,'index')){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']." <a href=./index.php?monxin=index.money_log_admin&username=".$username.">".self::$language['view']."</a></span>'}");
	}else{
		exit("{'state':'success','info':'<span class=fail>".self::$language['fail']."</span>'}");	
	}	
	
	exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");


}
