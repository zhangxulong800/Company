<?php


$act=@$_GET['act'];

if($act=='update'){

	if(@$_POST['start_time']==''){exit("{'state':'fail','info':'<span class=fail>start_time is null</span>','id':'start_time'}");}
	if(@$_POST['end_time']==''){exit("{'state':'fail','info':'<span class=fail>end_time is null</span>','id':'end_time'}");}
	$start_time=get_unixtime($_POST['start_time'],self::$config['other']['date_style']);
	$end_time=get_unixtime($_POST['end_time'],self::$config['other']['date_style'])+86399;
	if($end_time<=$start_time){exit("{'state':'fail','info':'<span class=fail>".self::$language['the_end_time_must_be_greater_than_the_start_time']."</span>'}");}
	
	$use_method=intval(@$_POST['use_method']);
	if($use_method==-1){exit("{'state':'fail','info':'<span class=fail>".self::$language['please_select']."</span>','id':'use_method'}");}
	
	$less_money=floatval(@$_POST['less_money']);
	$min_money=floatval(@$_POST['min_money']);
	if($min_money<1){exit("{'state':'fail','info':'<span class=fail>".self::$language['please_input']."</span>','id':'min_money'}");}
	if($use_method==1){
		if($less_money==0){exit("{'state':'fail','info':'<span class=fail>".self::$language['please_input']."</span>','id':'less_money'}");}
		if($min_money<=$less_money){exit("{'state':'fail','info':'<span class=fail>".self::$language['must_be_less_than'].$min_money."</span>','id':'less_money'}");}
		
	}
	$discount=floatval(@$_POST['discount']);
	if($discount>10){$discount=10;}
	if($discount<1){$discount=1;}
	
	
	
	if(intval($_POST['id'])==0){
		$sql="insert into ".self::$table_pre."fulfil_preferential (`shop_id`,`discount`,`start_time`,`end_time`,`time`,`username`,`use_method`,`less_money`,`min_money`,`join_goods`) values ('".SHOP_ID."','".$discount."','".$start_time."','".$end_time."','".time()."','".$_SESSION['monxin']['username']."','".$use_method."','".$less_money."','".$min_money."','".intval(@$_POST['join_goods'])."')";
	}else{
		$sql="update ".self::$table_pre."fulfil_preferential set `discount`='".$discount."',`start_time`='".$start_time."',`end_time`='".$end_time."',`time`='".time()."',`username`='".$_SESSION['monxin']['username']."',`use_method`='".$use_method."',`join_goods`='".intval(@$_POST['join_goods'])."',`less_money`='".$less_money."',`min_money`='".$min_money."' where `id`='".intval($_POST['id'])."' and `shop_id`=".SHOP_ID;	
	}
	//echo $sql;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
	

	
}
if($act=='del'){
	$id=intval($_GET['id']);
	$sql="delete from ".self::$table_pre."fulfil_preferential where `id`='$id' and `shop_id`=".SHOP_ID;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
