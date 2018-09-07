<?php
/* 已弃用
$act=@$_GET['act'];
if($act=='del' || $act=='update_state'){
	$id=intval(@$_GET['id']);
	if($id==0){exit("{'state':'fail','info':'id err'}");}	
}


if($act=='update_state'){
	$_GET['state']=intval(@$_GET['state']);
	$sql="update ".self::$table_pre."comment set `state`='".$_GET['state']."' where `id`='$id'";	
	$pdo->exec($sql);
	self::update_goods_comment($pdo,self::$table_pre,$id);
	exit();
}

if($act=='del'){
	$sql="delete from ".self::$table_pre."comment where `id`='".$id."'";
	if($pdo->exec($sql)){
		self::update_goods_comment($pdo,self::$table_pre,$id);
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
		$id=intval($id);
		$sql="delete from ".self::$table_pre."comment where `id`='".$id."'";
		if($pdo->exec($sql)){
			self::update_goods_comment($pdo,self::$table_pre,$id);
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}


if($act=='operation_state'){
	$ids=@$_GET['ids'];
	$_GET['state']=intval(@$_GET['state']);
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$ids=str_replace("|",",",$ids);
	$ids=trim($ids,",");
	$ids=explode(",",$ids);
	$ids=array_map('intval',$ids);
	$temp='';
	foreach($ids as $id){
		$temp.=$id.",";	
	}
	$ids=trim($temp,","); 
	$sql="update ".self::$table_pre."comment set `state`='".$_GET['state']."' where `id` in ($ids)";
	if($pdo->exec($sql)){
		$temp=explode(',',$ids);
		foreach($temp as $id){
			if($id==''){continue;}	
			self::update_goods_comment($pdo,self::$table_pre,$id);
		}
		
	}
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>'}");
}
*/