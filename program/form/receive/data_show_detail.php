<?php
$table_id=intval(@$_GET['table_id']);
if($table_id==0){exit('table_id err');}
$id=intval(@$_GET['id']);
if($id==0){exit('id err');}

$act=@$_GET['act'];
if($act=='count'){
	$sql="select `name`,`description`,`edit_power` from ".self::$table_pre."table where `id`=$table_id";
	$r=$pdo->query($sql,2)->fetch(2);
	$table_name=$r['name'];
	if($table_name==''){exit('table_id err');}
	$sql="update ".self::$table_pre.$table_name." set `visit`=`visit`+1 where `id`=".$id;
	$pdo->exec($sql);
}
