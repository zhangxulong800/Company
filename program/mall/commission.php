<?php
$sql="select `id`,`actual_money`,`receipt_time`,`goods_cost`,`is_add` from ".self::$table_pre."order where `state`=6 and `is_add`=0 and `buyer`='".$_SESSION['monxin']['username']."'";
$userorder=$pdo->query($sql,2);
$achievement=0;//本次自身消费业绩总数 ；系统一笔订单几款要退货都退;商品、会员卡类合在一起
foreach($userorder as $val){
	if((time()-$val['receipt_time'])/86400>=self::$config['refund_time_limit']){
		$achievement+=$val['actual_money'];
	}
}
if($achievement>0){
	//获取会员对应的信息
	$sql="select `id`,`achievement`,`path_pid` from ".$pdo->index_pre."user where `id`='".$_SESSION['monxin']['id']."'";
	$nowuser=$pdo->query($sql,2)->fetch(2);
	$achievement+=$nowuser['achievement'];
	//计算直属会员总数
	$sum_sql="select count(id) as c  from ".$pdo->index_pre."user where `state`=1 and `pid`='".$_SESSION['monxin']['id']."'";
	$once=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$once['c'];
	//变更会员业绩、级别 （级别：0会员2经理5总监）
	if($sum>=30 && $achievement>=10000){
		$grade=2;
	} else if($sum>=50 && $achievement>=300000){
		$grade=5;
	}
	$ngrade=empty($grade)?0:$grade;
	$sql="update ".$pdo->index_pre."user set `achievement`=".$achievement.",`grade`=".$ngrade." where `id`=".$_SESSION['monxin']['id'];
	$pdo->exec($sql);
	//计算提成
	$pid_arr=empty($nowuser['path_pid'])?array():explode('#',$nowuser['path_pid']);
	$tot_money=0;
	foreach($userorder as $val){
		if((time()-$val['receipt_time'])/86400>=self::$config['refund_time_limit']){
			$sql="update ".self::$table_pre."order set `is_add`=1 where `id`=".$val['id'];
			$pdo->exec($sql);
			//依据上级等级计算分成并将明细存入数据库，然后变更总数
		}
	}
	print_r($pid_arr);exit;
}