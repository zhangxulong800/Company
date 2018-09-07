<?php
$act=@$_GET['act'];
$id=intval(@$_GET['id']);
if($act=='update'){
	$_GET['state']=intval(@$_GET['state']);
	$_GET['sequence']=intval(@$_GET['sequence']);
	$sql="update ".self::$table_pre."account set `state`='".$_GET['state']."',`sequence`='".$_GET['sequence']."',`username`='".safe_str($_GET['username'])."' where `id`='$id'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
	}
}
if($act=='del'){
	$sql="select `wid`,`qr_code` from ".self::$table_pre."account where `id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	$sql="delete from ".self::$table_pre."account where `id`='$id'";
	if($pdo->exec($sql)){
		self::del_account_receive_data($pdo,self::$table_pre,$r['wid']);
		@safe_unlink("./program/weixin/qr_code/".$r['qr_code']);
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
		$sql="select `wid`,`qr_code` from ".self::$table_pre."account where `id`='$id'";
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="delete from ".self::$table_pre."account where `id`='$id'";
		if($pdo->exec($sql)){
			self::del_account_receive_data($pdo,self::$table_pre,$r['wid']);
			@safe_unlink("./program/weixin/qr_code/".$r['qr_code']);
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
if($act=='submit_select'){
	//var_dump($_POST);	
	$time=time();
	$editor=$_SESSION['monxin']['id'];
	$success='';
	foreach($_POST as $v){
		$v['id']=intval($v['id']);
		$v['state']=intval($v['state']);
		$v['sequence']=intval($v['sequence']);
		$v['username']=safe_str($v['username']);
		$sql="update ".self::$table_pre."account set `state`='".$v['state']."',`sequence`='".$v['sequence']."',`username`='".$v['username']."' where `id`='".$v['id']."'";
		if($pdo->exec($sql)){$success.=$v['id']."|";}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}