<?php
$object_id=intval($_GET['object_id']);
if($object_id==0){exit("{'state':'fail','info':'<span class=fail>object_id err</span>'}");}
$sql="select `username`,`pk_id` from ".self::$table_pre."object where `id`=".$object_id;
$r=$pdo->query($sql,2)->fetch(2);
if($r['username']==''){exit("{'state':'fail','info':'<span class=fail>object_id err</span>'}");}
if($r['username']!=$_SESSION['monxin']['username']){exit("{'state':'fail','info':'<span class=fail>object_id power err</span>'}");}
$pk_id=$r['pk_id'];
$item_id=intval($_GET['item_id']);
if($item_id==0){exit("{'state':'fail','info':'<span class=fail>item_id err</span>'}");}
$sql="select `username` from ".self::$table_pre."item where `id`=".$item_id;
$r=$pdo->query($sql,2)->fetch(2);
if($r['username']==''){exit("{'state':'fail','info':'<span class=fail>item_id err</span>'}");}
if($r['username']!=$_SESSION['monxin']['username']){exit("{'state':'fail','info':'<span class=fail>item_id power err</span>'}");}


$act=@$_GET['act'];


if($act=='checked'){
	$_GET['checked']=intval(@$_GET['checked']);
	$sql="select `id` from ".self::$table_pre."value where `object_id`=".$object_id." and `item_id`=".$item_id." limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){
		$sql="insert into ".self::$table_pre."value (`object_id`,`item_id`,`checked`,`pk_id`) values ('".$object_id."','".$item_id."','".$_GET['checked']."','".$pk_id."')";	
	}else{
		$sql="update ".self::$table_pre."value set `checked`=".$_GET['checked']." where `object_id`=".$object_id." and `item_id`=".$item_id." limit 1";
	}
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','id':'".$pdo->lastInsertId()."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='value'){
	$_GET['value']=safe_str(@$_GET['value']);
	$sql="select `id` from ".self::$table_pre."value where `object_id`=".$object_id." and `item_id`=".$item_id." limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){
		if($_GET['value']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");}
		$sql="insert into ".self::$table_pre."value (`object_id`,`item_id`,`value`,`pk_id`) values ('".$object_id."','".$item_id."','".$_GET['value']."','".$pk_id."')";	
	}else{
		$sql="update ".self::$table_pre."value set `value`='".$_GET['value']."' where `object_id`=".$object_id." and `item_id`=".$item_id." limit 1";
	}
	//file_put_contents('t.txt',$sql);
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','id':'".$pdo->lastInsertId()."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
