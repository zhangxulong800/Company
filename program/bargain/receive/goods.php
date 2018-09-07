<?php
$act=@$_GET['act'];

if($act=='del'){
	$id=intval($_GET['id']);
	$sql="select `shop_id` from ".self::$table_pre."goods where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if(SHOP_ID!=$r['shop_id']){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." shop err</span>'}");}
	
	if(self::delete_bargain($pdo,$id)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

