<?php
$shop_id=intval(@$_GET['shop_id']);
if($shop_id==0){echo 'id err';return false;}
if(!self::is_head($pdo,$shop_id)){echo 'shop_id no power';return false;}
$sql="select `name` from ".self::$table_pre."shop where `id`=".$shop_id;
$r=$pdo->query($sql,2)->fetch(2);
$module['shop_name']=de_safe_str($r['name']);

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['visible']=@$_GET['visible'];
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."order where `shop_id`='".$shop_id."'";

$where="";
if(intval(@$_GET['id'])!=0){
	$where=" and `id`=".intval($_GET['id']);
	echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=mall.m_order_admin">'.self::$language['pages']['mall.m_order_admin']['name'].'</a><span class=text>'.$_GET['id'].'</span></div>';
}

if($_GET['search']!=''){$where=" and (`id` ='".$_GET['search']."' or `out_id` ='".$_GET['search']."' or `goods_names` like '%".$_GET['search']."%' or `buyer` like '%".$_GET['search']."%' or `express_code` like '%".$_GET['search']."%' or `preferential_code` like '%".$_GET['search']."%' or `receiver_name` like '%".$_GET['search']."%' or `receiver_phone` like '%".$_GET['search']."%' or `receiver_detail` like '%".$_GET['search']."%' or `receiver_post_code` like '%".$_GET['search']."%' or `receiver_area_name` like '%".$_GET['search']."%')";}

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
	$v['actual_money']-=$v['web_credits_money'];
	$goods_money=0;
	$v=de_safe_str($v);
	if($v['credits_remark']!=''){$v['credits_remark']='<div class=credits_remark>'.$v['credits_remark'].'</div>';}

	$sql="select * from ".self::$table_pre."order_goods where `order_id`='".$v['id']."' order by `id` asc";
	$r2=$pdo->query($sql,2);
	$temp='';
	$phone_temp='';
	$shop_name=self::get_shop_name($pdo,$v['shop_id']);
	foreach($r2 as $v2){
		if($_COOKIE['monxin_device']=='pc'){
			$temp.='<div class=goods id=g_'.$v2['id'].'><a href="./index.php?monxin=mall.goods&id='.$v2['goods_id'].'" target=_blank class=icon><img src="./program/mall/order_icon/'.$v2['icon'].'" /></a><div class=title_price><div class=title><a href="./index.php?monxin=mall.goods&id='.$v2['goods_id'].'" target=_blank >'.$v2['title'].'</a></div><div class=price><a href="./index.php?monxin=mall.goods_snapshot&id='.$v2['snapshot_id'].'" target=_balnk>'.self::$language['goods'].self::$language['snapshot'].'</a><span class=g_price>'.str_replace('.00','',$v2['transaction_price'])."</span>*<span class=g_quantity>".self::format_quantity($v2['quantity']).'</span>'.$v2['unit']."=<span class=g_sum_money>".str_replace('.00','',$v2['transaction_price']*$v2['quantity']).'</span>'.self::$language['yuan'].'</div></div></div>';
		}else{
			$phone_temp.="<div class=goods_div>
        	<span class=icon>
            	<a ><img src=./program/mall/order_icon/".$v2['icon']." /></a>
            </span><span class=other>
            	<div class=title>".$v2['title']."</div>
                <div class=price>".self::$language['price'].":".self::$language['money_symbol'].str_replace('.00','',$v2['transaction_price'])." &nbsp; ".self::$language['quantity'].":".self::format_quantity($v2['quantity']).$v2['unit']." <a href=./index.php?monxin=mall.goods_snapshot&id=".$v2['snapshot_id']." target=_balnk>".self::$language['snapshot']."</a></div>
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
	if($v['state']>0){$state_remark='<div class=pay_method>'.self::$language['pay_method_str'].'<br />'.@self::$language['pay_method'][$v['pay_method']].'</div>';}
	if($v['state']>1 && $v['express_code']!=''){$state_remark.='<a class=view_logistics  target=_blank order_id='.$v['id'].'>'.self::$language['view_logistics'].'</a>';}
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
	$act='';
	if($v['express_code']!=''){
		$temp3=explode(',',$v['express_code']);
		if(count($temp3)>1){
			$temp2='';
			foreach($temp3 as $v3){
				$temp2.='<a href=./receive.php?target=mall::order_admin&act=go_express&id='.$v['express'].'&code='.$v3.' target=_blank>'.$v3.'</a> , ';		
			}
			$v['express_code']=trim($temp2,' , ');
		}else{
			$v['express_code']='<a href=./receive.php?target=mall::order_admin&act=go_express&id='.$v['express'].'&code='.$v['express_code'].' target=_blank>'.$v['express_code'].'</a>';	
		}	
	}
	
	$money_info="<div class=money_div><div class=sum_money>".self::$language['need_pay'].": <span class=value>".$v['sum_money']."</span></div>".$actual."</div>";
	if($v['pre_sale']==0){
		$preferential_way="<div class=preferential_way>".$v['preferential_code'].self::$language['preferential_way_option'][$v['preferential_way']].": -". sprintf('%.2f',$goods_money+$v['express_cost_buyer']-$v['sum_money']).self::$language['yuan']."</div>";
	}else{
		$sql="select `goods_id` from ".self::$table_pre."order_goods where `order_id`=".$v['id']." limit 0,1";
		$og=$pdo->query($sql,2)->fetch(2);
		$sql="select * from ".self::$table_pre."pre_sale where `goods_id`=".$og['goods_id']." limit 0,1";
		$pre=$pdo->query($sql,2)->fetch(2);
		$sql="select `pre_discount` from ".self::$table_pre."goods where `id`=".$og['goods_id']." limit 0,1";
		$pre_discount=$pdo->query($sql,2)->fetch(2);
		$pre_discount=$pre_discount['pre_discount'];
		$preferential_way="<div class=preferential_way>".self::$language['pre_price'].':'.trim(trim($pre_discount,'0'),'.').self::$language['discount'].'<br />'.self::$language['deposit2'].':'.$pre['deposit'].'<br />'.self::$language['deduction'].':'.$pre['reduction'].'<br />'.self::$language['end_pay'].':'.($v['goods_money']-$pre['reduction']+$v['express_cost_buyer'])."</div><br /><br />";
		$money_info='';
	}
	
	if($_COOKIE['monxin_device']=='pc'){
		$list.="<div class='mall_order  portlet light'>
		<div class=order_head id=head_".$v['id']."><div class=title_tr><div class=buyer_info><a class=shop_name href=./index.php?monxin=mall.shop_index&shop_id=".$v['shop_id']." target=_blank>".$shop_name."</a> <span class=add_time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['add_time'])."</span><span class=order_id>".self::$language['order_number'].": <span class=value>".$v['out_id']."</span></span><span  class=buyer><a href=#>".$v['buyer']."</a></span><span class=goods_money>".self::$language['goods_money'].": <span class=value>".$v['goods_money']."</span></span><span class=express_cost_buyer>".self::$language['express_cost_buyer'].":<span class=value>".str_replace('.00','',$v['express_cost_buyer'])."</span>  ".$edit_express_cost_buyer."</span><span class=express_cost_seller>".self::$language['express_cost_seller'].":<span class=value>".str_replace('.00','',$v['express_cost_seller'])."</span> </span><span class=invoice>".$v['invoice']."</span></div><div class=buyer_address>".$v['receiver_name'].' '.$v['receiver_phone'].' '.$v['receiver_area_name'].' '.$v['receiver_detail'].' '.$v['receiver_post_code'].' '.' <span class=delivery_time>'.self::$language['delivery_time_info'][$v['delivery_time']]."</span><span class=express>".self::get_express_name($pdo,self::$table_pre,$v['express'])."</span><span class=express_code>".$v['express_code']."</span>".$v['credits_remark']."</div></div></div>
		
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
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
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


$module['filter']="<select id='state' name='state'><option value='-1'>".self::$language['state']."</option><option value='' selected>".self::$language['all'].self::$language['state']."</option>".get_mall_array_option(self::$language['order_state'])."</select>";
$module['filter'].="<select id='pay_method' name='pay_method'><option value='-1'>".self::$language['pay_method_str']."</option><option value='' selected>".self::$language['all'].self::$language['pay_method_str']."</option>".get_mall_array_option(self::$language['pay_method'])."</select>";
$module['filter'].="<select id='buy_method' name='buy_method'><option value='-1'>".self::$language['buy_method']."</option><option value='' selected>".self::$language['all'].self::$language['buy_method']."</option><option value='monxin'>".self::$language['buy_method_option']['monxin']."</option><option value='cashier'>".self::$language['buy_method_option']['cashier']."</option></select>";
$module['filter'].="<select id='preferential_way' name='preferential_way'><option value='-1'>".self::$language['use_method']."</option><option value='' selected>".self::$language['all'].self::$language['use_method']."</option>".get_mall_array_option(self::$language['preferential_way_option'])."</select>";
$module['filter'].="<select id='express' name='express'><option value='-1'>".self::$language['express']."</option><option value='' selected>".self::$language['all'].self::$language['express']."</option>".get_mall_express_option($pdo,self::$table_pre)."</select>";



















//===============================================================================================================================【获取统计信息】
if(@$_GET['state']==''){$module['module_state_name']=self::$language['all'].self::$language['state'];}else{$module['module_state_name']=self::$language['order_state'][intval($_GET['state'])];}

$where=str_replace("and `pay_method`='balance'",'',$where);
$where=str_replace("and `pay_method`='bank_transfer'",'',$where);
$where=str_replace("and `pay_method`='cash_on_delivery'",'',$where);
$where=str_replace("and `pay_method`='online_payment'",'',$where);
$where=str_replace("and `pay_method`='cash'",'',$where);
$where=str_replace("and `pay_method`='credit'",'',$where);

$where=rtrim($where);
$where=str_replace('  ',' ',$where);

$sql="select sum(`actual_money`) as c from ".self::$table_pre."order".$where;
$sql=str_replace("_order and","_order where",$sql);
//echo $sql;

$r=$pdo->query($sql,2)->fetch(2);
$module['sum']['sum']=floatval($r['c']);

$sql="select sum(`actual_money`) as c from ".self::$table_pre."order".$where." and `pay_method`='balance'";
$sql=str_replace("_order and","_order where",$sql);
$r=$pdo->query($sql,2)->fetch(2);
$module['sum']['balance']=floatval($r['c']);

$sql="select sum(`actual_money`) as c from ".self::$table_pre."order".$where." and `pay_method`='bank_transfer'";
$sql=str_replace("_order and","_order where",$sql);
$r=$pdo->query($sql,2)->fetch(2);
$module['sum']['bank_transfer']=floatval($r['c']);

$sql="select sum(`actual_money`) as c from ".self::$table_pre."order".$where." and `pay_method`='cash_on_delivery'";
$sql=str_replace("_order and","_order where",$sql);
$r=$pdo->query($sql,2)->fetch(2);
$module['sum']['cash_on_delivery']=floatval($r['c']);

$sql="select sum(`actual_money`) as c from ".self::$table_pre."order".$where." and `pay_method`='online_payment'";
$sql=str_replace("_order and","_order where",$sql);
$r=$pdo->query($sql,2)->fetch(2);
$module['sum']['online_payment']=floatval($r['c']);

$sql="select sum(`actual_money`) as c from ".self::$table_pre."order".$where." and `pay_method`='cash'";
$sql=str_replace("_order and","_order where",$sql);
$r=$pdo->query($sql,2)->fetch(2);
$module['sum']['cash']=floatval($r['c']);

$sql="select sum(`actual_money`) as c from ".self::$table_pre."order".$where." and `pay_method`='credit'";
$sql=str_replace("_order and","_order where",$sql);
$r=$pdo->query($sql,2)->fetch(2);
$module['sum']['credit']=floatval($r['c']);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);