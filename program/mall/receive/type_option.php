<?php
$type=intval(@$_GET['type']);
if($type==0){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." type id err</span>'}");}

foreach($_GET as $key=>$v){
	if($v==''){exit("{'state':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");}
}
$act=@$_GET['act'];

if($act=='specifications_source'){
	$sql="update ".self::$table_pre."type set `specifications_source`='".intval($_GET['specifications_source'])."' where `id`='".$type."'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
	}
}

if($act=='add'){
	$_GET['name']=safe_str($_GET['name']);
	$_GET['sequence']=intval($_GET['sequence']);
	$sql="insert into ".self::$table_pre."type_option (`type_id`,`name`,`sequence`) values ('".$type."','".$_GET['name']."','".$_GET['sequence']."')";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}


if($act=='update'){
	$_GET['name']=safe_str($_GET['name']);
	$_GET['sequence']=intval($_GET['sequence']);
	$_GET['shop_id']=intval($_GET['shop_id']);
	$_GET['id']=intval(@$_GET['id']);
	$sql="update ".self::$table_pre."type_option set `name`='".$_GET['name']."',`sequence`='".$_GET['sequence']."',`shop_id`='".$_GET['shop_id']."' where `id`='".$_GET['id']."'";
	//echo $sql;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
	}
}

if($act=='color'){
	$_GET['color']=intval(@$_GET['color']);
	$sql="update ".self::$table_pre."type set `color`='".$_GET['color']."' where `id`='".$type."'";
	$pdo->exec($sql);
}
if($act=='diy_option'){
	$_GET['diy_option']=intval(@$_GET['diy_option']);
	$sql="update ".self::$table_pre."type set `diy_option`='".$_GET['diy_option']."' where `id`='".$type."'";
	$pdo->exec($sql);
}
if($act=='option_name'){
	$_GET['option_name']=safe_str(@$_GET['option_name']);
	$sql="update ".self::$table_pre."type set `option_name`='".$_GET['option_name']."' where `id`='".$type."'";
	$pdo->exec($sql);
}
if($act=='del'){
	$id=intval(@$_GET['id']);
	if($id<1){exit();}
	$sql="delete from ".self::$table_pre."type_option where `id`='$id'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}

}

