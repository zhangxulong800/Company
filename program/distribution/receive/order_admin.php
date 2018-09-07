<?php
$act=@$_GET['act'];
$id=intval(@$_POST['id']);
if($act!='del_select' && $id==0){exit("{'state':'fail','info':'id err'}");}
if($act=='del'){
	$sql="delete from ".self::$table_pre."order where `id`=".$id;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}