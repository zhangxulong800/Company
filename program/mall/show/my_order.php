<?php
if($_SESSION['monxin']['username']==''){echo '<span class=return_false>'.self::$language['username_null'].'</span>';return false;}
//检测是否有付款成功,但没成功跳回处理的订单
if(isset($_SESSION['monxin_mall_order_id'])){
	$for_id=trim($_SESSION['monxin_mall_order_id'],'|');
	$sql="select `state`,`for_id`,`money` from ".$pdo->index_pre."recharge where `for_id`='".$for_id."' and `username`='".$_SESSION['monxin']['username']."' order by `state` desc ,`id` desc  limit 0,1";
	//echo $sql;
	$r2=$pdo->query($sql,2)->fetch(2);
	if($r2['state']==4){
		$temp=explode('|',$for_id);
		foreach($temp as $v){
			if(is_numeric($v)){
				$sql="select `state`,`actual_money` from ".self::$table_pre."order where `id`=".$v." and `buyer`='".$_SESSION['monxin']['username']."' limit 0,1";
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['state']==0 && $r['actual_money']<=$r2['money']){header('location:./index.php?monxin=mall.pay&act=online_payment');exit;}	
			}	
		}
	}
}



if(@$_GET['act']=='show_bank_transfer'){
	echo '<style>#index_head,#top_bar,#index_user_position,#index_foot,#index_device{display:none;}</style>';
	$sql="select * from ".self::$table_pre."bank_transfer where `order_id`=".intval($_GET['id'])." and `buyer`='".$_SESSION['monxin']['username']."' limit 0,1";
	$r2=$pdo->query($sql,2)->fetch(2);
	if($r2['id']==''){echo 'id err';return false;}
	if($r2['pay_photo']!=''){$r2['pay_photo']='<img src=./program/mall/img/'.$r2['pay_photo'].' />';}
	echo '<div class=show_bank_transfer>'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$r2['time']).'<br />'.$r2['pay_info'].'<br />'.$r2['pay_photo'].'</div>';
	
	return false;	
}
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

$sql="select * from ".self::$table_pre."order where `buyer`='".$_SESSION['monxin']['username']."' and `buyer`!='' and `buyer_del`=0";

$where="";
if(intval(@$_GET['id'])!=0){
	$where=" and `id`=".intval($_GET['id']);
	echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=mall.my_order">'.self::$language['pages']['mall.my_order']['name'].'</a><span class=text>'.$_GET['id'].'</span></div>';
}

if($_GET['search']!=''){$where.=" and (`id` ='".$_GET['search']."' or `goods_names` like '%".$_GET['search']."%'  or `buyer_remark` like '%".$_GET['search']."%' or `receiver_name` like '%".$_GET['search']."%' or `receiver_phone` like '%".$_GET['search']."%' or `receiver_detail` like '%".$_GET['search']."%' or `receiver_post_code` like '%".$_GET['search']."%' or `receiver_area_name` like '%".$_GET['search']."%' or `out_id`='".$_GET['search']."')";}

if(@$_GET['state']!=''){$where.=" and `state`='".intval($_GET['state'])."'";}
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
	$sql="select * from ".self::$table_pre."order_goods where `order_id`='".$v['id']."' order by `id` asc";
	$r2=$pdo->query($sql,2);
	$temp='';
	$phone_temp='';
	foreach($r2 as $v2){
		$v2['transaction_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v2['transaction_price']);
		$v2['price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v2['price']);
		
		if($v['preferential_way']==5){$o_price='<span class=o_price>'.$v2['price'].'</span>';$v2['price']=$v2['transaction_price'];}else{$o_price='';}
		$add_comment='';
		$comment='';
		$refund='';
		if($v2['refund']>0){$refund='<span class=refund>'.self::$language['refunded'].':<span class=refund_v>'.self::format_quantity($v2['refund']).'</span>'.$v2['unit'].'</span>';}
		
		
		if($v['state']==6){//comment
			if((time()-$v['last_time'])/86400<=self::$config['comment_time_limit']){$comment_time_limit=true;}else{$comment_time_limit=false;}
			$comment_act='';
			$add_comment='';
			$sql="select * from ".self::$table_pre."comment where `order_id`='".$v['id']."' and `goods_id`='".$v2['goods_id']."' limit 0,1";
			$r3=$pdo->query($sql,2)->fetch(2);
			if($r3['id']!=''){
				$r3=de_safe_str($r3);
				if($comment_time_limit){$comment_act='<a href=# title="'.self::$language['edit'].'" class=edit>&nbsp;</a> <a href=# title="'.self::$language['del'].'" class=del d_id='.$r3['id'].'>&nbsp;</a>';}
				$comment='<div class=buyer><span class=time>'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$r3['time']).'</span><span class=content>'.$r3['content'].$comment_act.'</span><span class=user>'.self::$language['myself'].'</span></div>';
				if($r3['answer']!=''){
					$comment.='<div class=seller><span class=time>'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$r3['answer_time']).'</span><span class=content>&nbsp;'.$r3['answer'].'</span><span class=user>'.self::$language['seller'].'</span></div>';	
				}	
			}else{
				if($comment_time_limit){$add_comment='<a href=# class=add_comment>'.self::$language['comment'].'</a>';}
				$comment='';	
			}
		}
		if($_COOKIE['monxin_device']=='pc'){
			$temp.='<div class=goods goods_id='.$v2['goods_id'].' id=order_'.$v['id'].'_goods_'.$v2['goods_id'].'><a href="./index.php?monxin=mall.goods&id='.$v2['goods_id'].'" target=_blank class=icon><img src="./program/mall/order_icon/'.$v2['icon'].'" /></a><div class=title_price><div class=title><a href="./index.php?monxin=mall.goods&id='.$v2['goods_id'].'" target=_blank >'.$v2['title'].'</a></div><div class=price><a href="./index.php?monxin=mall.goods_snapshot&id='.$v2['snapshot_id'].'" target=_balnk>'.self::$language['goods'].self::$language['snapshot'].'</a>'.$o_price.str_replace('.00','',$v2['price'])."*".self::format_quantity($v2['quantity']).$v2['unit']."=".str_replace('.00','',$v2['price']*$v2['quantity']).self::$language['yuan'].$refund.' '.$add_comment.'</div></div>
			<div class=comment >
				'.$comment.'
			</div>
		</div>
		';
		}else{
			$phone_temp.="<div class=goods_div>
        	<span class=icon>
            	<a ><img src=./program/mall/order_icon/".$v2['icon']." /></a>
            </span><span class=other>
            	<div class=title>".$v2['title']."</div>
                <div class=price>".self::$language['price'].":".$o_price.str_replace('.00','',$v2['price']).self::$language['yuan']." &nbsp; ".self::$language['quantity'].":".self::format_quantity($v2['quantity']).$v2['unit'].$refund." <a href=./index.php?monxin=mall.goods_snapshot&id=".$v2['snapshot_id']." target=_balnk>".self::$language['snapshot']."</a> ".$add_comment."</div>
				
            </span>
			<div class=comment order_id=".$v['id']." goods_id=".$v2['goods_id'].">
				".$comment."
			</div>
        </div>";	
		}
		
		$goods_money+=$v2['transaction_price']*$v2['quantity'];
	}
	if($v['buyer_remark']!=''){$v['buyer_remark']="<div class=buyer_remark>".self::$language['remark'].': '.$v['buyer_remark'].'</div>';}
	if($v['state']<1){$actual="<div class=actual_money>".self::$language['actual_pay'].": <span class=value>".$v['actual_money']."</span></div>";}else{$actual="<div class=actual_money>".self::$language['actual_pay'].": <span class=value>".$v['actual_money']."</span></div>";}
	if($v['change_price_reason']!=''){$v['change_price_reason']="<div class=change_price_reason>".$v['change_price_reason']."</div>";}
	if($v['preferential_code']!=''){$v['preferential_code']='<div class=preferential_code>'.$v['preferential_code'].'</div>';}
	$act='';
	$state_remark='';
	$cancel_reason='';
	$edit_express_cost_buyer='';
	if($v['state']>0 && $v['pay_method']!=''){$state_remark='<div class=pay_method>'.self::$language['pay_method_str'].'<br />'.@self::$language['pay_method'][$v['pay_method']].'<span pay_method_remark='.$v['pay_method_remark'].'></span></div>';}
	
	if($v['state']>1 && $v['express_code']!=''){
		if($v['express']>0){
			$state_remark.='<a class=view_logistics  target=_blank order_id='.$v['id'].'>'.self::$language['view_logistics'].'</a>';
		}else{
			$state_remark.='<div style="background:#ECECEC; text-align:left; line-height:1.5rem;">'.rn_to_br($v['express_code']).'</div><a href=monxin></a>';
		}
	}
	
	switch($v['state']){
		case 0:
			$edit_express_cost_buyer="<a href=# class=edit_b d_id=".$v['id']." act='express_cost_buyer'></a>";
			$act="<a href='#' class=cancel d_id=".$v['id'].">".self::$language['cancel'].self::$language['order_id']."</a><br />";
			$state_remark='<div class=pay_time_limit>'.self::$language['pay_time_limit'].'<br />'.self::get_pay_time_limit(self::$language,self::$config['pay_time_limit'],$v['add_time']).'</div><a href="./index.php?monxin=mall.pay&id='.$v['id'].'" class=go_pay target=_blank>'.self::$language['select_pay_method'].'</a>';
			break;
		case 1:
			$act="<a href='#' class=cancel  d_id=".$v['id'].">".self::$language['cancel'].self::$language['order_id']."</a><br />";
			$act='';
			break;
		case 2:
			$time_limit=self::$language['time_limit'];
			$end_time=$v['send_time']+(self::$config['receipt_time_limit']+$v['receiving_extension'])*86400;
			$d=floor(($end_time-time())/86400);
			$h=floor((($end_time-time())%86400)/3600);
			$time_limit=str_replace('{d}',$d,$time_limit);
			$time_limit=str_replace('{h}',$h,$time_limit);
			$act="<div class=time_limit>".$time_limit."</div><a href='#' class=confirm_receipt d_id=".$v['id'].">".self::$language['confirm_receipt']."</a><br />";
			$act.="<a href='#' class=apply_refund d_id=".$v['id'].">".self::$language['apply_return']."</a><br />";
			if($v['check_code']!=''){$act.="<div class=check_code> &nbsp; ".self::$language['check_code_2'].":<b>".$v['check_code']."</b><br /><img src=./plugin/qrcode/index.php?text=".$v['check_code']."></div>";}
			
			break;
		case 3:
			$act="";
			break;
		case 4:
			$cancel_reason='<div class=cancel_reason>'.$v['cancel_reason'].'</div>';
			break;
		case 5:
			$cancel_reason='<div class=cancel_reason>'.$v['cancel_reason'].'</div>';
			break;
		case 6:
			$act="<a href='#' class=apply_refund d_id=".$v['id'].">".self::$language['apply_return']."</a><br />";
			break;
		case 7:
			$act="<a href='#' class=apply_refund d_id=".$v['id'].">".self::$language['edit'].self::$language['return_goods'].self::$language['apply']."</a><br />";
			$act.="<a href='#' class=undo_refund d_id=".$v['id'].">".self::$language['undo'].self::$language['return_goods'].self::$language['apply']."</a><br />";
			break;
		case 8:
			$act="<a href='#' class=apply_refund d_id=".$v['id'].">".self::$language['view'].self::$language['refund'].self::$language['apply']."</a><br />";
			$act.="<a href='#' class=upload_refund_voucher d_id=".$v['id'].">".self::$language['upload_refund_voucher']."</a><br />";
			$act.="<a href='#' class=undo_refund d_id=".$v['id'].">".self::$language['undo'].self::$language['return_goods'].self::$language['apply']."</a><br />";
			break;
		case 9:
			$act="<a href='#' class=apply_refund d_id=".$v['id'].">".self::$language['view'].self::$language['refund'].self::$language['apply']."</a><br />";
			$act.="<a href='#' class=upload_refund_voucher d_id=".$v['id'].">".self::$language['edit_refund_voucher']."</a><br />";
			break;
		case 10:
			$act="<a href='#' class=apply_refund d_id=".$v['id'].">".self::$language['view'].self::$language['refund'].self::$language['apply']."</a><br />";
			break;
		case 11:
			$edit_express_cost_buyer="<a href=# class=edit_b d_id=".$v['id']." act='express_cost_buyer'></a>";
			$act="<a href='#' class=cancel d_id=".$v['id'].">".self::$language['cancel'].self::$language['order_id']."</a><br />";
			$state_remark='<div class=pay_time_limit>'.self::$language['pay_time_limit'].'<br />'.self::get_pay_time_limit(self::$language,self::$config['pay_time_limit'],$v['add_time']).'</div><a href="./index.php?monxin=mall.pay&id='.$v['id'].'" class=go_pay target=_blank>'.self::$language['select_pay_method'].'</a>';
			break;
		case 13:
			$edit_express_cost_buyer="<a href=# class=edit_b d_id=".$v['id']." act='express_cost_buyer'></a>";
			$state_remark='<div class=pay_time_limit>'.self::$language['pay_time_limit'].'<br />'.self::get_pay_time_limit(self::$language,self::$config['pay_time_limit'],$v['add_time']).'</div><a href="./index.php?monxin=mall.pay&id='.$v['id'].'" class=go_pay target=_blank>'.self::$language['select_pay_method'].'</a>';
			break;
			
	}
	if(in_array($v['state'],self::$config['order_del_able'])){$act.="<a href='#' class='del'>".self::$language['del']."</a><br />";}
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
	if($v['sum_money']!=$v['actual_money']){
		$money_info="<div class=money_div><div class=sum_money>".self::$language['need_pay'].": <span class=value>".$v['sum_money']."</span></div>".$actual."</div>";	
	}else{
		$money_info='<div class=big_money>'.str_replace('.00','',$v['sum_money']).self::$language['yuan'].'</div>';
	}
	if($v['credits_remark']!=''){$v['credits_remark']='<div class=credits_remark>'.$v['credits_remark'].'</div>';}
	if($v['pre_sale']==0){
		$preferential_way="<div class=preferential_way>".$v['preferential_code'].self::$language['preferential_way_option'][$v['preferential_way']].": -". sprintf('%.2f',$v['goods_money']+$v['express_cost_buyer']-$v['sum_money']).self::$language['yuan']."</div>";
		if($_COOKIE['monxin_device']=='phone'){
			$preferential_way="<span class=goods_money><span class=value>".$v['goods_money']."</span></span> + <span class=express_cost_buyer>".self::$language['freight_costs'].": <span class=value>".str_replace('.00','',$v['express_cost_buyer'])."</span></span> + <div class=preferential_way>".$v['preferential_code'].self::$language['preferential_way_option'][$v['preferential_way']].": -". sprintf('%.2f',$v['goods_money']+$v['express_cost_buyer']-$v['sum_money']).self::$language['yuan']."</div> = ";
			if($v['preferential_way']==5){$preferential_way="+ <span class=express_cost_buyer>".self::$language['freight_costs'].": <span class=value>".str_replace('.00','',$v['express_cost_buyer'])."</span></span>=";}
		}
		
	}else{
		$sql="select * from ".self::$table_pre."order_pre_sale where `order_id`=".$v['id']." limit 0,1";
		$pre=$pdo->query($sql,2)->fetch(2);
		if($pre['id']!=''){
			self::end_pre_sale_order($pdo,$v,$pre);
			$pre_discount=$pre['pre_discount'];
			$pre['deposit']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$pre['deposit']);
			$pre['reduction']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$pre['reduction']);
			
			$preferential_way="<div class=preferential_way>".self::$language['pre_price'].':'.trim(trim($pre_discount,'0'),'.').self::$language['discount'].' <br />'.self::$language['deposit2'].':'.$pre['deposit'].self::$language['yuan'].' <br />'.self::$language['deduction'].':'.$pre['reduction'].' <br />'.self::$language['end_pay'].':'.($v['actual_money']-$pre['deposit']+$v['express_cost_buyer'])."<br />
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
		<div class=order_head id=head_".$v['id']."><div class=title_tr><div class=buyer_info><a talk='".self::get_shop_master($pdo,$v['shop_id'])."'>".self::get_shop_name($pdo,$v['shop_id'])."</a> <span class=add_time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['add_time'])."</span><span class=order_id>".self::$language['order_number'].": <span class=value>".$v['out_id']."</span></span><br><span class=express_cost_buyer>".self::$language['freight_costs'].": <span class=value>".str_replace('.00','',$v['express_cost_buyer'])."</span></span><span class=invoice>".$v['invoice']."</span></div><div class=buyer_address>".$buyer_address.$v['credits_remark']."</div></div></div>
		<div class=order_tr id='tr_".$v['id']."'>
			<div class=goods_td><div class=goods_info>".$temp."</div><div class=remark>".$v['buyer_remark']."</div></div>
			<div class=preferential_td>".$preferential_way.$money_info.$v['change_price_reason']."</div>
			<div class=state_td><div class=order_state value='".self::$language['order_state'][$v['state']]."'>".self::$language['order_state'][$v['state']].$cancel_reason."</div><div class=state_remark>".$state_remark."</div></div>
		  	<div class=operation_td>".$act." <span id=state_".$v['id']." class='state'></span></div>
		</div>

</div>
";	
	}else{
		
		$list.="<div class=mall_order  id='tr_".$v['id']."'>
        	<div class=order_head><a talk='".self::get_shop_master($pdo,$v['shop_id'])."' class=shop_name>".self::get_shop_name($pdo,$v['shop_id'])."</a><div class=order_state value='".self::$language['order_state'][$v['state']]."'>".self::$language['order_state'][$v['state']].$cancel_reason."</div>".$v['credits_remark']."<span class=express_code>".$v['express_code']."</span></div>
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
	if($_COOKIE['monxin_device']=='phone'){$list='<span class=no_related_content_span>'.self::$language['no_related_content'].'</span>';}
	}		
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

function get_mall_array_option($array){
	$list='';
	foreach($array as $k=>$v){
		//if($k==9){continue;}
		$list.='<option value='.$k.'>'.$v.'</option>';
	}
	return $list;	
}


$module['state_option']='<a href=./index.php?monxin=mall.my_order class=current>'.self::$language['all'].'</a>';
foreach(self::$language['order_state'] as $k=>$v){
	if($k==0 || $k==1 || $k==2 || $k==6 || $k==10 || $k==16){$module['state_option'].='<a href=./index.php?monxin=mall.my_order&state='.$k.' state='.$k.'>'.$v.'</a>';}
	
}


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
echo '<script src="./receive.php?target=mall::auto_receipt_expire_order"></script>';
