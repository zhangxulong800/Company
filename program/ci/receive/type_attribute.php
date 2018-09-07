<?php
$act=@$_GET['act'];
if($act=='update'){
	$_GET['id']=intval(@$_GET['id']);
	if($_GET['id']==0){exit('id err');}
	$_POST=safe_str($_POST);	
	$sql = "update ".self::$table_pre."type_attribute set `sequence`='".intval($_POST['sequence'])."',`screening_show`='".intval($_POST['screening_show'])."' where `id`='".$_GET['id']."'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
	}
}

if($act=='del'){
	$_GET['id']=intval(@$_GET['id']);
	if($_GET['id']==0){exit('id err');}
	$sql="delete from ".self::$table_pre."type_attribute where `id`='".$_GET['id']."'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
	
}
