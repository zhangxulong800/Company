<?php
$id=intval(@$_GET['id']);
if($id==0){exit("{'state':'fail','info':'id err'}");}
$act=@$_GET['act'];
if($act=='update'){
	$sql="update ".self::$table_pre."public_stock set `quantity`='".intval($_GET['quantity'])."' where `id`='".$id."' and `shop_id`=".SHOP_ID;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;".self::$language['executed']."</span>'}");
	}
}

if($act=='del'){
	  $sql="delete from ".self::$table_pre."public_stock where `id`=".$id." and `shop_id`=".SHOP_ID;
	  if($pdo->exec($sql)){
		  exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	  }else{
		  exit("{'state':'success','info':'<span class=success>&nbsp;".self::$language['executed']."</span>'}");
	  }
}