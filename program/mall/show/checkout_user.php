<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
self::call_update_checkout_log($pdo,SHOP_ID);


$module['months']='';
$m=date("Y-m",time());
$day= getthemonth($m);
$temp=explode('-',$m);
$temp=str_replace('0','',$temp[1]);
$module['months']='<a href="./index.php?monxin=mall.checkout_user&start_time='.$day[0].'&end_time='.$day[1].'">'.$temp.self::$language['m'].'</a>';
if(!isset($_GET['start_time']) || !isset($_GET['end_time'])){header('location:./index.php?monxin=mall.checkout_user&start_time='.$day[0].'&end_time='.$day[1].'');exit;}

$m=date("Y-m",strtotime("-1 month"));
$day= getthemonth($m);
$temp=explode('-',$m);
$temp=str_replace('0','',$temp[1]);
$module['months'].='<a href="./index.php?monxin=mall.checkout_user&start_time='.$day[0].'&end_time='.$day[1].'">'.$temp.self::$language['m'].'</a>';
$m=date("Y-m",strtotime("-2 month"));
$day= getthemonth($m);
$temp=explode('-',$m);
$temp=str_replace('0','',$temp[1]);
$module['months'].='<a href="./index.php?monxin=mall.checkout_user&start_time='.$day[0].'&end_time='.$day[1].'">'.$temp.self::$language['m'].'</a>';

	$module['user_data']='';




if(@$_GET['start_time']==''){
	$_GET['start_time']=date('Y-m-d',time());
}
$start_time=get_unixtime($_GET['start_time'],self::$config['other']['date_style']);

if(@$_GET['end_time']==''){
	$_GET['end_time']=date('Y-m-d',time());
}
$end_time=get_unixtime($_GET['end_time'],self::$config['other']['date_style'])+86400;

$where=" and `add_time`>$start_time";	
$where.=" and `add_time`<$end_time";	

$sql="select `cashier` from ".self::$table_pre."shop where `id`=".SHOP_ID;
$r=$pdo->query($sql,2)->fetch(2);
$r=explode(',',$r['cashier']);
$cashier=array();
$index=0;
foreach($r as $v){
	if($v==''){break;}
	$cashier[$index]['username']=$v;
	$tr_sum=0;
	$sql2="select sum(`actual_money`) as c,sum(`web_credits_money`) as c2 from ".self::$table_pre."order where `shop_id`=".SHOP_ID." and `state`=6 and `pay_method`='cash' and `cashier`='".$v."'".$where;
	$r2=$pdo->query($sql2,2)->fetch(2);
	$cashier[$index]['received_goods_money']=floatval($r2['c'])-floatval($r2['c2']);		
	$tr_sum+=floatval($r2['c']);
	
	$sql2="select sum(`actual_money`) as c from ".self::$table_pre."order where `shop_id`=".SHOP_ID." and `state`=6 and `pay_method`='pos' and `cashier`='".$v."'".$where;
	$r2=$pdo->query($sql2,2)->fetch(2);
	$cashier[$index]['pos']=floatval($r2['c']);		
	$tr_sum+=floatval($r2['c']);
	
	$sql2="select sum(`actual_money`) as c from ".self::$table_pre."order where `shop_id`=".SHOP_ID." and `state`=6 and `pay_method`='balance' and `cashier`='".$v."'".$where;
	$r2=$pdo->query($sql2,2)->fetch(2);
	$cashier[$index]['balance']=floatval($r2['c']);		
	$tr_sum+=floatval($r2['c']);
	
	$sql2="select sum(`actual_money`) as c from ".self::$table_pre."order where `shop_id`=".SHOP_ID." and `state`=6 and `pay_method`='shop_balance' and `cashier`='".$v."'".$where;
	$r2=$pdo->query($sql2,2)->fetch(2);
	$cashier[$index]['shop_balance']=floatval($r2['c']);		
	$tr_sum+=floatval($r2['c']);
	
	$sql2="select sum(`actual_money`) as c from ".self::$table_pre."order where `shop_id`=".SHOP_ID." and `state`=6 and `pay_method`='weixin' and `cashier`='".$v."'".$where;
	$r2=$pdo->query($sql2,2)->fetch(2);
	$cashier[$index]['weixin']=floatval($r2['c']);		
	$tr_sum+=floatval($r2['c']);
	
	$sql2="select sum(`actual_money`) as c from ".self::$table_pre."order where `shop_id`=".SHOP_ID." and `state`=6 and `pay_method`='alipay' and `cashier`='".$v."'".$where;
	$r2=$pdo->query($sql2,2)->fetch(2);
	$cashier[$index]['alipay']=floatval($r2['c']);		
	$tr_sum+=floatval($r2['c']);
	
	
	$sql2="select sum(`actual_money`) as c from ".self::$table_pre."order where `shop_id`=".SHOP_ID." and `state`=6 and `pay_method`='weixin_p' and `cashier`='".$v."'".$where;
	$r2=$pdo->query($sql2,2)->fetch(2);
	$cashier[$index]['weixin_p']=floatval($r2['c']);		
	$tr_sum+=floatval($r2['c']);
	
	$sql2="select sum(`actual_money`) as c from ".self::$table_pre."order where `shop_id`=".SHOP_ID." and `state`=6 and `pay_method`='alipay_p' and `cashier`='".$v."'".$where;
	$r2=$pdo->query($sql2,2)->fetch(2);
	$cashier[$index]['alipay_p']=floatval($r2['c']);		
	$tr_sum+=floatval($r2['c']);
	
	
	$sql2="select sum(`actual_money`) as c from ".self::$table_pre."order where `shop_id`=".SHOP_ID." and `state`=6 and `pay_method`='meituan' and `cashier`='".$v."'".$where;
	$r2=$pdo->query($sql2,2)->fetch(2);
	$cashier[$index]['meituan']=floatval($r2['c']);		
	$tr_sum+=floatval($r2['c']);
	
	
	$sql2="select sum(`actual_money`) as c from ".self::$table_pre."order where `shop_id`=".SHOP_ID." and `state`=6 and `pay_method`='nuomi' and `cashier`='".$v."'".$where;
	$r2=$pdo->query($sql2,2)->fetch(2);
	$cashier[$index]['nuomi']=floatval($r2['c']);		
	$tr_sum+=floatval($r2['c']);
	
	$sql2="select sum(`actual_money`) as c from ".self::$table_pre."order where `shop_id`=".SHOP_ID." and `state`=6 and `pay_method`='other' and `cashier`='".$v."'".$where;
	$r2=$pdo->query($sql2,2)->fetch(2);
	$cashier[$index]['other']=floatval($r2['c']);		
	$tr_sum+=floatval($r2['c']);
	
	$sql2="select sum(`actual_money`) as c from ".self::$table_pre."order where `shop_id`=".SHOP_ID." and `state`=6 and `pay_method`='credit' and `cashier`='".$v."'".$where;
	$r2=$pdo->query($sql2,2)->fetch(2);
	$cashier[$index]['credit']=floatval($r2['c']);		
	$tr_sum+=floatval($r2['c']);
	
	$sql2="select count(`id`) as c from ".self::$table_pre."order where `shop_id`=".SHOP_ID." and `state`=6 and `cashier`='".$v."'".$where;
	$r2=$pdo->query($sql2,2)->fetch(2);
	$cashier[$index]['exe_order']=floatval($r2['c']);	
	
	$sql2="select sum(`money`) as c from ".self::$table_pre."shop_buyer_balance where `shop_id`=".SHOP_ID." and `operator`='".$v."'".(str_replace('add_','',$where));
	$r2=$pdo->query($sql2,2)->fetch(2);
	$cashier[$index]['recharge']=floatval($r2['c']);	
	$tr_sum+=floatval($r2['c']);
	if($tr_sum!=0){$module['user_data'].="{value:".$tr_sum.",name:'".$v.':'.number_format($tr_sum).self::$language['yuan']."'},";}
		
	
	$index++;	
}

$cashier=self::array_sort($cashier,'received_goods_money',$type='desc');
$module['list']='';
foreach($cashier as $v){
	$module['list'].='<tr><td>'.$v['username'].'</td><td>'.$v['recharge'].'</td><td>'.$v['received_goods_money'].'</td><td>'.$v['pos'].'</td><td>'.$v['balance'].'</td><td>'.$v['shop_balance'].'</td><td>'.$v['weixin'].'</td><td>'.$v['alipay'].'</td><td>'.$v['weixin_p'].'</td><td>'.$v['alipay_p'].'</td><td>'.$v['meituan'].'</td><td>'.$v['nuomi'].'</td><td>'.$v['other'].'</td><td>'.$v['credit'].'</td><td>'.$v['exe_order'].'</td></tr>';	
}



$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);