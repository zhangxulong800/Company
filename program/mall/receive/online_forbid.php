<?php
$act=@$_GET['act'];
if($act=='update'){
	$_GET['id']=intval(@$_GET['id']);
	$_GET['online_forbid']=intval(@$_GET['online_forbid']);
	$_GET['online_forbid']=max($_GET['online_forbid'],0);
	$sql="update ".self::$table_pre."goods set `online_forbid`='".$_GET['online_forbid']."' where `id`='".$_GET['id']."' and `shop_id`=".SHOP_ID;
	if($pdo->exec($sql)){
		self::update_shop_navigation($pdo,self::$language);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
	}
}

