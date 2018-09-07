<?php

$act=@$_GET['act'];
$id=intval(@$_GET['id']);
if($act!='del_select' && $id==0){exit("{'state':'fail','info':'id err'}");}

if($id!=0){
	$sql="select * from ".self::$table_pre."order where `id`='".$id."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit("{'state':'fail','info':'id err'}");}	
	if($r['shop_id']!=SHOP_ID){exit("{'state':'fail','info':'id err'}");}	
}
switch ($act){
		
	case 'exe_check'://===========================================================================================================【核销】		
		if($r['check_code']!=$_GET['check_code']){exit("{'state':'fail','info':'<span class=fail>".self::$language['check_code_2'].self::$language['err']."</span>'}");}
		if($r['state']!=1 && $r['state']!=2 ){exit("{'state':'fail','info':'<span class=fail>".self::$language['state'].":err</span>'}");}		
		$sql="update ".self::$table_pre."order set `state`='6',`receipt`=1,`receipt_time`='".time()."',`check_code_state`=2 where `id`=".$id;
		if($pdo->exec($sql)){
			$r['state']=6;
			$sql="update ".self::$table_pre."order_goods set `order_state`='".$r['state']."' where `order_id`=".$id;
			$pdo->exec($sql);
			self::exe_introducer_fees($pdo,$r);
			self::update_shop_order_sum($pdo,self::$table_pre,$r['shop_id']);
			if($r['pay_method']=='balance' || $r['pay_method']=='online_payment'){
				$sql="select `username` from ".self::$table_pre."shop where `id`=".$r['shop_id'];
				$r2=$pdo->query($sql,2)->fetch(2);
				$seller=$r2['username'];
				$reason=str_replace('{order_id}','<a href=./index.php?monxin=mall.order_admin&search='.$r['out_id'].' target=_blank>'.$r['out_id'].'</a>',self::$language['add_order_money_template']);
				$reason=str_replace('{sum_money}',$r['actual_money'],$reason);
				if(operator_money(self::$config,self::$language,$pdo,$seller,$r['actual_money'],$reason,'mall')){
					self::operation_shop_finance(self::$language,$pdo,self::$table_pre,$r['shop_id'],$r['actual_money'],9,$reason);
					self::exe_online_pay_fees($pdo,$seller,$r);
					self::exe_pay_order_fees($pdo,$seller,$r);
					self::exe_pay_manage_fees($pdo,$seller,$r);
					self::exe_pay_ad_fees($pdo,$seller,$r);
					self::record_order_cost($pdo,$seller,$r);
					self::exe_pay_agent_fees($pdo,$seller,$r);
					self::decrease_goods_quantity($pdo,self::$table_pre,$r);
					self::update_shop_buyer($pdo,self::$table_pre,$r);
					self::exe_pay_recommendation_fees($pdo,$seller,$r);
					self::give_credits($pdo,$r);
					if(self::$config['agency']){
						require('./program/agency/agency.class.php');
						$agency=new agency($pdo);		
						$agency->order_complete_confirm_receipt($pdo,$id);
					}
					if(self::$config['distribution']){
						require('./program/distribution/distribution.class.php');
						$distribution=new distribution($pdo);		
						$distribution->order_complete_confirm_receipt($pdo,$id);
					}
					
					exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");	
				}else{
					$sql="update ".self::$table_pre."order set `state`='".$r['state']."',`receipt`=0,`receipt_time`='0' where `id`=".$id;
					$pdo->exec($sql);
					exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
				}
					
			}
			
			if($r['pay_method']=='credits'){
				$sql="select `username` from ".self::$table_pre."shop where `id`=".$r['shop_id'];
				$r2=$pdo->query($sql,2)->fetch(2);
				$seller=$r2['username'];
				
				$reason=str_replace('{order_id}','<a href=./index.php?monxin=mall.order_admin&search='.$r['out_id'].' target=_blank>'.$r['out_id'].'</a>',self::$language['add_order_money_template']);
				$credits=$r['actual_money']/self::$config['credits_set']['rate'];
				
				$reason=str_replace('{sum_money}','',$reason);
				$reason=str_replace(self::$language['yuan_2'],'',$reason);
				if(operation_credits($pdo,self::$config,self::$language,$seller,$credits,$reason,'goods_sold')){					
					self::operation_shop_finance(self::$language,$pdo,self::$table_pre,$r['shop_id'],$r['actual_money'],9,$reason);
					self::exe_online_pay_fees($pdo,$seller,$r);
					self::exe_pay_order_fees($pdo,$seller,$r);
					self::exe_pay_manage_fees($pdo,$seller,$r);
					self::exe_pay_ad_fees($pdo,$seller,$r);
					self::record_order_cost($pdo,$seller,$r);
					self::exe_pay_agent_fees($pdo,$seller,$r);
					self::decrease_goods_quantity($pdo,self::$table_pre,$r);
					self::update_shop_buyer($pdo,self::$table_pre,$r);
					self::exe_pay_recommendation_fees($pdo,$seller,$r);
					self::give_credits($pdo,$r);
					if(self::$config['agency']){
						require('./program/agency/agency.class.php');
						$agency=new agency($pdo);		
						$agency->order_complete_confirm_receipt($pdo,$id);
					}
					if(self::$config['distribution']){
						require('./program/distribution/distribution.class.php');
						$distribution=new distribution($pdo);		
						$distribution->order_complete_confirm_receipt($pdo,$id);
					}
					
					exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");	
				}else{
					$sql="update ".self::$table_pre."order set `state`='".$r['state']."',`receipt`=0,`receipt_time`='0' where `id`=".$id;
					$pdo->exec($sql);
					exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
				}
					
			}
			
			
			if($r['pay_method']=='cash_on_delivery'){
				$sql="select `username` from ".self::$table_pre."shop where `id`=".$r['shop_id'];
				$r2=$pdo->query($sql,2)->fetch(2);
				$seller=$r2['username'];
				
				$reason=str_replace('{order_id}','<a href=./index.php?monxin=mall.order_admin&search='.$r['out_id'].' target=_blank>'.$r['out_id'].'</a>',self::$language['add_order_money_template']);
				$reason=str_replace('{sum_money}',$r['actual_money'],$reason);
				self::operation_shop_finance(self::$language,$pdo,self::$table_pre,$r['shop_id'],$r['actual_money'],9,$reason);
				self::exe_pay_order_fees($pdo,$seller,$r);
				self::exe_pay_manage_fees($pdo,$seller,$r);
				self::exe_pay_ad_fees($pdo,$seller,$r);
				self::record_order_cost($pdo,$seller,$r);
				self::exe_pay_agent_fees($pdo,$seller,$r);
				self::decrease_goods_quantity($pdo,self::$table_pre,$r);
				self::update_shop_buyer($pdo,self::$table_pre,$r);
				self::exe_pay_recommendation_fees($pdo,$seller,$r);
				self::give_credits($pdo,$r);
				if(self::$config['agency']){
					require('./program/agency/agency.class.php');
					$agency=new agency($pdo);		
					$agency->order_complete_confirm_receipt($pdo,$id);
				}
				if(self::$config['distribution']){
					require('./program/distribution/distribution.class.php');
					$distribution=new distribution($pdo);		
					$distribution->order_complete_confirm_receipt($pdo,$id);
				}
				
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");	
			}
			
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");	
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}

		break;	
		
		
}