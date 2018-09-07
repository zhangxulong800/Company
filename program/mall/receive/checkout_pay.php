<?php
$act=@$_GET['act'];

if($act=='check_password'){
	$id=intval($_GET['id']);
	if($id==0){exit('{"state":"fail","info":"<span class=fail>id is err</span>"}');}
	$sql="select * from ".self::$table_pre."checkout where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit('{"state":"fail","info":"<span class=fail>id is err</span>"}');}
	$password=safe_str($_GET['password']);
	if($password==''){exit('{"state":"fail","info":"<span class=fail>'.self::$language['is_null'].'</span>"}');}
	$password=md5($password);
	
	$username=$r['username'];
	$where='';
	$sql="select `id`,`username`,`state` from ".$pdo->index_pre."user where `username`='".$username."' and `transaction_password`='".$password."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit('{"state":"fail","info":"<span class=fail>'.self::$language['err'].'</span>"}');}
	if($r['state']!=1){exit('{"state":"fail","info":"<span class=fail>'.self::$language['user_state'][$r['state']].'</span>"}');}
	
	$sql="update ".self::$table_pre."checkout set `state`=2 where `id`=".$id;
	if($pdo->exec($sql)){
		exit('{"state":"success","info":"<span class=success>'.self::$language['success'].'</span>"}');
	}else{
		exit('{"state":"fail","info":"<span class=fail>'.self::$language['fail'].'</span>"}');
	}
		
}
