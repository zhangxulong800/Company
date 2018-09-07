<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$id=intval(@$_GET['id']);
if($id==0){return not_find();}
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&id='.$id;


$sql="select `option_enable`,`id`,`title`,`unit`,`shop_id` from ".self::$table_pre."goods where `id`=".$id;
$module['data']=$pdo->query($sql,2)->fetch(2);
if($module['data']['id']==''){return not_find();}
if($module['data']['shop_id']!=SHOP_ID){return not_find();}

$module['head_td']='';
$module['add_option']='';
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."goods_batch where `goods_id`=".$id;
if($module['data']['option_enable']){
	$option=array();
	$sql="select `option_id`,`color_name`,`id` from ".self::$table_pre."goods_specifications where `goods_id`=".$id;
	$r=$pdo->query($sql,2);
	
	foreach($r as $v){
		$option_name='';
		$option_name=self::get_type_option_name($pdo,$v['option_id']);
		$option[$v['id']]='<td>'.$v['color_name'].' '.$option_name.'</td>';
		$module['add_option'].='<option value="'.$v['id'].'">'.$v['color_name'].' '.$option_name.'</option>';	
	}
	$module['add_option']='<td><select id=option_id name=option_id><option value="">'.self::$language['please_select'].'</option>'.$module['add_option'].'</select></td>';
	$sql="select * from ".self::$table_pre."goods_batch where `goods_id` like '".$id."\_%'";
	$module['head_td']='<td>'.self::$language['option'].'</td>';

	
}

$where="";

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
	$sum_sql=str_replace("_goods_batch and","_goods_batch where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_goods_batch and","_goods_batch where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
$unit=self::get_mall_unit_name($pdo,$module['data']['unit']);

foreach($r as $v){
	$gy='';
	$temp=explode('_',$v['goods_id']);
	if(isset($temp[1]) && isset($option[$temp[1]])){
		$gy=$option[$temp[1]];
	}
	
	if($v['expiration']!=0){$time=get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['expiration']);}else{$time='';}
	
	$list.='<tr id=tr_'.$v['id'].'>
	<td>'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['add_time']).'</td>
	'.$gy.'
	<td>'.self::get_supplier_name($pdo,$v['supplier']).'</td>
	<td>'.self::format_quantity($v['quantity']).' '.$unit.'</td>
	<td><input type=text class=payment d_id='.$v['id'].' value='.self::format_quantity($v['payment']).' /> '.$unit.'</td>
	<td>'.$v['price'].'</td>
	<td>'.self::format_quantity($v['left']).' '.$unit.'</td>
	<td>'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['sell_out_time']).'</td>
	<td><input class=expiration type=date value="'.$time.'" /> <a href=# class=modify d_id='.$v['id'].'>'.self::$language['modify'].'</a> <span class=state></span></td>
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