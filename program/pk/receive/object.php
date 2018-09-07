<?php
$pk_id=intval($_GET['pk_id']);
if($pk_id==0){exit("{'state':'fail','info':'<span class=fail>pk_id err</span>'}");}
$sql="select `id`,`name`,`username` from ".self::$table_pre."pk where `id`=".$pk_id;
$pk=$pdo->query($sql,2)->fetch(2);
if($pk['id']==''){exit("{'state':'fail','info':'<span class=fail>pk_id err</span>'}");}
if($pk['username']!=$_SESSION['monxin']['username']){exit("{'state':'fail','info':'<span class=fail>pk_id power err</span>'}");}
foreach($_GET as $key=>$v){
	if($v==''){exit("{'state':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");}
}
$act=@$_GET['act'];
if($act=='add'){
	$_GET['sequence']=intval(@$_GET['sequence']);
	$_GET['name']=safe_str(@$_GET['name']);
	$sql="insert into ".self::$table_pre."object (`name`,`sequence`,`pk_id`,`username`) values ('".$_GET['name']."','".$_GET['sequence']."','".$pk_id."','".$_SESSION['monxin']['username']."')";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','id':'".$pdo->lastInsertId()."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='update'){
	$_GET['id']=intval(@$_GET['id']);
	$_GET['parent']=intval(@$_GET['parent']);
	$_GET['sequence']=intval(@$_GET['sequence']);
	$_GET['state']=intval(@$_GET['state']);
	$_GET['name']=safe_str(@$_GET['name']);
	$sql="update ".self::$table_pre."object set `name`='".$_GET['name']."',`sequence`='".$_GET['sequence']."',`state`='".$_GET['state']."' where `id`='".$_GET['id']."' and `pk_id`=".$pk_id;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
	}
}
if($act=='del'){
	$id=intval(@$_GET['id']);
	if($id<1){exit();}	
	$sql="delete from ".self::$table_pre."object where `id`='$id' and `pk_id`=".$pk_id;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}

}
