<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;

$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select `id`,`out_id`,`actual_money`,`cashier`,`add_time`,`pay_method`,`preferential_way`,`goods_money`,`buyer`,`reference_number` from ".self::$table_pre."order where `shop_id`=".SHOP_ID." and `state`=6 and `cashier`!='monxin'";

$where="";

if(@$_GET['start_time']==''){
	$_GET['start_time']=date('Y-m-d',time());
}
$start_time=get_unixtime($_GET['start_time'],self::$config['other']['date_style']);

if(@$_GET['end_time']==''){
	$_GET['end_time']=date('Y-m-d',time());
}
$end_time=get_unixtime($_GET['end_time'],self::$config['other']['date_style'])+86400;
$where.=" and `add_time`>$start_time";	
$where.=" and `add_time`<$end_time";	

if(@$_GET['cashier']!=''){$where.=" and `cashier`='".safe_str($_GET['cashier'])."'";}
if(@$_GET['pay_method']!=''){$where.=" and `pay_method`='".safe_str($_GET['pay_method'])."'";}
if(@$_GET['preferential_way']!=''){$where.=" and `preferential_way`='".intval($_GET['preferential_way'])."'";}
if($_GET['search']!=''){$where.=" and (`id` ='".$_GET['search']."' or `out_id` ='".$_GET['search']."' or `goods_names` like '%".$_GET['search']."%' or `buyer` like '%".$_GET['search']."%' or `express_code` like '%".$_GET['search']."%' or `preferential_code` like '%".$_GET['search']."%' or `receiver_name` like '%".$_GET['search']."%' or `receiver_phone` like '%".$_GET['search']."%' or `receiver_detail` like '%".$_GET['search']."%' or `receiver_post_code` like '%".$_GET['search']."%' or `receiver_area_name` like '%".$_GET['search']."%' or `reference_number` = '".$_GET['search']."' or `cashier` = '".$_GET['search']."' )";}


$_GET['order']=safe_str(@$_GET['order']);
if($_GET['order']==''){
	$order=" order by `id` desc";
}else{
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" `id`,`out_id`,`actual_money`,`cashier`,`add_time`,`pay_method`,`preferential_way`,`goods_money`,`buyer`,`reference_number` "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_order and","_order where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_order and","_order where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';


foreach($r as $v){
	$v=de_safe_str($v);
	if($v['buyer']==''){$v['buyer']='&nbsp;';}
	if($v['reference_number']!=''){$v['reference_number']='<br />'.$v['reference_number'];}
	$d=sprintf('%.2f',$v['goods_money']-$v['actual_money']);
	$list.='<tr id=tr_'.$v['id'].'><td class=id>'.$v['out_id'].'</td><td class=buyer>'.$v['buyer'].'</td><td class=actual_money>'.$v['actual_money'].'</td><td class=pay_method>'.self::$language['pay_method'][$v['pay_method']].$v['reference_number'].'</td><td class=preferential_way>'.self::$language['preferential_way_option'][$v['preferential_way']].'-'.$d.'</td><td class=cashier>'.$v['cashier'].'</td><td class=time>'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['add_time']).'</td><td class=operation_td><a href=./index.php?monxin=mall.checkout_detail&id='.$v['id'].' target=_blank>'.self::$language['detail'].'</a> <span id=state_'.$v['id'].'></span></td></tr>';	
}
if($sum==0){
	$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';
	if($_COOKIE['monxin_device']=='phone'){$list=self::$language['no_related_content'];}
}		
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);


function get_cashier_option($pdo,$config){
	$sql="select `cashier` from ".$pdo->sys_pre."mall_shop where `id`=".SHOP_ID;
	$r=$pdo->query($sql,2)->fetch(2);
	$r=explode(',',$r['cashier']);
	$list='';
	foreach($r as $v){
		if($v==''){break;}
		$list.='<option value="'.$v.'">'.$v.'</option>';
	}
	return $list;
}


$module['filter']="<select id='cashier' name='cashier'><option value='-1'>".self::$language['cashier']."</option><option value='' selected>".self::$language['all'].self::$language['cashier']."</option>". get_cashier_option($pdo,self::$config)."</select>";

$module['filter'].="<select id='pay_method' name='pay_method'><option value='-1'>".self::$language['pay_method_str']."</option><option value='' selected>".self::$language['all'].self::$language['pay_method_str']."</option>".self::get_language_option(self::$language['pay_method'])."</select>";

$module['filter'].="<select id='preferential_way' name='preferential_way'><option value='-1'>".self::$language['use_method']."</option><option value='' selected>".self::$language['all'].self::$language['use_method']."</option>".self::get_language_option(self::$language['preferential_way_option'])."</select>";


//===============================================================================================================================sum_info
if(@$_GET['state']==''){$module['module_state_name']=self::$language['all'].self::$language['state'];}else{$module['module_state_name']=self::$language['order_state'][intval($_GET['state'])];}


$where=rtrim($where);
$sql="select sum(`actual_money`) as c from ".self::$table_pre."order and `shop_id`=".SHOP_ID." ".$where."";
$sql=str_replace("_order and","_order where",$sql);
$sql=str_replace("_order  and","_order where",$sql);
$r=$pdo->query($sql,2)->fetch(2);
$module['sum']['sum']=floatval($r['c']);


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);