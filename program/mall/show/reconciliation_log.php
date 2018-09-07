<?php
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['search']=safe_str(@$_GET['search']);
$time=time();
$today=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);
if(!isset($_GET['start_time']) || !isset($_GET['end_time'])){header('location:./index.php?monxin=mall.reconciliation_log&start_time='.$today.'&end_time='.$today.'');exit;}

$time=get_unixtime($today,'y-m-d')-86400;
$yesterday=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);
$time=get_unixtime($yesterday,'y-m-d')-86400;
$before_yesterday=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);

$module['days']='<a href="./index.php?monxin=mall.reconciliation_log&start_time='.$today.'&end_time='.$today.'">'.self::$language['today'].'</a>';
$module['days'].='<a href="./index.php?monxin=mall.reconciliation_log&start_time='.$yesterday.'&end_time='.$yesterday.'">'.self::$language['yesterday'].'</a>';
$module['days'].='<a href="./index.php?monxin=mall.reconciliation_log&start_time='.$before_yesterday.'&end_time='.$before_yesterday.'">'.self::$language['before_yesterday'].'</a>';

self::call_update_checkout_log($pdo,SHOP_ID);


$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."checkout_log where `shop_id`=".SHOP_ID."";

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
	$list.='<tr id=tr_'.$v['id'].'>
	<td>'.$v['username'].'</td>
	<td class=cash>'.self::$language['recharge'].self::$language['currency'].':'.$v['recharge'].'<br />'.self::$language['received_goods_money'].':'.$v['cash'].'<br />'.self::$language['balance_and_cash'].':'.$v['pay_2'].'<br />'.self::$language['cash_sum'].':'.($v['recharge']+$v['cash']+$v['pay_2']).'</td>
	<td>'.$v['pos'].'</td>
	<td>'.self::$language['pay_api_option']['weixin'].':'.$v['alipay_p'].'<br />'.self::$language['pay_api_option']['alipay'].':'.$v['weixin_p'].'</td>
	<td>'.$v['balance'].'</td>
	<td>'.$v['shop_balance'].'</td>
	<td>'.$v['weixin'].'</td>
	<td>'.$v['alipay'].'</td>
	<td>'.$v['meituan'].'</td>
	<td>'.$v['nuomi'].'</td>
	<td>'.$v['other'].'</td>
	<td>'.$v['credit'].'</td>
	<td>'.$tr_sum.self::$language['yuan'].'</td>
	<td><span class=data_state>'.self::$language['reconciliation_state'][$v['state']].'</span></td>
	<td>'.$operation.'</td>
	</tr>';	
}
if($list==''){
	$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';
	if($_COOKIE['monxin_device']=='phone'){$list=self::$language['no_related_content'];}
}else{
	$list.='<tr>
	<td>'.self::$language['the_day'].self::$language['sum'].'</td>
	<td class=cash>'.($sum['recharge']+$sum['cash']+$sum['pay_2']).'</td>
	<td>'.$sum['pos'].'</td>
	<td>'.($sum['weixin_p']+$sum['alipay_p']).'</td>
	<td>'.$sum['balance'].'</td>
	<td>'.$sum['shop_balance'].'</td>
	<td>'.$sum['weixin'].'</td>
	<td>'.$sum['alipay'].'</td>
	<td>'.$sum['meituan'].'</td>
	<td>'.$sum['nuomi'].'</td>
	<td>'.$sum['other'].'</td>
	<td>'.$sum['credit'].'</td>
	<td colspan=4>'.$all_sum.self::$language['yuan'].'</td>
	</tr>';	
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

