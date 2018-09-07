<?php
$act=@$_GET['act'];
if($act=='update'){
	$_GET['id']=intval(@$_GET['id']);
	if($_GET['id']==0){exit('id err');}
	$write_able=intval(@$_GET['write_able']);
	$read_able=intval(@$_GET['read_able']);
	$fore_list_show=intval(@$_GET['fore_list_show']);
	$back_list_show=intval(@$_GET['back_list_show']);
	$sequence=intval(@$_GET['sequence']);
	
	$sql = "update ".self::$table_pre."field set `write_able`='".$write_able."',`read_able`='".$read_able."',`fore_list_show`='".$fore_list_show."',`back_list_show`='".$back_list_show."',`sequence`='".$sequence."' where `id`='".$_GET['id']."'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
	}
		
		
}

if($act=='del'){
	$_GET['id']=intval(@$_GET['id']);
	if($_GET['id']==0){exit('id err');}
	$sql="select `name`,`table_id` from ".self::$table_pre."field where `id`='".$_GET['id']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['name']==''){exit("{'state':'fail','info':'<span class=fail>field is not exist</span>'}");}
	$field_name=$r['name'];
	if(in_array($field_name,self::$config['sys_field'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['forbidden_del']."</span>'}");}
	$table_id=$r['table_id'];
	$sql="select `name` from ".self::$table_pre."table where `id`=".$table_id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['name']==''){exit("{'state':'fail','info':'<span class=fail>field is not exist</span>'}");}
	$table_name=self::$table_pre.$r['name'];
	if(!field_exist($pdo,$table_name,$field_name)){
		$sql="delete from ".self::$table_pre."field where `id`='".$_GET['id']."'";
		$pdo->exec($sql);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}
	
	$sql="ALTER TABLE  `".$table_name."` DROP  `".$field_name."`";
	$pdo->exec($sql);
	if(field_exist($pdo,$table_name,$field_name)){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}else{
		$sql="delete from ".self::$table_pre."field where `id`='".$_GET['id']."'";
		$pdo->exec($sql);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}
	
}
