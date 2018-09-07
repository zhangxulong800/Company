<?php
$id=intval(@$_GET['id']);
if($id==0){exit('group id err');}
if($_GET['act']=='update'){
	$list=str_replace('__','.',$_POST['user_sum']);
	$sql="update ".$pdo->index_pre."group set `user_sum`='$list' where `id`='$id'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");	
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
