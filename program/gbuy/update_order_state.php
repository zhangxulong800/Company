<?php 
function gbuy_update_order_state($config,$language,$pdo,$for_id,$in_id){
	$program='gbuy';
	$sql="select * from ".$pdo->sys_pre."index_recharge where `in_id`=".$in_id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['for_id']!=$for_id || $r['state']!=4){return false;}
	$ids=explode(',',$r['for_id']);
	
	$sql="select * from ".$pdo->sys_pre."gbuy_order where id=".$for_id;
	$r=$pdo->query($sql,2);
	$success_sum=0;
	require('../../program/gbuy/gbuy.class.php');
	$gbuy_c=new gbuy($pdo);
	foreach($r as $v){
		if($v['state']!=0){continue;}
		$id=$v['id'];
		$deduction=false;
			$sql="select `state`,`money` from ".$pdo->index_pre."recharge where `username`='".$v['username']."' and `for_id`='".$for_id."' order by `state` desc ,`id` desc  limit 0,1";
			$r2=$pdo->query($sql,2)->fetch(2);
			
			
			$reason=str_replace('{order_id}','<a href=./index.php?monxin=gbuy.my_buy&search='.$v['out_id'].' target=_blank>'.$v['out_id'].'</a>',$language['deduction_order_money_template']);
			$reason=str_replace('{sum_money}',$v['price'],$reason);

			
			$deduction=operator_money($config,$language,$pdo,$v['username'],'-'.$v['price'],$reason,'gbuy');
			if(!$deduction){echo $_POST['operator_money_err_info'];}
			
			
		
		if($deduction===true){//如扣款成功，更新订单状态
			$v['state']=1;
			$sql="update ".$pdo->sys_pre."gbuy_order set `state`='".$v['state']."' where `id`=".$id;
			if($pdo->exec($sql)){
				$gbuy_c->update_order_group($pdo,$id,$config,$language);
				$success_sum++;
			}
		}		
	}
}
