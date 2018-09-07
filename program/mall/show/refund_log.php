<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;

$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."refund where `shop_id`='".SHOP_ID."'";
$where="";

if(@$_GET['search']!=''){
	$_GET['search']=safe_str($_GET['search']);
	$where=" and (`order_id` ='".$_GET['search']."' or `buyer` like '%".$_GET['search']."%' or `reason` like '%".$_GET['search']."%')";
}

if(@$_GET['start_time']!=''){
	$start_time=get_unixtime($_GET['start_time'],self::$config['other']['date_style']);
	$where.=" and `add_time`>$start_time";	
}
if(@$_GET['end_time']!=''){
	$end_time=get_unixtime($_GET['end_time'],self::$config['other']['date_style'])+86400;
	$where.=" and `add_time`<$end_time";	
}
$order=" order by `id` desc";
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_refund and","_refund where",$sum_sql);
 	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_refund and","_refund where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';

foreach($r as $v){
	$sql="select `id`,`title`,`option_enable`,`unit`,`icon` from ".self::$table_pre."goods where `id`=".intval($v['goods_id']);
	$goods=$pdo->query($sql,2)->fetch(2);
	if(!$goods){
		$sql="delete from ".self::$table_pre."refund where `id`=".$v['id'];
		$pdo->exec($sql);
		continue;
	}
	if($v['s_id']){
		$sql="select `option_id`,`color_name` from ".self::$table_pre."goods_specifications where `id`=".$v['s_id'];
		$s=$pdo->query($sql,2)->fetch(2);
		$goods['title'].='<span class=option>'.self::get_type_option_name($pdo,$s['option_id']).' '.$s['color_name'].'</span>';	
	}
	$unit=self::get_mall_unit_name($pdo,$goods['unit']);
	$list.='<tr>
	<td><a href=./index.php?monxin=mall.goods&id='.$goods['id'].' target=_blank class=goods_info><img src=./program/mall/img_thumb/'.$goods['icon'].' />'.$goods['title'].'</a></td>
	<td>'.self::format_quantity($v['quantity']).' '.$unit.'</td>
	<td>'.$v['buyer'].'</td>
	<td>'.$v['username'].'</td>
	<td>'.$v['out_id'].'</td>
	<td>'.$v['reason'].'</td>
	<td>'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time']).'</td>
	</tr>';	
}
if($sum==0){
	$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';
	if($_COOKIE['monxin_device']=='phone'){$list=self::$language['no_related_content'];}
}		
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);