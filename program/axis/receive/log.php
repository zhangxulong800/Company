<?php
$axis_id=intval($_GET['axis_id']);
if($axis_id==0){exit("{'state':'fail','info':'<span class=fail>axis_id err</span>'}");}
$sql="select `id`,`name`,`username` from ".self::$table_pre."group where `id`=".$axis_id;
$group=$pdo->query($sql,2)->fetch(2);
if($group['id']==''){exit("{'state':'fail','info':'<span class=fail>axis_id err</span>'}");}
if($group['username']!=$_SESSION['monxin']['username']){exit("{'state':'fail','info':'<span class=fail>axis_id power err</span>'}");}


$id=intval(@$_GET['id']);
$act=@$_GET['act'];


if($act=='del'){
	$sql="select `icon`,`content` from ".self::$table_pre."log where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	$sql="delete from ".self::$table_pre."log where `id`='$id' and `g_id`='".$axis_id."'";
	file_put_contents('t.txt',$sql);
	if($pdo->exec($sql)){
		self::delete_log_img($pdo,$r);
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
		$sql="select `icon`,`content` from ".self::$table_pre."log where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="delete from ".self::$table_pre."log where `id`='$id' and `g_id`='".$axis_id."'";
		if($pdo->exec($sql)){
			self::delete_log_img($pdo,$r);
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");	
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload(); class=refresh>".self::$language['refresh']."</a>','ids':'".$success."'}");
}

