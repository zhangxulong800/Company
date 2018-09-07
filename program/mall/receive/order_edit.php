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




switch($act){
	case 'express_cost_buyer'://====================================================================================================【没付款前 修改买家运费】
		if($r['state']!=0){exit("{'state':'fail','info':'<span class=fail>".self::$language['state'].':'.self::$language['order_state'][$r['state']]." ".self::$language['forbidden_del']."</span>'}");}
		$v=max(floatval(@$_GET['v']),0);
		$sql="update ".self::$table_pre."order set `express_cost_buyer`='".$v."',`sum_money`=`goods_money`+".$v.",`actual_money`=`actual_money`+".($v-$r['express_cost_buyer'])." where `id`=".$id;
		if($pdo->exec($sql)){
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','express_cost_buyer':'".$v."','sum_money':'".($r['goods_money']+$v)."','actual_money':'".($r['actual_money']+$v-$r['express_cost_buyer'])."'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
		break;	
	case 'express_cost_seller'://=============================================================================================================【修改店家运费支出】
		$v=max(floatval(@$_GET['v']),0);
		$sql="update ".self::$table_pre."order set `express_cost_seller`='".$v."' where `id`=".$id;
		if($pdo->exec($sql)){
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','express_cost_seller':'".$v."'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
		break;	
	case 'receiving_extension'://================================================================================================================【收货延期】
		$v=safe_str(@$_GET['v']);
		$sql="update ".self::$table_pre."order set `receiving_extension`='".intval($v)."' where `id`=".$id;
		if($pdo->exec($sql)){
			$time_limit=self::$language['time_limit'];
			$end_time=$r['send_time']+(self::$config['receipt_time_limit']+$v)*86400;
			$d=floor(($end_time-time())/86400);
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','day':'".$d."'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
		break;	
	case 'seller_remark'://================================================================================================================【订单备注】
		$v=safe_str(@$_GET['v']);
		$sql="update ".self::$table_pre."order set `seller_remark`='".$v."' where `id`=".$id;
		if($pdo->exec($sql)){
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
		break;	
	case 'actual_money'://================================================================================================================【没付款前，调整付款金额】
		if($r['state']>1){exit("{'state':'fail','info':'<span class=fail>".self::$language['state'].':'.self::$language['order_state'][$r['state']]." ".self::$language['forbidden_modify']."</span>'}");}
		$actual_money=floatval(@$_GET['actual_money']);
		if($actual_money==0){exit("{'state':'fail','info':'<span class=fail>".self::$language['must_be_greater_than']." 0</span>'}");}
		$change_price_reason=safe_str(@$_GET['change_price_reason']);
		if($change_price_reason==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['change_price_reason'].self::$language['is_null']."</span>'}");}
		$sql="update ".self::$table_pre."order set `actual_money`='".$actual_money."',`change_price_reason`='".$change_price_reason."' where `id`=".$id;
		if($pdo->exec($sql)){
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','actual_money':'".$actual_money."','change_price_reason':'".$change_price_reason."'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
		break;	
	case 'order_state_2'://================================================================================================================【设为已发货】
		$express=intval(@$_GET['express']);
		//if($express==0){exit("{'state':'fail','info':'<span class=fail>".self::$language['express'].self::$language['is_null']."</span>'}");}
		$express_code=safe_str(@$_GET['express_code']);
		$express_code=str_replace('，',',',$express_code);
		//$express_code=str_replace('  ','',$express_code);
		if($express_code==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['express_code'].self::$language['is_null']."</span>'}");}
		if($r['state']==2){
			$sql="update ".self::$table_pre."order set `express`='".$express."',`express_code`='".$express_code."' where `id`=".$id;
			if($pdo->exec($sql)){
				
							
							
					$r['express']=$express;
					$r['express_code']=$express_code;
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
					if(strstr($r['express_code'],'：')==''){
						push_send_order_info($pdo,self::$config,self::$language,$r['buyer'],$title,$r['out_id'],self::get_express_name($pdo,self::$table_pre,$r['express']),$r['express_code'],$url);	
					}else{
						$url='http://'.self::$config['web']['domain'].'/index.php?monxin=mall.my_order&search='.$r['out_id'];
						$temp=explode("\n",$r['express_code']);
						$remark='';
						foreach($temp as $k=>$t){
							if($t==''){continue;}
							if($k==0){
								$t=str_replace("：",":",$t);
								$tt=explode(":",$t);
								//var_dump($tt);
								$ttt=explode("  ",$tt[1]);
								$number=$ttt[0];
								$code=$tt[2];
							}else{
								$t=str_replace("  ","\n",$t);
								$remark.=$t."\n";
							}
						}
						$remark=str_replace("\n\n","\n",$remark);
						push_send_cabinet_info($pdo,self::$config,self::$language,$r['buyer'],$title,$r['out_id'],$number,$code,$url,$remark);	
						
					}
						  

						//$express_code=str_replace("\r","<br />",$r['express_code']);
						//$express_code=str_replace("\n","<br />",$express_code);
						//exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','express_code':'".$express_code."'}");
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		}
		if($r['state']>1 &&  $r['state']!=14){exit("{'state':'fail','info':'<span class=fail>".self::$language['state'].':'.self::$language['order_state'][$r['state']]." ".self::$language['forbidden_modify']."</span>'}");}
		$sql="update ".self::$table_pre."order set `state`='2',`express`='".$express."',`express_code`='".$express_code."',`send_time`='".time()."' where `id`=".$id;
		$s_express_code=$express_code;
		if($pdo->exec($sql)){
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
					if(strstr($r['express_code'],'：')==''){
						push_send_order_info($pdo,self::$config,self::$language,$r['buyer'],$title,$r['out_id'],self::get_express_name($pdo,self::$table_pre,$r['express']),$r['express_code'],$url);	
					}else{
						$url='http://'.self::$config['web']['domain'].'/index.php?monxin=mall.my_order&search='.$r['out_id'];
						$temp=explode("\n",$r['express_code']);
						$remark='';
						foreach($temp as $k=>$t){
							if($t==''){continue;}
							if($k==0){
								$t=str_replace("：",":",$t);
								$tt=explode(":",$t);
								//var_dump($tt);
								$ttt=explode("  ",$tt[1]);
								$number=$ttt[0];
								$code=$tt[2];
							}else{
								$t=str_replace("  ","\n",$t);
								$remark.=$t."\n";
							}
						}
						$remark=str_replace("\n\n","\n",$remark);
						push_send_cabinet_info($pdo,self::$config,self::$language,$r['buyer'],$title,$r['out_id'],$number,$code,$url,$remark);	
						
					}
		
				$msg=self::$language['im_order_state_2'];
				$msg=str_replace('{shopname}',$shop_name,$msg);
				$msg.='<a href=http://'.self::$config['web']['domain'].'/index.php?monxin=mall.my_order&search='.$r['out_id'].' target=_blank>http://'.self::$config['web']['domain'].'/index.php?monxin=mall.my_order&search='.$r['out_id'].'</a>';
				send_im_msg(self::$config,self::$language,$pdo,$shop_username,$r['buyer'],$msg);
			$express_code=str_replace("\r","<br />",$express_code);
			$express_code=str_replace("\n","<br />",$express_code);
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','express_code':'".$express_code."'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
		break;	
	case '':
		
		break;	
	case '':
		
		break;	
}














