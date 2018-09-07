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


$sql="select * from ".self::$table_pre."goods where `state`=1 and `price`>0 and `start_time`<".time()." and `end_time`>".time()." ";
$where='';

$_GET['order']=safe_str(@$_GET['order']);
if($_GET['order']==''){
	$order=" order by `sequence` desc,`id` desc";
}else{
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_goods and","_goods where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_goods and","_goods where",$sql);

$state_option="<option value=0>".self::$language['goods_state_option'][0]."</option><option value=1>".self::$language['goods_state_option'][1]."</option><option value=2>".self::$language['goods_state_option'][2]."</option>";

//echo $sql;
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$sql="select `id`,`icon`,`title` from ".$pdo->sys_pre."mall_goods where `id`=".$v['g_id']."";
	$g=$pdo->query($sql,2)->fetch(2);
	if($g['id']==''){self::delete_gbuy($pdo,$v['id']);}
	$sql="update ".self::$table_pre."goods set `g_title`='".$g['title']."' where `id`=".$v['id'];
	$pdo->exec($sql);
		$yj=self::get_goods_price($pdo,$v['g_id']);
		
		if($_COOKIE['monxin_device']=='pc'){
			$list.="<a class=goods  href=./index.php?monxin=mall.gbuy_goods&id=".$v['g_id']."&gid=".$v['id']."  target=_blank><img src='./program/mall/img_thumb/".$g['icon']."'><div class=title>".$g['title']."</div><div class=price_div><span class=l>".self::$language['goods_price_2']." <span class=v>".self::$language['money_symbol'].$yj."</span></span><span class=r>".self::$language['gbuy_price']."<span class=v> ".self::$language['money_symbol'].($v['price'])."</span></span></div></a>";

		}else{
			$list.="<a class=goods  href=./index.php?monxin=mall.gbuy_goods&id=".$v['g_id']."&gid=".$v['id']."  target=_blank><div class=l_info><img src='./program/mall/img_thumb/".$g['icon']."'></div><div class=r_info><div class=title>".$g['title']."</div><div class=price_div><span class=l>".self::$language['goods_price_2']." <span class=v>".self::$language['money_symbol'].$yj."</span></span><span class=r>".self::$language['gbuy_price']."<span class=v> ".self::$language['money_symbol'].($v['price'])."</span></span></div></div></a>";
		}
	
}
if($list==''){$list='<span class=no_related_content_span>'.self::$language['no_related_content'].'</span>';}		

$module['list']=$list;

$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
echo '<div style="display:none;" id="visitor_position_append">'.self::$language['pages']['gbuy.list']['name'].'</div>';