<?php
foreach($_GET as $key=>$v){
	if($v==''){exit("{'state':'fail','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>','id':'".$key."'}");}
}
$act=@$_GET['act'];
if($act=='del_select'){
	$ids=@$_GET['ids'];
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$ids=explode("|",$ids);
	$ids=array_filter($ids);
	$success='';
	foreach($ids as $id){
		$id=intval($id);
		$sql="delete from ".$pdo->sys_pre."api_log where `id`='$id'";
		if($pdo->exec($sql)){$success.=$id."|";}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
