<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;

$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);
$id=intval(@$_GET['id']);
$module['css']='';
$sql="select * from ".self::$table_pre."goods_deduct_stock where `shop_id`='".SHOP_ID."'";
if($id>0){
	$sql.=" and `goods_id`=".$id;
	$module['css']='.page-content{ background-color:#FFF;}
	.page-header{ display:none;}
	.page-footer{ display:none;}
	.fixed_right_div{ display:none; }
	.container{ width:100%; padding:0px; margin:0px;}
	.m_row{display:none;}
';
}

$where="";

if(@$_GET['start_time']!=''){
	$start_time=get_unixtime($_GET['start_time'],self::$config['other']['date_style']);
	$where.=" and `time`>$start_time";	
}
if(@$_GET['end_time']!=''){
	$end_time=get_unixtime($_GET['end_time'],self::$config['other']['date_style'])+86400;
	$where.=" and `time`<$end_time";	
}
$order=" order by `id` desc";
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_goods_deduct_stock and","_goods_deduct_stock where",$sum_sql);
 	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_goods_deduct_stock and","_goods_deduct_stock where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
$module['goods_title']='';
foreach($r as $v){
	$sql="select `id`,`title`,`option_enable`,`unit`,`icon` from ".self::$table_pre."goods where `id`=".intval($v['goods_id']);
	$goods=$pdo->query($sql,2)->fetch(2);
	if($id>0){$module['goods_title']=$goods['title'];}
	if($goods['option_enable']){
		$sql="select `option_id`,`color_name` from ".self::$table_pre."goods_specifications where `id`=".$v['s_id'];
		$s=$pdo->query($sql,2)->fetch(2);
		$goods['title'].='<span class=option>'.self::get_type_option_name($pdo,$s['option_id']).' '.$s['color_name'].'</span>';	
	}
	$unit=self::get_mall_unit_name($pdo,$goods['unit']);
	$list.='<tr>
	<td><a href=./index.php?monxin=mall.goods&id='.$goods['id'].' target=_blank class=goods_info><img src=./program/mall/img_thumb/'.$goods['icon'].' />'.$goods['title'].'</a></td>
	<td>'.self::format_quantity($v['quantity']).' '.$unit.'</td>
	<td>'.$v['money'].'</td>
	<td class=reason>'.de_safe_str($v['reason']).'</td>
	<td>'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time']).'</td>
	</tr>';	
}
if($sum==0){
	$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';
	if($_COOKIE['monxin_device']=='phone'){$list=self::$language['no_related_content'];}
}		
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);
if($id>0 && $module['goods_title']==''){
	$sql="select `title` from ".self::$table_pre."goods where `id`=".$id;	
	$r=$pdo->query($sql,2)->fetch(2);
	$module['goods_title']=$r['title'];
}

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);