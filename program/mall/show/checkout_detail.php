<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$sql="select * from ".self::$table_pre."order";

$where="";
if(intval(@$_GET['id'])!=0){
	$where=" and `id`=".intval($_GET['id']);
}else{
	echo 'id err';return false;	
}


$sql=$sql.$where;
$sql=str_replace("_order and","_order where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';


foreach($r as $v){
	if($v['cashier']=='monxin'){echo 'no checkout add';return false;}
	if($_SESSION['monxin']['group_id']==self::$config['cashier_group_id'] && $v['cashier']!=$_SESSION['monxin']['username']){echo 'no power';return false;}
	$goods_money=0;
	$v=de_safe_str($v);
	$sql="select * from ".self::$table_pre."order_goods where `order_id`='".$v['id']."' order by `id` asc";
	$r2=$pdo->query($sql,2);
	$temp='';
	$phone_temp='';
	foreach($r2 as $v2){
		
		if($v['preferential_way']==5){$o_price='<span class=o_price>'.$v2['price'].'</span>';$v2['price']=$v2['transaction_price'];}else{$o_price='';}	
		  $phone_temp.="<div class=goods_div>
		  <span class=icon>
			  <a href=./index.php?monxin=mall.goods&id=".$v2['goods_id']."><img src=./program/mall/order_icon/".$v2['icon']." /></a>
		  </span><span class=other>
			  <div class=title>".$v2['title']."</div>
			  <div class=price>".self::$language['price'].":".$o_price.self::$language['money_symbol'].str_replace('.00','',$v2['price'])." &nbsp; ".self::$language['quantity'].":".self::format_quantity($v2['quantity']).$v2['unit']." <a href=./index.php?monxin=mall.goods_snapshot&id=".$v2['snapshot_id']." target=_balnk>".self::$language['snapshot']."</a></div>
		  </span>
	  </div>";	
	  
		$goods_money+=$v2['price']*$v2['quantity'];
	}
	if($v['buyer_remark']!=''){$v['buyer_remark']="<div class=buyer_remark>".self::$language['buyer'].self::$language['remark'].': '.$v['buyer_remark'].'</div>';}
	if($v['state']<1){$actual="<div class=actual_money>".self::$language['actual_pay'].": <span class=value>".$v['actual_money']."</span> <a href=# class=edit_a d_id=".$v['id']." act='actual_money'></a></div>";}else{$actual="<div class=actual_money>".self::$language['actual_pay'].": <span class=value>".$v['actual_money']."</span></div>";}
	if($v['change_price_reason']!=''){$v['change_price_reason']="<div class=change_price_reason>".$v['change_price_reason']."</div>";}
	if($v['preferential_code']!=''){$v['preferential_code']='<div class=preferential_code>'.$v['preferential_code'].'</div>';}
	$act='';
	$state_remark='';
	$edit_express_cost_buyer='';
	switch($v['state']){
		case 0:
			$edit_express_cost_buyer="<a href=# class=edit_b d_id=".$v['id']." act='express_cost_buyer'></a>";
			$act="<a href='#' class=cash_on_delivery d_id=".$v['id']." >".self::$language['set_to'].self::$language['cash_on_delivery']."</a><br /><a href='#' class=cancel>".self::$language['cancel'].self::$language['order_id']."</a><br />";
			$state_remark='<div class=pay_time_limit>'.self::$language['pay_time_limit'].'<br />'.self::get_pay_time_limit(self::$language,self::$config['pay_time_limit'],$v['add_time']).'</div>';
			break;
		case 1:
			$act="<a href='#' class=order_state_0>".self::$language['verify'].self::$language['fail']."(".self::$language['set_to'].self::$language['order_state'][0].")</a><br /><a href='#' class=order_state_2>".self::$language['verify'].self::$language['success']."(".self::$language['set_to'].self::$language['order_state'][2].")</a><br />";
			$state_remark='<a href=# class=edit_c d_id='.$v['id'].' act=show_bank_transfer>'.self::$language['view'].'</a>';
			break;
		case 2:
			$act="<a href='#' class=edit_c d_id=".$v['id']." act='order_state_3'>".self::$language['set_to'].self::$language['order_state'][3]."</a><br /><a href='#' class=cancel >".self::$language['cancel'].self::$language['order_id']."</a><br />";
			$state_remark='<div class=pay_method>'.self::$language['pay_method_str'].'<br />'.@self::$language['pay_method'][$v['pay_method']].'</div>';			break;
		case 3:
			$act="<a href='#' class=order_state_4>".self::$language['set_to'].self::$language['order_state'][4]."</a><br /><a href='#' class=order_state_8>".self::$language['set_to'].self::$language['order_state'][8]."</a><br />";
			$state_remark='<div class=pay_method>'.self::$language['pay_method_str'].'<br />'.@self::$language['pay_method'][$v['pay_method']].'</div>';			break;
			break;
		case 4:
			$state_remark='<div class=pay_method>'.self::$language['pay_method_str'].'<br />'.@self::$language['pay_method'][$v['pay_method']].'</div>';			break;
			break;
		case 5:
			break;
		case 6:
			break;
		case 7:
			break;
		case 8:
			$state_remark='<div class=pay_method>'.self::$language['pay_method_str'].'<br />'.@self::$language['pay_method'][$v['pay_method']].'</div>';			break;
			break;
		case 9:
			$state_remark='<div class=pay_method>'.self::$language['pay_method_str'].'<br />'.@self::$language['pay_method'][$v['pay_method']].'</div>';			break;
			break;
	}
	if(in_array($v['state'],self::$config['order_del_able'])){$act.="<a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a><br />";}
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
	if($v['preferential_way']==5){$goods_money2=$goods_money;}else{$goods_money2=$v['goods_money'];}
	$list.="<div class=order_div id=order_".$v['id']." href='./index.php?monxin=mall.my_order_detail&id=".$v['id']."'>
	<div class=title><span class=time>".date('Y-m-d H:i',$v['add_time'])."</span><span class=buyer>".$v['buyer']."</span><span class=sum_money>".self::$language['actual_money'].self::$language['money_symbol'].str_replace('.00','',$v['sum_money'])."</span><span class=symbol>&nbsp;</span></div>
	<div class=other_info>
	<div class=buyer_info><span class=order_id>".self::$language['order_number'].": <span class=value>".$v['out_id']."</span></span> <span class=goods_money>".self::$language['goods_money'].": <span class=value>".$goods_money.self::$language['yuan']."</span></span></div>	
	<div class=preferential_way>".self::$language['use_method']." ".$v['preferential_code'].self::$language['preferential_way_option'][$v['preferential_way']].": -".(($v['goods_money']+$v['express_cost_buyer'])-$v['sum_money']).self::$language['yuan']."</div>
	<div class=order_state_out><div class=order_state value='".self::$language['order_state'][$v['state']]."'>".self::$language['state'].":".self::$language['order_state'][$v['state']]."</div><div class=state_remark>".$state_remark."</div></div>
	<div class=money_div><div class=sum_money>".self::$language['need_pay'].": <span class=value>".$v['sum_money']."</span></div>".$actual."</div>".$v['change_price_reason']."
	</div>
	
	".$phone_temp."
	<div class='bottom_div'></div>
</div>";	
	
}
$module['action_url']="";
$module['list']=$list;
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);