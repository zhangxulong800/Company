<?php
foreach($_GET as $key=>$v){
	if($v==''){exit("{'state':'fail','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>','id':'".$key."'}");}
}
$act=@$_GET['act'];
if($act=='add'){
	$sequence=intval(@$_GET['sequence']);
	$state=intval(@$_GET['state']);
	$name=safe_str(@$_GET['name']);
	$api=safe_str(@$_GET['api']);
	$sql="select count(id) as c from ".$pdo->sys_pre."api_list where `name`='".$name."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist_same'].self::$language['api_list_name']."</span>'}");}
	$api_array=explode('.',$api);
	if(!isset($api_array[1])){exit("{'state':'fail','info':'<span class=fail>API ".self::$language['pattern_err']."</span>'}");}
	$path='./api/'.$api_array[0].'/'.$api_array[1].'.php';
	if(!file_exists($path)){exit("{'state':'fail','info':'<span class=fail>".$path.' '.self::$language['not_exist'].self::$language['please_upload']."</span>'}");}
	
	$sql="insert into ".$pdo->sys_pre."api_list (`name`,`api`,`sequence`,`state`,`doc_url`) values ('".$_GET['name']."','".$_GET['api']."','".$_GET['sequence']."','".$_GET['state']."','".$_GET['doc_url']."')";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','id':'".$pdo->lastInsertId()."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='update'){
	$_GET['id']=intval(@$_GET['id']);
	$_GET['sequence']=intval(@$_GET['sequence']);
	$_GET['state']=intval(@$_GET['state']);
	$_GET['name']=safe_str(@$_GET['name']);
	$_GET['api']=safe_str(@$_GET['api']);
	$api_array=explode('.',$_GET['api']);
	
	$path='./api/'.$api_array[0].'/'.$api_array[1].'.php';
	if(!file_exists($path)){exit("{'state':'fail','info':'<span class=fail>".$path.' '.self::$language['not_exist'].self::$language['please_upload']."</span>'}");}
	$sql="select count(id) as c from ".$pdo->sys_pre."api_list where `name`='".$_GET['name']."' and `id`!=".$_GET['id'];
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist_same'].self::$language['api_list_name']."</span>'}");}
	$sql="update ".$pdo->sys_pre."api_list set `name`='".$_GET['name']."',`api`='".$_GET['api']."',`sequence`='".$_GET['sequence']."',`state`='".$_GET['state']."',`doc_url`='".$_GET['doc_url']."' where `id`='".$_GET['id']."'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
	}
}
if($act=='del'){
	$id=intval(@$_GET['id']);		
	$sql="delete from ".$pdo->sys_pre."api_list where `id`='$id'";
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
		$sql="delete from ".$pdo->sys_pre."api_list where `id`='$id'";
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
		$v['sequence']=intval($v['sequence']);
		$v['name']=safe_str($v['name']);
		$v['api']=safe_str($v['api']);
		$api_array=explode('.',$v['api']);
		$path='./api/'.$api_array[0].'/'.$api_array[1].'.php';
		if(!file_exists($path)){continue;}
		$sql="select count(id) as c from ".$pdo->sys_pre."api_list where `name`='".$v['name']."' and `id`!=".$v['id'];
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['c']!=0){continue;}
		$sql="update ".$pdo->sys_pre."api_list set `name`='".$v['name']."',`api`='".$v['api']."',`sequence`='".$v['sequence']."',`state`='".$v['state']."',`doc_url`='".$v['doc_url']."' where `id`='".$v['id']."'";
		if($pdo->exec($sql)){$success.=$v['id']."|";}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}

