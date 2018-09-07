<?php
$id=intval(@$_GET['id']);
if($id>0){
	$_POST=safe_str($_POST);
	$sql="update ".self::$table_pre."type set `list_show`='".$_POST['list_show']."' where `id`='$id'";
	//echo $sql;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}	
