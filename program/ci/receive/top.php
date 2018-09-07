<?php
$act=@$_GET['act'];
if($act=='submit'){
	$id=intval(@$_GET['id']);
	if($id==0){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
	$top_price=floatval($_GET['top_price']);
	$top_start=safe_str($_GET['top_start']);
	$day=intval($_GET['day']);
	if($top_price<self::$config['top_min_price']){$top_price=self::$config['top_min_price'];}
	if($day!=1 && $day!=3 && $day!=7 && $day!=15 && $day!=30){exit("{'state':'fail','info':'<span class=fail>".self::$language['please_select'].self::$language['promotion_duration']."</span>'}");}
	$top_start=get_unixtime($top_start,self::$config['other']['date_style'].' H:i');
	if($top_start<time()-300){exit("{'state':'fail','info':'<span class=fail>".self::$language['start_time_cannot_be_less_than_the_current_time']."</span>'}");}
	if($top_start>time()+864000){exit("{'state':'fail','info':'<span class=fail>".self::$language['start_time_is_not_greater_tha_the_current_10_days']."</span>'}");}
	
	$top_end=$top_start+(86400*$day);
	
	$costs=$top_price*$day;
	$sql="select `money` from ".$pdo->index_pre."user where `username`='".$_SESSION['monxin']['username']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['money']<$costs){exit("{'state':'fail','info':'<span class=fail>".self::$language['insufficient_balance']."</span>'}");}
	$balance=$r['money']-$costs;
	$time=time()-1;
	$sql="update ".self::$table_pre."content set `top_price_spare`='".$top_price."',`top_start`='".$top_start."',`top_end`='".$top_end."',`sum_cost`=`sum_cost`+".$costs." where `id`=".$id." and `username`='".$_SESSION['monxin']['username']."'";	
	//file_put_contents('./test.txt',$sql);
	if($pdo->exec($sql)){
		$sql="select `title` from ".self::$table_pre."content where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$reason=self::$language['day_offer'].$top_price.self::$language['yuan'].','.self::$language['promotion_duration'].$day.self::$language['day'].','.self::$language['title'].':'.$r['title'];
		if(operator_money(self::$config,self::$language,$pdo,$_SESSION['monxin']['username'],'-'.$costs,$reason,'ci')){
			
		}else{
			$sql="update ".self::$table_pre."content set `top_price_spare`='0',`top_start`='0',`top_end`='0',`sum_cost`=`sum_cost`-".$costs." where `id`=".$id." and `username`='".$_SESSION['monxin']['username']."'";	
			$pdo->exec($sql);
		}
		
		$html=get_time('m-d H:i',self::$config['other']['timeoffset'],self::$language,$time);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','html':'".$html."','balance':'".$balance."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}