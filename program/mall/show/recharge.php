<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['search']=safe_str(@$_GET['search']);
$time=time();
$today=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);
if(!isset($_GET['start_time']) || !isset($_GET['end_time'])){header('location:./index.php?monxin=mall.recharge&start_time='.$today.'&end_time='.$today.'');exit;}

$time=get_unixtime($today,'y-m-d')-86400;
$yesterday=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);

$module['days']='<a href="./index.php?monxin=mall.recharge&start_time='.$today.'&end_time='.$today.'">'.self::$language['today'].'</a>';
$module['days'].='<a href="./index.php?monxin=mall.recharge&start_time='.$yesterday.'&end_time='.$yesterday.'">'.self::$language['yesterday'].'</a>';



$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."shop_buyer_balance where `shop_id`=".SHOP_ID." and `money`>0";

$where="";

if(@$_GET['start_time']!=''){
	$start_time=get_unixtime($_GET['start_time'],self::$config['other']['date_style']);
	$where.=" and `time`>$start_time";	
}
if(@$_GET['end_time']!=''){
	$end_time=get_unixtime($_GET['end_time'],self::$config['other']['date_style'])+86400;
	$where.=" and `time`<$end_time";	
}
if($_GET['search']!=''){$where=" and `username` ='".$_GET['search']."'";}
$order=" order by `id` desc";
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_shop_buyer_balance and","_shop_buyer_balance where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_shop_buyer_balance and","_shop_buyer_balance where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';


foreach($r as $v){
	$v=de_safe_str($v);
	$list.='<tr>
	<td>'.$v['username'].'</td>
	<td>'.$v['money'].'</td>
	<td>'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time']).'</td>
	<td>'.$v['operator'].'</td>
	</tr>';	
}
if($sum==0){
	$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';
	if($_COOKIE['monxin_device']=='phone'){$list=self::$language['no_related_content'];}
}		
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);


$start_time=get_unixtime($_GET['start_time'],self::$config['other']['date_style']);
$end_time=get_unixtime($_GET['end_time'],self::$config['other']['date_style'])+86400;
$time_limit=" `time`>$start_time and `time`<$end_time ";
$where='';
if($_GET['search']!=''){$where=" and `username` ='".$_GET['search']."'";}
$sql="select sum(money) as c from ".self::$table_pre."shop_buyer_balance where `shop_id`=".SHOP_ID." and `money`>0 ".$where." and ".$time_limit;

$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['sum']=$r['c'];

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);

