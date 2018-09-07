<?php
$act=@$_GET['act'];
if($act=='del'){
	$id=intval(@$_GET['id']);
	if($id==0){exit("{'state':'fail','info':'id err'}");}
	$sql="select `goods_id` from ".self::$table_pre."comment where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	$goods_id=$r['goods_id'];
	$sql="delete from ".self::$table_pre."comment where `id`=".$id;
	if($pdo->exec($sql)){
		self::update_goods_comment($pdo,self::$table_pre,$goods_id);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='del_select'){
	$ids=@$_GET['ids'];
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$ids=explode("|",$ids);
	$ids=array_filter($ids);
	$success='';
	foreach($ids as $id){
		$id=intval($id);
		$sql="select `goods_id` from ".self::$table_pre."comment where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$goods_id=$r['goods_id'];
		$sql="delete from ".self::$table_pre."comment where `id`=".$id;
		if($pdo->exec($sql)){
			self::update_goods_comment($pdo,self::$table_pre,$goods_id);
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
