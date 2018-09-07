<?php
$shop_id=intval($_GET['shop_id']);
if($shop_id==''){echo 'err:shop_id null';exit;}

$sql="select * from ".self::$table_pre."shop_order_set where `shop_id`=".$shop_id." limit 0,1";
$order_set=$pdo->query($sql,2)->fetch(2);
if($order_set['id']==''){echo 'err:shop_id err';exit;}

$sql="select `name` from ".self::$table_pre."shop where `id`=".$shop_id;
$r=$pdo->query($sql,2)->fetch(2);
$shop_name=$r['name'];

$code=@$_GET['code'];
if($code==''){echo 'err:code null';exit;}
if($code!=$order_set['order_auto_print_code']){echo 'err:code err';exit;}


$sql="select `id`,`add_time`,`buyer`,`goods_money`,`express_cost_buyer`,`actual_money`,`receiver_name`,`receiver_phone`,`receiver_area_name`,`receiver_detail`,`receiver_post_code`,`delivery_time`,`express`,`express_code`,`change_price_reason` from ".self::$table_pre."order where `shop_id`=".$shop_id." and `auto_print`='0' and `state`='".$order_set['order_auto_print_when']."' order by `id` asc limit 0,".$order_set['order_auto_print_max'];
$r=$pdo->query($sql,2);
//echo $sql;
$c='';
$ids='';
foreach($r as $v){
	$ids.=$v['id'].',';
	$sql="select `title`,`price`,`quantity`,`unit` from ".self::$table_pre."order_goods where `order_id`=".$v['id'];
	$r2=$pdo->query($sql,2);
	$list2='';
	foreach($r2 as $v2){
		//echo $v2['title'].' '.mb_strlen($v2['title'],'utf-8').'<br />';
		if(mb_strlen($v2['title'],'utf-8')>24){
			$v2['title']=mb_substr($v2['title'],0,9,'utf-8').'**'.mb_substr($v2['title'],mb_strlen($v2['title'],'utf-8')-14,14,'utf-8');
		}
		$list2.=''.$v2['title'].' '.str_replace('.00','',$v2['price']).'*'.$v2['quantity'].$v2['unit'].'='.str_replace('.00','',$v2['price']*$v2['quantity'])."\r\n";	
	}
	$list1=''.$shop_name.' '.$v['id'].self::$language['order_postfix']."\r\n".$list2.self::$language['goods_cost'].':'.str_replace('.00','',$v['goods_money']).'+'.self::$language['freight_costs'].str_replace('.00','',$v['express_cost_buyer']).self::$language['yuan'].'='.str_replace('.00','',($v['goods_money']+$v['express_cost_buyer'])).self::$language['yuan']."\r\n".self::$language['actual_pay'].str_replace('.00','',$v['actual_money']).self::$language['yuan'].' '.$v['change_price_reason']."\r\n".$v['receiver_name'].' '.$v['receiver_phone'].' '.$v['receiver_area_name'].' '.$v['receiver_detail'].' '.$v['receiver_post_code'].' '.' '.self::$language['delivery_time_info'][$v['delivery_time']]." ".self::get_express_name($pdo,self::$table_pre,$v['express'])." ".$v['express_code']."\r\n".$v['buyer'].' '.date('Y-m-d H:i',$v['add_time'])."\r\n\r\n\r\n";
	
	for($i=0;$i<$order_set['order_auto_print_quantiy'];$i++){
		$c.=$list1;	
	}	

}

if($ids!=''){
	$sql="update ".self::$table_pre."order set `auto_print`=1 where `shop_id`=".$shop_id." and `id` in (".trim($ids,',').")";
	$pdo->exec($sql);	
}

//ob_end_clean();
header('Content-Type:text/html;charset='.$order_set['order_auto_print_charset']);
//$c=iconv("utf-8",self::$config['order_auto_print_charset'],$c);
$c=mb_convert_encoding($c,$order_set['order_auto_print_charset'],"utf-8");
exit($c);

