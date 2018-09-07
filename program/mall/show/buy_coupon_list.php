<?php
$c_id=intval(@$_GET['c_id']);
if($c_id==0){echo 'c_id err';return false;}
$sql="select `name`,`shop_id` from ".self::$table_pre."buy_coupon where `id`=".$c_id;
$r=$pdo->query($sql,2)->fetch(2);
if($r['shop_id']==''){echo 'c_id err';return false;}
if($r['shop_id']!=SHOP_ID){echo 'SHOP err';return false;}

$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&c_id='.$c_id;
$module['monxin_table_name']=$r['name'];
$module['module_name']=str_replace("::","_",$method);
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."buy_coupon_list where `coupon_id`=".$c_id;

$where="";

if($_GET['search']!=''){$where=" and (`code` like '%".$_GET['search']."%' or `id`='".$_GET['search']."')";}
$_GET['order']=safe_str(@$_GET['order']);
if($_GET['order']==''){
	$order=" order by `id` desc";
}else{
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_buy_coupon_list and","_buy_coupon_list where",$sum_sql);
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_buy_coupon_list and","_buy_coupon_list where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';


foreach($r as $v){
	if($v['buyer']!=''){$v['buyer']='<a href="./index.php?monxin=mall.my_buyer&search='.urlencode($v['buyer']).'">'.$v['buyer'].'</a>';}
	if($v['order_id']!=''){$v['order_id']='<a href="./index.php?monxin=mall.order_admin&id='.$v['order_id'].'">'.$v['order_id'].'</a>';}
	$list.="<tr id='tr_".$v['id']."'>
	<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
	<td>".$v['id']."</td>
	<td>".$v['code']."</td>
	<td>".$v['buyer']."</td>
	<td>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['use_time'])."</td>
	<td>".$v['order_id']."</td>
  <td class=operation_td>
  <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
</tr>
";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);