<?php
$order_id=intval(@$_GET['order_id']);
if($order_id==0){exit("{'state':'fail','info':'order_id err'}");}
$goods_id=intval(@$_GET['goods_id']);
if($goods_id==0){exit("{'state':'fail','info':'goods_id err'}");}
$sql="select * from ".self::$table_pre."order where `id`=".$order_id;
$r=$pdo->query($sql,2)->fetch(2);
if(@$r['id']==''){exit("{'state':'fail','info':'order_id err'}");}
if($r['buyer']!=$_SESSION['monxin']['username']){exit("{'state':'fail','info':'".self::$language['inoperable']."'}");}
if((time()-$r['send_time'])/86400>self::$config['comment_time_limit']){exit("{'state':'fail','info':'".str_replace('{v}',self::$config['comment_time_limit'],self::$language['comment_time_limit_alert'])."'}");}
$shop_id=$r['shop_id'];

$act=@$_GET['act'];
if($act=='comment'){
	$_POST=safe_str($_POST,1,0);
	$level=intval($_POST['level']);
	if(@$_POST['content']==''){exit("{'state':'fail','info':'".self::$language['content'].self::$language['is_null']."'}");}
	$sql="select `id` from ".self::$table_pre."comment where `order_id`='".$order_id."' and `goods_id`='".$goods_id."' and `buyer`='".$_SESSION['monxin']['username']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){
		$sql="insert into ".self::$table_pre."comment (`buyer`,`level`,`content`,`time`,`order_id`,`goods_id`,`shop_id`) values ('".$_SESSION['monxin']['username']."','".$level."','".$_POST['content']."','".time()."','".$order_id."','".$goods_id."','".$shop_id."')";	
	}else{
		$sql="update ".self::$table_pre."comment set `level`='".$level."',`content`='".$_POST['content']."',`time`='".time()."' where `id`=".$r['id'];	
	}
	if($pdo->exec($sql)){
		$sql="select `goods_id` from ".self::$table_pre."comment where `order_id`='".$order_id."' and `goods_id`='".$goods_id."' and `buyer`='".$_SESSION['monxin']['username']."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		self::update_goods_comment($pdo,self::$table_pre,$r['goods_id']);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='del'){
	$sql="delete from ".self::$table_pre."comment where `order_id`='".$order_id."' and `goods_id`='".$goods_id."' and `buyer`='".$_SESSION['monxin']['username']."'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}