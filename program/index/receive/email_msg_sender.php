<?php
$act=@$_GET['act'];
$id=intval(@$_GET['id']);
$sequence=intval(@$_GET['sequence']);

if($act=='exe_send'){
	if(send_email(self::$config,$pdo,$id)){
	//if(1){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}


if(isset($_GET['sequence'])){
	$sql="update ".$pdo->index_pre."email_msg set `sequence`='$sequence' where `id`='$id' and `sender`='".$_SESSION['monxin']['username']."'";
	$pdo->exec($sql);
	exit();
}

if($act=='del'){
		$sql="update ".$pdo->index_pre."email_msg set `state`='4' where `id`='$id' and `sender`='".$_SESSION['monxin']['username']."'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='del_select'){
	$ids=@$_GET['ids'];
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$ids=explode("|",$ids);
	$ids=array_filter($ids);
	$success='';
	foreach($ids as $id){
		$sql="update ".$pdo->index_pre."email_msg set `state`='4' where `id`='$id' and `sender`='".$_SESSION['monxin']['username']."'";
		if($pdo->exec($sql)){
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
