<?php
foreach($_GET as $key=>$v){
	if($v==''){exit("{'state':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");}
}
$act=@$_GET['act'];
if($act=='add'){
	$_GET['name']=safe_str($_GET['name']);
	$_GET['for_shop']=safe_str($_GET['for_shop']);
	$_GET['sequence']=intval($_GET['sequence']);
	if(!is_dir('./templates/0/mall_shop/'.$_GET['dir'])){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['not_exist_dir']."</span>'}");
	}
	$sql="select count(id) as c from ".self::$table_pre."template where `dir`='".$_GET['dir']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist_same']."</span>'}");}
	$sql="insert into ".self::$table_pre."template (`dir`,`name`,`for_shop`,`sequence`) values ('".$_GET['dir']."','".$_GET['name']."','".$_GET['for_shop']."','".$_GET['sequence']."')";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}


if($act=='update'){
	$_GET['name']=safe_str($_GET['name']);
	$_GET['for_shop']=safe_str($_GET['for_shop']);
	$_GET['state']=intval($_GET['state']);
	$_GET['sequence']=intval($_GET['sequence']);
	$_GET['state']=intval($_GET['state']);
	$_GET['id']=intval(@$_GET['id']);
	if(!is_dir('./templates/0/mall_shop/'.$_GET['dir'])){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['not_exist_dir']."</span>'}");
	}
	$sql="select count(id) as c from ".self::$table_pre."template where `dir`='".$_GET['dir']."' and `id`!=".$_GET['id'];
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist_same']."</span>'}");}
	
	$sql="update ".self::$table_pre."template set `dir`='".$_GET['dir']."',`name`='".$_GET['name']."',`for_shop`='".$_GET['for_shop']."',`state`='".$_GET['state']."',`sequence`='".$_GET['sequence']."' where `id`='".$_GET['id']."'";
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
	$sql="delete from ".self::$table_pre."template where `id`='$id'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}

}

