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
	$sql="select `title`,`transaction_price`,`quantity`,`unit`,`s_id`,`goods_id`,`price`,`barcode` from ".self::$table_pre."order_goods where `order_id`=".$v['id'];
	$r2=$pdo->query($sql,2);
	$list2='';
	foreach($r2 as $v2){
		if($v['preferential_way']==5  && $v2['price']!=$v2['transaction_price']){$o_price='<span class=o_price>'.$v2['price'].'</span>';$v2['price']=$v2['transaction_price'];}else{$o_price='';}		
		if($v2['barcode']=='0'){$v2['barcode']='';}
		$list2.="<div class=goods><span class=goods_id>".$v2['barcode']."</span><span class=goods_name>".$v2['title']."</span><span class=goods_price>".$v2['price'].$o_price."</span><span class=goods_quantity>".self::format_quantity($v2['quantity']).$v2['unit']."</span><span class=goods_money>".$v2['price']*$v2['quantity'].self::$language['yuan']."</span></div>";	
	}
	$sql="select * from ".self::$table_pre."shop where `id`=".SHOP_ID;
	$shop=$pdo->query($sql,2)->fetch(2);
	$shop=de_safe_str($shop);
	$shop_name=$shop['name'];
	$sql="select `name` from ".self::$table_pre."talk where `id`=".$shop['talk_type'];
	$talk=$pdo->query($sql,2)->fetch(2);
	$talk=de_safe_str($talk['name']);
	
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
	$module['list'].="<div class=order_div>
        	<div class=order_head>
            	<div class=icon_name>
                    <img src=./program/mall/ticket_logo/".SHOP_ID.".png />
                    <div>".$shop_name."</div>
                </div><div class=info>
                	<div>".self::$language['order'].self::$language['number']."：".$v['out_id']."</div>
                	<div>".self::$language['order'].self::$language['date']."：".date('Y-m-d',$v['add_time'])."</div>
                	<div>".self::$language['pay_method_str']."：".@self::$language['pay_method'][$v['pay_method']]."</div>
                </div><div class=barcode>
                	<img class='s_bar_code_img' src='./plugin/barcode/buildcode.php?codebar=BCGcode128&amp;text=".$v['out_id']."'>
                </div>
                <div class=receiver_info>".$receiver_info."</div>
            </div>
        	<div class=order_body>
            	<div class='goods thead'><span class=goods_id>".self::$language['barcode']."</span><span class=goods_name>".self::$language['goods'].self::$language['name']."</span><span class=goods_price>".self::$language['price']."</span><span class=goods_quantity>".self::$language['quantity']."</span><span class=goods_money>".self::$language['money']."</span></div>
            	".$list2."
            </div>
            <div class=order_foot>".$preferential_way.self::$language['actual_pay'].str_replace('.00','',$v['actual_money']-$v['web_credits_money']).self::$language['yuan'].'('.self::$language['freight_costs'].str_replace('.00','',$v['express_cost_buyer']).self::$language['yuan'].') '.$v['change_price_reason']."</div>
			".$v['buyer_remark'].$v['seller_remark']."
			<div class=shop_info>
						".self::$language['main_business'].':'.$shop['main_business']."<br />
						".self::$language['address'].':'.$shop['address']." ".self::$language['tel'].":".$shop['phone']." ".$talk.":".$shop['talk_account']."</div>
        </div>";


}

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
