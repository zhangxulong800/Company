<?php
foreach($_GET as $key=>$v){
	if($v==''){exit("{'state':'fail','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>','id':'".$key."'}");}
}
$act=@$_GET['act'];
if($act=='add'){
	$sequence=intval(@$_GET['sequence']);
	$state=intval(@$_GET['state']);
	$name=safe_str(@$_GET['name']);
	$description=safe_str(@$_GET['description']);
	$sql="select count(id) as c from ".self::$table_pre."function where `name`='".$name."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist_same'].self::$language['function_name']."</span>'}");}
	$path='./program/weixin/function/'.$name.'.php';
	if(!file_exists($path)){exit("{'state':'fail','info':'<span class=fail>".$path.' '.self::$language['not_exist'].self::$language['please_upload']."</span>'}");}
	
	$sql="insert into ".self::$table_pre."function (`name`,`description`,`sequence`,`state`) values ('".$_GET['name']."','".$_GET['description']."','".$_GET['sequence']."','".$_GET['state']."')";
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
	$_GET['description']=safe_str(@$_GET['description']);
	$path='./program/weixin/function/'.$_GET['name'].'.php';
	if(!file_exists($path)){exit("{'state':'fail','info':'<span class=fail>".$path.' '.self::$language['not_exist'].self::$language['please_upload']."</span>'}");}
	$sql="select count(id) as c from ".self::$table_pre."function where `name`='".$_GET['name']."' and `id`!=".$_GET['id'];
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist_same'].self::$language['function_name']."</span>'}");}
	$sql="update ".self::$table_pre."function set `name`='".$_GET['name']."',`description`='".$_GET['description']."',`sequence`='".$_GET['sequence']."',`state`='".$_GET['state']."' where `id`='".$_GET['id']."'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
	}
}
if($act=='del'){
	$id=intval(@$_GET['id']);		
	$sql="delete from ".self::$table_pre."function where `id`='$id'";
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
		$sql="delete from ".self::$table_pre."function where `id`='$id'";
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
		$v['description']=safe_str($v['description']);
		$path='./program/weixin/function/'.$v['name'].'.php';
		if(!file_exists($path)){continue;}
		$sql="select count(id) as c from ".self::$table_pre."function where `name`='".$v['name']."' and `id`!=".$v['id'];
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['c']!=0){continue;}
		$sql="update ".self::$table_pre."function set `name`='".$v['name']."',`description`='".$v['description']."',`sequence`='".$v['sequence']."',`state`='".$v['state']."' where `id`='".$v['id']."'";
		if($pdo->exec($sql)){$success.=$v['id']."|";}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}

