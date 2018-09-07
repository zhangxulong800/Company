<?php
$act=@$_GET['act'];
//==================================================================================================================================【提交订单 start】
if($act=='submit_checkout'){
	$credits_money=0;
	$shop_credits_money=0;
	$shop_credits=0;
	$web_credits=0;
	$shop_credits_value=0;
	$web_credits_value=0;
	$credits_remark='';
	$stocking=intval($_POST['stocking']);
	if($stocking!=0 && $stocking!=1 && $stocking!=6){$stocking=0;}
	if($_POST['user']!=''){
		$username=safe_str($_POST['user']);
		$where='';
		if(preg_match(self::$config['other']['reg_phone'],$username)){
			$where="`phone`='".$username."'";
			$sql="select `id`,`real_name`,`nickname`,`money`,`state`,`username`,`credits` from ".$pdo->index_pre."user where ".$where." limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']==''){$where='';}
		}
		if($where==''){
			$u=self::chip_inquiry_shop_buyer($pdo,$username,SHOP_ID);
			if($u!=''){
				$where="`username`='".$u."'";
			}else{
				$where="`chip`='".$username."'";
			}
		}
		$sql="select `id`,`real_name`,`nickname`,`money`,`state`,`username`,`transaction_password`,`credits` from ".$pdo->index_pre."user where ".$where." limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){
			$sql="select `id`,`real_name`,`nickname`,`money`,`state`,`username`,`transaction_password`,`credits` from ".$pdo->index_pre."user where `chip`='".$username."' limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
		}
		if($r['id']==''){
			$sql="select `id`,`real_name`,`nickname`,`money`,`state`,`username`,`transaction_password`,`credits` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
		}
		
		if($r['id']==''){exit('{"state":"fail","info":"<span class=fail>'.self::$language['username'].self::$language['not_exist'].'</span>"}');}
		if($r['state']!=1){exit('{"state":"fail","info":"<span class=fail>'.self::$language['username'].self::$language['user_state'][$r['state']].'</span>"}');}
		$buyer=$r;
		$buyer['shop_balance']=0;
		$sql="select `group_id`,`balance`,`credits` from ".self::$table_pre."shop_buyer where `shop_id`=".SHOP_ID." and `username`='".$buyer['username']."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		
		if($r['group_id']!=''){
			$buyer['shop_balance']=$r['balance'];
			$buyer['shop_credits']=$r['credits'];
			$sql="select `name`,`discount`,`id` from ".self::$table_pre."shop_buyer_group  where `id`=".$r['group_id'];
			$group=$pdo->query($sql,2)->fetch(2);
			if($group['name']!=''){
				$buyer['group_name']=$group['name'];
				$buyer['group_discount']=$group['discount'];
				$buyer['group_id']=$group['id'];
			}else{
				$buyer['group_name']='';
				$buyer['group_discount']=10;
				$buyer['group_id']=0;
			}	
		}else{
				$buyer['group_name']='';
				$buyer['group_discount']=10;
				$buyer['group_id']=0;
		}
		
	}
	//========================================================================积分检测
	$credits_money=floatval($_POST['credits_money']);
	$credits_use=floatval($_POST['credits_use']);
	$credits_type=safe_str($_POST['credits_type']);
	if($credits_money>0){
		$sql="select * from ".self::$table_pre."shop_order_set where `shop_id`=".SHOP_ID;
		$order_set=$pdo->query($sql,2)->fetch(2);
		$shop_credits_rate=1/$order_set['credits_rate'];
		$web_credits_rate=self::$config['credits_set']['rate'];
				
		if($credits_type=='web_credit'){
			if($buyer['credits']<$credits_use){exit('{"state":"fail","info":"<span class=fail>'.self::$language['credits'].self::$language['greater_than'].$buyer['credits'].'</span>"}');}
			$credits_value=$credits_use*$web_credits_rate;
			$credits_remark=self::$language['use_web_credits'].':'.$credits_use.','.self::$language['deduction'].self::$language['money_symbol'].$credits_money;
			$web_credits=$credits_use;
			$web_credits_value=$credits_money;
		}else{
			if($buyer['shop_credits']<$credits_use){exit('{"state":"fail","info":"<span class=fail>'.self::$language['credits'].self::$language['greater_than'].$buyer['shop_credits'].'</span>"}');}
			$credits_value=$credits_use*$shop_credits_rate;
			$shop_credits_money=$credits_money;
			$credits_remark=self::$language['use_shop_credits'].':'.$credits_use.','.self::$language['deduction'].self::$language['money_symbol'].$credits_money;
			$shop_credits=$credits_use;
			$shop_credits_value=$credits_money;
		}
		if($credits_value<$credits_money){exit('{"state":"fail","info":"<span class=fail>'.self::$language['credits'].' err</span>"}');}	
	}
	
	
	$sql="select * from ".self::$table_pre."shop where `id`=".SHOP_ID;
	$r2=$pdo->query($sql,2)->fetch(2);
	$seller=$r2['username'];
	$shop_info=$r2;
	$web_c_password=$r2['web_c_password'];
	$shop_c_password=$r2['shop_c_password'];
	
	
	$checkout_desk=json_decode(@$_COOKIE['checkout_desk'],true);
	if(!is_array($checkout_desk)){$checkout_desk=array();}
	$_POST=safe_str($_POST);
	
	$pay_method=$_POST['pay_method'];
	$reference_number=@$_POST['reference_number'];
	if($pay_method!='cash' && $pay_method!='pos' && $pay_method!='credit' && $pay_method!='balance' && $pay_method!='shop_balance' && $pay_method!='weixin' && $pay_method!='alipay' && $pay_method!='weixin_p' && $pay_method!='alipay_p' && $pay_method!='meituan' && $pay_method!='nuomi' && $pay_method!='other'){exit('{"state":"fail","info":"<span class=fail>pay_method err</span>"}');}
	if(($pay_method=='credit' || $pay_method=='balance' || $pay_method=='shop_balance') && @$_POST['user']==''){exit('{"state":"fail","info":"<span class=fail>user err</span>"}');}
	if(@$_COOKIE['checkout_desk']==''){exit('{"state":"fail","info":"<span class=fail>goods is null</span>"}');}
	$preferential_way=intval($_POST['preferential_way']);
	if($preferential_way!=2 && $preferential_way!=7 && $preferential_way!=4 && $preferential_way!=5 && $preferential_way!=8){exit('{"state":"fail","info":"<span class=fail>preferential_way err</span>"}');}
	$goods_money=floatval($_POST['goods_money']);
	$payable=floatval($_POST['payable']);
	if($goods_money==0 ){exit('{"state":"fail","info":"<span class=fail>'.self::$language['money'].self::$language['err'].'</span>"}');}
	
	$cost=0;
	$money_count=0;
	$promotion_money=0;
	$vip_money=0;
	$goods_info='';	
	$order_goods_sql=array();
	$wait_sql=array();
	$goods_names='';
	$goods_cost=0;
	$goods_count=0;
	$group_reduce=0;
	$introducer=0;
	$pay_2=0;
	//var_dump($_COOKIE['checkout_desk']);
	//打折...
	$discount=self::get_shop_discount($pdo,SHOP_ID);
	$checkout_desk=json_decode($_COOKIE['checkout_desk'],true);
	//var_dump($checkout_desk);

	$spec=array();
	$spec_ids='';
	foreach($checkout_desk as $key=>$v){
		$temp=explode('_',$key);
		if(isset($temp[1])){
			$spec[$temp[0]]=$temp[1];
			$spec_ids.=$temp[1].',';
		}
	}
	
	$spec_ids=trim($spec_ids,',');
	if($spec_ids!=''){
		$sql="select `id`,`color_name`,`option_id`,`e_price`,`color_img`,`cost_price` from ".self::$table_pre."goods_specifications where `id` in (".$spec_ids.")";
		$r=$pdo->query($sql,2);
		$spec2=array();
		foreach($r as $v){
			$spec2[$v['id']]['id']=$v['id'];
			$spec2[$v['id']]['e_price']=$v['e_price'];
			$spec2[$v['id']]['color_img']=$v['color_img'];
			$spec2[$v['id']]['color_name']=$v['color_name'];
			$spec2[$v['id']]['cost_price']=$v['cost_price'];
			$spec2[$v['id']]['option_name']=self::get_type_option_name($pdo,$v['option_id']);
		}	
	}
	$time=time();
	foreach($checkout_desk as $key=>$v){
		
		$s_id=0;
		$temp=explode('_',$key);
		$sql="select `id`,`title`,`e_price`,`unit`,`sales_promotion`,`icon`,`cost_price`,`introducer_rate` from ".self::$table_pre."goods where id='".intval($temp[0])."' and `state`!=0 and `shop_id`=".SHOP_ID;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){continue;}
		if(isset($temp[1])){
			$s_id=$temp[1];
			$price=$spec2[$temp[1]]['e_price'];
			$spec_info=$spec2[$temp[1]]['color_name'].' '.$spec2[$temp[1]]['option_name'];
			if($spec2[$temp[1]]['color_img']!=''){$icon=$spec2[$temp[1]]['color_img'];}else{$icon=$r['icon'];}
			$cost+=$spec2[$temp[1]]['cost_price']*$checkout_desk[$key]['quantity'];
			$cost_price=self::get_cost_price($pdo,$temp[0].'_'.$temp[1]);
		}else{
			$price=$r['e_price'];
			$spec_info='';
			$icon=$r['icon'];
			$cost_price=self::get_cost_price($pdo,$temp[0]);
		}
		$normal_price=$price;
		$favorite='';
		$goods_group_price=array();
		if($preferential_way==5 && $_POST['user']!=''){//====================================================优惠方式:店内用户组
			if($r['sales_promotion']){
				$sql="select `discount` from ".self::$table_pre."goods_group_discount where `goods_id`=".$r['id']." and `group_id`=".$buyer['group_id']." limit 0,1";
				$ggd=$pdo->query($sql,2)->fetch(2);
				if($ggd['discount']){
					$goods_group_discount=$ggd['discount'];
				}else{
					$goods_group_discount=$buyer['group_discount'];	
				}				
			
				$goods_group_price[$key]=$price*$goods_group_discount/10;
				$group_reduce+=($price-($price*$goods_group_discount/10))*$checkout_desk[$key]['quantity'];
				//var_dump(($price-($price*$buyer['group_discount']/10))*$checkout_desk[$key]['quantity']);
			}else{
				$goods_group_price[$key]=$price;
			}
			
		}else{	
			if($discount<10 && ($_POST['discount_join_goods'] || $r['sales_promotion'])){$price=sprintf("%.2f",$price*$discount/10);}
		}
		
		if($r['sales_promotion']){$promotion_money+=$price*$checkout_desk[$key]['quantity'];$sales_promotion='<span class=sales_promotion>'.self::$language['sales_promotion_short'].'</span>';}else{$sales_promotion='';}
		

		$title=$r['title']." ".$spec_info;
		$r['title']=$title;
		if(mb_strlen($title,'utf-8')>23){
			if($spec_info!=''){
				$title=mb_substr($title,0,8,'utf-8').'...'.mb_substr($title,mb_strlen($title,'utf-8')-14,14,'utf-8');
			}else{
				$title=mb_substr($title,0,21,'utf-8').'...';
			}
			
		}
		$goods_info.='<div class=goods>'.$title.' <span>'.self::$language['money_symbol'].str_replace('.00','',$price).'*'.$checkout_desk[$key]['quantity'].self::get_mall_unit_name($pdo,$r['unit']).'='.str_replace('.00','',$price*$checkout_desk[$key]['quantity']).'</span></div>';	

		$temp=explode('/',$icon);
		@mkdir('./program/mall/order_icon/'.$temp[0]);
		@mkdir('./program/mall/order_icon/'.$temp[0].'/'.$temp[1]);
		if(!file_exists('./program/mall/order_icon/'.$icon)){@copy('./program/mall/img/'.$icon,'./program/mall/order_icon/'.$icon);}

		$temp_sql="select `id` from ".self::$table_pre."goods_snapshot where `goods_id`='".$r['id']."' order by `id` desc limit 0,1";
		$temp_r=$pdo->query($temp_sql,2)->fetch(2);
		$snapshot_id=(isset($temp_r['id']))?$temp_r['id']:0;
		if($preferential_way==5){$transaction_price=$goods_group_price[$key];}else{$transaction_price=$price;}
		
		
		$order_goods_sql[]="insert into ".self::$table_pre."order_goods (`goods_id`,`s_id`,`shop_id`,`order_id`,`snapshot_id`,`icon`,`title`,`quantity`,`price`,`transaction_price`,`unit`,`time`,`buyer`,`order_state`,`cost_price`) values ('".$r['id']."','".$s_id."','".SHOP_ID."','{order_id}','".$snapshot_id."','".$icon."','".$r['title']."','".$checkout_desk[$key]['quantity']."','".$price."','".$transaction_price."','".self::get_mall_unit_name($pdo,$r['unit'])."','".$time."','".@$buyer['username']."','6','".$cost_price."')";
		$goods_names.=$r['title']."
		";;
		$money_count+=$price*$checkout_desk[$key]['quantity'];
		$vip_money+=$price*$checkout_desk[$key]['quantity'];
		//$vip_money+=($normal_price*$r['my_vip_discount']/10)*$checkout_desk[$key]['quantity'];
	
		$goods_cost+=$cost_price*$checkout_desk[$key]['quantity'];
		$goods_count+=$checkout_desk[$key]['quantity'];
		
		//计算会员注册推荐人返佣
		if(isset($buyer['username']) && $r['introducer_rate']>0){
			$introducer+=$price*$checkout_desk[$key]['quantity']*$r['introducer_rate']/100;
		}
		

	}
	
	
	$money_count=sprintf("%.2f",$money_count);
	if($money_count!=sprintf("%.2f",$goods_money)){exit('{"state":"fail","info":"<span class=fail>'.self::$language['money'].self::$language['err'].$money_count.'!='.sprintf("%.2f",$goods_money).'</span><script>window.location.reload();</script>"}');}
	$inpromotion_money=$money_count-$promotion_money;

	if($preferential_way==5){//优惠方式:店内用户组		
		$d_max=$group_reduce;	
	}		
		
	if($preferential_way==2){//====================================================优惠方式:满元优惠
		function get_less_money($v,$money,$type){
			if($v['use_method']==0){
				//打折
				return $money*((10-$v['discount'])/10);
			}
			if($v['use_method']==1){
				//减钱
				return $v['less_money'];
			}
			return 0;
		}
		$ful=self::get_fulfil_preferential_json($pdo,self::$table_pre);
		$ful=json_decode($ful,1);
		$less_money=array();
		foreach($ful as $v){
			if($v['min_money']<=$money_count && $v['join_goods']==1){$less_money[]=get_less_money($v,$money_count,'');}	
			if($v['min_money']<=$promotion_money && $v['join_goods']==0){$less_money[]=get_less_money($v,$promotion_money,'');}	
			if($v['min_money']<=$inpromotion_money && $v['join_goods']==2){$less_money[]=get_less_money($v,$inpromotion_money,'');}	
		}
		$d_max=0;
		foreach($less_money as $v){
			if($v>$d_max){$d_max=$v;}
		}
	}
	
	if($preferential_way==7){//====================================================单次购物券
		$code=$_POST['preferential_code'];
		if($code==''){exit('{"state":"fail","info":"<span class=fail>'.self::$language['preferential_way_option'][7].' is null</span>"}');}

		$time=time();
		if($money_count<=0){exit('{"state":"fail","info":"<span class=fail>sum_money err</span>"}');}

		$sql="select * from ".self::$table_pre."buy_coupon_list where `shop_id`=".SHOP_ID." and `code`='".$code."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		
		if($r['id']==''){
			$sql="select * from ".self::$table_pre."buy_coupon_list where `code`='".$code."' limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['not_exist']."</span>'}");}
			exit("{'state':'fail','info':'<span class=fail>".self::$language['not_this_shop']."</span>'}");
		}
		if($r['use_time']>0){exit("{'state':'fail','info':'<span class=fail>".self::$language['has_been_used']."</span>'}");}
		if($r['order_id']!=0){exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][3].self::$language['has_been_used']."</span>'}");}
		$buy_coupon_list_id=$r['id'];
		$buy_coupon_list_coupon_id=$r['coupon_id'];
		
		$sql="select * from ".self::$table_pre."buy_coupon where `id`=".$r['coupon_id'];
		$r=$pdo->query($sql,2)->fetch(2);

		if($r['start_time']>$time){exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][3].get_time('m-d',self::$config['other']['timeoffset'],self::$language,$r['start_time']).self::$language['can_be_use']."</span>'}");}	
		if($r['end_time']<$time){exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][3].get_time('m-d',self::$config['other']['timeoffset'],self::$language,$r['start_time']).self::$language['has_expired']."</span>'}");}	
		$d_max=0;
		if($r['join_goods']==0){
			if($promotion_money>=$r['min_money']){$d_max=$r['amount'];}
		}
		if($r['join_goods']==1){
			if($money_count>=$r['min_money']){$d_max=$r['amount'];}
		}
		if($r['join_goods']==2){
			if($money_count-$promotion_money>=$r['min_money']){$d_max=$r['amount'];}
		}
		if($d_max==0){
			if($r['join_goods']==1){$l=self::$language['goods_is_not_up_to'];}	
			if($r['join_goods']==0){$l=self::$language['join_goods_front'][0].self::$language['not_reached'];}	
			if($r['join_goods']==2){$l=self::$language['join_goods_front'][2].self::$language['not_reached'];}
			exit("{'state':'fail','info':'<span class=fail>".$l.$r['min_money']."</span>'}");
		}
		if($d_max>$money_count){$d_max=$money_count;}
		$wait_sql[]="update ".self::$table_pre."coupon_code set `use_order_id`={order_id} where `id`=".$r['id'];
		
		$wait_sql[]="update ".self::$table_pre."buy_coupon_list set `order_id`={order_id},`use_time`=".time().",`buyer`='".@$buyer['username']."' where `id`=".$buy_coupon_list_id;
		$wait_sql[]="update ".self::$table_pre."buy_coupon set `use_quantity`=`use_quantity`+1 where `id`=".$buy_coupon_list_coupon_id;
	}
	
	if($preferential_way==4){//====================================================优惠方式:纸质代金券
		
		$code=$_POST['preferential_code'];
		if($code==''){exit('{"state":"fail","info":"<span class=fail>'.self::$language['preferential_way_option'][4].' is null</span>"}');}
		$sql="select * from ".self::$table_pre."vouchers where `number`='".$code."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		$time=time();
		if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][4].self::$language['not_exist']."</span>'}");}
		if($r['start_time']>$time){exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][4].get_time('m-d',self::$config['other']['timeoffset'],self::$language,$r['start_time']).self::$language['can_be_use']."</span>'}");}	
		if($r['end_time']<$time){exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][4].get_time('m-d',self::$config['other']['timeoffset'],self::$language,$r['start_time']).self::$language['has_expired']."</span>'}");}	
		if($r['sum_quantity']<=$r['use_quantity']){exit("{'state':'fail','info':'<span class=fail>".self::$language['preferential_way_option'][4].self::$language['has_been_used']."</span>'}");}
		$d_max=0;
		if($r['join_goods']==0){
			if($promotion_money>=$r['min_money']){$d_max=$r['amount'];}
		}
		if($r['join_goods']==1){
			if($money_count>=$r['min_money']){$d_max=$r['amount'];}
		}
		if($r['join_goods']==2){
			if($money_count-$promotion_money>=$r['min_money']){$d_max=$r['amount'];}
		}
		if($d_max==0){
			if($r['join_goods']==1){$l=self::$language['goods_is_not_up_to'];}	
			if($r['join_goods']==0){$l=self::$language['join_goods_front'][0].self::$language['not_reached'];}	
			if($r['join_goods']==2){$l=self::$language['join_goods_front'][2].self::$language['not_reached'];}
			exit("{'state':'fail','info':'<span class=fail>".$l.$r['min_money']."</span>'}");
		}
		$wait_sql[]="update ".self::$table_pre."vouchers set `use_quantity`=`use_quantity`+1 where `id`=".$r['id'];
	}
	if($preferential_way==8){//====================================================优惠方式:自设成交价
		$d_max=$money_count-$payable;
		$_POST['preferential_code']='';
	}
	
	/*if(sprintf("%.2f",$money_count-$d_max)!=sprintf("%.2f",$payable)){exit('{"state":"fail","info":"<span class=fail>'.self::$language['money'].self::$language['err'].':'.$money_count.'-'.$d_max.'!='.$payable.'</span><script>window.location.reload();</script>"}');}*/
	
	
	if($credits_money!=0 && $shop_credits_money==0){
		$payable+=$credits_money;
		$_POST['received_money']=$payable;
		//var_dump($d_max);var_dump($payable);exit;
	}else{
		$d_max+=$shop_credits_money;
	}
	$difference=sprintf("%.2f",$money_count-$d_max)-sprintf("%.2f",$payable);
	if($difference<-1 || $difference>1){exit('{"state":"fail","info":"<span class=fail>'.self::$language['money'].self::$language['err'].':'.$money_count.'-'.$d_max.'!='.$payable.'</span><script>window.location.reload();</script>"}');}
	
	if($pay_method=='alipay' || $pay_method=='weixin'){
		$sql="select `id`,`money`,`state`,`time`,`settlement` from ".$pdo->sys_pre."scanpay_pay where `id`='".intval($_POST['scanpay_id'])."'";	
		$pay=$pdo->query($sql,2)->fetch(2);
		if($pay['id']==''){exit('{"state":"fail","info":"<span class=fail>scanpay_id err</span>"}');}
		$difference=$pay['money']-($payable-$web_credits_value);
		if($difference<-1 || $difference>1){exit('{"state":"fail","info":"<span class=fail>scanpay money err '.$pay['money'].'!='.$payable.'-'.$web_credits_value.'</span>"}');}
		if($pay['state']!=3){exit('{"state":"fail","info":"<span class=fail>scanpay state err</span>"}');}
		if($pay['state']!=3){exit('{"state":"fail","info":"<span class=fail>scanpay state err</span>"}');}
		if($pay['time']<time()-60*30){exit('{"state":"fail","info":"<span class=fail>scanpay timeout</span>"}');}
		if($pay['settlement']==1){exit('{"state":"fail","info":"<span class=fail>scanpay settlemented</span>"}');}
	}
	
	if($_POST['user']!=''){
		if($seller==$buyer['username']){exit('{"state":"fail","info":"<span class=fail>'.self::$language['can_not_buy_your_goods'].'</span>"}');}
		if($pay_method=='shop_balance' && $shop_c_password==0){
			if(@$_POST['transaction_password']=='' && intval(@$_POST['checkout_id'])==0){exit('{"state":"fail","info":"<span class=fail>'.self::$language['please_input'].self::$language['transaction_password'].'</span>"}');}
		}
		if($pay_method=='balance' && $web_c_password==0){
			if(@$_POST['transaction_password']=='' && intval(@$_POST['checkout_id'])==0){exit('{"state":"fail","info":"<span class=fail>'.self::$language['please_input'].self::$language['transaction_password'].'</span>"}');}
		}
		
		
		if(@$_POST['transaction_password']!=''){
			$pre=mb_substr($_POST['transaction_password'],0,5,'utf-8');
			$postfix=mb_substr($_POST['transaction_password'],5);
			if($pre=='6666_' && strlen($postfix)==8){
				$qr_info=get_qr_pay_info($pdo,$postfix);
				if($qr_info['id']!=''){
					if($qr_info['username']!=$buyer['username']){
						exit('{"state":"fail","info":"<span class=fail>'.self::$language['only_self_pay_code'].'</span>","qr_pay":1}');
					}
					$buyer['qr_pay']=$qr_info['id'];
				}else{
					exit('{"state":"fail","info":"<span class=fail>'.self::$language['pay_code_err'].'</span>","qr_pay":1}');
				}
			}else{
				if(md5($_POST['transaction_password'])!=$buyer['transaction_password']){exit('{"state":"fail","info":"<span class=fail>'.self::$language['transaction_password'].self::$language['err'].'</span>"}');}
			}
		}
		

		if(intval(@$_POST['checkout_id'])!=0 && $pay_method!='cash' && @$_POST['transaction_password']==''){
			$need_password=1;
			if($pay_method=='shop_balance' && $shop_c_password==1){
				$need_password=0;
			}
			if($pay_method=='balance' && $web_c_password==1){
				$need_password=0;
			}
			
			if($need_password){
				$checkout_id=intval($_POST['checkout_id']);
				$sql="select * from ".self::$table_pre."checkout where `id`=".$checkout_id;
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['state']!=2){exit('{"state":"fail","info":"<span class=fail>'.self::$language['transaction_password'].self::$language['err'].'</span>"}');}
				if(de_safe_str($r['goods'])!=$_COOKIE['checkout_desk']){exit('{"state":"fail","info":"<span class=fail>checkout_id err</span>"}');}
				
			}
			
		}


		
		if($pay_method=='balance'){
			if($buyer['money']<$payable){
				//
				$remaining=$payable-$buyer['money'];
				$remaining=sprintf("%.2f",$remaining);
				$reason=self::$language['web_part_cash_reason'];
				$reason=str_replace('{buyer}',$buyer['username'],$reason);
				
				$sql="select `money` from ".$pdo->index_pre."user where `username`='".$shop_info['username']."'";
				$seller_u=$pdo->query($sql,2)->fetch(2);
				//if($seller_u['money']<$remaining){exit('{"state":"fail","info":"<span class=fail>'.self::$language['seller'].self::$language['insufficient_balance'].'</span>"}');}

				if(operator_money(self::$config,self::$language,$pdo,$shop_info['username'],'-'.$remaining,$reason,self::$config['class_name'],1)){
					if(operator_money(self::$config,self::$language,$pdo,$buyer['username'],$remaining,$reason,self::$config['class_name'])){
						$pay_2=$remaining;
						
					}else{
						$sql="delete from ".$pdo->index_pre."money_transfer where `id`='$insret_id'";
						if(!$pdo->exec($sql)){add_err_log($sql);}
						operator_money(self::$config,self::$language,$pdo,$shop_info['username'],$remaining,self::$language['return'].self::$language['transfer'].self::$language['to'].$buyer['username'],self::$config['class_name']);
						
						exit('{"state":"fail","info":"<span class=fail>'.self::$language['insufficient_balance'].'</span>"}');
					}
					$buyer['money']=$payable;	
				}
		


			}
		}
		if($pay_method=='shop_balance'){
			if($buyer['shop_balance']<$payable){
				//
				$remaining=$payable-$buyer['shop_balance'];
				$remaining=sprintf("%.2f",$remaining);
				$reason=self::$language['shop_part_cash_reason'];
				$reason=str_replace('{buyer}',$buyer['username'],$reason);
				if(!self::operator_shop_buyer_balance($pdo,$buyer['username'],$remaining,$reason,$_SESSION['monxin']['username'])){
					exit('{"state":"fail","info":"<span class=fail>'.self::$language['insufficient_balance'].'</span>"}');
				}
				$buyer['shop_balance']=$payable;
							
			}
		}
		
		
		
	}
	if($pay_method=='cash' && is_numeric($_POST['received_money'])){
		$received_money=sprintf("%.2f",floatval(@$_POST['received_money']));
		$payable=sprintf("%.2f",floatval($payable));
		if($received_money==0){$received_money=$payable;}
		//var_dump($received_money);var_dump($payable);exit;
		
		if($received_money<$payable  && !monxin_number_difference($pay['money'],$payable,0.3)){exit('{"state":"fail","info":"<span class=fail>received_money err</span>"}');}
		$change=$received_money-$payable;
	}else{
		$received_money=$payable;
		$change=0;	
	}
	
	$all_discount=1;
	if($money_count>0){
		$all_discount=$payable/$money_count;
		if($all_discount<1){
			$introducer=$introducer*$all_discount;	
		}
	}
		
	$sql="select `id` from ".self::$table_pre."order where `add_time`>".(time()-10)." and `shop_id`=".SHOP_ID." and `cashier`='".$_SESSION['monxin']['username']."' and `actual_money`=".$payable." and `goods_names`='".$goods_names."' limit 0,1";
	$ee=$pdo->query($sql,2)->fetch(2);
	if($ee['id']!=''){exit('{"state":"fail","info":"<span class=fail>'.self::$language['submit'].self::$language['fail'].' re</span>"}');}
	if($stocking==0){$pay_method='';}
	$sql="insert into ".self::$table_pre."order (`add_time`,`last_time`,`shop_id`,`buyer`,`receiver_id`,`goods_money`,`actual_money`,`change_price_reason`,`pay_method`,`cashier`,`received_money`,`change`,`state`,`preferential_way`,`delivery_time`,`invoice`,`buyer_remark`,`express`,`preferential_code`,`weight`,`express_cost_buyer`,`sum_money`,`goods_names`,`goods_cost`,`goods_count`,`inventory_decrease`,`reference_number`,`introducer`,`shop_credits`,`web_credits`,`shop_credits_money`,`web_credits_money`,`credits_remark`,`checkout_address`,`pay_2`) values ('".time()."','".time()."','".SHOP_ID."','".@$buyer['username']."','0','".$money_count."','".$payable."','','".$pay_method."','".$_SESSION['monxin']['username']."','".$received_money."','".$change."','".$stocking."','".$preferential_way."','0','','','0','".$_POST['preferential_code']."','0','0','".$payable."','".$goods_names."','".$goods_cost."','".$goods_count."','0','".$reference_number."','".$introducer."','".$shop_credits."','".$web_credits."','".$shop_credits_value."','".$web_credits_value."','".$credits_remark."','".$_POST['address']."','".$pay_2."')";	
	if(!$pdo->exec($sql)){
		exit('{"state":"fail","info":"<span class=fail>'.self::$language['submit'].self::$language['fail'].'</span>"}');
	}else{
		$order_id=$pdo->lastInsertId();
		if(isset($buyer['qr_pay'])){
			index_qr_pay_update($pdo,$buyer['qr_pay'],$payable,$_SESSION['monxin']['username']);
		}
		self::set_order_out_id($pdo,$order_id);
		$sql="select * from ".self::$table_pre."order where `id`=".$order_id;
		$order=$pdo->query($sql,2)->fetch(2);
		
		if($shop_credits>0){
			self::operator_shop_buyer_credits($pdo,$buyer['username'],'-'.$shop_credits,self::$language['credits_type']['buy_deduction'],SHOP_ID);
		}
		
		if($web_credits>0){
			$reason='<a href=./index.php?monxin=mall.my_order&search='.$order['out_id'].' target=_blank>'.$order['out_id'].'</a>'.self::$language['order_postfix'];
			operation_credits($pdo,self::$config,self::$language,$buyer['username'],'-'.$web_credits,$reason,'buy_deduction');
		}
		
		$_SESSION['monxin_mall_order_id']=$order_id;
		foreach($order_goods_sql as $v){
			$v=str_replace('{order_id}',$order_id,$v);
			$pdo->exec($v);	
		}
		foreach($wait_sql as $v){
			$v=str_replace('{order_id}',$order_id,$v);
			$pdo->exec($v);	
		}
		
		//如有优惠打折，更新交易价
		if($all_discount<1 && $preferential_way!=5){
			$sql="select `id`,`transaction_price` from ".self::$table_pre."order_goods where `order_id`=".$order['id'];
			$og=$pdo->query($sql,2);
			foreach($og as $v){
				$transaction_price=$v['transaction_price']*$all_discount;
				$sql="update ".self::$table_pre."order_goods set `transaction_price`='".$transaction_price."' where `id`=".$v['id'];
				$pdo->exec($sql);	
			}
		}
		
		
		
		$sql="select * from ".self::$table_pre."order where `id`=".$order_id;
		$order=$pdo->query($sql,2)->fetch(2);
		
		//==================================================================================================如已付款 start
		if($stocking!=0){
				
			if($pay_method=='alipay' || $pay_method=='weixin'){
				$sql="select `a_id`,`settlement` from ".$pdo->sys_pre."scanpay_pay where `id`='".intval($_POST['scanpay_id'])."'";	
				$pay=$pdo->query($sql,2)->fetch(2);
				if($pay['settlement']!=0){
					$sql="select `is_web` from ".$pdo->sys_pre."scanpay_account where `id`=".$pay['a_id'];
					$ac=$pdo->query($sql,2)->fetch(2);
					if($ac['is_web']){
						$reason=str_replace('{order_id}','<a href=./index.php?monxin=mall.order_admin&search='.$order['out_id'].' target=_blank>'.$order['out_id'].'</a>',self::$language['add_order_money_template']);
						$reason=str_replace('{sum_money}',$order['actual_money'],$reason);
						if(!operator_money(self::$config,self::$language,$pdo,$seller,$order['actual_money'],$reason,'mall')){
							exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
						}
						$sql="update ".self::$table_pre."order set `settlement_state`=1 where `id`=".$order['id'];
						$pdo->exec($sql);
						self::exe_online_pay_fees($pdo,$seller,$order);
						$sql="update ".$pdo->sys_pre."scanpay_pay set `settlement`=1 where `id`=".intval($_POST['scanpay_id']);
						$pdo->exec($sql);
					}else{
						self::web_credits_subsidy($pdo,$seller,$order);
					}	
				}
				
			}else{
				self::web_credits_subsidy($pdo,$seller,$order);
			}	
		
			if($pay_method=='balance'){
				$d_payable=$payable-$web_credits_value;
				if($buyer['money']<$d_payable){
					$pdo->exec("delete from ".self::$table_pre."order where `id`=".$order_id);
					exit('{"state":"fail","info":"<span class=fail>'.self::$language['insufficient_balance'].'</span>"}');
				}
						
				$reason=str_replace('{order_id}',$order['out_id'],self::$language['deduction_order_money_template']);
				$reason=str_replace('{sum_money}',$d_payable,$reason);
				if(!operator_money(self::$config,self::$language,$pdo,$buyer['username'],'-'.$d_payable,$reason,'mall')){
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
				$d_payable=$payable-$web_credits_value;
				if($buyer['shop_balance']<$d_payable){
					$pdo->exec("delete from ".self::$table_pre."order where `id`=".$order_id);
					exit('{"state":"fail","info":"<span class=fail>shop '.self::$language['insufficient_balance'].'</span>"}');
				}
						
				$reason=str_replace('{order_id}',$order['out_id'],self::$language['deduction_order_money_template']);
				$reason=str_replace('{sum_money}',$d_payable,$reason);
				if(!self::operator_shop_buyer_balance($pdo,$buyer['username'],'-'.$d_payable,$reason)){
					$pdo->exec("delete from ".self::$table_pre."order where `id`=".$order_id);
					exit('{"state":"fail","info":"<span class=fail>decrease money err</span>"}');
				}
				$r=$order;
			}
			
			if($pay_method=='balance' || $pay_method=='shop_balance'){
				self::checkout_order_notice(self::$language,self::$config,$pdo,self::$table_pre,$order);	
			}
			if($stocking==1){//已付款备货
					if(self::$config['distribution'] && $order['buyer']!=''){
						if(!isset($distribution)){
							require('./program/distribution/distribution.class.php');
							$distribution=new distribution($pdo);		
						}
						$distribution->order_complete_pay($pdo,$order['id']);
						$distribution->order_complete_confirm_receipt($pdo,$order['id']);
					}
			}
			
			if($stocking==6){//实时完成无需备货
				self::checkout_decrease_goods_quantity($pdo,self::$table_pre,$order);
				self::update_goods_monthly($pdo,self::$table_pre,$order);
				self::update_shop_order_sum($pdo,self::$table_pre,SHOP_ID);
				//self::give_credits($pdo,$order);
				$reason=str_replace('{order_id}','<a href=./index.php?monxin=mall.order_admin&search='.$order['out_id'].' target=_blank>'.$order['out_id'].'</a>',self::$language['add_order_money_template']);
				$reason=str_replace('{sum_money}',$order['actual_money'],$reason);
				self::operation_shop_finance(self::$language,$pdo,self::$table_pre,$order['shop_id'],$order['actual_money'],9,$reason);
				self::record_order_cost($pdo,$seller,$order);
				self::give_credits($pdo,$order);
				if($pay_method=='balance'){self::exe_online_pay_fees($pdo,$seller,$order);self::update_card_state($pdo,$order['buyer']);}
				self::exe_introducer_fees($pdo,$order);
				self::set_order_goods_barcode($pdo,$order['id']);
				
				if($payable!=$money_count){
					$sum_info='<div class=money_info>'.self::$language['sum'].self::$language['money_symbol'].str_replace('.00','',$money_count).'-'.self::$language['preferential'].self::$language['money_symbol'].str_replace('.00','',$money_count-$payable).'=</div>
					<div class=actual_money>'.self::$language['actual_pay'].str_replace('.00','',$payable).self::$language['yuan'].'</div>';
				}else{
					$sum_info='<div class=actual_money>'.self::$language['sum'].str_replace('.00','',$payable).self::$language['yuan'].'</div>';
				}
				
				
					if(self::$config['distribution'] && $order['buyer']!=''){
						if(!isset($distribution)){
							require('./program/distribution/distribution.class.php');
							$distribution=new distribution($pdo);		
						}
						$distribution->order_complete_pay($pdo,$order['id']);
						$distribution->order_complete_confirm_receipt($pdo,$order['id']);
					}
	
					
			}	
		
			
				
		}
		//==================================================================================================如已付款 end
	
		$sql="select `username` from ".self::$table_pre."shop where `id`=".$order['shop_id'];
		$r2=$pdo->query($sql,2)->fetch(2);
		$seller=$r2['username'];
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		//=====================================================================================================================处理打印内容 start
		$sql="select `name` from ".self::$table_pre."shop where `id`=".SHOP_ID;
		$r2=$pdo->query($sql,2)->fetch(2);
		$shop_name=$r2['name'];
		$html='';
		if(intval(@$_COOKIE['checkout_print_set'])==1){//组织打印小票内容 
			
			$sql="select `title`,`transaction_price`,`quantity`,`unit`,`s_id`,`goods_id`,`price`,`barcode` from ".self::$table_pre."order_goods where `order_id`=".$order['id'];
			$r2=$pdo->query($sql,2);
			$list2='';
			foreach($r2 as $v2){
				if($order['preferential_way']==5){$o_price='<span class=o_price>'.$v2['price'].'</span>';$v2['price']=$v2['transaction_price'];}else{$o_price='';}		
				if(mb_strlen($v2['title'],'utf-8')>18){
					if($v2['s_id']!=0){
						$v2['title']=mb_substr($v2['title'],0,6,'utf-8').'..'.mb_substr($v2['title'],mb_strlen($v2['title'],'utf-8')-14,9,'utf-8');
					}else{
						$v2['title']=mb_substr($v2['title'],0,15,'utf-8').'..';
					}
					
				}
				if($v2['barcode']=='0'){$v2['barcode']='';}
				$list2.='<div class=goods><div class=title>'.$v2['title'].'</div><div class=o><span class=b>'.$v2['barcode'].'</span><span class=q>'.self::format_quantity($v2['quantity']).$v2['unit'].'</span><span class=p>'. trim_0($v2['price']).'</span><span class=s>'.trim_0(number_format($v2['price']*$v2['quantity'],2)).'</span></div></div>';	
		
			}
			
			
			$cash_info='';
			if($pay_method=='cash' && $received_money>$payable){
				$cash_info='<div>'.self::$language['received_money'].':'.str_replace('.00','',$received_money).' '.self::$language['return_money'].($received_money-$payable).'</div>';
			}
			if($order['goods_money']+$order['express_cost_buyer']-$order['sum_money']!=0){
				$preferential_way="<div class=normal_price>".self::$language['original_price'].self::$language['sum'].":".$order['goods_money'].self::$language['yuan']."</div><div class=preferential_way>".$order['preferential_code'].self::$language['preferential_way_option'][$order['preferential_way']].": -". sprintf('%.2f',$order['goods_money']+$order['express_cost_buyer']-$order['sum_money']).self::$language['yuan']."</div>";		
			}else{$preferential_way='';}
			if($order['web_credits_money']!=0){$order['buyer_remark'].='<br />'.$order['credits_remark'];}
			if($order['preferential_way']==5){$preferential_way='';}
			$shop_buyer_info='';
			if($order['buyer']!=''){
				$sql="select `balance`,`credits` from ".self::$table_pre."shop_buyer where `shop_id`=".SHOP_ID." and `username`='".$order['buyer']."' limit 0,1";
				$t=$pdo->query($sql,2)->fetch(2);
				$shop_buyer_info='<br />'.self::$language['store'].self::$language['balance'].':'.$t['balance'].'<br />'.self::$language['store'].self::$language['credits'].':'.$t['credits'];
			}

			
			$html='
		<div class=order>
        	<div class=logo><img src="./program/mall/ticket_logo/'.SHOP_ID.'.png" width="100%" /></div>
            <div class=title>'.$shop_name.'<br />'.self::$language['order_number'].':'.$order['out_id'].'<br />'.self::$language['order_id'].self::$language['state'].":".self::$language['order_state'][$order['state']]." ".@self::$language['pay_method'][$order['pay_method']].'</div>
            <div class=goods_info><div class="o g_head"><span class=g>'.self::$language['name'].'</span><span class=q>'.self::$language['quantity'].'</span><span class=p>'.self::$language['price'].'</span><span class=s>'.self::$language['subtotal'].'</span></div>'.$list2.'</div>
			'.$preferential_way.'
            <div class=actual_money>'.self::$language['actual_pay'].str_replace('.00','',$order['actual_money']-$order['web_credits_money']).self::$language['yuan'].' '.$order['change_price_reason'].'</div>
           
            <div class=username_time><span class=username>'.$order['buyer'].'</span> <span class=time>'.date('m-d H:i',$order['add_time']).'</span></div>
			'.$order['buyer_remark'].' '.de_safe_str($_POST['address']).$shop_buyer_info.'
        </div>
';	
		}
		
		if(intval(@$_COOKIE['checkout_print_set'])==2){
			$sql="select * from ".self::$table_pre."order where `id`=".$order['id']." and`shop_id`=".SHOP_ID."";
			$r=$pdo->query($sql,2);
			$module['list']='';
			foreach($r as $v){
				$sql="select `title`,`transaction_price`,`quantity`,`unit`,`s_id`,`goods_id`,`price`,`barcode` from ".self::$table_pre."order_goods where `order_id`=".$v['id'];
				$r2=$pdo->query($sql,2);
				$list2='';
				foreach($r2 as $v2){
					if($v['preferential_way']==5 && $v2['price']!=$v2['transaction_price']){$o_price='<span class=o_price>'.$v2['price'].'</span>';$v2['price']=$v2['transaction_price'];}else{$o_price='';}	
					if($v2['barcode']=='0'){$v2['barcode']='';}	
					$list2.="<div class=goods><span class=goods_id>".$v2['barcode']."</span><span class=goods_name>".$v2['title']."</span><span class=goods_price>".$v2['price'].$o_price."</span><span class=goods_quantity>".self::format_quantity($v2['quantity']).$v2['unit']."</span><span class=goods_money>".$v2['price']*$v2['quantity']."</span></div>";	
				}
				$sql="select * from ".self::$table_pre."shop where `id`=".SHOP_ID;
				$shop=$pdo->query($sql,2)->fetch(2);
				$shop=de_safe_str($shop);
				$shop_name=$shop['name'];
				$sql="select `name` from ".self::$table_pre."talk where `id`=".$shop['talk_type'];
				$talk=$pdo->query($sql,2)->fetch(2);
				$talk=de_safe_str($talk['name']);
				
				$receiver_info=de_safe_str($_POST['address']);
				if($v['goods_money']+$v['express_cost_buyer']-$v['sum_money']!=0){
					$preferential_way="<div class=normal_price>".self::$language['sum'].":".$v['goods_money'].self::$language['yuan']."</div><div class=preferential_way>".$v['preferential_code'].self::$language['preferential_way_option'][$v['preferential_way']].": -". sprintf('%.2f',$v['goods_money']+$v['express_cost_buyer']-$v['sum_money']).self::$language['yuan']."</div>";				
				}else{$preferential_way='';}
				if($v['web_credits_money']!=0){$v['buyer_remark'].='<br />'.$v['credits_remark'];}
				if($v['preferential_way']==5){$preferential_way='';}
				$module['list'].="<div class='order_div a4'>
						<div class=order_head>
							<div class=icon_name>
								<img src=./program/mall/ticket_logo/".SHOP_ID.".png />
								<div>".$shop_name."</div>
							</div><div class=info>
								<div>".self::$language['order'].self::$language['number']."：".$v['out_id']."</div>
								<div>".self::$language['order'].self::$language['date']."：".date('Y-m-d',$v['add_time'])."</div>
								<div>".self::$language['pay_method_str']."：".@self::$language['pay_method'][$v['pay_method']]."</div>
							</div><div class=barcode>
								<img src=./plugin/barcode/buildcode.php?codebar=BCGcode128&text=".$v['out_id'].">
							</div>
							<div class=receiver_info>".$receiver_info."</div>
						</div>
						<div class=order_body>
							<div class='goods thead'><span class=goods_id>".self::$language['barcode']."</span><span class=goods_name>".self::$language['goods'].self::$language['name']."</span><span class=goods_price>".self::$language['price']."</span><span class=goods_quantity>".self::$language['quantity']."</span><span class=goods_money>".self::$language['money']."</span></div>
							".$list2."
						</div>
						<div class=order_foot>".$preferential_way.self::$language['actual_pay'].str_replace('.00','',$v['actual_money']-$v['web_credits_money']).self::$language['yuan'].'('.self::$language['freight_costs'].str_replace('.00','',$v['express_cost_buyer']).self::$language['yuan'].') '.$v['change_price_reason']."</div>
						".$v['buyer_remark']."
					<div class=shop_info>
						".self::$language['main_business'].':'.$shop['main_business']."<br />
						".self::$language['address'].':'.$shop['address']." ".self::$language['tel'].":".$shop['phone']." ".$talk.":".$shop['talk_account']."</div>
					</div>";
			
				$html=$module['list'];
				//file_put_contents('th.txt',$html);
			}
		}
		
		if(intval(@$_COOKIE['checkout_print_set'])==3){//云打印小票
			self::submit_cloud_print($pdo,$order['id']);
		} 		
		$result=array();
		$result['html']=$html;
		$result['info']='<span class=success>'.self::$language['success'].'</span>';
		$result['state']='success';
		echo json_encode($result);
		exit();
//=====================================================================================================================处理打印内容 end

	}
	
	
	
	
}
//==================================================================================================================================【提交订单 end】

//==================================================================================================================================【查询扫码支付状态】
if($act=='check_qr_state'){
	function checkout_qr_state($pdo,$table_pre,$id){
		$sql="select `state` from ".$table_pre."checkout where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		return $r['state'];

	}
	
	$id=intval($_GET['id']);
	if($id==0){exit('{"state":"fail","info":"<span class=fail>id is err</span>"}');}
	$sql="select `state` from ".self::$table_pre."checkout where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['state']==''){exit('{"state":"fail","info":"<span class=fail>id is err</span>"}');}
	$old_state=$r['state'];
	$state=$r['state'];
	if($state<2 && $state==$old_state){
		sleep(3);
		$state=checkout_qr_state($pdo,self::$table_pre,$id);
	}
	if($state<2 && $state==$old_state){
		sleep(3);
		$state=checkout_qr_state($pdo,self::$table_pre,$id);
	}
	if($state<2 && $state==$old_state){
		sleep(3);
		$state=checkout_qr_state($pdo,self::$table_pre,$id);
	}
	if($state<2 && $state==$old_state){
		sleep(3);
		$state=checkout_qr_state($pdo,self::$table_pre,$id);
	}
	if($state<2 && $state==$old_state){
		sleep(2);
		$state=checkout_qr_state($pdo,self::$table_pre,$id);
	}
	exit('{"state":"'.$state.'"}');
}

//==================================================================================================================================【添加订单到收银台】
if($act=='add_checkout'){
	$username=safe_str($_GET['username']);
	$money=floatval($_GET['money']);
	$goods=safe_str($_COOKIE['checkout_desk']);
	if($username=='' || $money==0 || $goods==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
	$where='';
	if(is_email($username)){$where="`email`='".$username."'";}	
	if(preg_match(self::$config['other']['reg_phone'],$username)){
		$where="`phone`='".$username."'";
		$sql="select `id`,`real_name`,`nickname`,`money`,`state`,`username`,`credits` from ".$pdo->index_pre."user where ".$where." limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){$where='';}
	}
	if($where==''){
		$u=self::chip_inquiry_shop_buyer($pdo,$username,SHOP_ID);
		if($u!=''){
			$where="`username`='".$u."'";
		}else{
			$where="`chip`='".$username."'";
		}
	}
	$sql="select `id`,`username` from ".$pdo->index_pre."user where ".$where." limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){
		$sql="select `id`,`real_name`,`nickname`,`money`,`state`,`transaction_password`,`username` from ".$pdo->index_pre."user where `chip`='".$username."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
	}
	if($r['id']==''){
		$sql="select `id`,`real_name`,`nickname`,`money`,`state`,`transaction_password`,`username` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
	}
		
	if($r['id']==''){exit('{"state":"fail","info":"<span class=fail>'.self::$language['not_exist'].'</span>"}');}
	$username=$r['username'];
	$sql="select * from ".self::$table_pre."checkout where `username`='".$r['username']."' and `money`='".$money."' and `goods`='".$goods."' and `state`=0 limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	$url='http://'.self::$config['web']['domain'].'/index.php?monxin=mall.checkout_pay|||id=';
	if($r['id']!=''){
		exit("{'state':'success','url':'".$url.$r['id']."','id':'".$r['id']."'}");		
	}
	
	$sql="insert into ".self::$table_pre."checkout (`goods`,`username`,`money`,`time`,`pay_method`) values ('".$goods."','".$username."','".$money."','".time()."','".$_GET['pay_method']."')";
	//file_put_contents('./test.txt',$sql);
	if($pdo->exec($sql)){
		$insret_id=$pdo->lastInsertId();
		exit("{'state':'success','url':'".$url.$insret_id."','id':'".$insret_id."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
		
}

//==================================================================================================================================【查询单次购物券】
if($act=='preferential_code_7'){
	$time=time();
	$code=safe_str($_GET['code']);	
	$all_money=floatval($_GET['sum_money']);	
	$promotion_money=floatval($_GET['promotion_money']);
	if($code==''){exit('{"state":"fail","info":"<span class=fail>'.self::$language['preferential_way_option'][7].' is null</span>"}');}
	if($all_money<=0){exit('{"state":"fail","info":"<span class=fail>sum_money err</span>"}');}

		$sql="select * from ".self::$table_pre."buy_coupon_list where `shop_id`=".SHOP_ID." and `code`='".$code."' limit 0,1";
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
				exit("{'state':'success','info':'-".$r['amount']."'}");	
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['join_goods_front'][0].$promotion_money.self::$language['yuan'].self::$language['not_reached'].': '.$r['min_money']."</span>'}");
			}
		}
		if($r['join_goods']==1){//全店商品 可使用
			if($all_money>=$r['min_money']){
				if($r['amount']>$all_money){$r['amount']=$all_money;}
				exit("{'state':'success','info':'-".$r['amount']."'}");	
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['can_not_be_used_the_amount_of_goods_is_not_up_to'].': '.$r['min_money']."</span>'}");
			}
		}
		if($r['join_goods']==2){//不参加促销的商品 可使用
			if($all_money-$promotion_money>=$r['min_money']){
				if($r['amount']>$all_money){$r['amount']=$all_money-$promotion_money;}
				exit("{'state':'success','money':'-".$r['amount']."'}");	
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['join_goods_front'][2].($all_money-$promotion_money).self::$language['yuan'].self::$language['not_reached'].': '.$r['min_money']."</span>'}");
			}
		}
	
}



//==================================================================================================================================【查询代金券优惠金额】
if($act=='preferential_code_4'){
	$code=safe_str($_GET['code']);	
	$sum_money=floatval($_GET['sum_money']);	
	$promotion_money=floatval($_GET['promotion_money']);
	if($code==''){exit('{"state":"fail","info":"<span class=fail>'.self::$language['preferential_way_option'][4].' is null</span>"}');}
	if($sum_money<=0){exit('{"state":"fail","info":"<span class=fail>sum_money err</span>"}');}
	$sql="select * from ".self::$table_pre."vouchers where `shop_id`=".SHOP_ID." and `number`='".$code."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	$time=time();
	if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['not_exist']."</span>'}");}
	if($r['start_time']>$time){exit("{'state':'fail','info':'<span class=fail>".get_time('m-d',self::$config['other']['timeoffset'],self::$language,$r['start_time']).self::$language['can_be_use']."</span>'}");}	
	if($r['end_time']<$time){exit("{'state':'fail','info':'<span class=fail>".get_time('m-d',self::$config['other']['timeoffset'],self::$language,$r['start_time']).self::$language['has_expired']."</span>'}");}	
	if($r['sum_quantity']<=$r['use_quantity']){exit("{'state':'fail','info':'<span class=fail>".self::$language['has_been_used']."</span>'}");}
	$d=0;
	if($r['join_goods']==0){
		if($promotion_money>=$r['min_money']){$d='-'.$r['amount'];}
	}
	if($r['join_goods']==1){
		if($sum_money>=$r['min_money']){$d='-'.$r['amount'];}
	}
	if($r['join_goods']==2){
		if($sum_money-$promotion_money>=$r['min_money']){$d='-'.$r['amount'];}
	}
	if($d==0){
		if($r['join_goods']==1){$l=self::$language['goods_is_not_up_to'];}	
		if($r['join_goods']==0){$l=self::$language['join_goods_front'][0].self::$language['not_reached'];}	
		if($r['join_goods']==2){$l=self::$language['join_goods_front'][2].self::$language['not_reached'];}
		exit("{'state':'fail','info':'<span class=fail>".$l.$r['min_money']."</span>'}");
	}else{
		exit("{'state':'success','info':'".$d."'}");
	}
	
}

//==================================================================================================================================【查询买家信息】
if($act=='check_user'){
	$username=safe_str($_GET['username']);
	$where='';
	if(preg_match(self::$config['other']['reg_phone'],$username)){
		$where="`phone`='".$username."'";
		$sql="select `id`,`real_name`,`nickname`,`money`,`state`,`username`,`credits` from ".$pdo->index_pre."user where ".$where." limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){$where='';}
	}
	if($where==''){
		$u=self::chip_inquiry_shop_buyer($pdo,$username,SHOP_ID);
		if($u!=''){
			$where="`username`='".$u."'";
		}else{
			$where="`chip`='".$username."'";
		}
	}
	$sql="select `id`,`real_name`,`nickname`,`money`,`state`,`username`,`credits` from ".$pdo->index_pre."user where ".$where." limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){
		$sql="select `id`,`real_name`,`nickname`,`money`,`state`,`username`,`credits` from ".$pdo->index_pre."user where `chip`='".$username."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
	}
	if($r['id']==''){
		$sql="select `id`,`real_name`,`nickname`,`money`,`state`,`username`,`credits` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
	}
		
	if($r['id']==''){exit('{"state":"fail","info":"<span class=fail>'.self::$language['not_exist'].'</span>"}');}
	if($r['state']!=1){exit('{"state":"fail","info":"<span class=fail>'.self::$language['user_state'][$r['state']].'</span>"}');}
	$name='';
	if($r['real_name']!=''){$name=$r['real_name'];}
	if($r['nickname']!=''){$name=$r['nickname'];}
	if($name==''){$name=$r['username'];}
	
	
	//$name=encryption_str($name);
	$result=array();
	$result['username']=$r['username'];
	$result['web_credits']=$r['credits'];
	$result['info']=$name.' '.self::$language['money_symbol'].'<span class=balance>'.$r['money'].'</span>';
	$result['state']='success';
	$result['shop_balance']=0;
	$sql="select `group_id`,`balance`,`credits` from ".self::$table_pre."shop_buyer where `shop_id`=".SHOP_ID." and `username`='".$r['username']."' limit 0,1";
	$tr=$pdo->query($sql,2)->fetch(2);
	if($tr['group_id']==''){
		self::add_shop_buyer($pdo,$r['username'],SHOP_ID);
		$sql="select `group_id`,`balance`,`credits` from ".self::$table_pre."shop_buyer where `shop_id`=".SHOP_ID." and `username`='".$r['username']."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
	}else{		
		$r=$tr;
	}
	$result['shop_credits']=$r['credits'];
	if($r['group_id']!=''){
		$result['shop_balance']=$r['balance'];
		$result['info'].='/<span class=shop_balance>'.$r['balance'].'</span>';
		$sql="select `name`,`discount`,`id` from ".self::$table_pre."shop_buyer_group  where `id`=".$r['group_id'];
		//file_put_contents('c.txt',$sql);
		$group=$pdo->query($sql,2)->fetch(2);
		if($group['name']!=''){
			$result['group_name']=$group['name'];
			$result['group_discount']=$group['discount'];
			$result['group_id']=$group['id'];
			//file_put_contents('c.txt',$result['group_name']);
		}else{
			$result['group_name']='';
			$result['group_discount']=10;
			$result['group_id']=0;
		}	
	}else{
			$result['group_name']='';
			$result['group_discount']=10;
			$result['group_id']=0;
	}
	
	
	$sql="select `checkout_address` from ".self::$table_pre."order where `buyer`='".$result['username']."' and `checkout_address`!='' order by `id` desc limit 0,1";
	$temp=$pdo->query($sql,2)->fetch(2);
	$result['checkout_address']=de_safe_str($temp['checkout_address']);
	
	$sql="select * from ".self::$table_pre."receiver where `username`='".$result['username']."' order by `sequence` desc";
	$temp=$pdo->query($sql,2);
	$result['address']='';
	foreach($temp as $v){
		$v=de_safe_str($v);
		$result['address'].='<div><input type=radio name=address_radio /> <span>'.$v['name'].' '.$v['phone'].' '.get_area_name($pdo,$v['area_id']).' '.$v['detail'].' '.$v['post_code'].'</span></div>';	
	}
	echo json_encode($result);
	exit();
		
}

//==================================================================================================================================【检测买家支付密码是否正确】
if($act=='check_password'){
	$username=safe_str($_GET['username']);
	$password=safe_str($_GET['password']);
	if($password==''){exit('{"state":"fail","info":"<span class=fail>'.self::$language['is_null'].'</span>"}');}
	
			$pre=mb_substr($password,0,5,'utf-8');
			$postfix=mb_substr($password,5);
			if($pre=='6666_' && strlen($postfix)==8){
				$qr_info=get_qr_pay_info($pdo,$postfix);
				if($qr_info['id']==''){
					exit('{"state":"fail","info":"<span class=fail>'.self::$language['pay_code_err'].'</span>","qr_pay":1}');
				}
				$result=array();
				$result['info']='<span class=success>'.self::$language['right'].'</span>';
				$result['state']='success';
				echo json_encode($result);
				exit();
			}
	
	
	$password=md5($password);
	$where='';
	if(preg_match(self::$config['other']['reg_phone'],$username)){
		$where="`phone`='".$username."'";
		$sql="select `id`,`real_name`,`nickname`,`money`,`state`,`username`,`credits` from ".$pdo->index_pre."user where ".$where." limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){$where='';}
	}
	if($where==''){
		$u=self::chip_inquiry_shop_buyer($pdo,$username,SHOP_ID);
		if($u!=''){
			$where="`username`='".$u."'";
		}else{
			$where="`chip`='".$username."'";
		}
	}
	$sql="select `id`,`real_name`,`nickname`,`money`,`state` from ".$pdo->index_pre."user where ".$where." and `transaction_password`='".$password."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){
	$sql="select `id`,`real_name`,`nickname`,`money`,`state` from ".$pdo->index_pre."user where `chip`='".$username."' and `transaction_password`='".$password."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
	}
	if($r['id']==''){
	$sql="select `id`,`real_name`,`nickname`,`money`,`state` from ".$pdo->index_pre."user where `username`='".$username."' and `transaction_password`='".$password."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
	}
	
	if($r['id']==''){exit('{"state":"fail","info":"<span class=fail>'.self::$language['err'].'</span>"}');}
	if($r['state']!=1){exit('{"state":"fail","info":"<span class=fail>'.self::$language['user_state'][$r['state']].'</span>"}');}
	$result=array();
	$result['info']='<span class=success>'.self::$language['right'].'</span>';
	$result['state']='success';
	echo json_encode($result);
	exit();
		
}

//==================================================================================================================================【通过条形码获取商品信息 start】
$checkout_desk=json_decode(@$_COOKIE['checkout_desk'],true);
if(!is_array($checkout_desk)){$checkout_desk=array();}
if($act=='submit'){
	$discount=self::get_shop_discount($pdo,SHOP_ID);
	$barcode=safe_str($_GET['barcode']);
	
	$barcode=trim($barcode);
	//echo $barcode;
	$quantity=1;
	if(substr($barcode,0,1)=='0'){
		$sql="select `id` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and ( `bar_code`='".$barcode."' || `speci_bar_code` like '".$barcode."|%' || `speci_bar_code` like '%|".$barcode."|%' || `store_code`='".$barcode."' || `speci_store_code` like '".$barcode."|%' || `speci_store_code` like '%|".$barcode."|%') limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){
			$v=ltrim($barcode,'0');	
			$barcode=substr($v,0,5);
			$quantity=substr($v,5,5);
			$quantity=$quantity/1000;
		}	
	}
	$g=array();
	if(is_numeric($barcode)){
		$sql="select `id` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and ( `bar_code`='".$barcode."' || `speci_bar_code` like '".$barcode."|%' || `speci_bar_code` like '%|".$barcode."|%' || `store_code`='".$barcode."' || `speci_store_code` like '".$barcode."|%' || `speci_store_code` like '%|".$barcode."|%') and `state`!=0 limit 1,1";
		$r=$pdo->query($sql,2)->fetch(2);
		
		if($r['id']!=''){
			$result['state']='success';
			$result['info']='<span class=success>'.self::$language['success'].'</span>';
			$result['act']='search';
			echo json_encode($result);
			exit();
		}
		
		$sql="select `id`,`title`,`e_price`,`unit`,`bar_code`,`icon`,`sales_promotion`,`inventory`,`store_code`,`option_enable`,`state` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and ( `bar_code`='".$barcode."' || `speci_bar_code` like '%".$barcode."|%' || `store_code`='".$barcode."' || `speci_store_code` like '%".$barcode."|%') limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		//if($r['id']==''){exit('{"state":"fail","info":"<span class=fail>'.self::$language['not_exist'].'</span>"}');}
		if($r['id'] && $r['state']==0){exit("{'state':'fail','info':'<span class=fail>".self::$language['goods'].self::$language['goods_hide']."</span>'}");}
		if(($r['bar_code']==$barcode || $r['store_code']==$barcode) && $r['option_enable']==0 ){
			$normal_price=$r['e_price'];
			if($discount<10 && ($_POST['discount_join_goods'] || $r['sales_promotion'])){$r['e_price']=sprintf("%.2f",$r['e_price']*$discount/10);}
			$key=$r['id'];
			$g[$key]['icon']='img_thumb/'.$r['icon'];	
			$g[$key]['title']=$r['title'];	
			$checkout_desk[$key]['quantity']=(isset($checkout_desk[$key]))?$checkout_desk[$key]['quantity']+$quantity:$quantity;
			$checkout_desk[$key]['price']=$r['e_price'];
			$checkout_desk[$key]['time']=time();
		}else{
			$sql="select count(`id`) as c from ".self::$table_pre."goods_specifications where `goods_id`='".$r['id']."' and (`barcode`='".$barcode."' || `store_code`='".$barcode."') limit 0,2";
			$r2=$pdo->query($sql,2)->fetch();
			if($r2['c']>1){
				$result['state']='success';
				$result['info']='<span class=success>'.self::$language['success'].'</span>';
				$result['act']='search';
				echo json_encode($result);
				exit();
			}
			$sql="select `id`,`color_img`,`e_price`,`option_id`,`color_id`,`color_name` from ".self::$table_pre."goods_specifications where `goods_id`='".$r['id']."' and (`barcode`='".$barcode."' || `store_code`='".$barcode."') limit 0,1";
			$r2=$pdo->query($sql,2)->fetch();
			if($r2['id']==''){exit('{"state":"fail","info":"<span class=fail>'.self::$language['not_exist'].'</span>"}');}
			$normal_price=$r2['e_price'];
			if($discount<10 && ($_POST['discount_join_goods'] || $r['sales_promotion'])){$r2['e_price']=sprintf("%.2f",$r2['e_price']*$discount/10);}
			$key=$r['id'].'_'.$r2['id'];
			
			if($r2['color_img']!=''){
				$g[$key]['icon']='img/'.$r2['color_img'];	
			}else{
				$g[$key]['icon']='img_thumb/'.$r['icon'];
			}
			
			$g[$key]['title']=$r['title'].' '.self::get_type_option_name($pdo,$r2['option_id']).' '.$r2['color_name'];	
			
			$checkout_desk[$key]['quantity']=(isset($checkout_desk[$key]))?$checkout_desk[$key]['quantity']+$quantity:$quantity;
			$checkout_desk[$key]['price']=$r2['e_price'];
			$checkout_desk[$key]['time']=time();
		}
		//if(isset($quantity) && is_numeric($quantity)){$checkout_desk[$key]['quantity']=$quantity;}
		setcookie("checkout_desk",json_encode($checkout_desk));
		$_COOKIE['checkout_desk']=json_encode($checkout_desk);
		if($r['sales_promotion']){$sales_promotion='<span class=sales_promotion>'.self::$language['sales_promotion_short'].'</span>';}else{$sales_promotion='';}

		$goods='<tr id=tr_'.$key.'  normal_price="'.$normal_price.'" promotion="'.$checkout_desk[$key]['price'].'"  '.self::get_goods_group_discount($pdo,$r['id']).' >
		<td class=goods_td><a href=./index.php?monxin=mall.goods&id='.$r['id'].' class=goods_info target=_blank>
                            <span class=img><img src=./program/mall/'.$g[$key]['icon'].' /></span><span class=title>
                                '.$g[$key]['title'].'</span>
                    	</a></td>
		<td class=price_td><div class=normal><span class=price>'.$checkout_desk[$key]['price'].'</span>'.$sales_promotion.'</div><div class=group></div><span class=g_discount></span></td>
		<td class=quantity_div><a href=# class=decrease_quantity title="-1"></a><input type=text class=quantity  kg_rate="'.self::get_kg_rate($pdo,$r['unit']).'"  value="'.$checkout_desk[$key]['quantity'].'" /><a href=# class=add_quantity title="+1"></a><span class=unit>'.self::get_mall_unit_name($pdo,$r['unit']).'<span class=unit_gram value='.$_POST['temp_unit_gram'].'></span></span></td>
		<td class=subtotal_td><span class=subtotal>'.$checkout_desk[$key]['price']*$checkout_desk[$key]['quantity'].'</span></td>
		<td class=operation_td><a href=# class=del>'.self::$language['del'].'</a> <span class=state></span></td>
		</tr>';
		$result=array();
		$result['key']=$key;
		$result['state']='success';
		$result['info']='<span class=success>'.self::$language['success'].'</span>';
		$result['html']=$goods;
		echo json_encode($result);
		exit();
	}else{
		$result['state']='success';
		$result['info']='<span class=success>'.self::$language['success'].'</span>';
		$result['act']='search';
		echo json_encode($result);
		exit();
	}	
}

//==================================================================================================================================【通过条形码获取商品信息 end】

//==================================================================================================================================【通过商品ID取商品信息 start】
if($act=='click'){
	
	$id=intval(@$_GET['id']);
	$quantity=floatval(@$_GET['quantity']);
	$id_type=@$_GET['id_type'];
	if($id==0){exit('{"state":"fail","info":"<span class=fail>'.self::$language['fail'].' id is 0</span>"}');}
	$discount=self::get_shop_discount($pdo,SHOP_ID);
	$g=array();
	if($id_type=='g_id'){
		$sql="select `id`,`title`,`e_price`,`unit`,`bar_code`,`icon`,`sales_promotion`,`inventory` from ".self::$table_pre."goods where `id`='".$id."' and `shop_id`=".SHOP_ID."";
		//echo $sql;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){exit('{"state":"fail","info":"<span class=fail>'.self::$language['not_exist'].'</span>"}');}
		$normal_price=$r['e_price'];
		if($discount<10 && ($_POST['discount_join_goods'] || $r['sales_promotion'])){$r['e_price']=sprintf("%.2f",$r['e_price']*$discount/10);}
		$key=$r['id'];
		$g[$key]['icon']='img_thumb/'.$r['icon'];	
		$g[$key]['title']=$r['title'];	
		//$checkout_desk[$key]['quantity']=(isset($checkout_desk[$key]))?$checkout_desk[$key]['quantity']+1:1;
		$checkout_desk[$key]['quantity']=$quantity;
		$checkout_desk[$key]['price']=$r['e_price'];
		$checkout_desk[$key]['time']=time();
	}else{
		$sql="select `id`,`color_img`,`e_price`,`option_id`,`color_id`,`color_name`,`goods_id` from ".self::$table_pre."goods_specifications where `id`='".$id."'";
		$r2=$pdo->query($sql,2)->fetch();
		$normal_price=$r2['e_price'];
		$sql="select `id`,`title`,`e_price`,`unit`,`bar_code`,`icon`,`sales_promotion`,`inventory` from ".self::$table_pre."goods where `id`='".$r2['goods_id']."' and `shop_id`=".SHOP_ID."";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){exit('{"state":"fail","info":"<span class=fail>'.self::$language['not_exist'].'</span>"}');}

		if($r2['id']==''){exit('{"state":"fail","info":"<span class=fail>'.self::$language['not_exist'].'</span>"}');}
		if($discount<10 && ($_POST['discount_join_goods'] || $r['sales_promotion'])){$r2['e_price']=sprintf("%.2f",$r2['e_price']*$discount/10);}
		$key=$r['id'].'_'.$r2['id'];
		
		if($r2['color_img']!=''){
			$g[$key]['icon']='img/'.$r2['color_img'];	
		}else{
			$g[$key]['icon']='img_thumb/'.$r['icon'];
		}
		
		$g[$key]['title']=$r['title'].' '.self::get_type_option_name($pdo,$r2['option_id']).' '.$r2['color_name'];	
		
		//$checkout_desk[$key]['quantity']=(isset($checkout_desk[$key]))?$checkout_desk[$key]['quantity']+1:1;
		$checkout_desk[$key]['quantity']=$quantity;
		$checkout_desk[$key]['price']=$r2['e_price'];
		$checkout_desk[$key]['time']=time();
	}
	setcookie("checkout_desk",json_encode($checkout_desk));
	$_COOKIE['checkout_desk']=json_encode($checkout_desk);
	if($r['sales_promotion']){$sales_promotion='<span class=sales_promotion>'.self::$language['sales_promotion_short'].'</span>';}else{$sales_promotion='';}
	$goods='<tr id=tr_'.$key.'  normal_price="'.$normal_price.'" promotion="'.$checkout_desk[$key]['price'].'"  '.self::get_goods_group_discount($pdo,$r['id']).' >
	<td class=goods_td><a href=./index.php?monxin=mall.goods&id='.$r['id'].' class=goods_info target=_blank>
						<span class=img><img src=./program/mall/'.$g[$key]['icon'].' /></span><span class=title>
							'.$g[$key]['title'].'</span>
					</a></td>
	<td class=price_td><div class=normal><span class=price>'.$checkout_desk[$key]['price'].'</span>'.$sales_promotion.'</div><div class=group></div><span class=g_discount></span></td>
	<td class=quantity_div><a href=# class=decrease_quantity title="-1"></a><input type=text class=quantity  kg_rate="'.self::get_kg_rate($pdo,$r['unit']).'"  value="'.$checkout_desk[$key]['quantity'].'" /><a href=# class=add_quantity title="+1"></a><span class=unit>'.self::get_mall_unit_name($pdo,$r['unit']).'<span class=unit_gram value='.$_POST['temp_unit_gram'].'></span></span></td>
	<td class=subtotal_td><span class=subtotal>'.$checkout_desk[$key]['price']*$checkout_desk[$key]['quantity'].'</span></td>
	<td class=operation_td><a href=# class=del>'.self::$language['del'].'</a> <span class=state></span></td>
	</tr>';
	$result=array();
	$result['key']=$key;
	$result['state']='success';
	$result['info']='<span class=success>'.self::$language['success'].'</span>';
	$result['html']=$goods;
	echo json_encode($result);
	exit();
}
//==================================================================================================================================【通过商品ID取商品信息 end】
