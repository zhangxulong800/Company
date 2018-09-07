<?php 
function mall_update_order_state($config,$language,$pdo,$for_id,$in_id){
	return false;
	$program='mall';
	$sql="select * from ".$pdo->sys_pre."index_recharge where `in_id`=".$in_id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['for_id']!=$for_id || $r['state']!=4){return false;}
	$ids=explode(',',$r['for_id']);
	
	$sql="select * from ".$pdo->sys_pre."mall_order where id=".$for_id;
	if(count($ids)>1){
		$sql="select * from ".$pdo->sys_pre."mall_order where `id` in (".implode(',',$ids).")";
	}
	$r=$pdo->query($sql,2);
	$success_sum=0;
	$automatic_delivery=0;

	require('../../program/mall/receive.class.php');
	$p_config=require('../../program/mall/config.php');
	$p_language=require '../../program/mall/language/'.$p_config['program']['language'].'.php';
	$config=array_merge($config,$p_config);
	$language=array_merge($language,$p_language);	
	
	$receive=new receive($pdo);
	
	
	foreach($r as $v){
		if($v['state']!=0 && $v['state']!=11 && $v['state']!=13){continue;}
		
		$v['actual_money']-=$v['web_credits_money'];
		$v['actual_money']-=$v['shop_credits_money'];
		$v['actual_money']=sprintf("%.2f",$v['actual_money']);
		$id=$v['id'];
		$deduction=false;
		if($v['buyer']!=''){//------------------------------------------------登录用户
			$sql="select `state`,`money` from ".$pdo->index_pre."recharge where `username`='".$v['buyer']."' and `for_id`='".$for_id."' order by `state` desc ,`id` desc  limit 0,1";
			$r2=$pdo->query($sql,2)->fetch(2);
			
			
			$reason=str_replace('{order_id}','<a href=./index.php?monxin=mall.my_order&search='.$v['out_id'].' target=_blank>'.$v['out_id'].'</a>',$language['deduction_order_money_template']);
			$reason=str_replace('{sum_money}',$v['actual_money'],$reason);

			if($v['state']==11 || $v['state']==13){
				$reason=$v['out_id'].$language['order_postfix'];
				$sql="select * from ".$pdo->index_pre."mall_order_pre_sale where `order_id`=".$v['id']." limit 0,1";
				$pre=$pdo->query($sql,2)->fetch(2);
				if($v['state']==11){
					$v['actual_money']=$pre['deposit'];
					$reason.=$language['order_step_1'];
				}
				if($v['state']==13){
					$v['actual_money']-=$pre['deposit'];
					$reason.=$language['order_step_2'];
				}
			}
			
			$deduction=operator_money($config,$language,$pdo,$v['buyer'],'-'.$v['actual_money'],$reason,'mall');
			if(!$deduction){echo $_POST['operator_money_err_info'];}
			
			
		}else{//-------------------------------------------------------------------------------------游客用户
			$start_time=time()-84600;
			$sql="select `state`,`money` from ".$pdo->index_pre."recharge where `for_id`='".$for_id."' and `time`>".$start_time." order by `state` desc ,`id` desc  limit 0,1";
			//echo $sql;
			$r2=$pdo->query($sql,2)->fetch(2);
			if($r2['state']==4 && $r2['money']>=$v['actual_money']){
				$deduction=true;
			}else{
				$deduction=false;
			}	
		}
		if($deduction===true){//如扣款成功，更新订单状态
			if($v['state']==0){$v['state']=1;}
			if($v['state']==11){$v['state']=12;}
			if($v['state']==13){$v['state']=14;}
			
			$sql="update ".$pdo->sys_pre."mall_order set `state`='".$v['state']."',`pay_method`='online_payment' where `id`=".$id;
			file_put_contents('ua.txt',$sql);
			$pdo->exec($sql);
			if(1==1){
				
				$sql="update ".$pdo->sys_pre."mall_order_goods set `order_state`='".$v['state']."' where `order_id`=".$id;
				$pdo->exec($sql);
				//$receive->add_shop_buyer($pdo,$v['buyer'],$v['shop_id']);
				$v['pay_method']='online_payment';
				file_put_contents('ua.txt',87);
				$receive->decrease_goods_quantity($pdo,$pdo->sys_pre."mall_",$v);
				$receive->order_notice($language,$config,$pdo,$pdo->sys_pre."mall_",$v);
				file_put_contents('ua.txt',89);
				
				if($receive->virtual_auto_delivery($config,$language,$pdo,$pdo->sys_pre."mall_",$v)){
					$sql="update ".$pdo->sys_pre."mall_order set `state`='2' where `id`=".$id;
					file_put_contents('ua.txt',$sql);
					$pdo->exec($sql);
					$sql="update ".$pdo->sys_pre."mall_order_goods set `order_state`='2' where `order_id`=".$id;
					$pdo->exec($sql);
					$v['state']=2;
					$receive->decrease_goods_quantity($pdo,$pdo->sys_pre."mall_",$v);
					$automatic_delivery++;
				}
				
				if($config['agency']){
					if(!isset($agency) && is_file('../../program/agency/agency.class.php')){
						require('../../program/agency/agency.class.php');
						$agency=new agency($pdo);		
					}
					if(isset($agency)){$agency->order_complete_pay($pdo,$id);}
					
				}
				if($config['distribution'] && is_file('../../program/distribution/distribution.class.php')){
					if(!isset($distribution)){
						require('../../program/distribution/distribution.class.php');
						$distribution=new distribution($pdo);		
					}
					if(isset($distribution)){$distribution->order_complete_pay($pdo,$id);}
					
				}
				
				
				
				$success_sum++;
			}
		}		
	}
}
