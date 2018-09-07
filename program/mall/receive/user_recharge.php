<?php
$act=@$_GET['act'];
if($act=='add'){
	$id=intval($_GET['id']);
	if($id==0){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
	$sql="select `username`,`shop_id` from ".self::$table_pre."shop_buyer where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['shop_id']!=SHOP_ID)exit("{'state':'success','info':'<span class=fail>".self::$language['fail']." shop_id err</span>'}");
	if($r['username']==''){exit("{'state':'success','info':'<span class=fail>id err</span>'}");}
	$username=$r['username'];
	
	$money=floatval($_POST['money']);
	if($money<=0){exit("{'state':'fail','info':'<span class=fail>money err</span>'}");}
	$reason=self::$language['store'].self::$language['recharge'];
	if(self::operator_shop_buyer_balance($pdo,$username,$money,$reason,$_SESSION['monxin']['username'])){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=fail>".self::$language['fail']."</span>'}");	
	}	


}
