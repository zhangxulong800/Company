<?php
if(@$_GET['power']==''){exit('power is null');}
if(intval(@$_GET['id'])==0){exit('id is null');}

$power=$_GET['power'];
$sql="update ".self::$table_pre."type set `".$_GET['power']."`='".$_POST['ids']."' where `id`='".$_GET['id']."'";
if($pdo->exec($sql)){
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
}else{
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
}
