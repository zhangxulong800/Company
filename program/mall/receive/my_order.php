<?php
$act=@$_GET['act'];

//==================================================================================================================================【删除评论】
if($act=='del_comment'){
	$comment_id=intval(@$_GET['comment_id']);
	$sql="delete from ".self::$table_pre."comment where `id`=".$comment_id." and `buyer`='".$_SESSION['monxin']['username']."'";
	file_put_contents('t.txt',$sql);
	$r=$pdo->exec($sql);
	exit();
}
		
$id=intval(@$_GET['id']);
if($id==0){exit("{'state':'fail','info':'id err'}");}

//==================================================================================================================================【查看物流】
if($act=='go_express'){
	$sql="select `url` from ".self::$table_pre."express where `id`='".$id."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['url']==''){exit(sef::$language['query_url'].self::$language['is_null']);}
	header("location:".$r['url'].@$_GET['code']);exit;	
}


if($id!=0){
	$sql="select * from ".self::$table_pre."order where `id`='".$id."' and `buyer`='".$_SESSION['monxin']['username']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit("{'state':'fail','info':'id err'}");}	
}
switch ($act){
	case 'del'://================================================================================================================【删除订单】
		if(!in_array($r['state'],self::$config['order_del_able'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['state'].':'.self::$language['order_state'][$r['state']]." ".self::$language['forbidden_del']."</span>'}");}
		$sql="update ".self::$table_pre."order set `buyer_del`='1' where `id`=".$id." and `buyer`='".$_SESSION['monxin']['username']."'";
		if($pdo->exec($sql)){
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
		break;	
		
	case 'cancel'://================================================================================================================【取消订单】
		if($r['state']!=0 && $r['state']!=1 && $r['state']!=11){exit("{'state':'fail','info':'<span class=fail>".self::$language['state'].':'.self::$language['order_state'][$r['state']]." ".self::$language['forbidden_del']."</span>'}");}		
		$sql="update ".self::$table_pre."order set `state`='4',`cancel_reason`='".safe_str(@$_GET['cancel_reason'])."' where `id`=".$id;
		if($pdo->exec($sql)){
			self::return_goods_quantity($pdo,self::$table_pre,$id,$r['inventory_decrease']);
			$sql="select `name`,`username` from ".self::$table_pre."shop where `id`=".$r['shop_id'];
			$r2=$pdo->query($sql,2)->fetch(2);
			$shop_name=$r2['name'];
			
			$title=str_replace('{web_name}',self::$config['web']['name'],self::$language['cancel_order_template_for_seller']);
			$title=str_replace('{username}',$r['buyer'],$title);
			$r['goods_names']=mb_substr($r['goods_names'],0,10,'utf-8').' ...';	
			push_cancel_order_info($pdo,self::$config,self::$language,$r2['username'],$title,$r['out_id'],$r['actual_money'],'mall.order_admin',$r['goods_names']);
			
			self::order_cancel_untread_credits($pdo,$r);
				$msg=self::$language['im_order_state_4'];
				$msg=str_replace('{shopname}',$r2['name'],$msg);
				$msg=str_replace('{reason}',safe_str(@$_GET['cancel_reason']),$msg);
				$msg.='<a href=http://'.self::$config['web']['domain'].'/index.php?monxin=mall.order_admin&search='.$r['out_id'].' target=_blank>http://'.self::$config['web']['domain'].'/index.php?monxin=mall.order_admin&search='.$r['out_id'].'</a>';
				send_im_msg(self::$config,self::$language,$pdo,$r['buyer'],$r2['username'],$msg);

			if($r['state']==1 && ($r['pay_method']=='balance' || $r['pay_method']=='online_payment')){
				$reason=str_replace('{order_id}','<a href=./index.php?monxin=mall.my_order&search='.$r['out_id'].' target=_blank>'.$r['out_id'].'</a>',self::$language['return_order_money_template']);
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
		
	case 'confirm_receipt'://================================================================================================================【确认收货】
		if($r['state']!=2){exit("{'state':'fail','info':'<span class=fail>".self::$language['state'].":err</span>'}");}		
		$sql="update ".self::$table_pre."order set `state`='6',`receipt`=1,`receipt_time`='".time()."' where `id`=".$id;
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
		
	case 'undo_refund'://================================================================================================================【取消退货申请】
		if($r['state']!=7 && $r['state']!=8 ){exit("{'state':'fail','info':'<span class=fail>".self::$language['state'].":err</span>'}");}
		if($r['receipt']==1){
			$order_state=6;
			$sql="update ".self::$table_pre."order set `state`='6' where `id`=".$id;
		}else{
			$order_state=2;
			$sql="update ".self::$table_pre."order set `state`='2' where `id`=".$id;
		}		
		
		if($pdo->exec($sql)){
			$sql="select `name` from ".self::$table_pre."shop where `id`=".$r['shop_id'];
			$r2=$pdo->query($sql,2)->fetch(2);
			$shop_name=$r2['name'];
			
			$title=str_replace('{web_name}',self::$config['web']['name'],self::$language['undo_refund_template']);
			$title=str_replace('{username}',$r['buyer'],$title);
			$sql="select `order_notice_email` from ".self::$table_pre."shop_order_set where `shop_id`='".$r['shop_id']."' limit 0,1";
			$r2=$pdo->query($sql,2)->fetch(2);
			$content=self::$language['view'].' <a href="http://'.self::$config['web']['domain'].'/index.php?monxin=mall.order_admin&id='.$r['id'].'"  target=_blank>http://'.self::$config['web']['domain'].'/index.php?monxin=mall.order_admin&id='.$r['id'].'</a>';
			email(self::$config,self::$language,$pdo,'monxin',$r2['order_notice_email'],$title,$content);	
			self::update_shop_order_sum($pdo,self::$table_pre,$r['shop_id']);	
					
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','order_state':'".self::$language['order_state'][$order_state]."'}");	
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
		break;	
		
		
	case 'apply_refund'://================================================================================================================【提交退货申请】
		if($r['state']!=2 && $r['state']!=6 && $r['state']!=7){exit("{'state':'fail','info':'<span class=fail>".self::$language['state'].':'.self::$language['order_state'][$r['state']]." ".self::$language['inoperable']."</span>'}");}	
		$_POST=safe_str($_POST);
		if(@$_POST['refund_reason']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['order_return']."</span>'}");}	
		if($r['pay_method']!='balance' && $r['pay_method']!='online_payment'){exit("{'state':'fail','info':'<span class=fail>".self::$language['pay_method_str'].':<b>'.self::$language['pay_method'][$r['pay_method']].'</b>,'.self::$language['no_support_refund']."</span>'}");}
		if(floatval(@$_POST['refund_amount'])==0){exit("{'state':'fail','info':'<span class=fail>".self::$language['refund_amount'].' '.self::$language['err']."</span>'}");}	
		$r['actual_money']-=$r['web_credits_money'];
		if(floatval(@$_POST['refund_amount'])>$r['actual_money']){exit("{'state':'fail','info':'<span class=fail>".self::$language['not_more_than'].' <b>'.$r['actual_money']."</b></span>'}");}	
		$voucher='';
		if(@$_POST['voucher']!=''){
			if(is_file('./temp/'.$_POST['voucher'])){
				get_date_dir('./program/mall/img/');	
				if(safe_rename('./temp/'.$_POST['voucher'],'./program/mall/img/'.$_POST['voucher'])){$voucher=$_POST['voucher'];}	
			}
		}
		if($voucher==''){$voucher=$r['refund_voucher'];}
		$sql="update ".self::$table_pre."order set `state`='7',`refund_reason`='".$_POST['refund_reason']."',`refund_amount`='".$_POST['refund_amount']."',`refund_remark`='".@$_POST['refund_remark']."',`refund_voucher`='".$voucher."' where `id`=".$id;
		//file_put_contents('./test.txt',$sql);
		if($pdo->exec($sql)){
			if($r['refund_voucher']!='' && $r['refund_voucher']!=$voucher){safe_unlink('./program/mall/img/'.$r['refund_voucher']);}
			$sql="select `name`,`username` from ".self::$table_pre."shop where `id`=".$r['shop_id'];
			$r2=$pdo->query($sql,2)->fetch(2);
			$shop_name=$r2['name'];
			
			$title=str_replace('{web_name}',self::$config['web']['name'],self::$language['apply_return_order_template_for_seller']);
			$title=str_replace('{username}',$r['buyer'],$title);
			$r['goods_names']=mb_substr($r['goods_names'],0,10,'utf-8').' ...';	
			push_order_apply_refund_info($pdo,self::$config,self::$language,$r2['username'],$title,$r['goods_names'],$r['actual_money'],$r['id'],$_POST['refund_reason']);
				$msg=self::$language['im_order_state_7'];
				$msg=str_replace('{shopname}',$r2['name'],$msg);
				$msg=str_replace('{reason}',$_POST['refund_reason'],$msg);
				$msg.='<a href=http://'.self::$config['web']['domain'].'/index.php?monxin=mall.order_admin&search='.$r['out_id'].' target=_blank>http://'.self::$config['web']['domain'].'/index.php?monxin=mall.order_admin&search='.$r['out_id'].'</a>';
				send_im_msg(self::$config,self::$language,$pdo,$r['buyer'],$r2['username'],$msg);

			
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
		break;	
		
	case 'express_voucher'://================================================================================================================【提交退货凭证】
		if($r['state']!=8 && $r['state']!=9){exit("{'state':'fail','info':'<span class=fail>".self::$language['state'].':'.self::$language['order_state'][$r['state']]." ".self::$language['inoperable']."</span>'}");}	
		$_POST=safe_str($_POST);
		if(@$_POST['voucher']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
		
		if(is_file('./temp/'.$_POST['voucher'])){
			get_date_dir('./program/mall/img/');	
			if(safe_rename('./temp/'.$_POST['voucher'],'./program/mall/img/'.$_POST['voucher'])){$voucher=$_POST['voucher'];}	
		}
		
		if($voucher==''){$voucher=$r['express_voucher'];}
		$sql="update ".self::$table_pre."order set `state`='9',`express_voucher`='".$voucher."' where `id`=".$id;
		//file_put_contents('./test.txt',$sql);
		if($pdo->exec($sql)){
			if($r['express_voucher']!='' && $r['express_voucher']!=$voucher){safe_unlink('./program/mall/img/'.$r['express_voucher']);}
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
		break;	
		
}