<?php
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);
$head=self::get_headquarters_name($pdo);

$sql="select `id`,`name` from ".self::$table_pre."shop where `head`='".$head."' ";

$where="";
if($_GET['search']!=''){$where=" and (`name` like '%".$_GET['search']."%')";}
$_GET['order']=safe_str(@$_GET['order']);
if($_GET['order']==''){
	$order=" order by `id` desc";
}else{
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" `id`,`name` "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_shop and","_shop where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_shop and","_shop where",$sql);
//echo($sql);
//exit();

$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$v=de_safe_str($v);
	$time=time();

	$today=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);
	$start_time=get_unixtime($today,self::$config['other']['date_style']);
	$end_time=get_unixtime($today,self::$config['other']['date_style'])+86400;
	$time_limit=" `time`>$start_time and `time`<$end_time ";
	$sql="select sum(money) as c from ".self::$table_pre."shop_finance where `shop_id`='".$v['id']."' and ".$time_limit." and `money`>0";
	$t=$pdo->query($sql,2)->fetch(2);
	if($t['c']==''){$t['c']=0;}
	$today_add='+'.$t['c'];
	$sql="select sum(money) as c from ".self::$table_pre."shop_finance where `shop_id`='".$v['id']."' and ".$time_limit." and `money`<0";
	$t=$pdo->query($sql,2)->fetch(2);
	if($t['c']==''){$t['c']=0;}
	$today_reduce='-'.trim($t['c'],'-');
	$today_profit=trim($today_add,'+')+$t['c'];
	
	$time=get_unixtime($today,'y-m-d')-86400;
	$yesterday=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);
	$start_time=get_unixtime($yesterday,self::$config['other']['date_style']);
	$end_time=get_unixtime($yesterday,self::$config['other']['date_style'])+86400;
	$time_limit=" `time`>$start_time and `time`<$end_time ";
	$sql="select sum(money) as c from ".self::$table_pre."shop_finance where `shop_id`='".$v['id']."' and ".$time_limit." and `money`>0";
	$t=$pdo->query($sql,2)->fetch(2);
	if($t['c']==''){$t['c']=0;}
	$yesterday_add='+'.$t['c'];
	$sql="select sum(money) as c from ".self::$table_pre."shop_finance where `shop_id`='".$v['id']."' and ".$time_limit." and `money`<0";
	$t=$pdo->query($sql,2)->fetch(2);
	if($t['c']==''){$t['c']=0;}
	$yesterday_reduce='-'.trim($t['c'],'-');
	$yesterday_profit=trim($yesterday_add,'+')+$t['c'];
	
	$time=get_unixtime($today,'y-m-d')-(86400*6);
	$days_7=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);
	$start_time=get_unixtime($days_7,self::$config['other']['date_style']);
	$end_time=get_unixtime($today,self::$config['other']['date_style'])+86400;
	$time_limit=" `time`>$start_time and `time`<$end_time ";
	$sql="select sum(money) as c from ".self::$table_pre."shop_finance where `shop_id`='".$v['id']."' and ".$time_limit." and `money`>0";
	$t=$pdo->query($sql,2)->fetch(2);
	if($t['c']==''){$t['c']=0;}
	$days_7_add='+'.$t['c'];
	$sql="select sum(money) as c from ".self::$table_pre."shop_finance where `shop_id`='".$v['id']."' and ".$time_limit." and `money`<0";
	$t=$pdo->query($sql,2)->fetch(2);
	if($t['c']==''){$t['c']=0;}
	$days_7_reduce='-'.trim($t['c'],'-');
	$days_7_profit=trim($days_7_add,'+')+$t['c'];
	
	
	$time=get_unixtime($today,'y-m-d')-(86400*29);
	$days_30=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);
	$start_time=get_unixtime($days_30,self::$config['other']['date_style']);
	$end_time=get_unixtime($today,self::$config['other']['date_style'])+86400;
	$time_limit=" `time`>$start_time and `time`<$end_time ";
	$sql="select sum(money) as c from ".self::$table_pre."shop_finance where `shop_id`='".$v['id']."' and ".$time_limit." and `money`>0";
	$t=$pdo->query($sql,2)->fetch(2);
	if($t['c']==''){$t['c']=0;}
	$days_30_add='+'.$t['c'];
	$sql="select sum(money) as c from ".self::$table_pre."shop_finance where `shop_id`='".$v['id']."' and ".$time_limit." and `money`<0";
	$t=$pdo->query($sql,2)->fetch(2);
	if($t['c']==''){$t['c']=0;}
	$days_30_reduce='-'.trim($t['c'],'-');
	$days_30_profit=trim($days_30_add,'+')+$t['c'];

	$sql="select sum(money) as c from ".self::$table_pre."shop_finance where `shop_id`='".$v['id']."' and `money`>0";
	$t=$pdo->query($sql,2)->fetch(2);
	if($t['c']==''){$t['c']=0;}
	$sum_add='+'.$t['c'];
	$sql="select sum(money) as c from ".self::$table_pre."shop_finance where `shop_id`='".$v['id']."' and `money`<0";
	$t=$pdo->query($sql,2)->fetch(2);
	if($t['c']==''){$t['c']=0;}
	$sum_reduce='-'.trim($t['c'],'-');
	$sum_profit=trim($sum_add,'+')+$t['c'];
	
		
	$list.="<tr id='tr_".$v['id']."'>
		<td><a class=icon href=./index.php?monxin=mall.shop_index&shop_id=".$v['id']." target=_blank><img src=./program/mall/shop_icon/".$v['id'].".png />".$v['name']."</a></td>
		</td>
		<td>".$today_add.' '.$today_reduce."<br /><span class=profit>= ".$today_profit."</span></td>
		<td>".$yesterday_add.' '.$yesterday_reduce."<br /><span class=profit>= ".$yesterday_profit."</span></td>
		<td>".$days_7_add.'/'.$days_7_reduce."<br /><span class=profit>= ".$days_7_profit."</span></td>
		<td>".$days_30_add.'/'.$days_30_reduce."<br /><span class=profit>= ".$days_30_profit."</span></td>
		<td>".$sum_add.'/'.$sum_reduce."<br /><span class=profit>= ".$sum_profit."</span></td>
		<td class=operation_td><a href='./index.php?monxin=mall.branch_finance_list&shop_id=".$v['id']."' target=_blank class='submit'>".self::$language['detail']."</a></td>
	</tr>
";	

}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
