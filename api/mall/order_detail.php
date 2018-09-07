<?php 
$re=array('err_code'=>'0','err_msg'=>$language['err_msg'][0]);
if(!isset($_POST['id']) && !isset($_POST['out_id']) ){
	$re['api_state']='fail';
	$re['api_msg']=$language['order_detail_need_id'];
	return_api($re);
}
$sql="";
if(isset($_POST['id']) && $_POST['id']!=''){
	$sql="select * from ".$pdo->sys_pre."mall_order where `id`=".$_POST['id'];
}
if(isset($_POST['out_id']) && $_POST['out_id']!=''){
	$sql="select * from ".$pdo->sys_pre."mall_order where `out_id`=".$_POST['out_id'].' limit 0,1';
}
if($sql==''){
	$re['api_state']='fail';
	$re['api_msg']=$language['order_detail_need_id'];
	return_api($re);
}
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']==''){
	$re['api_state']='fail';
	$re['api_msg']=$language['not_exist'];
	return_api($re);
}

$r=de_safe_str($r);
$re['data']=$r;

$sql="select * from ".$pdo->sys_pre."mall_order_goods where `order_id`=".$r['id'];
$r=$pdo->query($sql,2);
$re['goods']=array();
foreach($r as $v){
	$v['icon']='http://'.$config['web']['domain'].'/program/mall/order_icon/'.$v['icon'];
	$re['goods'][$v['id']]=de_safe_str($v);
	
}

$re['api_state']='success';
$re['api_msg']=$language['success'];

return_api($re);


