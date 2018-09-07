<?php

foreach($_GET as $key=>$v){
	if($v==''){exit("{'state':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");}
}
$act=@$_GET['act'];


if($act=='export_csv'){
	$id=intval(@$_GET['id']);
	if($id<1){exit(' id err');}
	
	$sql="select `name` from ".self::$table_pre."shop where `id`=".SHOP_ID;
	$r=$pdo->query($sql,2)->fetch(2);
	$shop_name=$r['name'];
	$sql="select * from ".self::$table_pre."buy_coupon where `id`=".$id." and `shop_id`=".SHOP_ID;
	$c=$pdo->query($sql,2)->fetch(2);
	if($c['id']==''){exit('id err');}
	
	header("Content-Type: text/csv");
	header("Content-Disposition: attachment; filename=".urlencode($shop_name.'_'.$c['name']).".csv");
	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
	header('Expires:0');
	header('Pragma:public');
	
	
	
	$list=self::$language['id'].','.self::$language['name'].','.self::$language['vouchers_amount'].','.self::$language['vouchers_min_money'].','.self::$language['period_of_use'].','.self::$language['range_of_use'].','.self::$language['password'].''."\r\n";	
	
	$sql="select `id`,`code` from ".self::$table_pre."buy_coupon_list where `shop_id`=".SHOP_ID." and `coupon_id`=".$id;
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		
		$list.=$v['id']."\t,".$c['name']."\t,".$c['amount']."\t,".$c['min_money']."\t,".(get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$c['start_time'])." - ".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$c['end_time']))."\t,".self::$language['join_goods_front'][$c['join_goods']]."\t,".$v['code'].''."\r\n";	
	}
	
	$list=iconv("UTF-8",self::$config['other']['export_csv_charset'],$list);
	echo $list;
	exit;

}


if($act=='add'){
	$_GET['name']=safe_str($_GET['name']);
	$_GET['amount']=floatval($_GET['amount']);
	$_GET['min_money']=floatval($_GET['min_money']);
	$_GET['start_time']=get_unixtime($_GET['start_time'],self::$config['other']['date_style']);
	$_GET['end_time']=get_unixtime($_GET['end_time'],self::$config['other']['date_style'])+86399;
	$_GET['sum_quantity']=intval($_GET['sum_quantity']);
	$_GET['sum_quantity']=min($_GET['sum_quantity'],10000);
	$_GET['sum_quantity']=max($_GET['sum_quantity'],1);
	if($_GET['end_time']<=$_GET['start_time']){exit("{'state':'fail','info':'<span class=fail>".self::$language['the_end_time_must_be_greater_than_the_start_time']."</span>'}");}
	
	$sql="select count(id) as c from ".self::$table_pre."buy_coupon where `shop_id`=".SHOP_ID." and `name`='".$_GET['name']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist_same'].self::$language['name']."</span>'}");}
	
	$sql="insert into ".self::$table_pre."buy_coupon (`name`,`amount`,`min_money`,`start_time`,`end_time`,`shop_id`,`time`,`username`,`sum_quantity`,`join_goods`) values ('".$_GET['name']."','".$_GET['amount']."','".$_GET['min_money']."','".$_GET['start_time']."','".$_GET['end_time']."','".SHOP_ID."','".time()."','".$_SESSION['monxin']['username']."','".$_GET['sum_quantity']."','".intval(@$_GET['join_goods'])."')";
	if($pdo->exec($sql)){
		$coupon_id=$pdo->lastInsertId();
		$sql="select `code` from ".self::$table_pre."buy_coupon_list where `shop_id`=".SHOP_ID."";
		$r=$pdo->query($sql,2);
		$exist=array();
		foreach($r as $v){
			$exist[]=$v['code'];
		}
		
		$values='';
		$count=0;
		$i=0;
		while($i<$_GET['sum_quantity']){
			$code=get_random(8);
			if(!in_array($code,$exist)){
				$exist[]=$code;
				$values.="('".$code."',".$coupon_id.",".SHOP_ID."),";
				$i++;	
			}
			$count++;
			if($count>100000){break;}
		}
		
		$values=trim($values,',');
		$sql="insert into ".self::$table_pre."buy_coupon_list (`code`,`coupon_id`,`shop_id`) values ".$values;
		//file_put_contents('t.txt',$sql);
		if($pdo->exec($sql)){
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail> code ".self::$language['fail']."</span>'}");
		}
		
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}


if($act=='del'){
	$id=intval(@$_GET['id']);
	if($id<1){exit();}
	$sql="select `end_time` from ".self::$table_pre."buy_coupon where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	$sql="select `id` from ".self::$table_pre."buy_coupon_list where `coupon_id`=".$id." limit 0,1";
	$r2=$pdo->query($sql,2)->fetch(2);
	if($r['end_time']>time() && $r2['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['not_due']."</span>'}");}
	
	$sql="delete from ".self::$table_pre."buy_coupon where `id`='$id' and `shop_id`=".SHOP_ID;
	if($pdo->exec($sql)){
		$sql="delete from ".self::$table_pre."buy_coupon_list where `shop_id`=".SHOP_ID." and `coupon_id`=".$id;
		if($pdo->exec($sql)){
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail> code ".self::$language['fail']."</span>'}");
		}
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}

}



