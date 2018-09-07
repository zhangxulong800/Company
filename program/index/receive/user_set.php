<?php
$act=@$_GET['act'];
if($act=='set'){
	//var_dump($_POST);
	$variable=safe_str(@$_POST['variable'],1,0);
	$value=safe_str(@$_POST['value'],1,0);
	if($value==''){exit();}
	
	$sql="select `id` from ".$pdo->index_pre."user_set where `item_variable`='$variable' and `user_id`='".$_SESSION['monxin']['id']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){
		$sql="update ".$pdo->index_pre."user_set set `item_value`='".$value."' where `id`='".$r['id']."'";	
	}else{
		$sql="insert into ".$pdo->index_pre."user_set (`item_variable`,`item_value`,`user_id`) values ('".$variable."','".$value."','".$_SESSION['monxin']['id']."')";
	}
	
	if($pdo->exec($sql)){
		send_user_set_cookie($pdo);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}

}

