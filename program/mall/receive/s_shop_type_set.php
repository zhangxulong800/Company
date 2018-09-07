<?php


$act=@$_GET['act'];
if($act=='submit'){
	$_GET['c_id']=intval(@$_GET['c_id']);
	$sql="select `shop_id` from ".self::$table_pre."shop_type where `id`=".intval($_GET['shop_type']);
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['shop_id']!=SHOP_ID)exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." shop err</span>'}");
	$sql="update ".self::$table_pre."goods set `shop_type`='".intval($_GET['shop_type'])."' where `id`=".$_GET['c_id']." and `shop_id`=".SHOP_ID;	
	if($pdo->exec($sql)){
		$html=self::$language['store'].self::$language['type'].": ".str_replace('/a>','/a> >',self::get_shop_type_position($pdo,intval($_GET['shop_type']))).' <a href=./index.php?monxin=mall.s_shop_type_set&c_id='.$_GET['c_id'].'&id='.intval($_GET['shop_type']).' class=set>&nbsp;</a>';
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','html':'".$html."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}