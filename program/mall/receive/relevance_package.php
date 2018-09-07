<?php

$goods_id=intval(@$_GET['goods_id']);
if($goods_id==0){exit("{'state':'fail','info':'id err'}");}

$act=@$_GET['act'];
if($act=='update'){
	$ids=@$_GET['ids'];
	$temp=explode(',',$ids);
	$temp=array_filter($temp);
	$temp=array_unique($temp);
	foreach($temp as $key=>$v){
		if(!is_numeric($v)){unset($temp[$key]);}	
	}
	$temp=implode(',',$temp);
	$sql="update ".self::$table_pre."goods set `relevance_package`='".trim($temp,',')."' where `id`='".$goods_id."' and `shop_id`=".SHOP_ID;
	//echo $sql;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;".self::$language['executed']."</span>'}");
	}
}
