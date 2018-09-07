<?php
$act=@$_GET['act'];
$stocktake_id=intval(@$_GET['stocktake_id']);
if($stocktake_id<1){exit("{'state':'fail','info':'<span class=fail>stocktake_id err</span>'}");}

if($act=='inquiry'){
	$bar_code=safe_str($_POST['bar_code']);
	if($bar_code==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
	$sql="select * from ".self::$table_pre."goods where (`bar_code`='".$bar_code."' or `speci_bar_code` like '%".$bar_code."|%' or `store_code`='".$bar_code."' or `speci_store_code` like '%".$bar_code."|%')  and `shop_id`='".SHOP_ID."' limit 0,1";
	
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>".$bar_code.self::$language['not_exist']."</span>'}");}
	$r['option_id']=0;
	
	$sql="select `id` from ".self::$table_pre."goods where (`bar_code`='".$bar_code."' or `speci_bar_code` like '%".$bar_code."|%' or `store_code`='".$bar_code."' or `speci_store_code` like '%".$bar_code."|%')  and `shop_id`='".SHOP_ID."' limit 1,1";
	$r2=$pdo->query($sql,2)->fetch(2);
	if($r2['id']!=''){
		$sql="select `id`,`title` from ".self::$table_pre."goods where (`bar_code`='".$bar_code."' or `speci_bar_code` like '%".$bar_code."|%' or `store_code`='".$bar_code."' or `speci_store_code` like '%".$bar_code."|%')  and `shop_id`='".SHOP_ID."'";
		$r=$pdo->query($sql,2);
		$list='';
		foreach($r as $v){
			$list.='<a href='.$v['id'].'>'.de_safe_str($v['title']).'</a>';	
		}
		$result=array();
		$result['state']='success';
		$result['info']='<span class=success></span>';
		$result['list']='<div>'.self::$language['please_select'].'>></div>'.$list;
		exit(json_encode($result));
	}
	
	if($r['option_enable']){
		$sql="select * from ".self::$table_pre."goods_specifications where (`barcode`='".$bar_code."' || `store_code`='".$bar_code."') and `goods_id`='".$r['id']."' limit 0,100";
		$s=$pdo->query($sql,2);
		$r['option_list']='';
		$r['inventory']=0;
		foreach($s as $sv){
			$sql="select `id`,`stocktake`,`state` from ".self::$table_pre."stocktake_goods where `stocktake_id`='".$stocktake_id."' and `goods_id`='".$r['id']."' and `s_id`='".$sv['id']."' limit 0,1";
			$t=$pdo->query($sql,2)->fetch(2);
			//var_dump($t);
			if($t['state']==1 || $t['id']==''){continue;}
			$sv['quantity']=self::format_quantity($sv['quantity']);
			$r['option_list'].='<option s_id='.$sv['id'].' cost_price='.$sv['cost_price'].' value='.$t['id'].' quantity='.$sv['quantity'].' stocktake='.self::format_quantity($t['stocktake']).'>'.self::get_type_option_name($pdo,$sv['option_id']).' '.$sv['color_name'].'</option>';	
			$r['inventory']+=$sv['quantity'];
		}
		$r['id']=0;
		if($r['option_list']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['not_exist'].self::$language['or'].self::$language['stocktake_state'][1]."</span>'}");}
	}else{
		$sql="select `id`,`stocktake`,`state` from ".self::$table_pre."stocktake_goods where `stocktake_id`='".$stocktake_id."' and `goods_id`='".$r['id']."'  limit 0,1";
		$t=$pdo->query($sql,2)->fetch(2);
		if($t['state']==1 || $t['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['stocktake_end'].self::$language['inoperable']."</span>'}");}
		$r['id']=$t['id'];
		$r['quantity']=self::format_quantity($t['stocktake']);
		$r['inventory']=self::format_quantity($r['inventory']);
	}

	$r['state']='success';
	$r['info']='<span class=success></span>';
	$r['inventory']=self::format_quantity($r['inventory']);
	$r['unit']=self::get_mall_unit_name($pdo,$r['unit']);
	exit(json_encode($r));		
}


if($act=='inquiry_id'){
	$id=intval($_POST['id']);
	if($id==0){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
	$sql="select `id`,`title`,`inventory`,`unit`,`state`,`option_enable`,`icon` from ".self::$table_pre."goods where `id`=".$id." and `shop_id`='".SHOP_ID."' limit 0,1";
	
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['not_exist']."</span>'}");}
	$r['option_id']=0;
	
	if($r['option_enable']){
		$sql="select * from ".self::$table_pre."goods_specifications where `goods_id`='".$r['id']."' limit 0,100";
		$s=$pdo->query($sql,2);
		$r['option_list']='';
		$r['inventory']=0;
		foreach($s as $sv){
			$sql="select `id`,`stocktake`,`state` from ".self::$table_pre."stocktake_goods where `stocktake_id`='".$stocktake_id."' and `goods_id`='".$r['id']."' and `s_id`='".$sv['id']."' limit 0,1";
			$t=$pdo->query($sql,2)->fetch(2);
			//var_dump($t);
			if($t['state']==1 || $t['id']==''){continue;}
			$sv['quantity']=self::format_quantity($sv['quantity']);
			$r['option_list'].='<option s_id='.$sv['id'].' cost_price='.$sv['cost_price'].' value='.$t['id'].' quantity='.$sv['quantity'].' stocktake='.self::format_quantity($t['stocktake']).'>'.self::get_type_option_name($pdo,$sv['option_id']).' '.$sv['color_name'].'</option>';	
			$r['inventory']+=$sv['quantity'];
		}
		$r['id']=0;
		if($r['option_list']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['not_exist'].self::$language['or'].self::$language['stocktake_state'][1]."</span>'}");}
		
	}else{
		$sql="select `id`,`stocktake`,`state` from ".self::$table_pre."stocktake_goods where `stocktake_id`='".$stocktake_id."' and `goods_id`='".$r['id']."'  limit 0,1";
		$t=$pdo->query($sql,2)->fetch(2);
		if($t['state']==1 || $t['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['stocktake_end'].self::$language['inoperable']."</span>'}");}
		$r['id']=$t['id'];
		$r['quantity']=self::format_quantity($t['stocktake']);
		$r['inventory']=self::format_quantity($r['inventory']);
	}

	$r['state']='success';
	$r['info']='<span class=success></span>';
	$r['inventory']=self::format_quantity($r['inventory']);
	$r['unit']=self::get_mall_unit_name($pdo,$r['unit']);
	exit(json_encode($r));
		
}


if($act=='update'){
	$time=time();
	$id=intval($_POST['id']);
	$quantity=floatval(@$_POST['quantity']);
	if($id<0){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
	
	$sql="select * from ".self::$table_pre."stocktake_goods where `id`=".$id." and `stocktake_id`='".$stocktake_id."' limit 0,1";
	$s=$pdo->query($sql,2)->fetch(2);
	if($s['id']==''){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
	if($s['s_id']==0){
		$sql="select `inventory` from ".self::$table_pre."goods where `id`=".$s['goods_id'];
		$r=$pdo->query($sql,2)->fetch(2);
		$r['quantity']=$r['inventory'];	
	}else{
		$sql="select `quantity` from ".self::$table_pre."goods_specifications where `id`=".$s['s_id'];
		$r=$pdo->query($sql,2)->fetch(2);
	}
	//$stocktake=min($quantity,$r['quantity']);
	$stocktake=$quantity;
	if($stocktake>$r['quantity']){
		$quantity=$stocktake-$r['quantity'];
		if($s['s_id']==0){
			$g_id=$s['goods_id'];
		}else{
			$g_id=$s['goods_id'].'_'.$s['s_id'];
		}
		
		$sql="select `price`,`supplier` from ".self::$table_pre."goods_batch where `goods_id`='".$g_id."' order by `id` desc limit 0,1";
		$t=$pdo->query($sql,2)->fetch(2);
		if($t['price']==''){$t['price']=0;}
		if($t['supplier']==''){$t['supplier']=0;}
		$_POST['payment']=$quantity;
		$_POST['remark']=self::$language['auto_purchase_remark'];
		self::add_goods_batch($pdo,$g_id,$quantity,$t['price'],$t['supplier']);
	}
	
	
	$sql="update ".self::$table_pre."stocktake_goods set `stocktake`='".$stocktake."',`time`='".time()."' where `id`='$id' and `stocktake_id`='".$stocktake_id."'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
