<?php


$list='';
foreach($_POST as $key=>$v){
	if(@$_POST[$key]){
		$list.=safe_str(@$_POST[$key]).",";
		}	
}
$sql="update ".self::$table_pre."shop set `express`='$list' where `id`=".SHOP_ID;
$affected_rows=$pdo->exec($sql);
if($affected_rows==0){
	exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
}else{
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");	
}