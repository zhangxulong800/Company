<?php
$act=@$_GET['act'];
if($act=='refund'){
	$time=time();
	$ids='';
	$end_id='';
	$goods_names='';
	foreach($_POST as $k=>$v){
		$k=intval($k);
		if($v<=0){continue;}
		$sql="select `id`,`order_id`,`goods_id`,`title` from ".self::$table_pre."order_goods where `id`=".$k." and `shop_id`=".SHOP_ID;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){continue;}
		$goods_names.=$r['title'].' , ';
		$sql="select `id` from ".self::$table_pre."refund where `order_id`=".$r['order_id']." and `goods_id`=".$r['goods_id']." limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){
			exit("{'state':'fail','info':'<span class=fail>".self::$language['part_refunded']."</span>'}");
		}
		
		$end_id=$k;
		$ids.=$k.',';
		
		
		
		
	}
	$ids=trim($ids,',');
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['please_input'].self::$language['return_goods'].self::$language['quantity']."</span>'}");}
	
	$sql="select `order_id` from ".self::$table_pre."order_goods where `id`=".$end_id;
	$r=$pdo->query($sql,2)->fetch(2);
	$order_id=$r['order_id'];
	$sql="select * from ".self::$table_pre."order where `id`=".$order_id;
	$r=$pdo->query($sql,2)->fetch(2);
	$order=$r;
	
	$return_money=floatval($_GET['return_money']);
	$return_type=$_GET['return_type'];
	
	if($return_money<0){exit("{'state':'fail','info':'<span class=fail>return_money err</span>'}");}
	if($return_type!='cash' && $return_type!='balance'){exit("{'state':'fail','info':'<span class=fail>return_type err</span>'}");}
	$update_refund=false;
	
	if($return_type=='cash'){
		$update_refund=true;
		if($return_money>$order['actual_money']){exit("{'state':'fail','info':'<span class=fail>".self::$language['greater_than'].$order['actual_money']."</span>'}");}
		$inventory_decrease=$r['inventory_decrease'];
		if($r['state']!=6){exit("{'state':'fail','info':'<span class=fail>".self::$language['only_state_success']."</span>'}");}
	}else{
		
		
		//退款到网站余额
		$sql="select `username` from ".self::$table_pre."shop where `id`=".SHOP_ID;
		$r=$pdo->query($sql,2)->fetch(2);
		$seller=$r['username'];
		$sql="select `money` from ".$pdo->index_pre."user where `username`='".$r['username']."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['money']<$return_money){exit("{'state':'fail','info':'<span class=fail>".self::$language['shop_master'].self::$language['insufficient_balance']."</span>'}");}
		$r=$order;
		$inventory_decrease=$r['inventory_decrease'];
		if($r['buyer']==''){
			exit("{'state':'fail','info':'<span class=fail>".self::$language['please_select_cash']."</span>'}");	
		}
		if($r['state']!=6){exit("{'state':'fail','info':'<span class=fail>".self::$language['only_state_success']."</span>'}");}
		$order['actual_money']-=$order['web_credits_money'];
		if($return_money>$order['actual_money']+$order['web_credits_money']){exit("{'state':'fail','info':'<span class=fail>".self::$language['greater_than'].$order['actual_money']."</span>'}");}
		$reason=$r['out_id'].self::$language['offline_return_money'];
		$reason=str_replace('{goods_name}',$goods_names,$reason);
		//echo $seller.'-'.$return_money;
		if(operator_money(self::$config,self::$language,$pdo,$seller,'-'.$return_money,$reason,'mall')){
			$return_money-=$r['web_credits_money'];
			$reason=$r['out_id'].self::$language['offline_return_money'];
			$reason=str_replace('{goods_name}',$goods_names,$reason);

			if(operator_money(self::$config,self::$language,$pdo,$r['buyer'],$return_money,$reason,'mall')){
				$update_refund=true;
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." operator_money buyer</span>'}");
			}
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." operator_money seller</span>'}");
		}
		
	}
	
	
	
	
	
	
	if($update_refund==false){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." operator_money buyer</span>'}");}
	
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
	
	
		$refund_times=0;
		$sql="select `id` from ".self::$table_pre."refund where `order_id`=".$order_id." limit 0,1";
		$e=$pdo->query($sql,2)->fetch(2);
		if($e['id']!=''){
			$refund_times=1;
		}
	
		$sql="select * from ".self::$table_pre."order where `id`=".$order_id;
		$r=$pdo->query($sql,2)->fetch(2);
		$order=$r;
		$sql="select `username` from ".self::$table_pre."shop where `id`=".$r['shop_id'];
		$r2=$pdo->query($sql,2)->fetch(2);
		$seller=$r2['username'];
	
	
		if($return_money>=$order['actual_money']-$order['web_credits_money']){//退全款，则退抵扣积分
			self::order_cancel_untread_credits($pdo,$order);
		}
		if($refund_times==0){//如里首次退款，则执行 退赠送的积分，及各反佣
			self::untread_credits($pdo,$order);
			if($order['receipt']==1 || $order['cashier']!='monxin'){
				self::introducer_return_fees($pdo,$order);	
				self::return_agent_fees($pdo,$seller,$order);
				
			}
			//分销退佣
			if(self::$config['agency']){
				require_once('./program/agency/agency.class.php');
				$agency=new agency($pdo);
				$agency->order_refund($pdo,$order['id']);
			}
			if(self::$config['distribution']){
				require_once('./program/distribution/distribution.class.php');
				$distribution=new distribution($pdo);
				$distribution->order_refund($pdo,$order['id']);
			}
				
		}
	
	
	
	
	
	//新增店铺财务
	$reason=$order['out_id'].self::$language['offline_return_money'];
	$reason=str_replace('{goods_name}',$goods_names,$reason);
	self::operation_shop_finance(self::$language,$pdo,self::$table_pre,SHOP_ID,'-'.$return_money,13,$reason);
	
	
	
	$sql="select * from ".self::$table_pre."order_goods where `id` in (".$ids.")";
	$r=$pdo->query($sql,2);
	$goods_money=0;
	$sum_cost=0;
	foreach($r as $v){
		
		//计算已退商品成本
		$sum_cost+=floatval($_POST[$v['id']])*$v['cost_price'];
		
		//更新订单商品退货数量
		$sql="update ".self::$table_pre."order_goods set `refund`='".floatval($_POST[$v['id']])."' where `id`=".$v['id'];
		$pdo->exec($sql);
		//新增退货记录
		$sql="insert into ".self::$table_pre."refund (`shop_id`,`order_id`,`out_id`,`goods_id`,`s_id`,`quantity`,`username`,`time`,`reason`,`buyer`) value ('".SHOP_ID."','".$order['id']."','".$order['out_id']."','".$v['goods_id']."','".$v['s_id']."','".floatval($_POST[$v['id']])."','".$_SESSION['monxin']['username']."','".$time."','".safe_str($_GET['reason'])."','".$order['buyer']."')";
		$pdo->exec($sql);		
		
		//退到库存
		if($inventory_decrease){
			$sql="select `batch_id` from ".self::$table_pre."goods_quantity_log where `order_id`=".$order_id." limit 0,1";
			$batch=$pdo->query($sql,2)->fetch(2);
			if($batch['batch_id']==''){continue;}
			$sql="select * from ".self::$table_pre."goods_batch where `id`=".$batch['batch_id'];
			$batch=$pdo->query($sql,2)->fetch(2);
			if($v['s_id']){
				self::add_goods_batch($pdo,$v['goods_id'].'_'.$v['s_id'],floatval($_POST[$v['id']]),$batch['price'],$batch['supplier'],$batch['expiration']);
			}else{
				self::add_goods_batch($pdo,$v['goods_id'],floatval($_POST[$v['id']]),$batch['price'],$batch['supplier'],$batch['expiration']);
			}
		}
		
		
	}
	
	$sql="update ".self::$table_pre."order set `actual_money`=`actual_money`-".$return_money.",`change_price_reason`='".self::$language['refund'].$return_money."',`goods_cost`=`goods_cost`-".$sum_cost." where `id`=".$order['id'];
	$pdo->exec($sql);
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	
		
}