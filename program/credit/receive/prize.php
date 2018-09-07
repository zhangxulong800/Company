<?php
$id=intval(@$_GET['id']);
$act=@$_GET['act'];
if($act=='add'){
	$_POST=safe_str($_POST);
	$sql="insert into ".self::$table_pre."prize (`name`,`url`,`money`,`quantity`) values ('".$_POST['name']."','".$_POST['url']."','".$_POST['money']."','".$_POST['quantity']."')";
	//echo $sql;
	if($pdo->exec($sql)){
		if(file_exists('./temp/'.$_POST['img'])){safe_rename('./temp/'.$_POST['img'],'./program/credit/img/'.$pdo->lastInsertId().'.jpg');}
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}


if($act=='update'){
	$_POST=safe_str($_POST);
	$_POST['money']=intval($_POST['money']);
	if($_POST['money']<1){	exit("{'state':'fail','info':'<span class=fail>".self::$language['less_than']."1</span>'}");}
	
	$sql="update ".self::$table_pre."prize set `name`='".$_POST['name']."',`url`='".$_POST['url']."',`money`='".$_POST['money']."',`quantity`='".$_POST['quantity']."',`sequence`='".$_POST['sequence']."',`state`='".$_POST['state']."' where `id`='".$_POST['id']."'";
	file_put_contents('t.txt',$sql);
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='del'){
	$sql="delete from ".self::$table_pre."prize where `id`='$id'";
	if($pdo->exec($sql)){
		@safe_unlink('./program/credit/img/'.$id.'.jpg');
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

