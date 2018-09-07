<?php
$id=intval(@$_GET['id']);
$act=@$_GET['act'];
if($act=='add'){
	$time=time();
	$_GET['name']=safe_str(@$_GET['name']);
	$_GET['style']=safe_str(@$_GET['style']);
	$sql="insert into ".self::$table_pre."group (`name`,`style`,`username`,`time`) values ('".$_GET['name']."','".$_GET['style']."','".$_SESSION['monxin']['username']."','".$time."')";
	//echo $sql;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span> <a href=./index.php?monxin=axis.my>".self::$language['refresh']."</a>','id':'".$pdo->lastInsertId()."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}


if($act=='update'){
	$time=time();
	$_GET['name']=safe_str(@$_GET['name']);
	$_GET['style']=safe_str(@$_GET['style']);
	$sql="update ".self::$table_pre."group set `name`='".$_GET['name']."',`style`='".$_GET['style']."',`sequence`='".intval($_GET['sequence'])."',`state`='".intval($_GET['state'])."',`time`='$time' where `id`='".$_GET['id']."' and `username`='".$_SESSION['monxin']['username']."'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='del'){
	$sql="delete from ".self::$table_pre."group where `id`='$id' and `username`='".$_SESSION['monxin']['username']."'";
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
		$sql="delete from ".self::$table_pre."group where `id`='$id' and `username`='".$_SESSION['monxin']['username']."'";
		if($pdo->exec($sql)){
			self::delete_relevant($pdo,$id);
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");	
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload(); class=refresh>".self::$language['refresh']."</a>','ids':'".$success."'}");
}

if($act=='submit_select'){
	//var_dump($_POST);	
	$time=time();
	$editor=$_SESSION['monxin']['id'];
	$success='';
	foreach($_POST as $v){
		$v['id']=intval($v['id']);
		$v['name']=safe_str($v['name']);
		$v['style']=safe_str($v['style']);
		$sql="update ".self::$table_pre."group set `name`='".$v['name']."',`style`='".$v['style']."',`sequence`='".intval($v['sequence'])."',`state`='".intval($v['state'])."',`time`='$time' where `id`='".$v['id']."' and `username`='".$_SESSION['monxin']['username']."'";
		if($pdo->exec($sql)){$success.=$v['id']."|";}
	}
	$success=trim($success,"|");	
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload(); class=refresh>".self::$language['refresh']."</a>','ids':'".$success."'}");
}

