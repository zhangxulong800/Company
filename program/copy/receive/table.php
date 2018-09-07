<?php
$id=intval(@$_GET['id']);
if($id==0){exit("{'state':'fail','info':'id err'}");}
$act=@$_GET['act'];
$_POST=safe_str($_POST);
//var_dump($_POST);


if($act=='update'){
	$table=str_replace('tr_','',$_POST['tr_id']);
	if($table==''){exit("{'state':'fail','info':'tr_id err'}");}
	$sql="select count(id) as c from ".self::$table_pre."table where `regular_id`='".$id."' and `name`='".$table."'";
	//echo $sql;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']==0){
		$sql="insert into ".self::$table_pre."table (`regular_id`,`name`,`multiple`,`reg`) values ('".$id."','".$table."','".$_POST['multiple']."','".$_POST['reg']."')";
	}else{
		$sql="update ".self::$table_pre."table set `multiple`='".$_POST['multiple']."',`reg`='".$_POST['reg']."' where `regular_id`='".$id."' and `name`='".$table."'";
	}
	
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
	}	
}


