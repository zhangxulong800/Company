<?php
$act=@$_GET['act'];
$id=intval(@$_GET['id']);
if($act=='update'){
	$time=time();
	$_GET['title']=safe_str(@$_GET['title']);
	$sql="update ".self::$table_pre."title set `title`='".$_GET['title']."',`last_time`='$time',`last_ip`='".get_ip()."',`email`='".intval($_GET['email'])."' where `id`='$id' and `username`='".$_SESSION['monxin']['username']."'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='del'){
	exit();
	$sql="select `type` from ".self::$table_pre."title where `id`='$id' and `username`='".$_SESSION['monxin']['username']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	$type=$r['type'];
	$sql="delete from ".self::$table_pre."title where `id`='$id' and `username`='".$_SESSION['monxin']['username']."'";
	if($pdo->exec($sql)){
		$sql="select `id` from ".self::$table_pre."content where `title_id`=".$id;
		$r=$pdo->query($sql,2);
		foreach($r as $v){self::del_content($pdo,$v['id'],$type);}					
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

