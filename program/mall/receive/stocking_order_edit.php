<?php
$id=intval(@$_GET['id']);
if($id==0){exit("{'state':'fail','info':'id err'}");}
//$id=8;
$act=@$_GET['act'];


//==================================================================================================================================【没付款前 修改订单中的商品数量】
if($act=='edit_quantity'){
	$sql="select * from ".self::$table_pre."order_goods where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']=='' || $r['shop_id']!=SHOP_ID){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
	
	$sql="select `state`,`pay_method`,`goods_cost` from ".self::$table_pre."order where `id`=".$r['order_id'];
	$order=$pdo->query($sql,2)->fetch(2);
	$power=false;
	if($order['state']==0 || ($order['state']==1 && $order['pay_method']=='cash_on_delivery')){$power=true;}
	if($power==false){exit("{'state':'fail','info':'<span class=fail>state err</span>'}");}	
	$old_cost=$order['goods_cost'];	
	$sql="select `unit`,`cost_price`,`option_enable` from ".self::$table_pre."goods where `id`=".$r['goods_id'];
	$r2=$pdo->query($sql,2)->fetch(2);
	$cost_price=$r2['cost_price'];
	if($r2['option_enable']){
		$sql="select `cost_price` from ".self::$table_pre."goods_specifications where `id`=".$r['s_id'];
		$r3=$pdo->query($sql,2)->fetch(2);	
		$cost_price=$r3['cost_price'];
	}
	
	self::get_mall_unit_name($pdo,$r2['unit']);
	if($_POST['temp_unit_gram']!=0){
		$quantity=floatval(@$_GET['v']);
	}else{
		$quantity=intval(@$_GET['v']);
	}
	$change_quantity=$quantity-$r['quantity'];
	$change_price=$quantity*$r['transaction_price']-$r['quantity']*$r['transaction_price'];
	$cost=$old_cost+($quantity-$r['quantity'])*$cost_price;
	
	$sql="update ".self::$table_pre."order_goods  set `quantity`='".$quantity."' where `id`=".$id;
	if($pdo->exec($sql)){
		$sql="update ".self::$table_pre."order set `goods_money`=`goods_money`+".$change_price." , `actual_money`=`actual_money`+".$change_price." ,`received_money`=`received_money`+".$change_price." ,`sum_money`=`sum_money`+".$change_price." ,`last_time`='".time()."',`goods_cost`='".$cost."' where `id`=".$r['order_id'];
		if($pdo->exec($sql)){
			if($r['s_id']!=0){
				$sql="update ".self::$table_pre."goods_specifications set `quantity`=`quantity`-".$change_quantity." where `id`=".$r['s_id'];	
				$pdo->exec($sql);
			}
			$sql="update ".self::$table_pre."goods set `inventory`=`inventory`-".$change_quantity.",`sold`=`sold`+".$change_quantity." where `id`=".$r['goods_id'];	
			if($pdo->exec($sql)){
				$sql="insert into ".self::$table_pre."goods_quantity_log (`goods_id`,`quantity`,`username`,`time`) values ('".$r['goods_id']."','-".$change_quantity."','monxin','".time()."')";
				$pdo->exec($sql);
			}
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','change_price':'".$change_price."','change_quantity':'".$change_quantity."'}");	
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");	
		}	
	}else{
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");	
	}
		
}




$sql="select * from ".self::$table_pre."order where `id`='".$id."' and `shop_id`='".SHOP_ID."' limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
$sql="select `username` from ".self::$table_pre."shop where `id`=".$r['shop_id'];
$s=$pdo->query($sql,2)->fetch(2);
$seller=$s['username'];



switch($act){
	case 'paid'://====================================================================================================【付款】
		if($r['state']!=0){exit("{'state':'fail','info':'<span class=fail>".self::$language['state'].':'.self::$language['order_state'][$r['state']]." ".self::$language['inoperable']."</span>'}");}
		$order=$r;
		$order_id=$r['id'];
		$pay_method=safe_str($_GET['pay_method']);
		$order['pay_method']=$pay_method;
		$v=safe_str($_GET['v']);
		$reference_number='';
		
		if($pay_method=='pos' || $pay_method=='meituan' || $pay_method=='nuomi' || $pay_method=='other'){
			$reference_number=$v;
		}
		
		if($pay_method=='balance' || $pay_method=='balance'){
			$sql="select `transaction_password` from ".$pdo->index_pre."user where `username`='".$order['buyer']."' limit 0,1";
			$u=$pdo->query($sql,2)->fetch(2);
			if(md5($v)!=$u['transaction_password']){exit('{"state":"fail","info":"<span class=fail>'.self::$language['transaction_password'].=self::$language['err'].'</span>"}');}
			
			
			if($pay_method=='balance'){
				$reason=str_replace('{order_id}',$order['out_id'],self::$language['deduction_order_money_template']);
				$reason=str_replace('{sum_money}',$order['actual_money'],$reason);
				if(!operator_money(self::$config,self::$language,$pdo,$order['buyer'],'-'.$order['actual_money'],$reason,'mall')){
					$pdo->exec("delete from ".self::$table_pre."order where `id`=".$order_id);
					exit('{"state":"fail","info":"<span class=fail>decrease money err</span>"}');
				}
				
				$r=$order;
				
				$reason=str_replace('{order_id}','<a href=./index.php?monxin=mall.order_admin&search='.$order['out_id'].' target=_blank>'.$order['out_id'].'</a>',self::$language['add_order_money_template']);
				$reason=str_replace('{sum_money}',$r['actual_money'],$reason);
				if(!operator_money(self::$config,self::$language,$pdo,$seller,$r['actual_money'],$reason,'mall')){
					exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
				}
				$sql="update ".self::$table_pre."order set `settlement_state`=1 where `id`=".$order['id'];
				$pdo->exec($sql);
				
			}
		
			if($pay_method=='shop_balance'){
				$reason=str_replace('{order_id}',$order['out_id'],self::$language['deduction_order_money_template']);
				$reason=str_replace('{sum_money}',$order['actual_money'],$reason);

				if(!self::operator_shop_buyer_balance($pdo,$buyer['username'],'-'.$order['actual_money'],$reason)){
					$pdo->exec("delete from ".self::$table_pre."order where `id`=".$order_id);
					exit('{"state":"fail","info":"<span class=fail>decrease money err</span>"}');
				}
				$r=$order;
			}
			
			if(self::$config['distribution'] && $order['buyer']!=''){
				if(!isset($distribution)){
					require('./program/distribution/distribution.class.php');
					$distribution=new distribution($pdo);		
				}
				$distribution->order_complete_pay($pdo,$order['id']);
				$distribution->order_complete_confirm_receipt($pdo,$order['id']);
			}
	
			self::checkout_order_notice(self::$language,self::$config,$pdo,self::$table_pre,$order);	
		}
		
		
		$sql="update ".self::$table_pre."order set `state`=1,`pay_method`='".$pay_method."',`reference_number`='".$reference_number."' where `id`=".$id;
		if($pdo->exec($sql)){
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
		break;	
	case 'order_state_2'://========================================================================================================【设为已发货】
		$express=intval(@$_GET['express']);
		//if($express==0){exit("{'state':'fail','info':'<span class=fail>".self::$language['express'].self::$language['is_null']."</span>'}");}
		$express_code=safe_str(@$_GET['express_code']);
		$express_code=str_replace('，',',',$express_code);
		$express_code=str_replace('  ','',$express_code);
		if($express_code==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['express_code'].self::$language['is_null']."</span>'}");}
		if($r['state']==2){
			$sql="update ".self::$table_pre."order set `express`='".$express."',`express_code`='".$express_code."' where `id`=".$id;
			if($pdo->exec($sql)){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		}
		if($r['state']>1 &&  $r['state']!=14){exit("{'state':'fail','info':'<span class=fail>".self::$language['state'].':'.self::$language['order_state'][$r['state']]." ".self::$language['forbidden_modify']."</span>'}");}
		$sql="update ".self::$table_pre."order set `state`='2',`express`='".$express."',`express_code`='".$express_code."',`send_time`='".time()."' where `id`=".$id;
		$s_express_code=$express_code;
		if($pdo->exec($sql)){
			
		//==============================================================================================================自动完成订单 start	
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
		}
		//==============================================================================================================自动完成订单 end	
			
			
			
			
		  if($express_code!=''){
			  $temp=explode(',',$express_code);
			  if(count($temp)>1){
				  $temp2='';
				  foreach($temp as $v3){
					  $temp2.='<a href=./receive.php?target=mall::order_admin&act=go_express&id='.$r['express'].'&code='.$v3.' target=_blank>'.$v3.'</a> , ';		
				  }
				  $express_code=trim($temp2,' , ');
			  }else{
				  $express_code='<a href=./receive.php?target=mall::order_admin&act=go_express&id='.$r['express'].'&code='.$express_code.' target=_blank>'.$express_code.'</a>';	
			  }	
		  }
		$r['state']=2;
		self::decrease_goods_quantity($pdo,self::$table_pre,$r);
  		
		if(self::virtual_auto_delivery(self::$config,self::$language,$pdo,self::$table_pre,$r)){
			exit("{'state':'success','info':'<span class=success>".self::$language['success'].",".self::$language['have_automatic_delivery']."</span>','express_code':'".$express_code."'}");	
		}
		$r['express']=$express;
		$r['express_code']=$s_express_code;
		//self::send_notice(self::$language,self::$config,$pdo,self::$table_pre,$r);	
		
		$sql="select `name`,`username` from ".self::$table_pre."shop where `id`=".$r['shop_id'];
		$r2=$pdo->query($sql,2)->fetch(2);
		$seller=$r2['username'];
		$shop_name=$r2['name'];
		$shop_username=$r2['name'];
		$title=self::$language['order_send_notice_template'];
		$title=str_replace('{time}',date("m-d H:i",$r['add_time']),$title);
		$title=str_replace('{webname}',self::$config['web']['name'],$title);
		$title=str_replace('{shop_name}',$shop_name,$title);
		$sql="select `url` from ".self::$table_pre."express where `id`='".$r['express']."'";
		$r2=$pdo->query($sql,2)->fetch(2);
		$url=$r2['url'].$r['express_code'];
		
		push_send_order_info($pdo,self::$config,self::$language,$r['buyer'],$title,$r['out_id'],self::get_express_name($pdo,self::$table_pre,$r['express']),$r['express_code'],$url);		  
		
				$msg=self::$language['im_order_state_2'];
				$msg=str_replace('{shopname}',$shop_name,$msg);
				$msg.='<a href=http://'.self::$config['web']['domain'].'/index.php?monxin=mall.my_order&search='.$r['out_id'].' target=_blank>http://'.self::$config['web']['domain'].'/index.php?monxin=mall.my_order&search='.$r['out_id'].'</a>';
				send_im_msg(self::$config,self::$language,$pdo,$shop_username,$r['buyer'],$msg);
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','express_code':'".rn_to_br($express_code)."'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
		break;	
	case '':
		
		break;	
}














