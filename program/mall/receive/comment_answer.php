<?php
$id=intval(@$_GET['id']);
if($id==0){exit("{'state':'fail','info':'id err'}");}

$act=@$_GET['act'];
if($act=='update'){
	$_POST['answer']=safe_str(@$_POST['answer']);
	$sql="update ".self::$table_pre."comment set `seller`='".$_SESSION['monxin']['username']."',`answer`='".$_POST['answer']."',`answer_time`='".time()."' where `id`=".$id;	
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
