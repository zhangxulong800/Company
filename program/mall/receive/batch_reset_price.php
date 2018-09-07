<?php
$act=@$_GET['act'];
$id=intval(@$_GET['id']);
if($act=='update_discount'){
	$goods_id=intval(@$_POST['goods_id']);
	$group_id=intval(@$_POST['group_id']);
	if($_POST['discount']>10){$_POST['discount']=10;}
	if($_POST['discount']<0){$_POST['discount']=0;}
	if(!is_numeric($_POST['discount'])){$_POST['discount']=0;}
	$discount=$_POST['discount'];
		$sql="select `shop_id` from ".self::$table_pre."goods where `id`=".$goods_id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['shop_id']!=SHOP_ID){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." no power</span>'}");}

		$sql="select `id` from ".self::$table_pre."goods_group_discount where `goods_id`=".$goods_id." and `group_id`=".$group_id." limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){
			if($discount!=0){
				$sql="update ".self::$table_pre."goods_group_discount set `discount`=".$discount." where `goods_id`=".$goods_id." and `group_id`=".$group_id." limit 1";
			}else{
				$sql="delete from ".self::$table_pre."goods_group_discount where `goods_id`=".$goods_id." and `group_id`=".$group_id." limit 1";
			}
		}else{
			if($discount==0){exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");}
			$sql="insert into ".self::$table_pre."goods_group_discount (`goods_id`,`group_id`,`discount`) values ('".$goods_id."','".$group_id."','".$discount."')";
		}
		//file_put_contents('t.txt',$sql);
		if($pdo->exec($sql)){
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
}

if($act=='update_goods_s'){
	$id=str_replace('s_','',$_POST['s_id']);
	$id=intval($id);
	$sql="select `goods_id` from ".self::$table_pre."goods_specifications where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['goods_id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");}
	$goods_id=$r['goods_id'];
	$sql="select `shop_id` from ".self::$table_pre."goods where `id`=".$r['goods_id'];
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['shop_id']!=SHOP_ID){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." no power</span>'}");}
	$sql="update ".self::$table_pre."goods_specifications set `e_price`=".floatval($_POST['e_price']).",`w_price`=".floatval($_POST['w_price'])." where `id`=".$id;
	
	if($pdo->exec($sql)){
		$sql="select `w_price` from ".self::$table_pre."goods_specifications where `goods_id`=".$goods_id;
		$r=$pdo->query($sql,2);
		$w_price=array();
		foreach($r as $v){
			$w_price[]=$v['w_price'];
		}
		
		$sql="update ".self::$table_pre."goods set `min_price`='".min($w_price)."',`max_price`='".max($w_price)."',`w_price`='".((min($w_price)+max($w_price))/2)."' where `id`=".$goods_id;
		$pdo->exec($sql);
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='update_goods'){
	
	$id=str_replace('tr_','',$_POST['id']);
	$id=intval($id);
	$w_price=floatval($_POST['w_price']);
	$e_price=floatval($_POST['e_price']);
	$sql="update ".self::$table_pre."goods set `min_price`='".$w_price."',`max_price`='".$w_price."',`w_price`='".$w_price."',`e_price`='".$e_price."' where `id`=".$id;
	if($pdo->exec($sql)){		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='batch_reset'){
	//var_dump($_POST);exit;
	$min_price=floatval($_POST['min_price']);
	$max_price=floatval($_POST['max_price']);
	$new_price=floatval($_POST['new_price']);
	$where='';
	if(isset($_POST['type'])){
		$_POST['type']=intval(@$_POST['type']);
		$type_ids=$this->get_shop_type_ids($pdo,$_POST['type']);
		if($_POST['type']=='0'){$type_ids='0';}
		if($type_ids!='0'){$where.=" and `shop_type` in (".$type_ids.")";}
		
	}
	
	$_POST['tag']=intval(@$_POST['tag']);
	if($_POST['tag']>0){
		$where.=" and `shop_tag` like '%|".$_POST['tag']."|%'";
	}
	$_GET['position']=intval(@$_GET['position']);
	if($_GET['position']>0){$where.=" and `position` ='".$_GET['position']."'";}
	$_GET['supplier']=intval(@$_GET['supplier']);
	if($_GET['supplier']>0){$where.=" and `supplier` ='".$_GET['supplier']."'";}
	
	
	
	
	
	$sql="select `id`,`option_enable` from ".self::$table_pre."goods where `min_price`>".($min_price-0.01)." and `max_price`<".($max_price+0.01)." ".$where;
	$r=$pdo->query($sql,2);
	//file_put_contents('t.txt',$sql);
	$success=0;
	
	foreach($r as $v){
		if($v['option_enable']){
			$sql="update ".self::$table_pre."goods set `min_price`=".$new_price.",`max_price`=".$new_price.",`w_price`=".$new_price.",`e_price`=".$new_price." where `id`=".$v['id'];
			$pdo->exec($sql);
			$sql="update ".self::$table_pre."goods_specifications set `e_price`=".$new_price.",`w_price`=".$new_price." where `goods_id`=".$v['id'];
			if($pdo->exec($sql)){$success++;}
			
			
		}else{
			$sql="update ".self::$table_pre."goods set `min_price`=".$new_price.",`max_price`=".$new_price.",`w_price`=".$new_price.",`e_price`=".$new_price." where `id`=".$v['id'];
			if($pdo->exec($sql)){$success++;}
		}	
	}
	
	if($success){		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','success':'".$success."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
	
}

