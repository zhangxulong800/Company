<?php
$act=@$_GET['act'];
if($act=='goods_up'){
	$goods_id=intval(@$_POST['id']);
	if(self::goods_up($pdo,$goods_id)){
		self::update_shop_goods($pdo,self::$table_pre,SHOP_ID);	
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail'].@$_POST['reason']."</span>'}");
	}
}

if($act=='goods_up_select'){
	$r=explode('|',$_POST['ids']);
	$success='';
	foreach($r as $v){
		if(!is_numeric($v)){continue;}
		if(self::goods_up($pdo,$v)){
			$success.=$v."|";
		}
	}
	$success=trim($success,"|");	
	self::update_shop_goods($pdo,self::$table_pre,SHOP_ID);		
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}

if($act=='goods_up_all'){
	$sql="select `db_id` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and `db_id`!=0";
	$r=$pdo->query($sql,2);
	$exist='';
	foreach($r as $v){
		$exist.=$v['db_id'].',';	
	}
	$exist=trim($exist,',');
	
	$head_id=self::get_head_id($pdo,SHOP_ID);
	$sql="select `id` from ".self::$table_pre."goods where `shop_id`='".$head_id."'";
	if($exist!=''){$sql.=" and `id` not in (".$exist.")";}
	$r=$pdo->query($sql,2);
	$success='';
	foreach($r as $v){
		if(!is_numeric($v['id'])){continue;}
		if(self::goods_up($pdo,$v['id'])){
			$success.=$v['id']."|";
		}
	}
	$success=trim($success,"|");	
	self::update_shop_goods($pdo,self::$table_pre,SHOP_ID);		
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
