<?php

$act=@$_GET['act'];
$id=intval(@$_GET['id']);
if($act!='del_select' && $act!='yun_print' && $id==0){exit("{'state':'fail','info':'id err'}");}

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
	case 'yun_print'://=============================================================================================================【云打印】
		$ids=explode('|',$_GET['ids']);
		foreach($ids as $id){
			if(is_numeric($id)){self::submit_cloud_print($pdo,$id);}
		}
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
		break;	
		
	case 'del'://================================================================================================================【删除单个订单】
		if(!in_array($r['state'],self::$config['order_del_able_seller'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['state'].':'.self::$language['order_state'][$r['state']]." ".self::$language['inoperable']."</span>'}");}
		$sql="update ".self::$table_pre."order set `seller_del`='1' where `id`=".$id." and `shop_id`='".SHOP_ID."'";
		if($pdo->exec($sql)){
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
		break;	
		
	case 'del_select'://================================================================================================================【删除选中订单】
		$ids=@$_GET['ids'];
		if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
		$ids=explode("|",$ids);
		$ids=array_filter($ids);
		$success='';
		foreach($ids as $id){
			$id=intval($id);
			$sql="select `state` from ".self::$table_pre."order where `id`='$id'";
			$r=$pdo->query($sql,2)->fetch(2);
			if(in_array($r['state'],self::$config['order_del_able_seller'])){
				$sql="update ".self::$table_pre."order set `seller_del`='1' where `id`=".$id." and `shop_id`='".SHOP_ID."'";
				if($pdo->exec($sql)){
					$success.=$id."|";
				}
			}
		}
		$success=trim($success,"|");			
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
		break;	
		
	case 'cash_on_delivery'://================================================================================================================【设为货到付款】
		if($r['state']!=0){exit("{'state':'fail','info':'<span class=fail>".self::$language['state'].':'.self::$language['order_state'][$r['state']]." ".self::$language['inoperable']."</span>'}");}
		$sql="update ".self::$table_pre."order set `state`='1',`pay_method`='".$act."' where `id`=".$id;
		if($pdo->exec($sql)){
			$r['state']=2;
			self::decrease_goods_quantity($pdo,self::$table_pre,$r);
				if(self::$config['agency']){
					require('./program/agency/agency.class.php');
					$agency=new agency($pdo);
					$agency->order_complete_pay($pdo,$r['id']);
				}
				if(self::$config['distribution']){
					require('./program/distribution/distribution.class.php');
					$distribution=new distribution($pdo);
					$distribution->order_complete_pay($pdo,$r['id']);
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
		
	case 'agree_return'://================================================================================================================【同意退货】
		if($r['state']!=7){exit("{'state':'fail','info':'<span class=fail>".self::$language['state'].':'.self::$language['order_state'][$r['state']]." ".self::$language['inoperable']."</span>'}");}
		
		$sql="update ".self::$table_pre."order set `state`='8' where `id`=".$id;
		if($pdo->exec($sql)){
			$sql="select `name`,`username` from ".self::$table_pre."shop where `id`=".$r['shop_id'];
			$r2=$pdo->query($sql,2)->fetch(2);
			$shop_name=$r2['name'];
			$shop_username=$r2['username'];
			
			$title=str_replace('{web_name}',self::$config['web']['name'],self::$language['return_order_template']);
			$title=str_replace('{shop_name}',$shop_name,$title);
			$sql="select `email` from ".$pdo->index_pre."user where `username`='".$r['buyer']."' limit 0,1";
			$r2=$pdo->query($sql,2)->fetch(2);
			$content=self::$language['view'].' <a href="http://'.self::$config['web']['domain'].'/index.php?monxin=mall.my_order&id='.$r['id'].'"  target=_blank>http://'.self::$config['web']['domain'].'/index.php?monxin=mall.my_order&id='.$r['id'].'</a>';
			email(self::$config,self::$language,$pdo,'monxin',$r2['email'],$title,$content);
	
		
				$msg=self::$language['im_order_state_8'];
				$msg=str_replace('{shopname}',$shop_name,$msg);
				$msg.='<a href=http://'.self::$config['web']['domain'].'/index.php?monxin=mall.my_order&search='.$r['out_id'].' target=_blank>http://'.self::$config['web']['domain'].'/index.php?monxin=mall.my_order&search='.$r['out_id'].'</a>';
				send_im_msg(self::$config,self::$language,$pdo,$shop_username,$r['buyer'],$msg);
			
				
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
		break;	
		
		
		
	case 'confirm_refund'://================================================================================================================【确认退款】
		if($r['state']!=9){exit("{'state':'fail','info':'<span class=fail>".self::$language['state'].':'.self::$language['order_state'][$r['state']]." ".self::$language['inoperable']."</span>'}");}
		$sql="select `name`,`username` from ".self::$table_pre."shop where `id`=".$r['shop_id'];
		$r2=$pdo->query($sql,2)->fetch(2);
		
		if($r['receipt']==1 || $r['cashier']!='monxin'){
			self::introducer_return_fees($pdo,$r);	
		}
		
		//店家已收到款，扣除款项 
		$seller_Received=false;
		if($r['receipt']==1  && ($r['pay_method']=='balance' || $r['pay_method']=='online_payment') ){
			$seller_Received=true;
		}
		if($r['cashier']!='monxin'){
			if($r['pay_method']=='balance' ){
				$seller_Received=true;
			}
		}
		if($seller_Received){
			$sql="select `money` from ".$pdo->index_pre."user where `username`='".$r2['username']."' and `state`=1 limit 0,1";
			$r3=$pdo->query($sql,2)->fetch(2);
			if($r3['money']<$r['refund_amount']){exit("{'state':'fail','info':'<span class=fail>".self::$language['insufficient_balance'].":".$r['refund_amount']."<br />".self::$language['inoperable'].", <a href=./index.php?monxin=index.recharge target=_blank>".self::$language['recharge']."</a></span>'}");}
			if($r['actual_money']==$r['refund_amount']){$reason=self::$language['refund_money_template_all'];}else{$reason=self::$language['refund_money_template_part'];}
			$reason=str_replace('{order_id}','<a href=./index.php?monxin=mall.order_admin&search='.$r['out_id'].' target=_blank>'.$r['out_id'].'</a>',$reason);
			$reason=str_replace('{sum_money}',$r['refund_amount'],$reason);
			if(!operator_money(self::$config,self::$language,$pdo,$r2['username'],'-'.$r['refund_amount'],$reason,'mall')){
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." operator_money seller</span>'}");
			}
			self::return_agent_fees($pdo,$r2['username'],$r);
		}
		
		//店家没收到款，给店家补回未退部分款项 
		if($r['receipt']==0 && $r['cashier']!='monxin'  && ($r['pay_method']=='balance' || $r['pay_method']=='online_payment') && $r['actual_money']-$r['web_credits_money']>$r['refund_amount']){
			
			$reason=str_replace('{order_id}','<a href=./index.php?monxin=mall.order_admin&search='.$r['out_id'].' target=_blank>'.$r['out_id'].'</a>',self::$language['add_order_money_template']);
			$reason=str_replace('{sum_money}',$r['actual_money']-$r['refund_amount'],$reason);
			if(!operator_money(self::$config,self::$language,$pdo,$r2['username'],$r['actual_money']-$r['refund_amount'],$reason,'mall')){
				exit("{'state':'success','info':'<span class=success>".self::$language['fail']."  add_money seller</span>'}");
			}
		}

		//退款给买家
		if($r['pay_method']=='balance' || $r['pay_method']=='online_payment' ){
			if($r['actual_money']==$r['refund_amount']){$reason=self::$language['refund_money_template_all'];}else{$reason=self::$language['refund_money_template_part'];}
			$reason=str_replace('{order_id}','<a href=./index.php?monxin=mall.my_order&search='.$r['out_id'].' target=_blank>'.$r['out_id'].'</a>',$reason);
			if($r['refund_amount']!=$r['actual_money']-$r['web_credits_money']){
				$r['refund_amount']-=$r['web_credits_money'];
			}
			
			$reason=str_replace('{sum_money}',$r['refund_amount'],$reason);
			if(!operator_money(self::$config,self::$language,$pdo,$r['buyer'],$r['refund_amount'],$reason,'mall')){
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." operator_money buyer</span>'}");
			}
		}
		
		self::order_cancel_untread_credits($pdo,$r);
		$sql="update ".self::$table_pre."order set `state`='10',`actual_money`='".($r['actual_money']-$r['refund_amount'])."',`change_price_reason`='".$r['change_price_reason']." ".self::$language['refund']."' where `id`=".$id;
		if($pdo->exec($sql)){
			self::untread_credits($pdo,$r);
			self::return_goods_quantity($pdo,self::$table_pre,$id,$r['inventory_decrease']);
			if($r['pay_method']=='balance' || $r['pay_method']=='online_payment' ){
				$shop_name=$r2['name'];
				$title=str_replace('{web_name}',self::$config['web']['name'],self::$language['return_order_success_template']);
				$title=str_replace('{shop_name}',$shop_name,$title);
				$r['goods_names']=mb_substr($r['goods_names'],0,10,'utf-8').' ...';	
				push_order_agree_refund_info($pdo,self::$config,self::$language,$r['buyer'],$title,$r['goods_names'],$r['refund_amount'],$r['id']);	
			}
			self::update_shop_order_sum($pdo,self::$table_pre,SHOP_ID);
			if(self::$config['agency']){
				require('./program/agency/agency.class.php');
				$agency=new agency($pdo);
				$agency->order_refund($pdo,$r['id']);
			}
			if(self::$config['distribution']){
				require('./program/distribution/distribution.class.php');
				$distribution=new distribution($pdo);
				$distribution->order_refund($pdo,$r['id']);
			}
			
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
		break;	
				
		
}