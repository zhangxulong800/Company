<?php
if($_COOKIE['monxin_device']=='pc'){header('location:index.php?monxin=mall.my_order&id='.$_GET['id']);exit;}
$_SESSION['token']['mall::my_order']=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token']['mall::my_order']."&target=mall::my_order";
$_SESSION['token']['mall::buyer_comment']=get_random(8);$module['action_url_buyer_comment']="receive.php?token=".$_SESSION['token']['mall::buyer_comment']."&target=mall::buyer_comment";
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$sql="select * from ".self::$table_pre."order where `buyer`='".$_SESSION['monxin']['username']."' and `state`!=9";

$where="";
if(intval(@$_GET['id'])!=0){
	$where=" and `id`=".intval($_GET['id']);
}else{
	echo 'id err';return false;	
}

$sql=$sql.$where;
$r=$pdo->query($sql,2);
$list='';


foreach($r as $v){
	if($v['credits_remark']!=''){$v['credits_remark']='<div class=credits_remark>'.$v['credits_remark'].'</div>';}
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
		if($v['state']==8){//comment
			$sql="select * from ".self::$table_pre."comment where `order_id`='".$v['id']."' and `goods_id`='".$v2['goods_id']."' limit 0,1";
			$r3=$pdo->query($sql,2)->fetch(2);
			if($r3['id']!=''){
				$r3=de_safe_str($r3);
				$comment='<div class=buyer><span class=time>'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$r3['time']).'</span><span class=content>'.$r3['content'].'<a href=# title="'.self::$language['edit'].'" class=edit>&nbsp;</a> <a href=# title="'.self::$language['del'].'" class=del>&nbsp;</a></span><span class=user>'.self::$language['myself'].'</span></div>';
				if($r3['answer']!=''){
					$comment.='<div class=buyer><span class=time>'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$r3['answer_time']).'</span><span class=content>&nbsp;'.$r3['answer'].'</span><span class=user>'.self::$language['seller'].'</span></div>';	
				}	
			}else{
				$add_comment='<a href=# class=add_comment>'.self::$language['comment'].'</a>';
				
				$comment='';	
			}
		}
			$phone_temp.="<div class=goods_div goods_id=".$v2['goods_id']." id=order_".$v['id']."_goods_".$v2['goods_id'].">
        	<span class=icon>
            	<a href=./index.php?monxin=mall.goods&id=".$v2['goods_id']."><img src=./program/mall/order_icon/".$v2['icon']." /></a>
            </span><span class=other>
            	<div class=title>".$v2['title']."</div>
                <div class=price>".self::$language['price'].":".$o_price.' '.str_replace('.00','',$v2['price']).self::$language['yuan']." &nbsp; ".self::$language['quantity'].":".self::format_quantity($v2['quantity']).$v2['unit']." <a href=./index.php?monxin=mall.goods_snapshot&id=".$v2['snapshot_id']." target=_balnk>".self::$language['snapshot']."</a> ".$add_comment."</div>
            </span>
			<div class=comment>".$comment."</div>
        </div>";	
		$goods_money+=$v2['price']*$v2['quantity'];
	}
	if($v['buyer_remark']!=''){$v['buyer_remark']="<div class=buyer_remark>".self::$language['remark'].': '.$v['buyer_remark'].'</div>';}
	if($v['state']<1){$actual="<div class=actual_money>".self::$language['actual_pay'].": <span class=value>".$v['actual_money']."</span></div>";}else{$actual="<div class=actual_money>".self::$language['actual_pay'].": <span class=value>".$v['actual_money']."</span></div>";}
	if($v['change_price_reason']!=''){$v['change_price_reason']="<div class=change_price_reason>".$v['change_price_reason']."</div>";}
	if($v['preferential_code']!=''){$v['preferential_code']='<div class=preferential_code>'.$v['preferential_code'].'</div>';}
	$act='';
	$state_remark='';
	$edit_express_cost_buyer='';
	switch($v['state']){
		case 0:
			$edit_express_cost_buyer="<a href=# class=edit_b d_id=".$v['id']." act='express_cost_buyer'></a>";
			$act="<a href='#' class=cancel>".self::$language['cancel'].self::$language['order_id']."</a><br />";
			$state_remark='<div class=pay_time_limit>'.self::$language['pay_time_limit'].'<br />'.self::get_pay_time_limit(self::$language,self::$config['pay_time_limit'],$v['add_time']).'</div><a href="./index.php?monxin=mall.pay&id='.$v['id'].'" class=go_pay target=_blank>'.self::$language['select_pay_method'].'</a>';
			break;
		case 1:
			$act="";
			$state_remark='<div class=pay_method>'.self::$language['pay_method_str'].'<br />'.@self::$language['pay_method'][$v['pay_method']].'<span pay_method_remark='.$v['pay_method_remark'].'></span></div>';
			break;
		case 2:
			$act="<a href='#' class=cancel >".self::$language['cancel'].self::$language['order_id']."</a><br />";
			$state_remark='<div class=pay_method>'.self::$language['pay_method_str'].'<br />'.@self::$language['pay_method'][$v['pay_method']].'<span pay_method_remark='.$v['pay_method_remark'].'></span></div>';
			break;
		case 3:
			$act="";
			$state_remark='<div class=pay_method>'.self::$language['pay_method_str'].'<br />'.@self::$language['pay_method'][$v['pay_method']].'<span pay_method_remark='.$v['pay_method_remark'].'></span></div>';
			break;
		case 4:
			$state_remark='<div class=pay_method>'.self::$language['pay_method_str'].'<br />'.@self::$language['pay_method'][$v['pay_method']].'<span pay_method_remark='.$v['pay_method_remark'].'></span></div>';
			break;
		case 5:
			break;
		case 6:
			break;
		case 7:
			break;
		case 8:
			$state_remark='<div class=pay_method>'.self::$language['pay_method_str'].'<br />'.@self::$language['pay_method'][$v['pay_method']].'<span pay_method_remark='.$v['pay_method_remark'].'></span></div>';
			break;
		case 9:
			$state_remark='<div class=pay_method>'.self::$language['pay_method_str'].'<br />'.@self::$language['pay_method'][$v['pay_method']].'<span pay_method_remark='.$v['pay_method_remark'].'></span></div>';
			break;
	}
	if(in_array($v['state'],self::$config['order_del_able'])){$act.="<a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a><br />";}
	if($v['express_code']!=''){
		if($v['express']>0){
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
		}else{
			
			$v['express_code']='<div style="background:#ECECEC; text-align:left;line-height:1.5rem;">'.rn_to_br($v['express_code']).'</div><a href=monxin></a>';
		}
	}
	if($v['sum_money']!=$v['actual_money']){
		$money_info="<div class=money_div><div class=sum_money>".self::$language['need_pay'].": <span class=value>".$v['sum_money']."</span></div>".$actual."</div>";	
	}else{
		$money_info='<div class=big_money>'.str_replace('.00','',$v['sum_money']).self::$language['yuan'].'</div>';
	}
	if($v['preferential_way']==5){$goods_money2=$goods_money;}else{$goods_money2=$v['goods_money'];}
	$list.="<div class=order_div id=order_".$v['id']." href='./index.php?monxin=mall.my_order_detail&id=".$v['id']."'>
	<div class=title><span class=time>".get_time('Y-m-d H:i',self::$config['other']['timeoffset'],self::$language,$v['add_time'])."</span><span class=sum_money>".self::$language['actual_money'].str_replace('.00','',$v['sum_money']).self::$language['yuan']."</span><span class=symbol>&nbsp;</span></div>
	
	<div class=other_info>
	<div class=buyer_info><span class=order_id>".self::$language['order_number'].": <span class=value>".$v['out_id']."</span></span> <span class=goods_money>".self::$language['goods_money'].": <span class=value>".$goods_money2.self::$language['yuan']."</span></span> <span class=express_cost_buyer>".self::$language['freight_costs'].": <span class=value>".str_replace('.00','',$v['express_cost_buyer']).self::$language['yuan']."</span></span><span class=invoice>".$v['invoice']."</span></div>	
	<div class=preferential_way>".self::$language['use_method']." ".$v['preferential_code'].self::$language['preferential_way_option'][$v['preferential_way']].": -".(($v['goods_money']+$v['express_cost_buyer'])-$v['sum_money']).self::$language['yuan']."</div>".$v['change_price_reason']."
	".$v['credits_remark']."
	<div class=order_state_out><div class=order_state value='".self::$language['order_state'][$v['state']]."'>".self::$language['state'].":".self::$language['order_state'][$v['state']]."</div><div class=state_remark>".$state_remark."</div></div>

	</div>
	
	
	".$phone_temp."
	<div class=remark>".$v['buyer_remark']."</div>
	
	<div class=act_div>".$act." <span id=state_".$v['id']." class='state'></span></div>
	
	<div class=buyer_address>".self::$language['receiver_info'].":<br />".$v['receiver_name'].' '.$v['receiver_phone'].' '.$v['receiver_area_name'].' '.$v['receiver_detail'].' '.$v['receiver_post_code'].' '.' <span class=delivery_time>'.self::$language['delivery_time_info'][$v['delivery_time']]."</span><span class=express>".self::get_express_name($pdo,self::$table_pre,$v['express'])."</span> <span class=express_code>".$v['express_code']."</span></div>
	<div class='bottom_div'></div>
</div>";	
	
}
$module['list']=$list;

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);