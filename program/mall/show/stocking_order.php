<?php
//send_im_msg(self::$config,self::$language,$pdo,$_SESSION['monxin']['username'],'monxin.com','auto_msg');

self::update_order_pay_method_remark($pdo);
self::update_expire_order($pdo,self::$table_pre,self::$config['pay_time_limit']);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['visible']=@$_GET['visible'];
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);
$shop_master=self::get_shop_master($pdo,SHOP_ID);

$sql="select * from ".self::$table_pre."order where `shop_id`=".SHOP_ID." and `seller_del`=0 and `state`<2 and `cashier`!='monxin'";

$where="";
if(intval(@$_GET['id'])!=0){
	$where=" and `id`=".intval($_GET['id']);
	echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=mall.stocking_order">'.self::$language['pages']['mall.stocking_order']['name'].'</a><span class=text>'.$_GET['id'].'</span></div>';
}

if($_GET['search']!=''){$where=" and (`id` ='".$_GET['search']."' or `buyer_remark` like '%".$_GET['search']."%'  or `goods_names` like '%".$_GET['search']."%' or `buyer` like '%".$_GET['search']."%' or `express_code` like '%".$_GET['search']."%' or `preferential_code` like '%".$_GET['search']."%' or `receiver_name` like '%".$_GET['search']."%' or `receiver_phone` like '%".$_GET['search']."%' or `receiver_detail` like '%".$_GET['search']."%' or `receiver_post_code` like '%".$_GET['search']."%' or `receiver_area_name` like '%".$_GET['search']."%' or `share` like '%".$_GET['search']."%' or `check_code` ='".$_GET['search']."' or `out_id`='".$_GET['search']."')";}

if(@$_GET['pay_method']!=''){$where.=" and `pay_method`='".safe_str($_GET['pay_method'])."'";}
if(@$_GET['buy_method']!=''){
	if($_GET['buy_method']=='monxin'){$where.=" and `cashier`='monxin'";}
	if($_GET['buy_method']=='cashier'){$where.=" and `cashier`!='monxin'";}
}
if(@$_GET['preferential_way']!=''){$where.=" and `preferential_way`='".intval($_GET['preferential_way'])."'";}
if(@$_GET['express']!=''){$where.=" and `express`='".intval($_GET['express'])."'";}
if(@$_GET['start_time']!=''){
	$start_time=get_unixtime($_GET['start_time'],self::$config['other']['date_style']);
	$where.=" and `add_time`>$start_time";	
}
if(@$_GET['end_time']!=''){
	$end_time=get_unixtime($_GET['end_time'],self::$config['other']['date_style'])+86400;
	$where.=" and `add_time`<$end_time";	
}

$time=time();
$today=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);
$time=get_unixtime($today,'y-m-d')-86400;
$yesterday=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);

$time=get_unixtime($today,'y-m-d')-(86400*6);
$days_7=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);

$time=get_unixtime($today,'y-m-d')-(86400*29);
$days_30=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);

$module['days']='<a href="./index.php?monxin=mall.stocking_order&start_time='.$today.'&end_time='.$today.'" se="'.$today.'-'.$today.'">'.self::$language['today'].'</a>';
$module['days'].='<a href="./index.php?monxin=mall.stocking_order&start_time='.$yesterday.'&end_time='.$yesterday.'" se="'.$yesterday.'-'.$yesterday.'">'.self::$language['yesterday'].'</a>';
$module['days'].='<a href="./index.php?monxin=mall.stocking_order&start_time='.$days_7.'&end_time='.$today.'" se="'.$days_7.'-'.$today.'">'.self::$language['days_7'].'</a>';
$module['days'].='<a href="./index.php?monxin=mall.stocking_order&start_time='.$days_30.'&end_time='.$today.'" se="'.$days_30.'-'.$today.'">'.self::$language['days_30'].'</a>';

if(@$_GET['pay_method_remark']!=''){
	$where.=" and (`pay_method_remark`='".safe_str($_GET['pay_method_remark'])."' or `pay_method_remark`='".safe_str($_GET['pay_method_remark'])."_wap')";
}


$_GET['order']=safe_str(@$_GET['order']);
if($_GET['order']==''){
	$order=" order by `id` desc";
}else{
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
if(isset($_GET['credit_state'])){$where.=" and `credit_state`=".intval($_GET['credit_state']);}

$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_order and","_order where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_order and","_order where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';


foreach($r as $v){
	
	if($v['shop_credits_money']>0){$v['credits_remark']='<div class=credits_remark>'.self::$language['use_shop_credits'].':'.$v['shop_credits'].','.self::$language['deduction'].self::$language['money_symbol'].$v['shop_credits_money'].'</div>';}else{$v['credits_remark']='';}

	$goods_money=0;
	$v=de_safe_str($v);
	$sql="select * from ".self::$table_pre."order_goods where `order_id`='".$v['id']."' order by `id` asc";
	$r2=$pdo->query($sql,2);
	$temp='';
	$phone_temp='';
	if($v['state']==0 || ($v['state']==1 && $v['pay_method']=='cash_on_delivery')){$edit_quantity="<a href=# class=edit_a d_id act='edit_quantity'></a>";}else{$edit_quantity='';}
	
	
	foreach($r2 as $v2){
		if($v['preferential_way']==5){$o_price='<span class=o_price>'.$v2['price'].'</span>';$v2['price']=$v2['transaction_price'];}else{$o_price='';}
		$refund='';
		if($v2['refund']>0){$refund='<span class=refund>'.self::$language['refunded'].':<span class=refund_v>'.self::format_quantity($v2['refund']).'</span>'.$v2['unit'].'</span>';}
		
		if($_COOKIE['monxin_device']=='pc'){
			$temp.='<div class=goods id=g_'.$v2['id'].'><a href="./index.php?monxin=mall.goods&id='.$v2['goods_id'].'" target=_blank class=icon><img src="./program/mall/order_icon/'.$v2['icon'].'" /></a><div class=title_price><div class=title><a href="./index.php?monxin=mall.goods&id='.$v2['goods_id'].'" target=_blank >'.$v2['title'].'</a></div><div class=price><a href="./index.php?monxin=mall.goods_snapshot&id='.$v2['snapshot_id'].'" target=_balnk>'.self::$language['goods'].self::$language['snapshot'].'</a><span class=g_price>'.$o_price.str_replace('.00','',$v2['price'])."</span>*<span class=g_quantity>".self::format_quantity($v2['quantity']).'</span>'.$v2['unit']."=<span class=g_sum_money>".str_replace('.00','',$v2['price']*$v2['quantity']).'</span>'.self::$language['yuan'].$refund.$edit_quantity.' <input type="checkbox" name='.$v2['id'].' id='.$v2['id'].' class=goods_id /></div></div></div>';
		}else{
			$phone_temp.="<div class=goods_div  id=g_".$v2['id'].">
        	<span class=icon>
            	<a ><img src=./program/mall/order_icon/".$v2['icon']." /></a>
            </span><span class=other>
            	<div class=title>".$v2['title']."</div>
                <div class=price>".self::$language['price'].":".$o_price.self::$language['money_symbol'].str_replace('.00','',$v2['price'])." &nbsp; ".self::$language['quantity'].":".self::format_quantity($v2['quantity']).$v2['unit'].$refund.str_replace('d_id','d_id='.$v2['id'],$edit_quantity)." <a href=./index.php?monxin=mall.goods_snapshot&id=".$v2['snapshot_id']." target=_balnk>".self::$language['snapshot']."</a></div>
            </span>
        </div>";
		}
		
		$goods_money+=$v2['transaction_price']*$v2['quantity'];
	}
	if($v['buyer_remark']!=''){$v['buyer_remark']="<div class=buyer_remark>".self::$language['buyer'].self::$language['remark'].': '.$v['buyer_remark'].'</div>';}
	if($v['state']<1){$actual="<div class=actual_money>".self::$language['actual_pay'].": <span class=value>".$v['actual_money']."</span> <a href=# class=edit_a d_id=".$v['id']." act='actual_money'></a></div>";}else{$actual="<div class=actual_money>".self::$language['actual_pay'].": <span class=value>".$v['actual_money']."</span></div>";}
	if($v['change_price_reason']!=''){$v['change_price_reason']="<div class=change_price_reason>".$v['change_price_reason']."</div>";}
	if($v['preferential_code']!=''){$v['preferential_code']='<div class=preferential_code>'.$v['preferential_code'].'</div>';}
	$act='';
	$cancel_reason='';
	$state_remark='';
	$edit_express_cost_buyer='';
	$edit_express_cost_seller='';
	if($v['pay_method']=='credit' && $v['credit_state']==1){$end_credit="<br /><i>".self::$language['have_pay'].'</i>';	}else{$end_credit='';}
	if($v['state']>0){
		$state_remark='<div class=pay_method>'.self::$language['pay_method_str'].'<br />'.@self::$language['pay_method'][$v['pay_method']].$end_credit.'<span pay_method_remark='.$v['pay_method_remark'].'></span></div>';
	}
	
	if($v['state']>1 && $v['express_code']!=''){
		if($v['express']>0){
			$state_remark.='<a class=view_logistics  target=_blank order_id='.$v['id'].'>'.self::$language['view_logistics'].$end_credit.'</a>';
		}else{
			$state_remark.='<div style="background:#ECECEC; text-align:left;line-height:1.5rem;">'.rn_to_br($v['express_code']).'</div><a href=monxin></a>';
		}
	}
	
	
	
	$automatically_confirm_receipt='';
	switch($v['state']){
		case 0:
			$edit_express_cost_buyer="<a href=# class=edit_b d_id=".$v['id']." act='express_cost_buyer'></a>";
			$edit_express_cost_seller="<a href=# class=edit_b d_id=".$v['id']." act='express_cost_seller'></a>";
			$act="<a href='#' class=paid d_id=".$v['id']." >".self::$language['set_to'].self::$language['paid']."</a><br /><a href='#' class=cancel  d_id=".$v['id'].">".self::$language['cancel'].self::$language['order_id']."</a><br />";
			$state_remark='<div class=pay_time_limit>'.self::$language['pay_time_limit'].'<br />'.self::get_pay_time_limit(self::$language,self::$config['pay_time_limit'],$v['add_time']).'</div>';
			break;
		case 1:
			$edit_express_cost_seller="<a href=# class=edit_b d_id=".$v['id']." act='express_cost_seller'></a>";
			$act="<a href='#' class=edit_c d_id=".$v['id']." act='order_state_2'>".self::$language['set_to'].self::$language['order_state'][2]."</a><br /><a href='#' class=set_success  d_id=".$v['id'].">".self::$language['set'].self::$language['order_state'][6]."</a><br /><a href='#' class=cancel   d_id=".$v['id'].">".self::$language['cancel'].self::$language['order_id']."</a><br />";
			break;
		case 2:
			$time_limit=self::$language['time_limit'];
			$end_time=$v['send_time']+(self::$config['receipt_time_limit']+$v['receiving_extension'])*86400;
			$d=floor(($end_time-time())/86400);
			$h=floor((($end_time-time())%86400)/3600);
			$time_limit=str_replace('{d}','<i class=day>'.$d.'</i>',$time_limit);
			$time_limit=str_replace('{h}',$h,$time_limit);
		
			$automatically_confirm_receipt='<div class=time_limit>'.$time_limit.'<br />'.self::$language['automatically_confirm_receipt'].'</div>';
			$edit_express_cost_seller="<a href=# class=edit_b d_id=".$v['id']." act='express_cost_seller'></a>";
			$act="<a href='#' class=edit_c d_id=".$v['id']." act='receiving_extension'>".self::$language['receiving_extension']."</a><br /><a href='#' class=edit_c d_id=".$v['id']." act='order_state_2'>".self::$language['edit'].self::$language['express_2']."</a><br /><a href='#' class=cancel  d_id=".$v['id'].">".self::$language['cancel'].self::$language['order_id']."</a>";
			break;
		case 3:
			//$act="<a href='#' class=order_state_4>".self::$language['set_to'].self::$language['order_state'][4]."</a><br /><a href='#' class=order_state_8>".self::$language['set_to'].self::$language['order_state'][8]."</a><br />";
			break;
		case 4:
			$cancel_reason='<div class=cancel_reason>'.$v['cancel_reason'].'</div>';
			break;
		case 5:
			$cancel_reason='<div class=cancel_reason>'.$v['cancel_reason'].'</div>';
			break;
		case 6:
			break;
		case 7:
			$act="<a href='#' class=view_apply d_id=".$v['id'].">".self::$language['view'].self::$language['refund'].self::$language['apply']."</a><br />";
			break;
		case 8:
			$act="<a href='#' class=view_apply d_id=".$v['id'].">".self::$language['view'].self::$language['refund'].self::$language['apply']."</a><br />";
			break;
		case 9:
			$act="<a href='#' class=view_apply d_id=".$v['id'].">".self::$language['view'].self::$language['refund'].self::$language['apply']."</a><br />";
			$act.="<a href='#' class=view_refund_voucher d_id=".$v['id'].">".self::$language['view_refund_voucher']."</a><br />";
			$act.="<a href='#' class=confirm_refund d_id=".$v['id'].">".self::$language['confirm_refund']."</a><br />";
			break;
		case 10:
			$act="<a href='#' class=view_apply d_id=".$v['id'].">".self::$language['view'].self::$language['refund'].self::$language['apply']."</a><br />";
			break;
		case 11:
			$act="<a href='#' class=cancel   d_id=".$v['id'].">".self::$language['cancel'].self::$language['order_id']."</a><br />";
			break;
		case 12:
			$act="<a href='#' class=cancel   d_id=".$v['id'].">".self::$language['cancel'].self::$language['order_id']."</a><br />";
			break;
		case 13:
			$act="<a href='#' class=cancel   d_id=".$v['id'].">".self::$language['cancel'].self::$language['order_id']."</a><br />";
			break;
		case 14:
			$act="<a href='#' class=edit_c d_id=".$v['id']." act='order_state_2'>".self::$language['set_to'].self::$language['order_state'][2]."</a><br /><a href='#' class=cancel   d_id=".$v['id'].">".self::$language['cancel'].self::$language['order_id']."</a><br />";
			break;
	}
	if(in_array($v['state'],self::$config['order_del_able_seller'])){$act.="<a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a><br />";}
	
	
	if($v['express_code']!=''){
		$temp3=explode(',',$v['express_code']);
		if(count($temp3)>1){
			$temp2='';
			foreach($temp3 as $v3){
				$temp2.='<a href=./'.$module['action_url'].'&act=go_express&id='.$v['express'].'&code='.$v3.' target=_blank>'.$v3.'</a> , ';		
			}
			$v['express_code']=trim($temp2,' , ');
		}else{
			$v['express_code']='<a href=./'.$module['action_url'].'&act=go_express&id='.$v['express'].'&code='.$v['express_code'].' target=_blank>'.$v['express_code'].'</a>';	
		}	
	}
	if($v['share']!=''){
		$share='<span class=share>'.self::$language['promotion'].':<span>'.get_username($pdo,$v['share']).'</span></span>';
	}else{
		$share='';
	}
	if($v['check_code']!=''){
		$check_code='<span class=check_code>'.self::$language['check_code'].':<span>'.$v['check_code'].'</span></span>';
	}else{
		$check_code='';
	}
	$money_info="<div class=money_div><div class=sum_money>".self::$language['need_pay'].": <span class=value>".$v['sum_money']."</span></div>".$actual."</div>";
	if($v['pre_sale']==0){
		$preferential_way="<div class=preferential_way>".$v['preferential_code'].self::$language['preferential_way_option'][$v['preferential_way']].": -". sprintf('%.2f',$v['goods_money']+$v['express_cost_buyer']-$v['sum_money']).self::$language['yuan']."</div>";
		
	}else{
		$sql="select * from ".self::$table_pre."order_pre_sale where `order_id`=".$v['id']." limit 0,1";
		$pre=$pdo->query($sql,2)->fetch(2);
		if($pre['id']!=''){
			self::end_pre_sale_order($pdo,$v,$pre);
			$pre_discount=$pre['pre_discount'];
			$preferential_way="<div class=preferential_way>".self::$language['pre_price'].':'.trim(trim($pre_discount,'0'),'.').self::$language['discount'].' <br />'.self::$language['deposit2'].':'.$pre['deposit'].' <br />'.self::$language['deduction'].':'.$pre['reduction'].' <br />'.self::$language['end_pay'].':'.($v['actual_money']-$pre['deposit']+$v['express_cost_buyer'])."<br />
			".self::$language['delivered'].":<br />".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$pre['delivered'])."<br /></div>
			<br />";
			
			$time=time();
			$pay_button='';
			if($time>$pre['last_pay_start_time'] && $time<$pre['last_pay_end_time'] ){
				//$pay_button='<a href=./index.php?monxin=mall.pay&id='.$v['id'].' target="_blank" class=go_pay>'.self::$language['pay'].'</a>';
			}
			
			
			if($v['state']==12 || $v['state']==13 ){
				$state_remark.="<div class=last_pay>".self::$language['last_pay_time'].":<br />".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$pre['last_pay_start_time'])."-<br />".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$pre['last_pay_end_time'])."<br />".$pay_button."</div>";
			}
			
			$money_info='';
		}
	}

	$buyer_address='';
	if($v['receiver_id']==-1){$buyer_address=self::$language['no_delivery'].'  '.self::$language['take_self'];}
	if($v['receiver_id']==0){
		if($v['express_code']==''){
			$buyer_address=self::$language['offline_purchase'];
		}else{
			$buyer_address="<span class=express>".self::get_express_name($pdo,self::$table_pre,$v['express'])."</span><span class=express_code>".$v['express_code']."</span>";
		}
	}
	if($v['receiver_id']>0){$buyer_address=$v['receiver_name'].' '.$v['receiver_phone'].' '.$v['receiver_area_name'].' '.$v['receiver_detail'].' '.$v['receiver_post_code'].' '.' <span class=delivery_time>'.@self::$language['delivery_time_info'][$v['delivery_time']]."</span><span class=express>".self::get_express_name($pdo,self::$table_pre,$v['express'])."</span><span class=express_code>".$v['express_code']."</span>";}
	
	if($_COOKIE['monxin_device']=='pc'){
		$list.="<div class='mall_order  portlet light'>
		<div class=order_head id=head_".$v['id']."><div class=title_tr><div class=buyer_info><span class=add_time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['add_time'])."</span><span class=order_id>".self::$language['order_number'].": <span class=value>".$v['out_id']."</span></span><span  class=buyer><a talk='".$v['buyer']."'>".$v['buyer']."</a></span><span class=express_cost_buyer>".self::$language['express_cost_buyer'].":<span class=value>".str_replace('.00','',$v['express_cost_buyer'])."</span>  ".$edit_express_cost_buyer."</span><span class=express_cost_seller>".self::$language['express_cost_seller'].":<span class=value>".str_replace('.00','',$v['express_cost_seller'])."</span>  ".$edit_express_cost_seller."</span><span class=invoice>".$v['invoice']."</span>".$share."</div><div class=buyer_address>".$buyer_address.$v['credits_remark']."</div></div></div>
		
	<div class=order_tr id='tr_".$v['id']."'>
		<div class=checkbox_td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></div>
		<div class=goods_td><div class=goods_info>".$temp."</div><div class=remark>".$v['buyer_remark']."<div class=seller_remark>".self::$language['seller'].self::$language['remark'].': <span class=value>'.$v['seller_remark']."</span> <a href=# class=edit_a d_id=".$v['id']." act='seller_remark'></a></div></div></div>
		<div class=preferential_td>".$preferential_way.$money_info.$v['change_price_reason']."</div>
		<div class=state_td><div class=order_state value='".self::$language['order_state'][$v['state']]."'>".self::$language['order_state'][$v['state']].$automatically_confirm_receipt.$cancel_reason."</div><div class=state_remark>".$state_remark."</div></div>
	  	<div class=operation_td>".$act." <span id=state_".$v['id']." class='state'></span></div>
	</div>
</div>
";
	}else{
		$list.="<div class=mall_order  id='tr_".$v['id']."'>
        	<div class=order_head><div class=shop_name>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['add_time'])." <a  talk='".$v['buyer']."'>".$v['buyer']."</a></div><div class=order_state value='".self::$language['order_state'][$v['state']]."'>".self::$language['order_state'][$v['state']].$cancel_reason."</div>".$v['credits_remark']."<span class=express_code>".$v['express_code']."</span></div>
            <div class=goods_td><div class=goods_info>".$phone_temp."</div><div class=remark>".$v['buyer_remark']."</div></div>
           	<div class=preferential_td>".$preferential_way.$money_info.$v['change_price_reason']."</div>
            <div class=operation_td>".$act." <span id=state_".$v['id']." class='state'></span></div>
			<div class=state_remark>".$state_remark."</div>
        </div>
";		
	}
	
}
if($sum==0){
	$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';
	if($_COOKIE['monxin_device']=='phone'){$list=self::$language['no_related_content'];}
}		
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

function get_mall_array_option($array){
	$list='';
	foreach($array as $k=>$v){
		if($k=='bank_transfer'){continue;}
		$list.='<option value='.$k.'>'.$v.'</option>';
	}
	return $list;	
}
function get_mall_invoice_option($pdo,$table_pre){
	$sql="select * from ".$table_pre."invoice order by `sequence` desc";
	$r=$pdo->query($sql,2);
	$list='';
	foreach($r as $v){
		$list.='<option value="'.$v['name'].'">'.$v['name'].'</option>';
	}
	return $list;
}
function get_mall_express_option($pdo,$table_pre){
	$sql="select * from ".$table_pre."express order by `sequence` desc";
	$r=$pdo->query($sql,2);
	$list='';
	foreach($r as $v){
		$list.='<option value="'.$v['id'].'">'.$v['name'].'</option>';
	}
	return $list;
}

function get_pay_api_option($pdo,$language){
	$list='';
	foreach($language['pay_api_option'] as $k=>$v){
		$list.='<option value="'.$k.'">'.$v.'</option>';
	}
	return $list;
}




$module['filter']="<select id='state' name='state'><option value='-1'>".self::$language['state']."</option><option value='' selected>".self::$language['all'].self::$language['state']."</option>".get_mall_array_option(self::$language['order_state'])."</select>";




$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
echo '<script src="./receive.php?target=mall::auto_receipt_expire_order"></script>';
