<?php
$act=@$_GET['act'];
if($act=='inquiry'){
	$bar_code=safe_str($_POST['bar_code']);
	if($bar_code==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
	$sql="select * from ".self::$table_pre."goods where (`bar_code`='".$bar_code."' or `speci_bar_code` like '%".$bar_code."|%')  and `shop_id`='".SHOP_ID."' limit 0,1";
	
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['not_exist']."</span>'}");}
	if($r['option_enable']){
		$sql="select * from ".self::$table_pre."goods_specifications where `barcode`='".$bar_code."' and `goods_id`='".$r['id']."' limit 0,1";
		$s=$pdo->query($sql,2)->fetch(2);
		if($s['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['not_exist']."</span>'}");}
		$r['option_id']=$s['id'];
		$r['option_name']=self::get_type_option_name($pdo,$s['option_id']).' '.$s['color_name'];
		$r['cost_price']=$s['cost_price'];
		$r['inventory']=$s['quantity'];
	}
	$r['state']='success';
	$r['info']='<span class=success></span>';
	$r['inventory']=self::format_quantity($r['inventory']);
	$r['unit']=self::get_mall_unit_name($pdo,$r['unit']);
	
	$r['loss_reason_option']='';
	$sql="select `reason` from ".self::$table_pre."goods_deduct_stock where `goods_id`=".$r['id']." group by `reason` order by `id` desc limit 0,10";
	$rr=$pdo->query($sql,2);
	$i=0;
	foreach($rr as $v){
		$v['reason']=de_safe_str($v['reason']);
		$r['loss_reason_option'].='<option value="'.$v['reason'].'">'.$v['reason'].'</option>';
		$i++;	
	}

	if($i<10){
		$sql="select `reason` from ".self::$table_pre."goods_deduct_stock where `goods_id`!=".$r['id']." group by `reason` order by `id` desc limit 0,".(10-$i);
		$rr=$pdo->query($sql,2);
		foreach($rr as $v){
			$v['reason']=de_safe_str($v['reason']);
			$r['loss_reason_option'].='<option value="'.$v['reason'].'">'.$v['reason'].'</option>';
		}
	}
	if($r['loss_reason_option']!=''){$r['loss_reason_option'].='<option value="0">'.self::$language['other'].'</option>';}
	
	exit(json_encode($r));
		
}

if($act=='add'){
	$time=time();
	$id=intval($_POST['id']);
	$option_id=intval(@$_POST['option_id']);
	$supplier=intval($_POST['supplier']);
	$quantity=floatval(@$_POST['quantity']);
	$reason=safe_str(@$_POST['reason']);
	if($id<0){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
	if($quantity<0){exit("{'state':'fail','info':'<span class=fail>".self::$language['please_input'].self::$language['quantity']."</span>'}");}
	
	
	$sql="select `option_enable`,`id`,`title`,`shop_id`,`cost_price`,`inventory` from ".self::$table_pre."goods where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']=='' || $r['shop_id']!=SHOP_ID){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
	$goods_id=$id;
	if($r['option_enable']){
		$option_id=intval(@$_POST['option_id']);
		if($option_id==0){exit("{'state':'fail','info':'<span class=fail>".self::$language['please_select'].self::$language['option']."</span>'}");}
		$sql="select * from ".self::$table_pre."goods_specifications where `id`=".$option_id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>optioni_id err</span>'}");}
		if($quantity>$r['quantity']){exit("{'state':'fail','info':'<span class=fail>".self::$language['quantity'].self::$language['greater_than'].self::format_quantity($r['quantity'])."</span>'}");}
		
		$goods_id.='_'.$option_id;
		$sql="update ".self::$table_pre."goods_specifications set `quantity`=`quantity`-".$quantity." where `id`=".$option_id." and `goods_id`=".$id;
		$pdo->exec($sql);
	}else{
		if($quantity>$r['inventory']){exit("{'state':'fail','info':'<span class=fail>".self::$language['quantity'].self::$language['greater_than'].self::format_quantity($r['inventory'])."</span>'}");}
		
	}
	
	
	$sql="update ".self::$table_pre."goods set `inventory`=`inventory`-".$quantity." where `id`=".$id;	
	if($pdo->exec($sql)){
		$batch_id=self::decrease_goods_batch($pdo,$goods_id,$quantity);
		$sql="insert into ".self::$table_pre."goods_deduct_stock (`goods_id`,`s_id`,`quantity`,`money`,`reason`,`time`,`username`,`shop_id`) values ('".$id."','".$option_id."','".$quantity."','".(self::get_cost_price($pdo,$goods_id)*$quantity)."','".$reason."','".$time."','".$_SESSION['monxin']['username']."','".SHOP_ID."')";
		if($pdo->exec($sql)){
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
