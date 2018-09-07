<?php
foreach($_GET as $key=>$v){
	if($v==''){exit("{'state':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");}
}
$act=@$_GET['act'];
if($act=='add'){
	$_GET['name']=safe_str($_GET['name']);
	$_GET['first_weight']=intval($_GET['first_weight']);
	$_GET['over_weight']=intval($_GET['over_weight']);
	$_GET['first_price']=floatval($_GET['first_price']);
	$_GET['over_price']=floatval($_GET['over_price']);
	$_GET['sequence']=intval($_GET['sequence']);
	$sql="insert into ".self::$table_pre."express (`name`,`first_weight`,`over_weight`,`first_price`,`over_price`,`sequence`,`url`) values ('".$_GET['name']."','".$_GET['first_weight']."','".$_GET['over_weight']."','".$_GET['first_price']."','".$_GET['over_price']."','".$_GET['sequence']."','".safe_str($_GET['url'])."')";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}


if($act=='update'){
	$_GET['name']=safe_str($_GET['name']);
	$_GET['first_weight']=intval($_GET['first_weight']);
	$_GET['over_weight']=intval($_GET['over_weight']);
	$_GET['first_price']=floatval($_GET['first_price']);
	$_GET['over_price']=floatval($_GET['over_price']);
	$_GET['sequence']=intval($_GET['sequence']);
	$_GET['id']=intval(@$_GET['id']);
	$sql="update ".self::$table_pre."express set `name`='".$_GET['name']."',`first_weight`='".$_GET['first_weight']."',`over_weight`='".$_GET['over_weight']."',`first_price`='".$_GET['first_price']."',`over_price`='".$_GET['over_price']."',`sequence`='".$_GET['sequence']."',`url`='".safe_str($_GET['url'])."' where `id`='".$_GET['id']."'";
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
	$sql="delete from ".self::$table_pre."express where `id`='$id'";
	if($pdo->exec($sql)){
		$sql="delete from ".self::$table_pre."express_price where `express_id`=".$id."";
		$pdo->exec($sql);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}

}

