<?php
$id=intval(@$_GET['id']);
if($id>0){
	$sql="update ".self::$table_pre."pk set `visit`=visit+1 where `id`='$id'";
	$pdo->exec($sql);
}