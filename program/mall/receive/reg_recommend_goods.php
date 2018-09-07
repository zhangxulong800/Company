<?php
$act=@$_GET['act'];
if($act=='update'){
	$_GET['id']=intval(@$_GET['id']);
	$_GET['introducer_rate']=floatval(@$_GET['introducer_rate']);
	$_GET['introducer_rate']=max($_GET['introducer_rate'],0);
	$sql="update ".self::$table_pre."goods set `introducer_rate`='".$_GET['introducer_rate']."' where `id`='".$_GET['id']."' and `shop_id`=".SHOP_ID;
	if($pdo->exec($sql)){
		self::update_shop_navigation($pdo,self::$language);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
	}
}

if($act=='submit_select'){
	$success='';
	foreach($_POST as $v){
		$v['id']=intval($v['id']);
		$v['introducer_rate']=floatval($v['introducer_rate']);
		$v['introducer_rate']=max($v['introducer_rate'],0);
		$sql="update ".self::$table_pre."goods set `introducer_rate`='".$v['introducer_rate']."' where `id`='".$v['id']."' and `shop_id`=".SHOP_ID;
		if($pdo->exec($sql)){$success.=$v['id']."|";}
	}
	$success=trim($success,"|");	
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}

