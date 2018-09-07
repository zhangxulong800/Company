<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;

$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."goods_batch where `shop_id`='".SHOP_ID."'";
$where="";
if(@$_GET['purchase_name']!=''){
	$where.=" and `purchase_name`='".safe_str($_GET['purchase_name'])."'";	
}
if(@$_GET['supplier']!=''){
	$where.=" and `supplier`=".intval($_GET['supplier'])."";	
}
if(@$_GET['start_time']!=''){
	$start_time=get_unixtime($_GET['start_time'],self::$config['other']['date_style']);
	$where.=" and `add_time`>$start_time";	
}
if(@$_GET['end_time']!=''){
	$end_time=get_unixtime($_GET['end_time'],self::$config['other']['date_style'])+86400;
	$where.=" and `add_time`<$end_time";	
}
$_GET['order']=safe_str(@$_GET['order']);
if($_GET['order']==''){
	$order=" order by `id` desc";
}else{
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}	
}
$_GET['order2']=safe_str(@$_GET['order2']);
if($_GET['order2']!=''){
	$temp=safe_order_by($_GET['order2']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order.=" , `".$temp[0]."` ".$temp[1];}
}

if(@$_GET['pay_wait']==1){
	$where.=" and `quantity`>`payment`";	
}


$temp='';
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_goods_batch and","_goods_batch where",$sum_sql);
 	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_goods_batch and","_goods_batch where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';

foreach($r as $v){
	$sql="select `id`,`title`,`option_enable`,`unit`,`icon` from ".self::$table_pre."goods where `id`=".intval($v['goods_id']);
	$goods=$pdo->query($sql,2)->fetch(2);
	if(!isset($goods['id'])){
		$s=$pdo->query($sql,2)->fetch(2);
		if(!isset($s['id'])){
			$sql="delete from ".self::$table_pre."goods_batch where `id`=".$v['id'];
			$pdo->exec($sql);
			continue;		
		}	
	}
	if(!is_numeric($v['goods_id'])){
	//if($goods['option_enable']){
		$temp=explode('_',$v['goods_id']);
		//var_dump($v['goods_id']);
		if(!isset($temp[1])){
			$sql="delete from ".self::$table_pre."goods_batch where `id`=".$v['id'];
			$pdo->exec($sql);
			continue;
		}
		$sql="select `id`,`option_id`,`color_name` from ".self::$table_pre."goods_specifications where `id`=".$temp[1];
		$s=$pdo->query($sql,2)->fetch(2);
		if(!isset($s['id'])){
			$sql="delete from ".self::$table_pre."goods_batch where `id`=".$v['id'];
			$pdo->exec($sql);
			continue;		
		}
		$goods['title'].='<span class=option>'.self::get_type_option_name($pdo,$s['option_id']).' '.$s['color_name'].'</span>';	
	}
	$unit=self::get_mall_unit_name($pdo,$goods['unit']);
	$list.='<tr id=tr_'.$v['id'].'>
	<td><a href=./index.php?monxin=mall.goods&id='.$goods['id'].' target=_blank class=goods_info><img src=./program/mall/img_thumb/'.$goods['icon'].' />'.$goods['title'].'</a><div class=remark> '.self::$language['operator'].':'.$v['username'].' , '.self::$language['remark'].':'.$v['remark'].' , '.self::$language['purchase_name'].': <input type=text d_id='.$v['id'].' class=purchase_name value="'.$v['purchase_name'].'" /></div></td>
	<td><a href=./index.php?monxin=mall.supplier>'.self::get_supplier_name($pdo,$v['supplier']).'</a></td>
	<td>'.self::format_quantity($v['quantity']).' '.$unit.'</td>
	<td>'.self::format_quantity($v['left']).' '.$unit.'</td>
	<td><input type=text class=payment  d_id='.$v['id'].' value='.self::format_quantity($v['payment']).' /> '.$unit.'</td>
	<td><input type=text class=price value='.$v['price'].' d_id='.$v['id'].' /></td>
	<td>'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['add_time']).'</td>
	<td>'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['expiration']).'</td>
	</tr>';	
}
if($sum==0){
	$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';
	if($_COOKIE['monxin_device']=='phone'){$list=self::$language['no_related_content'];}
}		
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

$sql=str_replace(' and `quantity`>`payment`','',$sum_sql);
$old_sql=$sql;
$sql=str_replace('count(id) as c','sum(`quantity`*`price`) as c',$sql);
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']==0;}
$module['data']['sum']=number_format($r['c']);

$sql=str_replace('count(id) as c','sum(`payment`*`price`) as c',$old_sql);
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']==0;}
$module['data']['pay_end']=number_format($r['c']);



$sql=str_replace('count(id) as c','sum((`quantity`-`payment`)*`price`) as c',$old_sql);
$r=$pdo->query($sql." and `quantity`>`payment`",2)->fetch(2);
if($r['c']==''){$r['c']==0;}
$module['data']['pay_wait']=number_format($r['c']);

$sql="select `name` from ".self::$table_pre."purchase where `shop_id`=".SHOP_ID." order by `id` desc limit 0,100";
$r=$pdo->query($sql,2);
$module['purchase_option']="<option value='-1'>".self::$language['purchase_name']."</option><option value='' selected>".self::$language['all'].self::$language['purchase_name']."</option>";
foreach($r as $v){
	$v['name']=de_safe_str($v['name']);
	$module['purchase_option'].='<option value="'.$v['name'].'">'.$v['name'].'</option>';
}
$module['filter']="<select  name='purchase_name_filter' id='purchase_name_filter'>".$module['purchase_option']."</select> ";

$sql="select `name`,`id` from ".self::$table_pre."supplier where `shop_id`=".SHOP_ID." order by `sequence` desc";
$r=$pdo->query($sql,2);
$module['supplier_option']="<option value='-1'>".self::$language['supplier']."</option><option value='' selected>".self::$language['all'].self::$language['supplier']."</option>";
foreach($r as $v){
	$v['name']=de_safe_str($v['name']);
	$module['supplier_option'].='<option value="'.$v['id'].'">'.$v['name'].'</option>';
}
$module['filter'].="<select name='supplier_filter' id='supplier_filter'>".$module['supplier_option']."</select>";



$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);

if(@$_GET['pay_wait']==1){
	echo ' <div id="user_position_reset" style="display:none;"><a href="index.php?monxin=index.user">'.self::$language['user_center'].'</a><a href="index.php?monxin=mall.seller">'.self::$language['pages']['mall.seller']['name'].'</a><a href=./index.php?monxin=mall.purchase>'.self::$language['pages']['mall.purchase']['name'].'</a><span class=text>'.self::$language['pay_wait'].'</span></div>';
}