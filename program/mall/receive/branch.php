<?php
$act=@$_GET['act'];

if(intval(@$_GET['id'])==0){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
$id=intval(@$_GET['id']);

if($act=='del'){
	$sql="update ".self::$table_pre."shop set `use_goods_db`=0,`head`='' where `id`=".$id;
	if($pdo->exec($sql)){
		self::update_brand_sum($pdo,$_SESSION['monxin']['username']);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='update'){	
	$sql="update ".self::$table_pre."shop set `use_goods_db`='".intval($_GET['use_goods_db'])."' where `id`=".$id;
	if($pdo->exec($sql)){
		self::update_brand_sum($pdo,$_SESSION['monxin']['username']);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}