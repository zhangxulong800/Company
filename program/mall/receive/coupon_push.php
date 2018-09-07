<?php
$id=intval(@$_GET['id']);
$sql="select `name`,`sum_quantity`,`draws` from ".self::$table_pre."coupon where `id`=".$id." and `shop_id`=".SHOP_ID;
$r=$pdo->query($sql,2)->fetch(2);
if($r['name']==''){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
$balance=$r['sum_quantity']-$r['draws'];
$draws=$r['draws'];
if($balance<1){exit("{'state':'fail','info':'<span class=fail>balance < 1</span>'}");}
$act=$_GET['act'];
if($act=='push'){
	$not_exist='';
	$push=0;
	$type=@$_GET['type'];
	if($type=='group'){
		$group=intval($_POST['group']);
		$sql="select `username` from ".self::$table_pre."shop_buyer";
		if($group>0){
			$sql="select `username` from ".self::$table_pre."shop_buyer where `group_id`=".$group;
		}
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			if($balance-$push<1){break;}
			$sql="select `id` from ".self::$table_pre."my_coupon where `username`='".$v['username']."' and `coupon_id`=".$id." and `order_id`=0 limit 0,1";
			$r2=$pdo->query($sql,2)->fetch(2);
			if($r2['id']==''){
				$sql="insert into ".self::$table_pre."my_coupon (`coupon_id`,`username`,`draws_time`) values ('".$id."','".$v['username']."','".time()."')";
				if($pdo->exec($sql)){
					$push++;	
				}	
			}	
		}
	}else{
		
		$usernames=safe_str($_POST['usernames']);
		if($usernames==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
		$usernames=explode(',',$usernames);
		if(count($usernames)>$balance){exit("{'state':'fail','info':'<span class=fail>".str_replace('{sum}',count($usernames),str_replace('{balance}',$balance,self::$language['balance_less_than_sum']))."</span>'}");}
		foreach($usernames as $username){
			if($balance-$push<1){break;}
			$sql="select `id` from ".self::$table_pre."shop_buyer where `username`='".$username."' limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']==''){$not_exist.=$username.',';continue;}
			$sql="select `id` from ".self::$table_pre."my_coupon where `username`='".$username."' and `coupon_id`=".$id." and `order_id`=0 limit 0,1";
			$r2=$pdo->query($sql,2)->fetch(2);
			if($r2['id']==''){
				$sql="insert into ".self::$table_pre."my_coupon (`coupon_id`,`username`,`draws_time`) values ('".$id."','".$username."','".time()."')";
				if($pdo->exec($sql)){
					$push++;	
				}	
			}	
		}
		$not_exist=trim($not_exist,',');
		if($not_exist!=''){$not_exist=' '.self::$language['not_your_member'].$not_exist;}
	}
	
	$sql="update ".self::$table_pre."coupon set `draws`=`draws`+".$push." where `id`=".$id;	
	$draws+=$push;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success'].$not_exist."</span>','draws':'".$draws."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail'].$not_exist."</span>','draws':'".$draws."'}");
	}
}
