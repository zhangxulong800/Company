<?php
$act=@$_GET['act'];

if($act=='set_1'){
	$_GET['id']=intval(@$_GET['id']);
	$sql="update ".self::$table_pre."checkout_log set `state`=1 where `id`='".$_GET['id']."' and `shop_id`=".SHOP_ID;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
	}
}
