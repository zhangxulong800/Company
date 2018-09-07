<?php

foreach($_GET as $key=>$v){
	if($v==''){exit("{'state':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");}
}
$act=@$_GET['act'];
if($act=='add'){
	$_GET['name']=safe_str($_GET['name']);
	$_GET['link_man']=safe_str($_GET['link_man']);
	$_GET['contact']=safe_str($_GET['contact']);
	$_GET['sequence']=intval($_GET['sequence']);
	$sql="insert into ".self::$table_pre."supplier (`name`,`link_man`,`contact`,`sequence`,`shop_id`) values ('".$_GET['name']."','".$_GET['link_man']."','".$_GET['contact']."','".$_GET['sequence']."','".SHOP_ID."')";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}


if($act=='update'){
	$_GET['name']=safe_str($_GET['name']);
	$_GET['link_man']=safe_str($_GET['link_man']);
	$_GET['contact']=safe_str($_GET['contact']);
	$_GET['sequence']=intval($_GET['sequence']);
	$_GET['id']=intval(@$_GET['id']);
	$sql="update ".self::$table_pre."supplier set `name`='".$_GET['name']."',`link_man`='".$_GET['link_man']."',`contact`='".$_GET['contact']."',`sequence`='".$_GET['sequence']."' where `id`='".$_GET['id']."' and `shop_id`=".SHOP_ID;
	//echo $sql;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
	}
}
if($act=='del'){
	$id=intval(@$_GET['id']);
	if($id<1){exit();}
	$sql="delete from ".self::$table_pre."supplier where `id`='$id' and `shop_id`=".SHOP_ID;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}

}

