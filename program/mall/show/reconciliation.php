<?php
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['search']=safe_str(@$_GET['search']);
$time=time();
$today=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);
if(!isset($_GET['start_time']) || !isset($_GET['end_time'])){header('location:./index.php?monxin=mall.reconciliation&start_time='.$today.'&end_time='.$today.'');exit;}

$time=get_unixtime($today,'y-m-d')-86400;
$yesterday=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);
$time=get_unixtime($yesterday,'y-m-d')-86400;
$before_yesterday=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);

$module['days']='<a href="./index.php?monxin=mall.reconciliation&start_time='.$today.'&end_time='.$today.'">'.self::$language['today'].'</a>';
$module['days'].='<a href="./index.php?monxin=mall.reconciliation&start_time='.$yesterday.'&end_time='.$yesterday.'">'.self::$language['yesterday'].'</a>';
$module['days'].='<a href="./index.php?monxin=mall.reconciliation&start_time='.$before_yesterday.'&end_time='.$before_yesterday.'">'.self::$language['before_yesterday'].'</a>';

self::call_update_checkout_log($pdo,SHOP_ID);


$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."checkout_log where `shop_id`=".SHOP_ID." and `username`='".$_SESSION['monxin']['username']."'";

$where="";

if(@$_GET['start_time']!=''){
	$start_time=get_unixtime($_GET['start_time'],self::$config['other']['date_style']);
	$where.=" and `day`=$start_time";	
}
if($_GET['search']!=''){$where=" and `username` ='".$_GET['search']."'";}
$order=" order by `id` desc";
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_checkout_log and","_checkout_log where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';

$sum=array();
$all_sum=0;

foreach($r as $v){
	$v=de_safe_str($v);
	if($v['state']==0){$operation='<a href=# class=set_1 d_id="'.$v['id'].'">'.self::$language['confirm_reconciliation'].'</a> <span class=state></span>';}else{$operation='';}
	$tr_sum=0;
	foreach($v as $k=>$vv){
		if(!isset($sum[$k])){$sum[$k]=0;}
		$sum[$k]+=$vv;
		if($k!='day' && $k!='id' && $k!='exe_order' && $k!='shop_id' && $k!='username' && $k!='state' && $k!='pay_2'){$all_sum+=$vv;$tr_sum+=$vv;}
	}
	$list.='
	<tr><td>'.self::$language['date'].'</td><td>'.date('Y-m-d',$v['day']).'</td></tr>
	<tr><td>'.self::$language['cashier'].'</td><td>'.$v['username'].'</td></tr>
	<tr><td>'.self::$language['recharge'].self::$language['currency'].'</td><td class=cash>'.$v['recharge'].'</td></tr>
	<tr><td>'.self::$language['received_goods_money'].'</td><td class=cash>'.$v['cash'].'</td></tr>
	<tr><td>'.self::$language['pay_2'].'</td><td class=pay_2>'.$v['pay_2'].'</td></tr>
	<tr><td>'.self::$language['pay_method']['pos'].'</td><td>'.$v['pos'].'</td></tr>
	<tr><td>'.self::$language['pay_method']['weixin_p'].'</td><td>'.$v['weixin_p'].'</td></tr>
	<tr><td>'.self::$language['pay_method']['alipay_p'].'</td><td>'.$v['alipay_p'].'</td></tr>
	<tr><td>'.self::$language['pay_method']['balance'].'</td><td>'.$v['balance'].'</td></tr>
	<tr><td>'.self::$language['pay_method']['shop_balance'].'</td><td>'.$v['shop_balance'].'</td></tr>
	<tr><td>'.self::$language['pay_method']['weixin'].'</td><td>'.$v['weixin'].'</td></tr>
	<tr><td>'.self::$language['pay_method']['alipay'].'</td><td>'.$v['alipay'].'</td></tr>
	<tr><td>'.self::$language['pay_method']['meituan'].'</td><td>'.$v['meituan'].'</td></tr>
	<tr><td>'.self::$language['pay_method']['nuomi'].'</td><td>'.$v['nuomi'].'</td></tr>
	<tr><td>'.self::$language['pay_method']['other'].'</td><td>'.$v['other'].'</td></tr>
	<tr><td>'.self::$language['credit'].'</td><td>'.$v['credit'].'</td></tr>
	<tr><td>'.self::$language['sum'].'</td><td>'.$tr_sum.self::$language['yuan'].'</td></tr>
	<tr><td>'.self::$language['state'].'</td><td>'.self::$language['reconciliation_state'][$v['state']].'</td></tr>';
	
}
if($list==''){
	$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';
	if($_COOKIE['monxin_device']=='phone'){$list=self::$language['no_related_content'];}
}	
$module['list']=$list;


$start_time=get_unixtime($_GET['start_time'],self::$config['other']['date_style']);
$end_time=get_unixtime($_GET['end_time'],self::$config['other']['date_style'])+86400;
$time_limit=" `day`>$start_time and `day`<$end_time ";
$where='';
if($_GET['search']!=''){$where=" and `username` ='".$_GET['search']."'";}

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);

