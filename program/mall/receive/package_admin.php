<?php

$id=intval(@$_GET['id']);
if($id==0){exit("{'state':'fail','info':'id err'}");}

$act=@$_GET['act'];
if($act=='update'){
	$discount=floatval(@$_GET['discount']);
	if($discount>10){$discount=10;}
	$ids=@$_GET['ids'];
	$temp=explode(',',$ids);
	$temp=array_filter($temp);
	$temp=array_unique($temp);
	foreach($temp as $key=>$v){
		if(!is_numeric($v)){unset($temp[$key]);}	
	}
	$temp=implode(',',$temp);
	$sql="update ".self::$table_pre."package set `goods_ids`='".trim($temp,',')."',`discount`='".$discount."',`free_shipping`='".intval(@$_GET['free_shipping'])."' where `id`='".$id."' and `shop_id`=".SHOP_ID;
	if($pdo->exec($sql)){
		if(trim($temp,',')==''){
			$sql="delete from ".self::$table_pre."package where `id`=".$id." and `shop_id`=".SHOP_ID;
			$pdo->exec($sql);	
		}
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;".self::$language['executed']."</span>'}");
	}
}

if($act=='del'){
	  $sql="delete from ".self::$table_pre."package where `id`=".$id." and `shop_id`=".SHOP_ID;
	  if($pdo->exec($sql)){
		  exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	  }else{
		  exit("{'state':'success','info':'<span class=success>&nbsp;".self::$language['executed']."</span>'}");
	  }
}