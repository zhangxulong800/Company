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


$sql="select * from ".self::$table_pre."group";
$where='';

if(isset($_GET['state'])){
	$where.=" and `state`=".intval($_GET['state']);
}
if($_GET['search']!=''){$where=" and (`g_title` like '%".$_GET['search']."%' or `username` like '%".$_GET['search']."%')";}

$_GET['order']=safe_str(@$_GET['order']);
if($_GET['order']==''){
	$order=" order by `id` desc";
}else{
	$temp=safe_group_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_group and","_group where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_group and","_group where",$sql);

$state_option="<option value=0>".self::$language['goods_state_option'][0]."</option><option value=1>".self::$language['goods_state_option'][1]."</option><option value=2>".self::$language['goods_state_option'][2]."</option>";

//echo $sql;
$r=$pdo->query($sql,2);
$list='';
$goods_hour=array();
$goods_info=array();

foreach($r as $v){
	if(!isset($goods_info[$v['g_id']])){
		$sql="select `id`,`icon`,`title` from ".$pdo->sys_pre."mall_goods where `id`=".$v['g_id']."";
		$goods_info[$v['g_id']]=$pdo->query($sql,2)->fetch(2);
		$sql="select `hour` from ".self::$table_pre."goods where `id`=".$v['b_id'];
		$goods_hour[$v['g_id']]=$pdo->query($sql,2)->fetch(2);
	}
	
	
	$act='';
	if($v['state']!=1){$act.="<a  onclick='return del(".$v['id'].")'  class='del'>".self::$language['del'].self::$language['tuan']."</a>";}
	
	$list.="<div class=border id=tr_".$v['id']."><div class=o_head><span class=h_left><span class=g_username>".self::$language['group_founder'].": ".$v['username']."</span><span class=start>".self::$language['open_gbuy_time'].': '.get_date($v['start'],self::$config['other']['date_style'].' H:i',self::$config['other']['timeoffset'])."</span><span class=time_limit remain=".(($v['start']+($goods_hour[$v['g_id']]['hour']*3600))-time()).">"."</span><span class=g_earn>".self::$language['g_earn'].": ".self::$language['money_symbol'].$v['earn']."</span></span><span class=h_right>".self::$language['group_state_option'][$v['state']]."</span></div><div class=goods>
	<div class=g_left><img src='./program/mall/img_thumb/".$goods_info[$v['g_id']]['icon']."' /></div><div class=g_right>
		<a class=g_title href=./index.php?monxin=mall.gbuy_goods&id=".$v['g_id']."&gid=".$v['b_id'].">".$goods_info[$v['g_id']]['title']."</a>
		<div class=price>".self::$language['money_symbol'].$v['price']."</div>
		<div class=group_list>".self::get_gbuy_group_show($pdo,$v['id'])." <a class=view_order href=./index.php?monxin=gbuy.order&group=".$v['id'].">".self::$language['view_order']."</a></div>
	</div>
	</div>
		<div class=act_div>".$act."</div>
	</div>";
		
	
}
if($list==''){$list='<span class=no_related_content_span>'.self::$language['no_related_content'].'</span>';}		

$module['list']=$list;

$module['state_option']='<a href=./index.php?monxin=gbuy.group class=current>'.self::$language['all'].'</a>';
foreach(self::$language['group_state_option'] as $k=>$v){
	$module['state_option'].='<a href=./index.php?monxin=gbuy.group&state='.$k.' state='.$k.'>'.$v.'</a>';
}

$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
