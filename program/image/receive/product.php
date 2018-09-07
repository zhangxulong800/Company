<?php
$act=@$_GET['act'];
$id=intval(str_replace('i_','',@$_GET['id']));
if($act=='get_content' && $id>0){
	$sql="select `content` from ".self::$table_pre."img where `id`='$id' and `visible`=1";
	$r=$pdo->query($sql,2)->fetch(2);
		$sql="update ".self::$table_pre."img set `visit`=visit+1 where `id`='$id'";
		$pdo->exec($sql);
	exit($r['content']);
}

if($id>0){
	$sql="update ".self::$table_pre."img set `visit`=visit+1 where `id`='$id'";
	$pdo->exec($sql);
}