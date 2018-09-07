<?php
$id=intval(@$_GET['id']);
$sql="select `name` from ".self::$table_pre."express where `id`='".$id."'";
$r=$pdo->query($sql,2)->fetch(2);
$name=$r['name'];

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&id='.$id;
$module['class_name']=self::$config['class_name'];

$sql="select * from ".self::$table_pre."express_layout where `e_id`=".$id." limit 0,1";
$module['data']=$pdo->query($sql,1)->fetch(2);
if($module['data']['id']==''){
	$c=require('./program/mall/express_layout_default.php');
	$sql="insert into ".self::$table_pre."express_layout (`e_id`,`shipper_name`,`shipper_tel`,`shipper_phone`,`shipper_company`,`shipper_address`,`shipper_city`,`shipper_postcode`,`shipper_signature`,`shipper_time`,`shipper_remark`,`consignee_name`,`consignee_tel`,`consignee_phone`,`consignee_company`,`consignee_address`,`consignee_city`,`consignee_postcode`,`width`,`height`) values ('".$id."','".$c['shipper_name']."','".$c['shipper_tel']."','".$c['shipper_phone']."','".$c['shipper_company']."','".$c['shipper_address']."','".$c['shipper_city']."','".$c['shipper_postcode']."','".$c['shipper_signature']."','".$c['shipper_time']."','".$c['shipper_remark']."','".$c['consignee_name']."','".$c['consignee_tel']."','".$c['consignee_phone']."','".$c['consignee_company']."','".$c['consignee_address']."','".$c['consignee_city']."','".$c['consignee_postcode']."','".$c['width']."','".$c['height']."')";	
	$pdo->exec($sql);
	$sql="select * from ".self::$table_pre."express_layout where `e_id`=".$id." limit 0,1";
	$module['data']=$pdo->query($sql,1)->fetch(2);
}

$module['list']='';
foreach($module['data'] as $k=>$v){
	if($k=='width' || $k=='height' || $k=='id' || $k=='e_id'){continue;}
	$v=str_replace(',}','}',$v);
	$css=json_decode($v,1);
	$module['list'].="<div style='left:".$css['left']."%;top:".$css['top']."%;width:".$css['width']."%;height:".$css['height']."%;' field=".$k.">".self::$language['express_layout'][$k]."</div>";	
}
$module['data']['width_css']=$module['data']['width']/3;
$module['data']['height_css']=$module['data']['height']/3;


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);



echo ' <div id="user_position_reset" style="display:none;"><a href="index.php"><span id=user_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a><a href="index.php?monxin=index.user">'.self::$language['user_center'].'</a><a href="index.php?monxin=mall.express">'.self::$language['pages']['mall.express']['name'].'</a><span class=text>'.$name.' '.self::$language['pages']['mall.express_layout']['name'].'</span></div>';	

require "./plugin/html4Upfile/createHtml4.class.php";
$html4Upfile=new createHtml4();

$html4Upfile->echo_input("bg",'auto','./temp/','false','false','jpg|png',1024*10,'1');
//echo_input("控件名称",'控件宽度(百分比或像素)','保存目录','文件夹是否附加日期','是否原名保存','允许文件后缀','文件大小 上限','文件大小 下限','指定保存名');
//指定保存名时，要先设置权限 $_SESSION['replace_file']=true;  ，否则将无效
