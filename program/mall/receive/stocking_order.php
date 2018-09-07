<?php

$act=@$_GET['act'];
$id=intval(@$_GET['id']);
if($act!='del_select' && $id==0){exit("{'state':'fail','info':'id err'}");}

//==================================================================================================================================【查看物流】
if($act=='go_express'){
	$sql="select `url` from ".self::$table_pre."express where `id`='".$id."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['url']==''){exit(sef::$language['query_url'].self::$language['is_null']);}
	header("location:".$r['url'].@$_GET['code']);	
}


if($id!=0){
	$sql="select * from ".self::$table_pre."order where `id`='".$id."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit("{'state':'fail','info':'id err'}");}	
	if($r['shop_id']!=SHOP_ID){exit("{'state':'fail','info':'id err'}");}	
}
switch ($act){
		
	case 'set_success'://================================================================================================================【设为交易成功】
		if($r['state']!=1){exit("{'state':'fail','info':'<span class=fail>".self::$language['state'].':'.self::$language['order_state'][$r['state']]." ".self::$language['inoperable']."</span>'}");}
		$sql="update ".self::$table_pre."order set `state`='6' where `id`=".$id;
		if($pdo->exec($sql)){
			$r['state']=6;
			$order=$r;	
			$sql="select `username` from ".self::$table_pre."shop where `id`=".$order['shop_id'];
			$s=$pdo->query($sql,2)->fetch(2);
			$seller=$s['username'];
			$pay_method=$r['pay_method'];
			
			
			
				self::checkout_decrease_goods_quantity($pdo,self::$table_pre,$order);
				self::update_goods_monthly($pdo,self::$table_pre,$order);
				self::update_shop_order_sum($pdo,self::$table_pre,SHOP_ID);
				//self::give_credits($pdo,$order);
				$reason=str_replace('{order_id}','<a href=./index.php?monxin=mall.order_admin&search='.$order['out_id'].' target=_blank>'.$order['out_id'].'</a>',self::$language['add_order_money_template']);
				$reason=str_replace('{sum_money}',$order['actual_money'],$reason);
				self::operation_shop_finance(self::$language,$pdo,self::$table_pre,$order['shop_id'],$order['actual_money'],9,$reason);
				self::record_order_cost($pdo,$seller,$order);
				self::give_credits($pdo,$order);
				if($order['pay_method']=='balance'){self::exe_online_pay_fees($pdo,$seller,$order);self::update_card_state($pdo,$order['buyer']);}
				self::exe_introducer_fees($pdo,$order);
				self::set_order_goods_barcode($pdo,$order['id']);
					if(self::$config['distribution'] && $order['buyer']!=''){
						if(!isset($distribution)){
							require('./program/distribution/distribution.class.php');
							$distribution=new distribution($pdo);		
						}
						$distribution->order_complete_pay($pdo,$order['id']);
						$distribution->order_complete_confirm_receipt($pdo,$order['id']);
					}
				
			
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
		break;	
		
	case 'cancel'://================================================================================================================【取肖订单】
		if(!(($r['state']==0 || $r['state']==1 || $r['state']==2 || $r['state']==12 || $r['state']==13 || $r['state']==14) )){exit("{'state':'fail','info':'<span class=fail>".self::$language['state'].':'.self::$language['order_state'][$r['state']]." ".self::$language['inoperable']."</span>'}");}
		$sql="select `name`,`username` from ".self::$table_pre."shop where `id`=".$r['shop_id'];
		$r2=$pdo->query($sql,2)->fetch(2);
		$shop_name=$r2['name'];
		if($r['pre_sale']){			
			$sql="select * from ".self::$table_pre."order_pre_sale where `order_id`=".$r['id']." limit 0,1";
			$pre=$pdo->query($sql,2)->fetch(2);
			if($r['state']==12 || $r['state']==13){
				$r['actual_money']=$pre['deposit'];
			}
		}
		
		$title=str_replace('{web_name}',self::$config['web']['name'],self::$language['cancel_order_template']);
		$title=str_replace('{shop_name}',$shop_name,$title);	
		$r['goods_names']=mb_substr($r['goods_names'],0,10,'utf-8').' ...';	
		push_cancel_order_info($pdo,self::$config,self::$language,$r['buyer'],$title,$r['out_id'],$r['actual_money'],'mall.my_order',$r['goods_names']);
		
		$sql="update ".self::$table_pre."order set `state`='5',`cancel_reason`='".safe_str(@$_GET['cancel_reason'])."' where `id`=".$id;
		if($pdo->exec($sql)){
			self::return_goods_quantity($pdo,self::$table_pre,$id,$r['inventory_decrease']);
			self::order_cancel_untread_credits($pdo,$r);
			
				$msg=self::$language['im_order_state_5'];
				$msg=str_replace('{shopname}',$r2['name'],$msg);
				$msg=str_replace('{reason}',safe_str(@$_GET['cancel_reason']),$msg);
				$msg.='<a href=http://'.self::$config['web']['domain'].'/index.php?monxin=mall.my_order&search='.$r['out_id'].' target=_blank>http://'.self::$config['web']['domain'].'/index.php?monxin=mall.my_order&search='.$r['out_id'].'</a>';
				send_im_msg(self::$config,self::$language,$pdo,$r2['username'],$r['buyer'],$msg);

				if(self::$config['distribution']){
					if(!isset($distribution)){
						require('./program/distribution/distribution.class.php');
						$distribution=new distribution($pdo);		
					}
					$distribution->order_cancel($pdo,$id);
				}
			
			if(($r['state']==1 || $r['state']==2 || $r['state']==12 || $r['state']==13 || $r['state']==14) && ($r['pay_method']=='balance' || $r['pay_method']=='online_payment')  && $r['buyer']!=''){
				$reason=str_replace('{order_id}','<a href=./index.php?monxin=mall.my_order&search='.$r['out_id'].' target=_blank>'.$r['out_id'].'</a>',self::$language['return_order_money_template']);
				
				
				if($r['pre_sale'] && ($r['state']==14 || $r['state']==1 || $r['state']==2)){
					//$r['actual_money']=$r['goods_money']+$r['express_cost_buyer'];
				}
				$r['actual_money']-=$r['web_credits_money'];
				$reason=str_replace('{sum_money}',$r['actual_money'],$reason);
				if(operator_money(self::$config,self::$language,$pdo,$r['buyer'],$r['actual_money'],$reason,'mall')){
					exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");	
				}else{
					$sql="update ".self::$table_pre."order set `state`='1' where `id`=".$id;
					$pdo->exec($sql);
					exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
				}	
			}			
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
		break;	
		
				
		
}