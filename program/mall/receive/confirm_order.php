<?php
$act=@$_GET['act'];
$_GET['quantity']=floatval(@$_GET['quantity']);
if($_GET['quantity']<0){$_GET['quantity']=1;}
if(isset($_GET['bargain_log'])){$_GET['quantity']=1;}

//==================================================================================================================================【提交订单 start】
if($act=='submit'){
	//var_dump($_POST);
	//var_dump($_GET);
	//exit;
	$bargain=0;
	if($_SESSION['mall_buy_quantity']>3){//同段时间内，下单频率超过三次，否要求输入验证码
		$authcode=@$_GET['authcode'];
		if($authcode==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['authcode'].self::$language['is_null']."</span>'}");}
		if(strtolower($authcode)!=strtolower($_SESSION["authCode"])){
			exit ("{'state':'fail','info':'<span class=fail>".self::$language['authcode_err']."</span>'}");			
		}
	}
	if(isset($_COOKIE['mall_cart'])){
		$mall_cart=json_decode($_COOKIE['mall_cart'],true);	
	}else{
		$mall_cart=array();
	}
	
	$time=time();
	$receiver=intval(@$_GET['receiver']);

	$sql="select * from ".self::$table_pre."receiver where `id`=".$receiver;
	$re=$pdo->query($sql,2)->fetch(2);
	$area_top_id=self::get_area_top_id($pdo,$re['area_id']);
	$delivery_time=intval(@$_GET['delivery_time']);
	
	if($receiver==0 && $_GET['receiver']!='no'){exit("{'state':'fail','info':'<span class=fail>".self::$language['please_select'].self::$language['receiver']."</span>'}");}
	
	$goods_src=@$_GET['goods_src'];
	if($goods_src==''){exit("{'state':'fail','info':'goods_src is null'}");}
	
	if($goods_src=='goods_id'){
		
			//=============================================================================================================砍价 start
			if(isset($_GET['bargain_log']) && $_GET['bargain_log']!=''){
				$_GET['quantity']=1;
					//========================================== 获取商品原 网售价
					function get_goods_price($pdo,$goods_id){
						$sql="select `w_price`,`min_price`,`max_price`,`option_enable` from ".$pdo->sys_pre."mall_goods where `id`=".$goods_id;
						$r=$pdo->query($sql,2)->fetch();
						if($r['option_enable']==1){
							if($r['min_price']==$r['max_price']){
								$r['w_price']=$r['min_price'];
							}else{
								$r['w_price']=$r['min_price'].'-'.$r['max_price'];
							}
						}
						return $r['w_price'];
					}
					
				$bargain_log=intval($_GET['bargain_log']);
				$sql="select * from ".$pdo->sys_pre."bargain_log where `id`=".$bargain_log;
				$log=$pdo->query($sql,2)->fetch(2);
				if($log['id']!=''){
					if(($log['state']==1 || $log['state']==3) && $log['username']){
						$sql="select * from ".$pdo->sys_pre."bargain_goods where `id`=".$log['b_id'];
						$gb=$pdo->query($sql,2)->fetch(2);
						if($gb['id']!=''){
							if($log['state']==1){
								$bargain=get_goods_price($pdo,$log['g_id'])-$log['money'];
							}else{
								$bargain=$gb['final_price'];
							}
							$actual_money=$bargain;
							foreach($_POST as $k=>$v){
								$_POST[$k]['preferential_way']=9;
							}
							
						}	
		
					}
				}
				//var_dump($bargain);
			}
			//=============================================================================================================砍价 end
			
	
		
		
			
	}elseif($goods_src=='package_id'){//如商品来源是套餐
		$id=intval($_GET['id']);
		if($id==0){exit("{'state':'fail','info':'package_id err'}");}
		$sql="select * from ".self::$table_pre."package where `id`='".$id."'";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){exit("{'state':'fail','info':'package_id err'}");}
		if(!($r['discount']>0)){exit("{'state':'fail','info':'". self::$language['not_set'].self::$language['discount_rate']."'}");}
		$package_discount=$r['discount'];
		$free_shipping=$r['free_shipping'];

	}elseif($goods_src=='selected_goods'){//如商品来源是购物车
		if($_COOKIE['selected_goods']==''){echo self::$language['at_least_to_select_a_commodity_to_settlement'];return false;}
		
	}else{exit("{'state':'fail','info':'goods_src is null'}");}
	$_POST=safe_str($_POST,1,0);
	$order_sum=0;
	$_SESSION['monxin_mall_order_id']='';
	$shop_sum=(count($_POST));
	$shop_index=0;
	$deposit=0;
	$pre_sale=0;
	
	$group_reduce=array();
	$group_discount=array();
	$group_id=array();
	foreach($_POST as $k=>$v){
		$k=intval($k);
		$shop_index++;
		$state=0;
		//var_dump($v);
		$goods_cost=0;
		$goods_count=0;
		$goods_names='';
		$shop_discount=self::get_shop_discount($pdo,$k);
		$order_goods_sql=array();
		$specifications=array();
		$quantity=array();
		$v['goods_ids']=trim($v['goods_ids'],',');
		if($v['goods_ids']==''){exit("{'state':'fail','info':'".self::$language['goods'].self::$language['is_null']."'}");}
		$temp=explode(',',$v['goods_ids']);
		$goods_ids='';
		foreach($temp as $v2){
			$temp2=explode('*',$v2);
			$temp3=explode('_',$temp2[0]);
			$gid=$temp3[0];	
			if(isset($temp3[1])){$specifications[$gid][]=$temp3[1];}else{$specifications[$gid][]=0;}
			$quantity[$gid]=$temp2[1];
			$quantity[$temp2[0]]=$temp2[1];
			$goods_ids.=$gid.',';	
		}
		$goods_ids=trim($goods_ids,',');
		if($goods_ids==''){exit("{'state':'fail','info':'".self::$language['goods'].self::$language['is_null']."'}");}
		$cost=0;
		$all_money=0;
		$weight=0;
		$promotion_money=0;
		$vip_money=0;
		$introducer=0;
		$sql="select `id`,`title`,`icon`,`w_price`,`unit`,`sales_promotion`,`option_enable`,`state`,`logistics_weight`,`logistics_volume`,`free_shipping`,`discount`,`discount_start_time`,`discount_end_time`,`cost_price`,`recommendation`,`pre_discount`,`introducer_rate` from ".self::$table_pre."goods where `id` in (".$goods_ids.")";
		$r=$pdo->query($sql,2)->fetchAll(2);
		$index=0;
		//var_dump($r[0]);
		for($i=0;$i<count($r);$i++){
			$again=false;
			$v3=$r[$i];
			$key=$v3['id'];
			
			
			
			$goods_names.=$v3['title']."
		";
			$temp_sql="select `id` from ".self::$table_pre."goods_snapshot where `goods_id`='".$v3['id']."' order by `id` desc limit 0,1";
			$temp_r=$pdo->query($temp_sql,2)->fetch(2);
			$snapshot_id=(isset($temp_r['id']))?$temp_r['id']:0;;
			if($v3['option_enable']){//如果是有选项的商品
				$sql="select * from ".self::$table_pre."goods_specifications where `id`='".$specifications[$v3['id']][0]."' limit 0,1";
				$v4=$pdo->query($sql,2)->fetch(2);
				if($v4['id']==''){continue;}
				$v3['w_price']=$v4['w_price'];	
				if($v4['color_img']!=''){$v3['icon']=$v4['color_img'];}
				$v3['title']=$v3['title'].' '.$v4['color_name'].' '.self::get_type_option_name($pdo,$v4['option_id']);
				$key.='_'.$v4['id'];
				if(count($specifications[$v3['id']])>1){
					$specifications[$v3['id']]=array_splice($specifications[$v3['id']],1);
					$again=true;
				}
				$quantity[$v3['id']]=$quantity[$v3['id'].'_'.$v4['id']];
				$v3['cost_price']=self::get_cost_price($pdo,$v3['id'].'_'.$v4['id']);
			}else{//如果是没选项的商品
				$v3['cost_price']=self::get_cost_price($pdo,$v3['id']);
			}
				
						
				
				
				
				
			$temp=explode('/',$v3['icon']);
			@mkdir('./program/mall/order_icon/'.$temp[0]);
			@mkdir('./program/mall/order_icon/'.$temp[0].'/'.$temp[1]);
			if(!file_exists('./program/mall/order_icon/'.$v3['icon'])){copy('./program/mall/img/'.$v3['icon'],'./program/mall/order_icon/'.$v3['icon']);}
			//var_dump($v3['w_price']);
			if(!isset($group_reduce[$k])){$group_reduce[$k]=0;}
			if($goods_src=='package_id'){
				$price=sprintf("%.2f",$v3['w_price']*$package_discount/10);
			}else{
				if($v['preferential_way']==5){//优惠方式:店内用户组
					if(!isset($group_discount[$k])){$group_discount[$k]=self::shop_buyer_group_discount($pdo,$k);}
					if(!isset($group_id[$k])){$group_id[$k]=self::shop_buyer_group_id($pdo,$k);}
					$price=$v3['w_price'];
					$sql="select `discount` from ".self::$table_pre."goods_group_discount where `goods_id`=".$v3['id']." and `group_id`=".$group_id[$k]." limit 0,1";
					$ggd=$pdo->query($sql,2)->fetch(2);
					if($ggd['discount']){
						$goods_group_discount=$ggd['discount'];
					}else{
						$goods_group_discount=100;	
					}
					
					
					if(($group_discount[$k]<10 || $goods_group_discount<10) && $v3['sales_promotion']){
						if($goods_group_discount==100){
							$goods_group_discount=$group_discount[$k];
						}
						$group_reduce[$k]+=(($v3['w_price']-sprintf("%.2f",$v3['w_price']*$goods_group_discount/10)) *$quantity[$v3['id']]);
						//var_dump($goods_group_discount);
					}
					$goods_group_price=sprintf("%.2f",$v3['w_price']*$goods_group_discount/10);
				}else{
					if($v3['discount']<10 && $time>$v3['discount_start_time'] && $time<$v3['discount_end_time']){$discount=$v3['discount'];$goods_discount=$v3['discount'];}else{$discount=$shop_discount;}
					if($discount<10 && ($v3['sales_promotion'] || $_SESSION['discount_all']) ){$price=sprintf("%.2f",$v3['w_price']*$discount/10);}else{$price=$v3['w_price'];}
					if($goods_src=='selected_goods'){unset($mall_cart[$key]);}
					
				}
			}
			//var_dump($price);
			//▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃ 如是预售商品 start
			if($v3['state']==1){
				$sql="select * from ".self::$table_pre."pre_sale where `goods_id`=".$v3['id']." limit 0,1";
				$r2=$pdo->query($sql,2)->fetch(2);
				$deposit=$r2['deposit'];
				$price=$v3['w_price']*$v3['pre_discount']/10;
				//file_put_contents('t.txt',$v3['w_price'].'*'.$v3['pre_discount']);
				$pre_sale=1;
			}
			//▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃▃ 如是预售商品  end
			
			if($v['preferential_way']==5 && $v3['state']!=1){
				if($bargain>0){$v3['w_price']=$bargain;$goods_group_price=$bargain;$price=$bargain;}
				$order_goods_sql[]="insert into ".self::$table_pre."order_goods (`goods_id`,`s_id`,`order_id`,`snapshot_id`,`icon`,`title`,`quantity`,`price`,`transaction_price`,`unit`,`time`,`buyer`,`shop_id`,`recommendation`,`order_state`,`cost_price`) values ('".$v3['id']."','".$specifications[$v3['id']][0]."','{order_id}','".$snapshot_id."','".$v3['icon']."','".$v3['title']."','".$quantity[$v3['id']]."','".$v3['w_price']."','".$goods_group_price."','".self::get_mall_unit_name($pdo,$v3['unit'])."','".$time."','".@$_SESSION['monxin']['username']."','".$k."','".$v3['recommendation']."','{order_state}','".$v3['cost_price']."')";
			}else{
				$order_goods_sql[]="insert into ".self::$table_pre."order_goods (`goods_id`,`s_id`,`order_id`,`snapshot_id`,`icon`,`title`,`quantity`,`price`,`transaction_price`,`unit`,`time`,`buyer`,`shop_id`,`recommendation`,`order_state`,`cost_price`) values ('".$v3['id']."','".$specifications[$v3['id']][0]."','{order_id}','".$snapshot_id."','".$v3['icon']."','".$v3['title']."','".$quantity[$v3['id']]."','".$v3['w_price']."','".$price."','".self::get_mall_unit_name($pdo,$v3['unit'])."','".$time."','".@$_SESSION['monxin']['username']."','".$k."','".$v3['recommendation']."','{order_state}','".$v3['cost_price']."')";

			}
			

			
			
						
			
			$all_money+=$price*$quantity[$v3['id']];
			
			$goods_cost+=$v3['cost_price']*$quantity[$v3['id']];
			$goods_count+=$quantity[$v3['id']];
			
			//计算会员注册推荐人返佣
			if(isset($_SESSION['monxin']['username']) && $v3['introducer_rate']>0){
				$introducer+=$price*$quantity[$v3['id']]*$v3['introducer_rate']/100;
			}
			
			
			if($v3['sales_promotion']){//如是参加优惠活动的商品
				$promotion_money+=$price*$quantity[$v3['id']];
				$sales_promotion='<span class=sales_promotion>'.self::$language['sales_promotion_short'].'</span>';
			}else{
				$sales_promotion='';
			}
			$weight_a=0;
			$weight_b=0;
			if($v3['logistics_volume']>0){$weight_a=$v3['logistics_volume']/self::$config['volume_rate'];}
			if($v3['logistics_weight']){$weight_b=$v3['logistics_weight'];}
			if($goods_src=='package_id'){$v3['free_shipping']=$free_shipping;}
			if($v3['free_shipping']==0){//如商品不包邮,计算重量
				$weight+=max($weight_a,$weight_b)*$quantity[$v3['id']];
				//echo $shops[$goods[$v]['shop_id']]['weight'].'<br />';
			}
			if($again){$i--;}
		}
		
		if($_GET['receiver']>0){
			$v['express']=intval($v['express']);
			$sql="select * from ".self::$table_pre."express where `id`=".$v['express'];
			$express=$pdo->query($sql,2)->fetch(2);
			
			$area_ids=get_area_parent_ids($pdo,$re['area_id']);
			$area_ids=trim($area_ids,',');
			$area_ids=explode(',',$area_ids);
			foreach($area_ids as $ai){
				if($ai==''){continue;}
				$sql="select * from ".self::$table_pre."express_price where `area_id`=".$ai." and `shop_id`=".$k." and `express_id`=".$v['express'];
				$express_price=$pdo->query($sql,2)->fetch(2);
				if($express_price['id']!=''){
					$express['first_price']=$express_price['first_price'];	
					$express['over_price']=$express_price['continue_price'];
					break;	
				}
			}
			if($weight<=$express['first_weight']){
				$express_cost=$express['first_price'];
			}else{
				$express_cost=$express['first_price']+((($weight-$express['first_weight'])/$express['over_weight'])*$express['over_price']);
			}
			
		}else{
			$express_cost=0;
		}
		//echo 'weight='.$weight.',first_price='.$express['first_price'].',express_cost='.$express_cost;
		if($weight==0){$express_cost=0;}
		
		
		
		$time=time();
		$wait_sql=array();
		//======================================================优惠方式 start
		if($v['preferential_way']==7){//单次购物券
			if($v['preferential_code']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][7].self::$language['please_input']."</span>'}");}
			$sql="select * from ".self::$table_pre."buy_coupon_list where `shop_id`=".$k." and `code`='".$v['preferential_code']."' limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']==''){
				$sql="select * from ".self::$table_pre."buy_coupon_list where `code`='".$v['preferential_code']."' limit 0,1";
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][7].self::$language['not_exist']."</span>'}");}
				exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][7].self::$language['not_this_shop']."</span>'}");
			}
			if($r['use_time']>0){exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][7].self::$language['has_been_used']."</span>'}");}
			$buy_coupon_list_id=$r['id'];
			$buy_coupon_list_coupon_id=$r['coupon_id'];
			$sql="select * from ".self::$table_pre."buy_coupon where `id`=".$r['coupon_id'];
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['start_time']>$time){exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][7].get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$r['start_time']).self::$language['can_be_use']."</span>'}");}	
			if($r['end_time']<$time){exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][7].get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$r['start_time']).self::$language['has_expired']."</span>'}");}	
			if($r['join_goods']==0){
				if($promotion_money>=$r['min_money']){
					$actual_money=$all_money-$r['amount'];
				}else{
					exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][7].','.self::$language['join_goods_front'][0].$promotion_money.self::$language['yuan'].self::$language['not_reached'].': '.$r['min_money']."</span>'}");
				}				
			}
			if($r['join_goods']==1){
				if($all_money>=$r['min_money']){
					$actual_money=$all_money-$r['amount'];
				}else{
					exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][7].','.self::$language['can_not_be_used_the_amount_of_goods_is_not_up_to'].': '.$r['min_money']."</span>'}");
				}
			}
			if($r['join_goods']==2){
				if($all_money-$promotion_money>=$r['min_money']){
					$actual_money=$all_money-$r['amount'];
				}else{
					exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][7].','.self::$language['join_goods_front'][2].($all_money-$promotion_money).self::$language['yuan'].self::$language['not_reached'].': '.$r['min_money']."</span>'}");
				}
			}
			
			
			$wait_sql[]="update ".self::$table_pre."buy_coupon_list set `order_id`={order_id},`use_time`=".time().",`buyer`='".$_SESSION['monxin']['username']."' where `id`=".$buy_coupon_list_id;
			$wait_sql[]="update ".self::$table_pre."buy_coupon set `use_quantity`=`use_quantity`+1 where `id`=".$buy_coupon_list_coupon_id;
			
		}
		
		if($v['preferential_way']==6){//推荐码
			if($v['preferential_code']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][6].self::$language['please_input']."</span>'}");}
			$s_id=intval(@$_GET['s_id']);
			$id=intval(@$_GET['id']);
			$sql="select `id`,`username` from ".$pdo->index_pre."user where `recommendation`='".$v['preferential_code']."' limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']==''){
				exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][6].self::$language['not_exist']."</span>'}");
			}
			
			$sql="select `id` from ".self::$table_pre."order_goods where `goods_id`=".$id." and `buyer`='".$r['username']."' and `order_state`=6 limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']==''){
				exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][6].self::$language['have_no_right_to_recommend']."</span>'}");
			}
			
			$sql="select `recommendation_discount` from ".self::$table_pre."shop where `id`=".$k;
			$r=$pdo->query($sql,2)->fetch(2);
			$recommendation_discount=$r['recommendation_discount'];
			$sql="select `recommendation`,`w_price`,`option_enable` from ".self::$table_pre."goods where `id`=".$id." and `shop_id`=".$k;
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['recommendation']!=1){exit("{'state':'fail','info':'<span class=fail>goods err</span>'}");}
			if($r['option_enable']){
				$sql="select `w_price` from ".self::$table_pre."goods_specifications where `id`=".$s_id." and `goods_id`=".$id;
				$r=$pdo->query($sql,2)->fetch(2);
			}
			if($r['w_price']==''){exit("{'state':'fail','info':'<span class=fail>goods err</span>'}");}
			if(!is_numeric($_GET['quantity'])){exit("{'state':'fail','info':'<span class=fail>quantity err</span>'}");}
			$decrease=$r['w_price']-$recommendation_discount/10*$r['w_price'];
			
			$actual_money=$all_money-($decrease*$_GET['quantity']);
			
		}
		
		if($v['preferential_way']==2){//优惠方式:满元优惠
			$full_pre=self::get_fulfil_preferential($pdo,self::$table_pre,$promotion_money,$all_money,$k);
			if($full_pre==='free_shipping'){
				$express_cost=0;
				$actual_money=$all_money;
			}else{
				$actual_money=$all_money-$full_pre;
			}
		}
		
		if($v['preferential_way']==3){//优惠方式:红包
			$temp=self::get_red_coupon($pdo,self::$table_pre,$promotion_money,$all_money,$k);
			if($temp===false){exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][3].self::$language['not_exist']."</span>'}");}
			if($temp['id']!=intval($_POST[$k]['red_coupon_id'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][3].self::$language['not_exist']." err</span>'}");}
			//if($v['preferential_code']==''){exit("{'state':'fail','info':'<span class=fail>code null</span>'}");}
			$sql="select * from ".self::$table_pre."coupon where `id`='".intval($_POST[$k]['red_coupon_id'])."' and `shop_id`=".$k;
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][3].self::$language['not_exist']."</span>'}");}
			if($r['start_time']>$time){exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][3].get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$r['start_time']).self::$language['can_be_use']."</span>'}");}	
			if($r['end_time']<$time){exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][3].get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$r['start_time']).self::$language['has_expired']."</span>'}");}	
			if($r['join_goods']==0){
				if($all_money>=$r['min_money']){$actual_money=$all_money-$r['amount'];}
			}
			if($r['join_goods']==1){
				if($all_money>=$r['min_money']){$actual_money=$all_money-$r['amount'];}
			}
			if($r['join_goods']==2){
				if($all_money-$promotion_money>=$r['min_money']){$actual_money=$all_money-$r['amount'];}
			}
			
			$wait_sql[]="update ".self::$table_pre."my_coupon set `order_id`={order_id},`use_time`=".time()." where `coupon_id`=".$r['id']." and `username`='".$_SESSION['monxin']['username']."'";
			$wait_sql[]="update ".self::$table_pre."coupon set `used`=`used`+1 where `id`=".$temp['id'];
		}
		if($v['preferential_way']==4){//优惠方式:纸质代金券
			if($v['preferential_code']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][4].self::$language['please_input']."</span>'}");}
			if(isset($_SESSION['monxin']['username'])){
				$sql="select `id` from ".self::$table_pre."order where `buyer`='".$_SESSION['monxin']['username']."' and `preferential_code`='".$v['preferential_code']."' and `state` in (0,1,2,6) limit 0,1";
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][4].self::$language['limit_per_person']."</span>'}");}
				
			}
			
			$sql="select * from ".self::$table_pre."vouchers where `number`='".$v['preferential_code']."'";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][4].self::$language['not_exist']."</span>'}");}
			if($r['start_time']>$time){exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][4].get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$r['start_time']).self::$language['can_be_use']."</span>'}");}	
			if($r['end_time']<$time){exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][4].get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$r['start_time']).self::$language['has_expired']."</span>'}");}	
			if($r['use_quantity']>=$r['sum_quantity']){exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][4].self::$language['has_been_used']."</span>'}");}
			if($r['join_goods']==0){
				if($promotion_money>=$r['min_money']){$actual_money=$all_money-$r['amount'];}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][4].','.self::$language['join_goods_front'][0].$promotion_money.self::$language['yuan'].self::$language['not_reached'].': '.$r['min_money']."</span>'}");
				}
			}
			if($r['join_goods']==1){
				if($all_money>=$r['min_money']){$actual_money=$all_money-$r['amount'];}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][4].','.self::$language['can_not_be_used_the_amount_of_goods_is_not_up_to'].': '.$r['min_money']."</span>'}");
				}
			}
			if($r['join_goods']==2){
				if($all_money-$promotion_money>=$r['min_money']){$actual_money=$all_money-$r['amount'];}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][4].','.self::$language['join_goods_front'][2].($all_money-$promotion_money).self::$language['yuan'].self::$language['not_reached'].': '.$r['min_money']."</span>'}");
				}
			}
			$wait_sql[]="update ".self::$table_pre."vouchers set `use_quantity`=`use_quantity`+1 where `id`=".$r['id'];
		}
		
		if($v['preferential_way']==5){//优惠方式:店内用户组
			$actual_money=$all_money-$group_reduce[$k];	
			//var_dump($group_reduce[$k]);
		}		
		//===============================================================================================================================优惠方式 end
		$all_discount=1;
		if($all_money>0){
			$all_discount=$actual_money/$all_money;
			if($all_discount<1){
				$introducer=$introducer*$all_discount;	
			}
		}
		
		
		$credits_remark='';
		
		if(!isset($actual_money)){$actual_money=$all_money;}
		$actual_money=$actual_money+$express_cost;
		if($actual_money<0){$actual_money=0;$express_cost=0;$state=1;}
		$_GET['credits']=intval(@$_GET['credits']);
		$_GET['credits_money']=0;
		$credits=intval(@$v['credits']);
		$credits_money=0;
		if($credits>0){
			$sql="select `credits` from ".self::$table_pre."shop_buyer where `username`='".$_SESSION['monxin']['username']."' and `shop_id`=".$k."  limit 0,1";	
			$user=$pdo->query($sql,2)->fetch(2);
			if($user['credits']<$credits)exit("{'state':'fail','info':'<span class=fail>".self::$language['credits_not_enough']."</span>'}");
			$sql="select `credits_rate` from ".self::$table_pre."shop_order_set where `shop_id`=".$k." limit 0,1";
			$order_set=$pdo->query($sql,2)->fetch(2);
			$actual_money-=$credits/$order_set['credits_rate'];
			$credits_money=$credits/$order_set['credits_rate'];
			
			if($credits_money>=$actual_money){
				$credits_money=$actual_money;
				$credits=$credits_money*$order_set['credits_rate'];
				$state=1;
			}
			$credits_remark.=self::$language['use_shop_credits'].':'.$credits.','.self::$language['deduction'].self::$language['money_symbol'].$credits_money.',';
		}
		
		if($_GET['credits']>0){
			$sql="select `credits` from ".$pdo->index_pre."user where `id`='".$_SESSION['monxin']['id']."' limit 0,1";	
			$user=$pdo->query($sql,2)->fetch(2);
			if($user['credits']<$_GET['credits'])exit("{'state':'fail','info':'<span class=fail>".self::$language['web_credits']." ".self::$language['credits_not_enough']."</span>'}");
			$_GET['credits_money']=$_GET['credits']*self::$config['credits_set']['rate'];
			if($_GET['credits_money']>=$actual_money){
				$_GET['credits_money']=$actual_money;
				$_GET['credits']=$_GET['credits_money']/self::$config['credits_set']['rate'];
				$state=1;
			}
			$credits_remark.=self::$language['use_web_credits'].':'.$_GET['credits'].','.self::$language['deduction'].self::$language['money_symbol'].$_GET['credits_money'];
		}
		
		if($bargain>0){
			$actual_money=$bargain;
			$all_money=$bargain;
			$goods_count=$bargain;
		}
		$pay_method='';
		if(self::$config['pay_mode']=='credits'){$pay_method='credits';}
		

		//执行新增订单
		$sql="insert into ".self::$table_pre."order (`add_time`,`last_time`,`shop_id`,`buyer`,`receiver_id`,`goods_money`,`actual_money`,`change_price_reason`,`pay_method`,`cashier`,`received_money`,`change`,`state`,`preferential_way`,`delivery_time`,`buyer_remark`,`express`,`preferential_code`,`weight`,`express_cost_buyer`,`sum_money`,`receiver_name`,`receiver_phone`,`receiver_area_id`,`receiver_detail`,`receiver_post_code`,`receiver_area_name`,`goods_names`,`share`,`goods_cost`,`goods_count`,`inventory_decrease`,`shop_credits`,`web_credits`,`shop_credits_money`,`web_credits_money`,`credits_remark`,`pre_sale`,`introducer`) values ('".$time."','".$time."','".$k."','".@$_SESSION['monxin']['username']."','".$receiver."','".$all_money."','".($actual_money)."','','".$pay_method."','monxin','".$actual_money."','0','".$state."','".$v['preferential_way']."','".$delivery_time."','".$v['remark']."','".$v['express']."','".$v['preferential_code']."','".$weight."','".$express_cost."','".($actual_money+$credits_money)."','".$re['name']."','".$re['phone']."','".$re['area_id']."','".$re['detail']."','".$re['post_code']."','".get_area_name($pdo,$re['area_id'])."','".$goods_names."','".@$_SESSION['share']."','".$goods_cost."','".$goods_count."','0','".$credits."','".$_GET['credits']."','".$credits_money."','".$_GET['credits_money']."','".$credits_remark."','".$pre_sale."','".$introducer."')";
		

		if($pdo->exec($sql)){
			$order_id=$pdo->lastInsertId();
			self::set_order_out_id($pdo,$order_id);
			
			if($bargain>0){
				$sql="update ".$pdo->sys_pre."bargain_log set `state`=4,`order_money`=".$bargain.",`order_id`=".$order_id." where `id`=".$bargain_log;
				if($pdo->exec($sql)){
					$sql="update ".$pdo->sys_pre."bargain_goods set `sum_sold`=`sum_sold`+1,`sum_money`=`sum_money`+".$bargain." where `id`=".$log['b_id'];
					$pdo->exec($sql);
					
				}
			}
			
			if($pre_sale){
				$sql="select * from ".self::$table_pre."pre_sale where `goods_id`=".$v3['id']." limit 0,1";
				$pre=$pdo->query($sql,2)->fetch(2);
				foreach($quantity as $v){$quantity=$v;}
				$sql="select `pre_discount` from ".self::$table_pre."goods where `id`=".$v3['id']." limit 0,1";
				$pre_discount=$pdo->query($sql,2)->fetch(2);
				
				$sql="insert into ".self::$table_pre."order_pre_sale (`order_id`,`deposit`,`reduction`,`last_pay_start_time`,`delivered`,`last_pay_end_time`,`pre_discount`) values ('".$order_id."','".($pre['deposit']*$quantity)."','".($pre['reduction']*$quantity)."','".$pre['last_pay_start_time']."','".$pre['delivered']."','".$pre['last_pay_end_time']."','".$pre_discount['pre_discount']."')";
				$pdo->exec($sql);
				$sql="update ".self::$table_pre."order set `state`=11,`actual_money`=".($actual_money-($pre['reduction']*$quantity)+($pre['deposit']*$quantity))." where `id`=".$order_id;
				$pdo->exec($sql);
				
				
			}
			

			$sql="select * from ".self::$table_pre."order where `id`=".$order_id;
			$order=$pdo->query($sql,2)->fetch(2);
			$_SESSION['monxin_mall_order_id'].=$order_id.'|';
			
			
		if($credits>0){
			self::operator_shop_buyer_credits($pdo,$_SESSION['monxin']['username'],'-'.$credits,self::$language['credits_type']['buy_deduction'],$k);
		}
		
		if($_GET['credits']>0){
			$reason='<a href=./index.php?monxin=mall.my_order&search='.$order['out_id'].' target=_blank>'.$order['out_id'].'</a>'.self::$language['order_postfix'];
			operation_credits($pdo,self::$config,self::$language,$_SESSION['monxin']['username'],'-'.$_GET['credits'],$reason,'buy_deduction');
			$_GET['credits']=0;
		}
			
			
			
			
			foreach($order_goods_sql as $v){
				$v=str_replace('{order_id}',$order_id,$v);
				$v=str_replace('{order_state}',$state,$v);
				//file_put_contents('./test.txt',$v);
				$pdo->exec($v);	
			}
			foreach($wait_sql as $v){
				$v=str_replace('{order_id}',$order_id,$v);
				$w_state=$pdo->exec($v);	
				//if(!$w_state){echo $v;}
			}
			
		
			//如有优惠打折，更新交易价
			if($all_discount<1 && $order['preferential_way']!=5){
				$sql="select `id`,`transaction_price` from ".self::$table_pre."order_goods where `order_id`=".$order_id;
				$og=$pdo->query($sql,2);
				foreach($og as $v){
					$transaction_price=$v['transaction_price']*$all_discount;
					$sql="update ".self::$table_pre."order_goods set `transaction_price`='".$transaction_price."' where `id`=".$v['id'];
					$pdo->exec($sql);
				}
			}
			
			//从购物车中删除 已购商城
			if($goods_src=='selected_goods'){
				//var_dump($mall_cart);
				if(count($mall_cart)==0){
					setcookie("mall_cart",'');
					$_COOKIE['mall_cart']='';
					self::update_cart($pdo,self::$table_pre);	
				}else{
					setcookie("mall_cart",json_encode($mall_cart));	
					$_COOKIE['mall_cart']=json_encode($mall_cart);
					self::update_cart($pdo,self::$table_pre);	
				}
				//self::update_cart($pdo,self::$table_pre);
			}
			$_SESSION['mall_buy_quantity']++;
			$sql="select * from ".self::$table_pre."order where `id`=".$order_id;
			$order=$pdo->query($sql,2)->fetch(2);
			self::decrease_goods_quantity($pdo,self::$table_pre,$order);
			self::order_notice(self::$language,self::$config,$pdo,self::$table_pre,$order);
			self::update_goods_monthly($pdo,self::$table_pre,$order);
			self::set_order_goods_barcode($pdo,$order_id);

			$order_sum++;
		}

		
	}
	if($order_sum>0){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span><script>window.location.href=\"index.php?monxin=".self::$config['class_name'].".pay\";</script>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");	
	}
	
	
	exit;	
}

//==================================================================================================================================【提交订单 end】

//==================================================================================================================================【查询优惠码代金券 优惠金额】
if($act=='preferential_code'){
	$shop_id=intval(@$_GET['shop_id']);
	$code=safe_str(@$_GET['code'],1,0);
	if($shop_id==0){exit("{'state':'fail','info':'<span class=fail>shop_id err</span>'}");}
	if($code==''){exit("{'state':'fail','info':'<span class=fail>code null</span>'}");}
	$promotion_money=floatval(@$_GET['promotion_money']);
	$all_money=floatval(@$_GET['all_money']);
	if($all_money==0){exit("{'state':'fail','info':'<span class=fail>all_money err</span>'}");}
	$type=intval(@$_GET['type']);
	if($type!=7 && $type!=4 && $type!=6){exit("{'state':'fail','info':'<span class=fail>type err</span>'}");}
	$time=time();
	if($type==7){//单次购物券
		$sql="select * from ".self::$table_pre."buy_coupon_list where `shop_id`=".$shop_id." and `code`='".$code."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){
			$sql="select * from ".self::$table_pre."buy_coupon_list where `code`='".$code."' limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['not_exist']."</span>'}");}
			exit("{'state':'fail','info':'<span class=fail>".self::$language['not_this_shop']."</span>'}");
		}
		if($r['use_time']>0){exit("{'state':'fail','info':'<span class=fail>".self::$language['has_been_used']."</span>'}");}
		
		$sql="select * from ".self::$table_pre."buy_coupon where `id`=".$r['coupon_id'];
		$r=$pdo->query($sql,2)->fetch(2);
		
		if($r['start_time']>$time){exit("{'state':'fail','info':'<span class=fail>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$r['start_time']).self::$language['can_be_use']."</span>'}");}	
		if($r['end_time']<$time){exit("{'state':'fail','info':'<span class=fail>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$r['start_time']).self::$language['has_expired']."</span>'}");}	
		
		if($r['join_goods']==0){//仅参加促销的商品 可使用
			if($promotion_money>=$r['min_money']){
				if($r['amount']>$promotion_money){$r['amount']=$promotion_money;}
				$r['amount']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$r['amount']);
				exit("{'state':'success','info':'<span class=success>&nbsp;</span>','money':'-".$r['amount']."'}");	
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['join_goods_front'][0].$promotion_money.self::$language['yuan'].self::$language['not_reached'].': '.$r['min_money']."</span>'}");
			}
		}
		if($r['join_goods']==1){//全店商品 可使用
			if($all_money>=$r['min_money']){
				if($r['amount']>$all_money){$r['amount']=$all_money;}
				$r['amount']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$r['amount']);
				exit("{'state':'success','info':'<span class=success>&nbsp;</span>','money':'-".$r['amount']."'}");	
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['can_not_be_used_the_amount_of_goods_is_not_up_to'].': '.$r['min_money']."</span>'}");
			}
		}
		if($r['join_goods']==2){//不参加促销的商品 可使用
			if($all_money-$promotion_money>=$r['min_money']){
				if($r['amount']>$all_money){$r['amount']=$all_money-$promotion_money;}
				$r['amount']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$r['amount']);
				exit("{'state':'success','info':'<span class=success>&nbsp;</span>','money':'-".$r['amount']."'}");	
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['join_goods_front'][2].($all_money-$promotion_money).self::$language['yuan'].self::$language['not_reached'].': '.$r['min_money']."</span>'}");
			}
		}
		
	}
	if($type==4){//纸质代金券
		if(isset($_SESSION['monxin']['username'])){
			$sql="select `id` from ".self::$table_pre."order where `buyer`='".$_SESSION['monxin']['username']."' and `preferential_code`='".$code."' and `state` in (0,1,2,6) limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['limit_per_person']."</span>'}");}
			
		}
		
		$sql="select * from ".self::$table_pre."vouchers where `number`='".$code."' and `shop_id`=".$shop_id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['not_exist']."</span>'}");}
		if($r['start_time']>$time){exit("{'state':'fail','info':'<span class=fail>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$r['start_time']).self::$language['can_be_use']."</span>'}");}	
		if($r['end_time']<$time){exit("{'state':'fail','info':'<span class=fail>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$r['start_time']).self::$language['has_expired']."</span>'}");}	
		if($r['use_quantity']>=$r['sum_quantity']){exit("{'state':'fail','info':'<span class=fail>".self::$language['has_been_used']."</span>'}");}
		if($r['join_goods']==0){//仅参加促销的商品 可使用
			if($promotion_money>=$r['min_money']){
				if($r['amount']>$promotion_money){$r['amount']=$promotion_money;}
				$r['amount']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$r['amount']);
				exit("{'state':'success','info':'<span class=success>&nbsp;</span>','money':'-".$r['amount']."'}");	
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['join_goods_front'][0].$promotion_money.self::$language['yuan'].self::$language['not_reached'].': '.$r['min_money']."</span>'}");
			}
		}
		if($r['join_goods']==1){//全店商品 可使用
			if($all_money>=$r['min_money']){
				if($r['amount']>$all_money){$r['amount']=$all_money;}
				$r['amount']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$r['amount']);
				exit("{'state':'success','info':'<span class=success>&nbsp;</span>','money':'-".$r['amount']."'}");	
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['can_not_be_used_the_amount_of_goods_is_not_up_to'].': '.$r['min_money']."</span>'}");
			}
		}
		if($r['join_goods']==2){//不参加促销的商品 可使用
			if($all_money-$promotion_money>=$r['min_money']){
				if($r['amount']>$all_money){$r['amount']=$all_money-$promotion_money;}
				$r['amount']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$r['amount']);
				exit("{'state':'success','info':'<span class=success>&nbsp;</span>','money':'-".$r['amount']."'}");	
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['join_goods_front'][2].($all_money-$promotion_money).self::$language['yuan'].self::$language['not_reached'].': '.$r['min_money']."</span>'}");
			}
		}
		
	}
	
	if($type==6){//推荐码
		$s_id=intval(@$_GET['s_id']);
		$id=intval(@$_GET['id']);
		$sql="select `id`,`username` from ".$pdo->index_pre."user where `recommendation`='".$code."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){
			exit("{'state':'fail','info':'<span class=fail>".self::$language['not_exist']."</span>'}");
		}
		
		$sql="select `id` from ".self::$table_pre."order_goods where `goods_id`=".$id." and `buyer`='".$r['username']."' and `order_state`=6 limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){
			exit("{'state':'fail','info':'<span class=fail>".self::$language['have_no_right_to_recommend']."</span>'}");
		}
		
		$sql="select `recommendation_discount` from ".self::$table_pre."shop where `id`=".$shop_id;
		$r=$pdo->query($sql,2)->fetch(2);
		$recommendation_discount=$r['recommendation_discount'];
		
		$sql="select `recommendation`,`w_price`,`option_enable` from ".self::$table_pre."goods where `id`=".$id." and `shop_id`=".$shop_id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['recommendation']!=1){exit("{'state':'fail','info':'<span class=fail>goods err</span>'}");}
		if($r['option_enable']){
			$sql="select `w_price` from ".self::$table_pre."goods_specifications where `id`=".$s_id." and `goods_id`=".$id;
			$r=$pdo->query($sql,2)->fetch(2);
		}
		if($r['w_price']==''){exit("{'state':'fail','info':'<span class=fail>goods err</span>'}");}
		if(!is_numeric($_GET['quantity'])){exit("{'state':'fail','info':'<span class=fail>quantity err</span>'}");}
		$decrease=$r['w_price']-($recommendation_discount/10*$r['w_price']);
		$decrease=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$decrease);
		
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>','money':'-".$decrease*$_GET['quantity']."'}");
		
	}
	
	exit;	
}

//==================================================================================================================================【查询收货人信息】
if($act=='get_receiver'){
	$id=intval(@$_GET['id']);
	if($id==0){exit('id err');}
	$sql="select * from ".self::$table_pre."receiver where `id`='".$id."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit('id err');}
	$power=false;
	if($r['username']==''){
		if($_SESSION['receiver_id']==$r['id']){$power=true;}
	}else{
		if(@$_SESSION['monxin']['username']==$r['username']){$power=true;}
	}
	$r=de_safe_str($r);
	$top_id=self::get_area_top_id($pdo,$r['area_id']);
	$ids=get_area_parent_ids($pdo,$r['area_id']);
	if($r['post_code']!=''){$r['post_code']='('.$r['post_code'].')';}
	if($r['tag']!=''){$r['tag']='<span class=tag ><span>'.$r['tag'].'</span></span>';}
	echo '<div class=receiver_head><span class=name>'.$r['name'].'</span>'.$r['tag'].'</div>
                        <div class=phone>'.$r['phone'].'</div>
                        <div class=area_id>'.get_area_name($pdo,$r['area_id']).'</div>
                        <div class=detail>'.$r['detail'].$r['post_code'].'</div>
						<div class=edit>'.self::$language['edit'].'</div>
						<div class=top_id>'.$top_id.'</div>
						<div class=ids>'.$ids.'</div>
						';
	exit;	
}

