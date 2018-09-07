<?php
$id=intval(@$_GET['id']);
$act=@$_GET['act'];
if($act=='del'){
	$sql="delete from ".self::$table_pre."pk where `id`='$id'";
	if($pdo->exec($sql)){
		self::delete_relevant($pdo,$id);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='del_select'){
	$ids=safe_str(@$_GET['ids']);
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$ids=explode("|",$ids);
	$ids=array_filter($ids);
	$success='';
	foreach($ids as $id){
		$id=intval($id);
		$sql="delete from ".self::$table_pre."pk where `id`='$id'";
		if($pdo->exec($sql)){
			self::delete_relevant($pdo,$id);
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");	
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload(); class=refresh>".self::$language['refresh']."</a>','ids':'".$success."'}");
}


