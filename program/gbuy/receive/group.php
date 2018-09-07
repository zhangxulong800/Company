<?php
$act=@$_GET['act'];

if($act=='del'){
	$id=intval($_GET['id']);
	$sql="delete from ".self::$table_pre."group where `id`=".$id." and `state`!=1";
	
	if($pdo->exec($sql)){
		$sql="delete from ".self::$table_pre."order where `gr_id`=".$id;
		$pdo->exec($sql);			
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
