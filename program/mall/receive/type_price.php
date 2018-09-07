<?php
$id=intval(@$_GET['id']);
if($id>0){
	$_POST['price']=safe_str(@$_POST['price']);
	
	$sql="update ".self::$table_pre."type set `price`='".$_POST['price']."' where `id`='$id'";
	//echo $sql;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}	
