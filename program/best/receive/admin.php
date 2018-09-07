<?php
$act=@$_GET['act'];
$id=intval(@$_GET['id']);
if($act=='update_visible'){
	$_GET['visible']=intval(@$_GET['visible']);
	$sql="update ".self::$table_pre."page set `visible`='".$_GET['visible']."' where `id`='$id'";	
	$pdo->exec($sql);
	exit();
}
if($act=='update'){
	$time=time();
	$_GET['sequence']=intval(@$_GET['sequence']);
	$_GET['title']=safe_str(@$_GET['title']);
	$sql="update ".self::$table_pre."page set `title`='".$_GET['title']."',`sequence`='".$_GET['sequence']."',`time`='$time',`username`='".$_SESSION['monxin']['username']."',`show_type`='".intval(@$_GET['show_type'])."' where `id`='$id'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='del'){
	$sql="delete from ".self::$table_pre."page where `id`='$id'";
	if($pdo->exec($sql)){
		self::del_relevant($pdo,$id);			
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
		$sql="delete from ".self::$table_pre."page where `id`='$id'";
		if($pdo->exec($sql)){
			self::del_relevant($pdo,$id);
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
if($act=='operation_visible'){
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
	}
	$ids=trim($temp,","); 
	$sql="update ".self::$table_pre."page set `visible`='".$_GET['visible']."' where `id` in ($ids)";
	$pdo->exec($sql);
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>'}");
}

if($act=='submit_select'){
	//var_dump($_POST);	
	$time=time();
	$editor=$_SESSION['monxin']['id'];
	$success='';
	foreach($_POST as $v){
		$v['id']=intval($v['id']);
		$v['sequence']=intval($v['sequence']);
		$v['title']=safe_str($v['title']);
		$sql="update ".self::$table_pre."page set `title`='".$v['title']."',`sequence`='".$v['sequence']."',`time`='$time',`username`='".$_SESSION['monxin']['username']."',`show_type`='".intval(@$v['show_type'])."' where `id`='".$v['id']."'";
		if($pdo->exec($sql)){$success.=$v['id']."|";self::update_search_text($pdo,$id);}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}