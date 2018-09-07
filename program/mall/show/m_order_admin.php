<?php
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




$sql="select * from ".self::$table_pre."order";

$where="";
if(intval(@$_GET['id'])!=0){
	$where=" and `id`=".intval($_GET['id']);
	echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=mall.m_order_admin">'.self::$language['pages']['mall.m_order_admin']['name'].'</a><span class=text>'.$_GET['id'].'</span></div>';
}

if($_GET['search']!=''){$where=" and (`id` ='".$_GET['search']."' or `buyer_remark` like '%".$_GET['search']."%'  or `goods_names` like '%".$_GET['search']."%' or `buyer` like '%".$_GET['search']."%' or `express_code` like '%".$_GET['search']."%' or `preferential_code` like '%".$_GET['search']."%' or `receiver_name` like '%".$_GET['search']."%' or `receiver_phone` like '%".$_GET['search']."%' or `receiver_detail` like '%".$_GET['search']."%' or `receiver_post_code` like '%".$_GET['search']."%' or `receiver_area_name` like '%".$_GET['search']."%' or `out_id`='".$_GET['search']."')";}

if(@$_GET['shop_name']!=''){
	$t_sql="select `id` from ".self::$table_pre."shop where `name`='".safe_str($_GET['shop_name'])."' and `state`>1 order by `state` asc";
	$r=$pdo->query($t_sql,2)->fetch(2);
	$shop_id=$r['id'];
	if($shop_id==''){$shop_id=0;}
	$where.=" and `shop_id`='".$shop_id."'";
}
if(@$_GET['seller']!=''){
	$t_sql="select `id` from ".self::$table_pre."shop where `username`='".safe_str($_GET['seller'])."' and `state`>1 order by `state` asc";
	$r=$pdo->query($t_sql,2)->fetch(2);
	$shop_id=$r['id'];
	if($shop_id==''){$shop_id=0;}
	$where.=" and `shop_id`='".$shop_id."'";
}

if(@$_GET['state']!=''){$where.=" and `state`='".intval($_GET['state'])."'";}


$time=time();
$today=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);
$time=get_unixtime($today,'y-m-d')-86400;
$yesterday=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);

$time=get_unixtime($today,'y-m-d')-(86400*6);
$days_7=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);

$time=get_unixtime($today,'y-m-d')-(86400*29);
$days_30=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);

$module['days']='<a href="./index.php?monxin=mall.m_order_admin&start_time='.$today.'&end_time='.$today.'" se="'.$today.'-'.$today.'">'.self::$language['today'].'</a>';
$module['days'].='<a href="./index.php?monxin=mall.m_order_admin&start_time='.$yesterday.'&end_time='.$yesterday.'" se="'.$yesterday.'-'.$yesterday.'">'.self::$language['yesterday'].'</a>';
$module['days'].='<a href="./index.php?monxin=mall.m_order_admin&start_time='.$days_7.'&end_time='.$today.'" se="'.$days_7.'-'.$today.'">'.self::$language['days_7'].'</a>';
$module['days'].='<a href="./index.php?monxin=mall.m_order_admin&start_time='.$days_30.'&end_time='.$today.'" se="'.$days_30.'-'.$today.'">'.self::$language['days_30'].'</a>';

if(@$_GET['pay_method_remark']!=''){
	$where.=" and (`pay_method_remark`='".safe_str($_GET['pay_method_remark'])."' or `pay_method_remark`='".safe_str($_GET['pay_method_remark'])."_wap')";
}
if(@$_GET['settlement_state']!=''){$where.=" and `settlement_state`='".intval($_GET['settlement_state'])."'";}
if(@$_GET['pay_method']!=''){$where.=" and `pay_method`='".safe_str($_GET['pay_method'])."'";}
if(@$_GET['buy_method']!=''){
	if($_GET['buy_method']=='monxin'){$where.=" and `cashier`='monxin'";}
	if($_GET['buy_method']=='cashier'){$where.=" and `cashier`!='monxin'";}
}
if(@$_GET['preferential_way']!=''){$where.=" and `preferential_way`='".intval($_GET['preferential_way'])."'";}
if(@$_GET['express']!=''){$where.=" and `express`='".intval($_GET['express'])."'";}
if(@$_GET['invoice']!=''){$where.=" and `invoice`='".safe_str($_GET['invoice'])."'";}
if(@$_GET['start_time']!=''){
	$start_time=get_unixtime($_GET['start_time'],self::$config['other']['date_style']);
	$where.=" and `add_time`>$start_time";	
}
if(@$_GET['end_time']!=''){
	$end_time=get_unixtime($_GET['end_time'],self::$config['other']['date_style'])+86400;
	$where.=" and `add_time`<$end_time";	
}


$_GET['order']=safe_str(@$_GET['order']);
if($_GET['order']==''){
	$order=" order by `id` desc";
}else{
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
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
	
	if($v['pay_method']=='credits'){
		self::$language['yuan']=self::$language['credits'];
		self::$config['pay_mode']='credits';
	}else{
		self::$language['yuan']=self::$language['yuan_2'];
		self::$config['pay_mode']='money';
	}
	
	$v['actual_money']-=$v['web_credits_money'];
	$v['actual_money']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['actual_money']);
	$v['sum_money']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['sum_money']);
	$v['goods_money']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['goods_money']);
	$v['express_cost_buyer']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['express_cost_buyer']);

	$goods_money=0;
	$v=de_safe_str($v);
	if($v['credits_remark']!=''){$v['credits_remark']='<div class=credits_remark>'.$v['credits_remark'].'</div>';}

	$sql="select * from ".self::$table_pre."order_goods where `order_id`='".$v['id']."' order by `id` asc";
	$r2=$pdo->query($sql,2);
	$temp='';
	$phone_temp='';
	$shop_name=self::get_shop_name($pdo,$v['shop_id']);
	$shop_master=self::get_shop_master($pdo,$v['shop_id']);
	foreach($r2 as $v2){
		$v2['transaction_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v2['transaction_price']);
		$v2['price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v2['price']);
		if($v['preferential_way']==5){$o_price='<span class=o_price>'.$v2['price'].'</span>';$v2['price']=$v2['transaction_price'];}else{$o_price='';}
		$refund='';
		if($v2['refund']>0){$refund='<span class=refund>'.self::$language['refunded'].':<span class=refund_v>'.self::format_quantity($v2['refund']).'</span>'.$v2['unit'].'</span>';}
		
		
		if($_COOKIE['monxin_device']=='pc'){
			$temp.='<div class=goods id=g_'.$v2['id'].'><a href="./index.php?monxin=mall.goods&id='.$v2['goods_id'].'" target=_blank class=icon><img src="./program/mall/order_icon/'.$v2['icon'].'" /></a><div class=title_price><div class=title><a href="./index.php?monxin=mall.goods&id='.$v2['goods_id'].'" target=_blank >'.$v2['title'].'</a></div><div class=price><a href="./index.php?monxin=mall.goods_snapshot&id='.$v2['snapshot_id'].'" target=_balnk>'.self::$language['goods'].self::$language['snapshot'].'</a><span class=g_price>'.$o_price.str_replace('.00','',$v2['price'])."</span>*<span class=g_quantity>".self::format_quantity($v2['quantity']).'</span>'.$v2['unit']."=<span class=g_sum_money>".str_replace('.00','',$v2['price']*$v2['quantity']).'</span>'.self::$language['yuan'].$refund.'</div></div></div>';
		}else{
			$phone_temp.="<div class=goods_div>
        	<span class=icon>
            	<a ><img src=./program/mall/order_icon/".$v2['icon']." /></a>
            </span><span class=other>
            	<div class=title>".$v2['title']."</div>
                <div class=price>".self::$language['price'].":".$o_price.self::$language['money_symbol'].str_replace('.00','',$v2['price'])." &nbsp; ".self::$language['quantity'].":".self::format_quantity($v2['quantity']).$v2['unit'].$refund." <a href=./index.php?monxin=mall.goods_snapshot&id=".$v2['snapshot_id']." target=_balnk>".self::$language['snapshot']."</a></div>
            </span>
        </div>";	

		}
		
		$goods_money+=$v2['transaction_price']*$v2['quantity'];
	}
	if($v['buyer_remark']!=''){$v['buyer_remark']="<div class=buyer_remark>".self::$language['buyer'].self::$language['remark'].': '.$v['buyer_remark'].'</div>';}
	if($v['state']<1){$actual="<div class=actual_money>".self::$language['actual_pay'].": <span class=value>".$v['actual_money']."</span></div>";}else{$actual="<div class=actual_money>".self::$language['actual_pay'].": <span class=value>".$v['actual_money']."</span></div>";}
	if($v['change_price_reason']!=''){$v['change_price_reason']="<div class=change_price_reason>".$v['change_price_reason']."</div>";}
	if($v['preferential_code']!=''){$v['preferential_code']='<div class=preferential_code>'.$v['preferential_code'].'</div>';}
	$act='';
	$cancel_reason='';
	$state_remark='';
	$edit_express_cost_buyer='';
	if($v['state']>0){$state_remark='<div class=pay_method>'.self::$language['pay_method_str'].'<br />'.@self::$language['pay_method'][$v['pay_method']].'<span pay_method_remark='.$v['pay_method_remark'].'></span></div>';}

	if($v['state']>1 && $v['express_code']!=''){
		if($v['express']>0){
			$state_remark.='<a class=view_logistics  target=_blank order_id='.$v['id'].'>'.self::$language['view_logistics'].'</a>';
		}else{
			
		}
	}
	
	switch($v['state']){
		case 0:
			$state_remark='<div class=pay_time_limit>'.self::$language['pay_time_limit'].'<br />'.self::get_pay_time_limit(self::$language,self::$config['pay_time_limit'],$v['add_time']).'</div>';
			break;
		case 1:
			break;
		case 2:
			break;
		case 3:
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
			$act.="<a href='#' class=force_refund d_id=".$v['id'].">".self::$language['force_refund']."</a><br />";
			break;
		case 8:
			$act="<a href='#' class=view_apply d_id=".$v['id'].">".self::$language['view'].self::$language['refund'].self::$language['apply']."</a><br />";
			break;
		case 9:
			$act="<a href='#' class=view_apply d_id=".$v['id'].">".self::$language['view'].self::$language['refund'].self::$language['apply']."</a><br />";
			$act.="<a href='#' class=force_refund d_id=".$v['id'].">".self::$language['force_refund']."</a><br />";
			break;
		case 10:
			$act="<a href='#' class=view_apply d_id=".$v['id'].">".self::$language['view'].self::$language['refund'].self::$language['apply']."</a><br />";
			break;
	}
	if(in_array($v['state'],self::$config['order_del_able_master'])){$act.="<a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a><br />";}
	
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
	
	$money_info="<div class=money_div><div class=sum_money>".self::$language['need_pay'].": <span class=value>".$v['sum_money']."</span></div>".$actual."</div>";
	if($v['pre_sale']==0){
		$preferential_way="<div class=preferential_way>".$v['preferential_code'].self::$language['preferential_way_option'][$v['preferential_way']].": -". sprintf('%.2f',$v['goods_money']+$v['express_cost_buyer']-$v['sum_money']).self::$language['yuan']."</div>";
	}else{
		$sql="select * from ".self::$table_pre."order_pre_sale where `order_id`=".$v['id']." limit 0,1";
		$pre=$pdo->query($sql,2)->fetch(2);
		if($pre['id']!=''){
			self::end_pre_sale_order($pdo,$v,$pre);
			$pre['deposit']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$pre['deposit']);
			$pre['reduction']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$pre['reduction']);
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
	if($v['receiver_id']==0){$buyer_address=self::$language['offline_purchase'];}
	if($v['receiver_id']>0){$buyer_address=$v['receiver_name'].' '.$v['receiver_phone'].' '.$v['receiver_area_name'].' '.$v['receiver_detail'].' '.$v['receiver_post_code'].' '.' <span class=delivery_time>'.@self::$language['delivery_time_info'][$v['delivery_time']]."</span><span class=express>".self::get_express_name($pdo,self::$table_pre,$v['express'])."</span><span class=express_code>".$v['express_code']."</span>";}
	
	if($_COOKIE['monxin_device']=='pc'){
		$list.="<div class='mall_order  portlet light'>
		<div class=order_head id=head_".$v['id']."><div class=title_tr><div class=buyer_info><a class=shop_name  talk='".$shop_master."'>".$shop_name."</a> <span class=add_time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['add_time'])."</span><span class=order_id>".self::$language['order_number'].": <span class=value>".$v['out_id']."</span></span><span  class=buyer><a talk='".$v['buyer']."'>".$v['buyer']."</a></span><span class=express_cost_buyer>".self::$language['express_cost_buyer'].":<span class=value>".str_replace('.00','',$v['express_cost_buyer'])."</span>  ".$edit_express_cost_buyer."</span><span class=express_cost_seller>".self::$language['express_cost_seller'].":<span class=value>".str_replace('.00','',$v['express_cost_seller'])."</span> </span><span class=invoice>".$v['invoice']."</span></div><div class=buyer_address>".$buyer_address.$v['credits_remark']."</div></div></div>
		
	<div class=order_tr id='tr_".$v['id']."'>
		<div class=checkbox_td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></div>
		<div class=goods_td><div class=goods_info>".$temp."</div><div class=remark>".$v['buyer_remark']."<div class=seller_remark>".self::$language['seller'].self::$language['remark'].': <span class=value>'.$v['seller_remark']."</span> </div></div></div>
		<div class=preferential_td>".$preferential_way.$money_info.$v['change_price_reason']."</div>
		<div class=state_td><div class=order_state value='".self::$language['order_state'][$v['state']]."'>".self::$language['order_state'][$v['state']].$cancel_reason."</div><div class=state_remark>".$state_remark."</div></div>
	 	<div class=operation_td>".$act." <span id=state_".$v['id']." class='state'></span></div>
  	</div>
</div>
";
	}else{
		$list.="<div class=mall_order  id='tr_".$v['id']."'>
        	<div class=order_head><a href='./index.php?monxin=mall.shop_index&shop_id=".$v['shop_id']."' class=shop_name target=_blank>".self::get_shop_name($pdo,$v['shop_id'])."</a><div class=order_state value='".self::$language['order_state'][$v['state']]."'>".self::$language['order_state'][$v['state']].$cancel_reason."</div>".$v['credits_remark']."</div>
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
$module['filter'].="<select id='pay_method' name='pay_method'><option value='-1'>".self::$language['pay_method_str']."</option><option value='' selected>".self::$language['all'].self::$language['pay_method_str']."</option>".get_mall_array_option(self::$language['pay_method'])."</select>";
$module['filter'].="<select id='buy_method' name='buy_method'><option value='-1'>".self::$language['buy_method']."</option><option value='' selected>".self::$language['all'].self::$language['buy_method']."</option><option value='monxin'>".self::$language['buy_method_option']['monxin']."</option><option value='cashier'>".self::$language['buy_method_option']['cashier']."</option></select>";
$module['filter'].="<select id='preferential_way' name='preferential_way'><option value='-1'>".self::$language['use_method']."</option><option value='' selected>".self::$language['all'].self::$language['use_method']."</option>".get_mall_array_option(self::$language['preferential_way_option'])."</select>";
$module['filter'].="<select id='express' name='express'><option value='-1'>".self::$language['express']."</option><option value='' selected>".self::$language['all'].self::$language['express']."</option>".get_mall_express_option($pdo,self::$table_pre)."</select>";
$module['filter'].="<select id='pay_method_remark' name='pay_method_remark'><option value='-1'>".self::$language['pay_api']."</option><option value='' selected>".self::$language['all'].self::$language['pay_api']."</option>".get_pay_api_option($pdo,self::$language)."</select>";


//===============================================================================================================================【获取统计信息】
if(@$_GET['state']==''){$module['module_state_name']=self::$language['all'].self::$language['state'];}else{$module['module_state_name']=self::$language['order_state'][intval($_GET['state'])];}
$where=rtrim($where);
$where=str_replace('  ',' ',$where);

$sql="select sum(`actual_money`) as c from ".self::$table_pre."order".$where;
$sql=str_replace("_order and","_order where",$sql);
//echo $sql;

$r=$pdo->query($sql,2)->fetch(2);
$module['sum']['sum']=floatval($r['c']);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
echo '<script src="./receive.php?target=mall::auto_receipt_expire_order"></script>';
