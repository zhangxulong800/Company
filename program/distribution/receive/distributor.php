<?php
foreach($_GET as $key=>$v){
	if($key=='url'){continue;}
	if($v==''){exit("{'state':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");}
}
$act=@$_GET['act'];
if($act=='update'){
	$_GET['id']=intval(@$_GET['id']);
	$_GET['state']=intval(@$_GET['state']);
	$sql="update ".self::$table_pre."distributor set `state`='".$_GET['state']."',`superior`='".safe_str($_GET['superior'])."' where `id`='".$_GET['id']."'";
	if($pdo->exec($sql)){
		$sql="select `username` from ".self::$table_pre."distributor where `id`=".$_GET['id'];
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="update ".$pdo->index_pre."user set `introducer`='".safe_str($_GET['superior'])."' where `username`='".$r['username']."' limit 1";
		$pdo->exec($sql);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
	}
}
if($act=='del'){
	$id=intval(@$_GET['id']);
	$sql="delete from ".self::$table_pre."distributor where `id`='$id'";
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
		$sql="delete from ".self::$table_pre."distributor where `id`='$id'";
		if($pdo->exec($sql)){$success.=$id."|";}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
if($act=='set_1'){
	$ids=@$_GET['ids'];
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$ids=explode("|",$ids);
	$ids=array_filter($ids);
	$success='';
	foreach($ids as $id){
		$id=intval($id);
		$sql="update ".self::$table_pre."distributor set `state`='1' where `id`=".$id;
		if($pdo->exec($sql)){$success.=$id."|";}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}

if($act=='submit_select'){
	$success='';
	foreach($_POST as $v){
		$v['id']=intval($v['id']);
		$v['state']=intval($v['state']);
		$sql="update ".self::$table_pre."distributor set `state`='".$v['state']."' where `id`='".$v['id']."'";
		if($pdo->exec($sql)){$success.=$v['id']."|";}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}

