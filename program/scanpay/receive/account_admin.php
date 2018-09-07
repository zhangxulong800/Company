<?php
$act=@$_GET['act'];
$id=intval(@$_POST['id']);
if($act=='update'){
	$_POST['state']=intval(@$_POST['state']);
	$_POST['is_web']=intval(@$_POST['is_web']);
	$sql="update ".self::$table_pre."account set `state`='".$_POST['state']."',`is_web`='".$_POST['is_web']."',`username`='".safe_str($_POST['username'])."' where `id`='$id'";
	if($pdo->exec($sql)){
		if($_POST['is_web']==1){
			$sql="select `type` from ".self::$table_pre."account where `id`=".$id;
			$r=$pdo->query($sql,2)->fetch(2);
			$sql="update ".self::$table_pre."account set `is_web`=0 where `type`='".$r['type']."' and `id`!=".$id;
			$pdo->exec($sql);	
		}
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='del'){
	$sql="select `banner` from ".self::$table_pre."account where `id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	$sql="delete from ".self::$table_pre."account where `id`='$id'";
	if($pdo->exec($sql)){
		$sql="delete from ".self::$table_pre."pay where `a_id`=".$id;
		$pdo->exec($sql);
		@safe_unlink("./program/scanpay/banner/".$r['banner']);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='del_select'){
	$ids=@$_POST['ids'];
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$ids=explode("|",$ids);
	$ids=array_filter($ids);
	$success='';
	foreach($ids as $id){
		$id=intval($id);
		$sql="select `banner` from ".self::$table_pre."account where `id`='$id'";
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="delete from ".self::$table_pre."account where `id`='$id'";
		if($pdo->exec($sql)){
			$sql="delete from ".self::$table_pre."pay where `a_id`=".$id;
			$pdo->exec($sql);
			@safe_unlink("./program/scanpay/banner/".$r['banner']);
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
