<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$ids=safe_str(@$_GET['ids']);
if($ids==''){echo self::$language['select_null'];return false;}
$ids=str_replace('|',',',$ids);
$ids=trim($ids,',');
$sql="select * from ".self::$table_pre."order where `shop_id`=".SHOP_ID." and `id` in (".$ids.") order by `id` asc";
$r=$pdo->query($sql,2);
$module['list']='';
foreach($r as $v){
	$shop_buyer_info='';
	if($v['buyer']!=''){
		$sql="select `balance`,`credits` from ".self::$table_pre."shop_buyer where `shop_id`=".SHOP_ID." and `username`='".$v['buyer']."' limit 0,1";
		$t=$pdo->query($sql,2)->fetch(2);
		$shop_buyer_info=self::$language['store'].self::$language['balance'].':'.$t['balance'].'<br />'.self::$language['store'].self::$language['credits'].':'.$t['credits'];
	}
	
	$sql="select `title`,`transaction_price`,`quantity`,`unit`,`s_id`,`price`,`barcode` from ".self::$table_pre."order_goods where `order_id`=".$v['id'];
	$r2=$pdo->query($sql,2);
	$list2='';
	foreach($r2 as $v2){
		if($v['preferential_way']==5){$o_price='<span class=o_price>'.$v2['price'].'</span>';$v2['price']=$v2['transaction_price'];}else{$o_price='';}		
		//echo $v2['title'].' '.mb_strlen($v2['title'],'utf-8').'<br />';
		if(mb_strlen($v2['title'],'utf-8')>18){
			if($v2['s_id']!=0){
				$v2['title']=mb_substr($v2['title'],0,6,'utf-8').'..'.mb_substr($v2['title'],mb_strlen($v2['title'],'utf-8')-14,9,'utf-8');
			}else{
				$v2['title']=mb_substr($v2['title'],0,15,'utf-8').'..';
			}
			
		}
		if($v2['barcode']=='0'){$v2['barcode']='';}
		$list2.='<div class=goods><div class=title>'.$v2['title'].'</div><div class=o><span class=b>'.$v2['barcode'].'</span><span class=q>'.self::format_quantity($v2['quantity']).$v2['unit'].'</span><span class=p>'.$v2['price'].'</span><span class=s>'.number_format($v2['price']*$v2['quantity'],2).'</span></div></div>';	
	}
	$sql="select `name` from ".self::$table_pre."shop where `id`=".SHOP_ID;
	$r=$pdo->query($sql,2)->fetch(2);
	$shop_name=$r['name'];
	if($v['receiver_area_name']==''){
		$receiver_info=de_safe_str($v['checkout_address']);
	}else{
		$receiver_info=$v['receiver_name'].' '.$v['receiver_phone'].' '.$v['receiver_area_name'].' '.$v['receiver_detail'].' '.$v['receiver_post_code'].' '.' <span class=delivery_time>'.self::$language['delivery_time_info'][$v['delivery_time']]."</span><span class=express>".self::get_express_name($pdo,self::$table_pre,$v['express'])."</span> <span class=express_code>".$v['express_code']."</span>";
	}
	
	if($v['goods_money']+$v['express_cost_buyer']-$v['sum_money']!=0){
		$preferential_way="<div class=normal_price>".self::$language['sum'].":".$v['goods_money'].self::$language['yuan']."</div><div class=preferential_way>".$v['preferential_code'].self::$language['preferential_way_option'][$v['preferential_way']].": -". sprintf('%.2f',$v['goods_money']+$v['express_cost_buyer']-$v['sum_money']).self::$language['yuan']."</div>";
	}else{$preferential_way='';}
	
	if($v['buyer_remark']!=''){$v['buyer_remark']=self::$language['buyer'].self::$language['remark'].':'.$v['buyer_remark'];}
	if($v['seller_remark']!=''){$v['seller_remark']=self::$language['seller'].self::$language['remark'].':'.$v['seller_remark'];}
	if($v['web_credits_money']!=0){$v['buyer_remark'].='<br />'.$v['credits_remark'];}
	if($v['preferential_way']==5){$preferential_way='';}
	$module['list'].='
		<div class=order>
        	<div class=logo><img src="./program/mall/ticket_logo/'.SHOP_ID.'.png" width="100%" /></div>
            <div class=title>'.$shop_name.'<br />'.self::$language['order_number'].':'.$v['out_id'].'<br />'.self::$language['order_id'].self::$language['state'].":".self::$language['order_state'][$v['state']]." ".self::$language['pay_method'][$v['pay_method']].'</div>
            <div class=goods_info><div class="o g_head"><span class=g>'.self::$language['name'].'</span><span class=q>'.self::$language['quantity'].'</span><span class=p>'.self::$language['price'].'</span><span class=s>'.self::$language['subtotal'].'</span></div>'.$list2.'</div>
			'.$preferential_way.'
            <div class=actual_money>'.self::$language['actual_pay'].str_replace('.00','',$v['actual_money']-$v['web_credits_money']).self::$language['yuan'].'('.self::$language['freight_costs'].str_replace('.00','',$v['express_cost_buyer']).self::$language['yuan'].') '.$v['change_price_reason'].'</div>
            <div class=receiver>'.$receiver_info.'</div>
            <div class=username_time><span class=username>'.$v['buyer'].'</span> <span class=time>'.date('Y-m-d H:i',$v['add_time']).'</span></div>
			'.$v['buyer_remark'].$v['seller_remark'].$shop_buyer_info.'
        </div>
';	


}

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
