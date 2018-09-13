<?php
$sql="select `id`,`actual_money`,`receipt_time` from ".self::$table_pre."order where `state`=6 and `buyer`='".$_SESSION['monxin']['username']."'";
$userorder=$pdo->query($sql,2);
$achievement=0;//自身消费业绩总数
foreach($userorder as $val){
	if((time()-$val['receipt_time'])/86400>=self::$config['refund_time_limit']){$achievement+=$val['actual_money'];}
}
//区分会员卡和购物两种情形计算
//计算直属会员总数
$sum_sql="select count(id) as c  from ".$pdo->index_pre."user where `state`=1 and `pid`='".$_SESSION['monxin']['id']."'";
$once=$pdo->query($sum_sql,2)->fetch(2);
$sum=$once['c'];
//print_r($sum);exit;
//变更会员业绩、级别 （级别：0会员2经理5总监）
if($sum>=30 && $achievement>=10000){
	$grade=2;
} else if($sum>=50 && $achievement>=300000){
	$grade=5;
}
$ngrade=empty($grade)?0:$grade;
$sql="update ".$pdo->index_pre."user set `achievement`=".$achievement.",`grade`=".$ngrade." where `id`=".$_SESSION['monxin']['id'];
$pdo->exec($sql);