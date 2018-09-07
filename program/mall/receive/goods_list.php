<?php
$act=@$_GET['act'];
if($act=='bidding'){
	$_POST=safe_str($_POST);	
	$id=intval(@$_POST['id']);
	if($id==0){exit('id err');}
	$time=time()-86400;	
	$ip=get_ip();
	if(@$_SESSION['monxin']['username']!=''){
		$sql="select `id` from ".self::$table_pre."bidding where `gid`=".$id." and `time`>".$time." and `username`='".$_SESSION['monxin']['username']."' limit 0,1";
	}else{
		$sql="select `id` from ".self::$table_pre."bidding where `gid`=".$id." and `time`>".$time." and `ip`='".$ip."' limit 0,1";
	}
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit('clicked');}
	
	$sql="select `bidding_show`,`title`,`shop_id` from ".self::$table_pre."goods where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['bidding_show']<=0){exit('price err');}
	$money=$r['bidding_show'];
	$shop_id=$r['shop_id'];
	$goods_title=mb_substr($r['title'],0,10,'utf-8');
	$sql="select `username` from ".self::$table_pre."shop where `id`=".$shop_id;
	$r=$pdo->query($sql,2)->fetch(2);
	$seller=$r['username'];
	if(@$_SESSION['monxin']['username']==$seller){exit('self');}
	$sql="select `money` from ".$pdo->index_pre."user where `username`='".$seller."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['money']<$money){
		$sql="update ".self::$table_pre."goods set `bidding_show`=0 where `shop_id`=".$shop_id;
		$pdo->exec($sql);
		exit('no money');	
	}
	
	$reason=str_replace('{goods_name}','<a href=./index.php?monxin=mall.goods&id='.$id.' target=_blank>'.$goods_title.'</a>',self::$language['bidding_show_pay_reason']);
	if(operator_money(self::$config,self::$language,$pdo,$seller,'-'.$money,$reason,'mall')){
		$temp=explode('monxin=',$_POST['src_url']);
		$_POST['src_url']=@$temp[1];
		$sql="insert into ".self::$table_pre."bidding (`gid`,`time`,`src_title`,`src_url`,`username`,`money`,`shop_id`,`ip`) values ('".$id."','".time()."','".$_POST['src_title']."','".$_POST['src_url']."','".@$_SESSION['monxin']['username']."','-".$money."','".$shop_id."','".$ip."')";
		$pdo->exec($sql);
		self::operation_finance(self::$language,$pdo,self::$table_pre,$shop_id,$money,4,$reason);
		self::operation_shop_finance(self::$language,$pdo,self::$table_pre,$shop_id,'-'.$money,4,$reason);
		exit('done');
	}
	
}
