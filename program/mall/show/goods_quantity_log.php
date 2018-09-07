<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$id=intval(@$_GET['id']);
if($id==0){return not_find();}

$sql="select `title`,`id`,`option_enable` from ".self::$table_pre."goods where `id`=".$id;
$module['data']=$pdo->query($sql,2)->fetch(2);
if($module['data']['id']==''){return not_find();}


$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."goods_quantity_log where `goods_id`=".$id;

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
	$sum_sql=str_replace("_goods_quantity_log and","_goods_quantity_log where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_goods_quantity_log and","_goods_quantity_log where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';


foreach($r as $v){
	if($v['username']=='monxin'){$v['username']='';}
	$option='';
	if($v['s_id']!=0){
		$sql="select `id`,`option_id`,`color_name` from ".self::$table_pre."goods_specifications where `id`=".$v['s_id'];
		$s=$pdo->query($sql,2)->fetch(2);
		if(isset($s['id'])){
			$option='<span class=option>'.self::get_type_option_name($pdo,$s['option_id']).' '.$s['color_name'].'</span>';	
		}
			
	}
	
	$list.='<tr>
	<td>'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time']).'</td>
	<td>'.self::format_quantity($v['quantity']).'</td>
	<td>'.$option.'</td>
	<td>'.self::$language['money_symbol'].$v['in_price'].'</td>
	<td>'.self::$language['money_symbol'].$v['out_price'].'</td>
	<td>'.self::$language['money_symbol'].($v['out_price']-$v['in_price']).'</td>
	<td>'.$v['username'].'</td>
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