<?php
$type=intval(@$_GET['type']);
if($type==0){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." type id err</span>'}");}

foreach($_GET as $key=>$v){
	if($key=='values'){continue;}
	if($v==''){exit("{'state':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");}
}
$act=@$_GET['act'];

if($act=='attribute_source'){
	$sql="update ".self::$table_pre."type set `attribute_source`='".intval($_GET['attribute_source'])."' where `id`='".$type."'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
	}
}

if($act=='add'){
	$_GET['name']=safe_str($_GET['name']);
	$_GET['values']=safe_str($_GET['values']);
	$_GET['sequence']=intval($_GET['sequence']);
	$_GET['list_show']=intval($_GET['list_show']);
	$sql="insert into ".self::$table_pre."type_attribute (`type_id`,`name`,`values`,`sequence`,`list_show`) values ('".$type."','".$_GET['name']."','".$_GET['values']."','".$_GET['sequence']."','".$_GET['list_show']."')";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}


if($act=='update'){
	$_GET['name']=safe_str($_GET['name']);
	$_GET['values']=safe_str($_GET['values']);
	$_GET['sequence']=intval($_GET['sequence']);
	$_GET['list_show']=intval($_GET['list_show']);
	$_GET['id']=intval(@$_GET['id']);
	$sql="update ".self::$table_pre."type_attribute set `name`='".$_GET['name']."',`values`='".$_GET['values']."',`sequence`='".$_GET['sequence']."',`list_show`='".$_GET['list_show']."' where `id`='".$_GET['id']."'";
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
	$sql="delete from ".self::$table_pre."type_attribute where `id`='$id'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}

}
		
