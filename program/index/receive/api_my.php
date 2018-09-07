<?php
foreach($_GET as $key=>$v){
	if($v==''){exit("{'state':'fail','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>','id':'".$key."'}");}
}
$act=@$_GET['act'];
if($act=='add'){
	$id=intval($_GET['id']);
	$sql="select `api` from ".$pdo->sys_pre."api_list where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	
	$sql="select * from ".$pdo->sys_pre."api_user where `username`='".$_SESSION['monxin']['username']."' limit 0,1";
	$old=$pdo->query($sql,2)->fetch(2);
	
	$sql="update ".$pdo->sys_pre."api_user set `application`='".$old['application'].",".$r['api']."' where `id`=".$old['id'];
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
