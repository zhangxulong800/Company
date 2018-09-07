<?php
self::close_overtime_order($pdo);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);


$sql="select * from ".self::$table_pre."order";
$where='';

if(isset($_GET['state'])){
	$where.=" and `state`=".intval($_GET['state']);
}
if(isset($_GET['group'])){
	$where.=" and `gr_id`=".intval($_GET['group']);
}
if($_GET['search']!=''){$where=" and (`g_title` like '%".$_GET['search']."%' or `username` like '%".$_GET['search']."%' or `out_id` ='".$_GET['search']."')";}

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
	$sum_sql=str_replace("_order and","_order where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_order and","_order where",$sql);

$state_option="<option value=0>".self::$language['goods_state_option'][0]."</option><option value=1>".self::$language['goods_state_option'][1]."</option><option value=2>".self::$language['goods_state_option'][2]."</option>";

//echo $sql;
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$sql="select `id`,`icon`,`title` from ".$pdo->sys_pre."mall_order_goods where `goods_id`=".$v['g_id']."";
	$goods=$pdo->query($sql,2)->fetch(2);
	
	$act='';
	//if($v['state']!=1){$act.="<a  onclick='return del(".$v['id'].")'  class='del'>".self::$language['del'].self::$language['orders']."</a>";}
	$list.="<div class=border id=tr_".$v['id']."><div class=o_head><span class=h_left><span class=o_user>".$v['username']."</span>".get_date($v['time'],self::$config['other']['date_style'],self::$config['other']['timeoffset'])." <span class=out_id>".$v['out_id']."</span></span><span class=h_right>".self::$language['order_state_option'][$v['state']]."</span></div><div class=goods>
	<div class=g_left><img src='./program/mall/order_icon/".$goods['icon']."' /></div><div class=g_right>
		<a class=g_title href=./index.php?monxin=mall.gbuy_goods&id=".$v['g_id']."&gid=".$v['b_id'].">".$goods['title']."</a>
		<div class=price>".self::$language['money_symbol'].$v['price']."</div>
		<div class=group_list>".self::get_gbuy_group_show($pdo,$v['gr_id'])."</div>
	</div>
	</div>
		<div class=act_div>".$act."</div>
	</div>";
		
	
}
if($list==''){$list='<span class=no_related_content_span>'.self::$language['no_related_content'].'</span>';}		

$module['list']=$list;

$module['state_option']='<a href=./index.php?monxin=gbuy.shop_order class=current>'.self::$language['all'].'</a>';
foreach(self::$language['order_state_option'] as $k=>$v){
	$module['state_option'].='<a href=./index.php?monxin=gbuy.shop_order&state='.$k.' state='.$k.'>'.$v.'</a>';
}

$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
