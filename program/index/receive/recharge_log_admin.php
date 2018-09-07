<?php
$act=@$_GET['act'];
$id=intval(@$_GET['id']);
if($act=='success'){
	$sql="update ".$pdo->index_pre."recharge set `state`='4' where `id`='$id' and `state`='1'";
	if($pdo->exec($sql)){
		$sql="select `username`,`money` from ".$pdo->index_pre."recharge where `id`='$id'";
		$r=$pdo->query($sql,2)->fetch(2);
		if(operator_money(self::$config,self::$language,$pdo,$r['username'],$r['money'],self::$language['recharge'],self::$config['class_name'])){
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}else{
			$sql="update ".$pdo->index_pre."recharge set `state`='1' where `id`='$id' and `state`='4'";
			$pdo->exec($sql);
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='fail'){
	$sql="update ".$pdo->index_pre."recharge set `state`='3' where `id`='$id' and `state`='1'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='del'){
	$sql="delete from ".$pdo->index_pre."recharge where `id`='$id' and (`state`='2' or `state`='3')";
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
		$sql="delete from ".$pdo->index_pre."recharge where `id`='$id' and (`state`='2' or `state`='3')";
		if($pdo->exec($sql)){
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
