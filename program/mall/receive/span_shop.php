<?php
$act=@$_GET['act'];
if($act=='update'){
	$id=intval($_POST['id']);	
	$span_circle=intval($_POST['span_circle']);	
	$sql="update ".self::$table_pre."shop set `span_circle`='".$span_circle."' where `id`=".$id;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}