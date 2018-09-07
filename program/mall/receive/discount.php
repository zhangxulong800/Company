<?php

$rate=floatval(@$_POST['rate']);
if($rate>10){$rate=10;}
if($rate<1){$rate=1;}
if(@$_POST['start_time']==''){exit("{'state':'fail','info':'<span class=fail>start_time is null</span>','id':'start_time'}");}
if(@$_POST['end_time']==''){exit("{'state':'fail','info':'<span class=fail>end_time is null</span>','id':'end_time'}");}

$start_time=get_unixtime($_POST['start_time'],self::$config['other']['date_style']);
$end_time=get_unixtime($_POST['end_time'],self::$config['other']['date_style']);
if($end_time<=$start_time){exit("{'state':'fail','info':'<span class=fail>".self::$language['the_end_time_must_be_greater_than_the_start_time']."</span>'}");}

$sql="select * from ".self::$table_pre."discount where `shop_id`=".SHOP_ID;
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']==''){
	$sql="insert into ".self::$table_pre."discount (`shop_id`,`rate`,`start_time`,`end_time`,`time`,`username`,`join_goods`) values ('".SHOP_ID."','".$rate."','".$start_time."','".$end_time."','".time()."','".$_SESSION['monxin']['username']."','".intval(@$_POST['join_goods'])."')";
}else{
	$sql="update ".self::$table_pre."discount set `rate`='".$rate."',`start_time`='".$start_time."',`end_time`='".$end_time."',`time`='".time()."',`username`='".$_SESSION['monxin']['username']."',`join_goods`='".intval(@$_POST['join_goods'])."' where  `shop_id`=".SHOP_ID;	
}
if($pdo->exec($sql)){
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
}else{
	exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
}

