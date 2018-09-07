<?php
foreach($_GET as $key=>$v){
	if($v==''){exit("{'state':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");}
}
$act=@$_GET['act'];
if($act=='update'){	
	$id=intval($_POST['id']);
	$expiration=get_unixtime($_POST['expiration'],self::$config['other']['date_style']);
	if($id==0)exit("{'state':'fail','info':'<span class=fail>id err</span>'}");
	if($expiration<time())exit("{'state':'fail','info':'<span class=fail>".self::$language['cannot_be_less_than_the_current_date']."</span>'}");
	$sql="select * from ".self::$table_pre."goods_batch where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	$payment=floatval($_POST['payment']);
	if($payment>$r['quantity']){$payment=$r['quantity'];}
	if($payment<0){$payment=0;}
	
	$sql="update ".self::$table_pre."goods_batch set `expiration`='".$expiration."',`payment`='".$payment."' where `id`=".$id." and `shop_id`='".SHOP_ID."'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='add'){
	$option_html='';
	$id=intval(@$_GET['id']);
	if($id==0){return not_find();}
	
	$quantity=floatval(@$_POST['quantity']);
	$price=floatval(@$_POST['price']);
	if($quantity<0){exit("{'state':'fail','info':'<span class=fail>".self::$language['please_input'].self::$language['quantity']."</span>'}");}
	if($price<0){exit("{'state':'fail','info':'<span class=fail>".self::$language['please_input'].self::$language['price']."</span>'}");}
	
	
	$sql="select `option_enable`,`id`,`title`,`shop_id` from ".self::$table_pre."goods where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']=='' || $r['shop_id']!=SHOP_ID){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
	if($r['option_enable']){
		$option_id=intval(@$_POST['option_id']);
		if($option_id==0){exit("{'state':'fail','info':'<span class=fail>".self::$language['please_select'].self::$language['option']."</span>'}");}
		$sql="select * from ".self::$table_pre."goods_specifications where `id`=".$option_id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>optioni_id err</span>'}");}
		$id.='_'.$option_id;
		$option_name=self::get_type_option_name($pdo,$r['option_id']);
		$option_html='<td>'.$r['color_name'].' '.$option_name.'</td>';
	}
	if(self::add_goods_batch($pdo,$id,$quantity,$price)){
		$sql="select `inventory` from ".self::$table_pre."goods where `id`=".intval(@$_GET['id']);
		$r=$pdo->query($sql,2)->fetch(2);
		
		$html='<tr><td>'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,time()).'</td>'.$option_html.'<td>'.$quantity.'</td><td>'.$price.'</td><td>'.$quantity.'</td><td>--</td></tr>';
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','html':'".$html."','sum':'".self::format_quantity($r['inventory'])."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='update_payment'){
	$id=intval($_POST['id']);
	$v=floatval($_POST['v']);
	
	$sql="select * from ".self::$table_pre."goods_batch where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	$payment=floatval($_POST['v']);
	if($payment>$r['quantity']){$payment=$r['quantity'];}
	if($payment<0){$payment=0;}
	
	
	$sql="update ".self::$table_pre."goods_batch set `payment`=".$payment." where `id`=".$id." and `shop_id`=".SHOP_ID;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
