<?php
$act=@$_GET['act'];
if($act=='update'){
	$id=intval($_POST['id']);
	$credits=floatval($_POST['credits']);
	$sql="select `id` from ".self::$table_pre."group_set where `group_id`=".$id." limit 0,1";
	$r=$pdo->query($sql,2)->fetch();
	if($r['id']!=''){
		$sql="update ".self::$table_pre."group_set set `credits`=".$credits." where `group_id`=".$id;
	}else{
		$sql="insert into ".self::$table_pre."group_set (`group_id`,`credits`) values ('".$id."','".$credits."')";		
	}
	if($pdo->exec($sql)){		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}		
}