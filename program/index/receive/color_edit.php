<?php
$id=intval($_GET['id']);
if($id==0){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
$sql="select `id` from ".$pdo->index_pre."color where `id`=".$id;
$pk=$pdo->query($sql,2)->fetch(2);
if($pk['id']==''){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}

$data=json_encode($_POST);
$data=safe_str($data);
$sql="update ".$pdo->index_pre."color set `data`='".$data."' where `id`=".$id;
if($pdo->exec($sql)){
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");			
}else{
	exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
}
