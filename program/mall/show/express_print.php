<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$ids=safe_str(@$_GET['ids']);
if($ids==''){echo self::$language['select_null'];return false;}

$sql="select * from ".self::$table_pre."express_consignor where `shop_id`='".SHOP_ID."' limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']==''){header('location:./index.php?monxin=mall.express_consignor');exit;}
$r=de_safe_str($r);
$consignor='';
foreach($r as $k=>$v){
	if($k=='id' || $k=='shop_id'){continue;}
	$consignor.='<div class='.$k.' field='.$k.'>'.$v.'</div>';
}

$express=array();
$module['ignore']='';
$ids=str_replace('|',',',$ids);
$ids=trim($ids,',');
$sql="select `id`,`add_time`,`buyer`,`goods_money`,`express_cost_buyer`,`actual_money`,`receiver_name`,`receiver_phone`,`receiver_area_name`,`receiver_detail`,`receiver_post_code`,`delivery_time`,`express`,`receiver_area_id` from ".self::$table_pre."order where `shop_id`=".SHOP_ID." and `id` in (".$ids.") order by `id` asc";
$r=$pdo->query($sql,2);
$module['list']='';
foreach($r as $v){
	if($v['express']==0){$module['ignore'].=$v['id'].',';continue;}
	$v=de_safe_str($v);
	$express[]=$v['express'];
	$consignee='';
	$consignee.='<div class=consignee_name field=consignee_name>'.$v['receiver_name'].'</div>';
	$consignee.='<div class=consignee_phone field=consignee_phone>'.$v['receiver_phone'].'</div>';
	$consignee.='<div class=consignee_address field=consignee_address>'.$v['receiver_detail'].'</div>';
	$consignee.='<div class=consignee_city field=consignee_city>'.get_area_name($pdo,$v['receiver_area_id']).'</div>';
	$consignee.='<div class=consignee_postcode field=consignee_postcode>'.$v['receiver_post_code'].'</div>';
	$consignee.='<div class=shipper_remark field=shipper_remark>'.self::$language['delivery_time_info'][$v['delivery_time']].'</div>';
	
	$module['list'].='<div class="order express_'.$v['express'].'">
		'.$consignor.$consignee.'
	</div>';	
}

$express=array_unique($express);
$module['css']='';
foreach($express as $v){
	$sql="select * from ".self::$table_pre."express_layout where `e_id`=".$v." limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){continue;}
	$field='';
	foreach($r as $k=>$vv){
		if($k=='width' || $k=='height' || $k=='id' || $k=='e_id'){continue;}
		$vv=str_replace(',}','}',$vv);
		$css=json_decode($vv,1);
		$field.='.express_'.$r['e_id'].' .'.$k.'{ left:'.$css['left'].'%; top:'.$css['top'].'%; width:'.$css['width'].'%; height:'.$css['height'].'%;}
		';
	}
	$r['width_css']=$r['width']/3;
	$r['height_css']=$r['height']/3;
	$module['css'].='
		.express_'.$r['e_id'].'{ width:'.$r['width_css'].'rem;height:'.$r['height_css'].'rem; background:url(./program/mall/express_bg/'.$r['e_id'].'.png); background-size:contain; position:relative;}
		.express_'.$r['e_id'].' div{ position: absolute;}
		'.$field.'
	';	
}

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
