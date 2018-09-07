<?php
$act=@$_GET['act'];
$id=intval(@$_GET['id']);
if($act=='del'){
	
	$sql="select * from ".$pdo->index_pre."share where `id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	$sql="delete from ".$pdo->index_pre."share where `id`='$id'";
	if($pdo->exec($sql)){
		$sql="delete from ".$pdo->index_pre."share_visit where `share_id`='$id'";
		$pdo->exec($sql);
		$sql="delete from ".$pdo->index_pre."share_reg where `share_id`='$id'";
		$pdo->exec($sql);
		$sql="update ".$pdo->index_pre."user set `share`=`share`-".$r['contribution']." where `username`='".$r['username']."'";
		$pdo->exec($sql);
		
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
		$sql="select * from ".$pdo->index_pre."share where `id`='$id'";
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="delete from ".$pdo->index_pre."share where `id`='$id'";
		if($pdo->exec($sql)){
			$sql="delete from ".$pdo->index_pre."share_visit where `share_id`='$id'";
			$pdo->exec($sql);
			$sql="delete from ".$pdo->index_pre."share_reg where `share_id`='$id'";
			$pdo->exec($sql);
			$sql="update ".$pdo->index_pre."user set `share`=`share`-".$r['contribution']." where `username`='".$r['username']."'";
			$pdo->exec($sql);	
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
