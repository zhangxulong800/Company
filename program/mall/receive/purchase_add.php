<?php
$act=@$_GET['act'];
if($act=='inquiry'){
	$bar_code=safe_str($_POST['bar_code']);
	if($bar_code==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
	$sql="select * from ".self::$table_pre."goods where (`bar_code`='".$bar_code."' or `speci_bar_code` like '%".$bar_code."|%' or `store_code`='".$bar_code."' or `speci_store_code` like '%".$bar_code."|%')  and `shop_id`='".SHOP_ID."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>".$bar_code.self::$language['not_exist']."</span>','clear':'1'}");}
	
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
		$new_cost_price2=0;
		foreach($s as $sv){
			if($new_cost_price2==0){$new_cost_price2=self::get_cost_price_new_2($pdo,$r['id'].'_'.$sv['id']);}
			$sv['cost_price']=self::get_cost_price_new($pdo,$r['id'].'_'.$sv['id']);
			$r['cost_price']=$new_cost_price2;
			
			$sv['quantity']=self::format_quantity($sv['quantity']);
			$r['option_list'].='<option value='.$sv['id'].' cost_price='.$sv['cost_price'].' quantity='.$sv['quantity'].'>'.self::get_type_option_name($pdo,$sv['option_id']).' '.$sv['color_name'].'</option>';	
			$r['inventory']+=$sv['quantity'];
		}
		if($r['option_list']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['not_exist']."</span>'}");}
	}else{
		$r['inventory']=self::format_quantity($r['inventory']);
		$r['cost_price']=$r['cost_price'];
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
	$sql="select * from ".self::$table_pre."goods where `id`=".$id." and `shop_id`='".SHOP_ID."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['not_exist']."</span>','clear':'1'}");}
	if($r['option_enable']){
		$sql="select * from ".self::$table_pre."goods_specifications where `goods_id`='".$r['id']."' limit 0,100";
		$s=$pdo->query($sql,2);
		$r['option_list']='';
		$r['inventory']=0;
		foreach($s as $sv){
			$sv['quantity']=self::format_quantity($sv['quantity']);
			$r['option_list'].='<option value='.$sv['id'].' cost_price='.$sv['cost_price'].' quantity='.$sv['quantity'].'>'.self::get_type_option_name($pdo,$sv['option_id']).' '.$sv['color_name'].'</option>';	
			$r['inventory']+=$sv['quantity'];
		}
		if($r['option_list']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['not_exist']."</span>'}");}
	}else{
		$r['inventory']=self::format_quantity($r['inventory']);
		$r['cost_price']=$r['cost_price'];
	}
	
	$r['state']='success';
	$r['info']='<span class=success></span>';
	$r['unit']=self::get_mall_unit_name($pdo,$r['unit']);
	exit(json_encode($r));
		
}

if($act=='add'){
	
	$id=intval($_POST['id']);
	$supplier=intval($_POST['supplier']);
	$quantity=floatval(@$_POST['quantity']);
	$price=floatval(@$_POST['price']);
	if($id<0){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
	if($quantity<0){exit("{'state':'fail','info':'<span class=fail>".self::$language['please_input'].self::$language['quantity']."</span>'}");}
	if($price<=0){exit("{'state':'fail','info':'<span class=fail>".self::$language['please_input'].self::$language['cost_price']."</span>'}");}
	
	$expiration=0;
	if($_POST['production_date']!='' && $_POST['shelf_life']!=''){
		$_POST['shelf_life']=intval($_POST['shelf_life']);
		if($_POST['shelf_life']>0){
			$start_time=get_unixtime($_POST['production_date'],self::$config['other']['date_style']);
			$expiration=$start_time+(86400*$_POST['shelf_life']);	
		}	
	}
		
	$sql="select `option_enable`,`id`,`title`,`shop_id` from ".self::$table_pre."goods where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']=='' || $r['shop_id']!=SHOP_ID){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
	if($r['option_enable']){
		$option_id=intval(@$_POST['option_id']);
		
		//if($option_id==0){exit("{'state':'fail','info':'<span class=fail>".self::$language['please_select'].self::$language['option']."</span>'}");}
		if($option_id>0){
			$sql="select * from ".self::$table_pre."goods_specifications where `id`=".$option_id;
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>optioni_id err</span>'}");}
			$id.='_'.$option_id;
		}else{
			$sql="select `id` from ".self::$table_pre."goods_specifications where `goods_id`=".$id;
			$r=$pdo->query($sql,2);
			$success=0;
			foreach($r as $v){
				if(self::add_goods_batch($pdo,$id.'_'.$v['id'],$quantity,$price,$supplier,$expiration)){$success++;}
			}
			$sql="select `inventory`,`state` from ".self::$table_pre."goods where `id`=".intval(@$_GET['id']);
			$r=$pdo->query($sql,2)->fetch(2);
			if($success>0){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','sum':'".self::format_quantity($r['inventory'])."'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
			

		}
	}
	
	if(self::add_goods_batch($pdo,$id,$quantity,$price,$supplier,$expiration)){
		$sql="select `inventory`,`state` from ".self::$table_pre."goods where `id`=".intval(@$_GET['id']);
		$r=$pdo->query($sql,2)->fetch(2);		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','sum':'".self::format_quantity($r['inventory'])."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
