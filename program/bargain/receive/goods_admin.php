<?php
$act=@$_GET['act'];

if($act=='del'){
	$id=intval($_GET['id']);
	if(self::delete_bargain($pdo,$id)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='state'){
	$id=intval($_GET['id']);
	$sql="update ".self::$table_pre."goods set `state`=".intval($_GET['state'])." where `id`=".$id;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='sequence'){
	$id=intval($_GET['id']);
	$sql="update ".self::$table_pre."goods set `sequence`=".intval($_GET['sequence'])." where `id`=".$id;
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
		$id=intval($id);
		if(self::delete_bargain($pdo,$id)){
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");	
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
if($act=='set_1'){
	$ids=@$_GET['ids'];
	$_GET['visible']=intval(@$_GET['visible']);
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$ids=str_replace("|",",",$ids);
	$ids=trim($ids,",");
	$ids=explode(",",$ids);
	$ids=array_map('intval',$ids);
	$temp='';
	foreach($ids as $id){
		$temp.=$id.",";	
		if($_GET['visible']==0){
			$sql="delete from ".self::$table_pre."cart where `key`='".$id."' or `key` like '".$id."\_%'";
			$pdo->exec($sql);
		}
	}
	$ids=trim($temp,","); 
	$sql="update ".self::$table_pre."goods set `state`=1 where `id` in ($ids)";
	
	$pdo->exec($sql);
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>'}");
}

