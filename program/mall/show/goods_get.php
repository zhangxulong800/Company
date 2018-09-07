<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$sql="select `id`,`bar_code`,`speci_bar_code`,`title`,`type` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and (`icon`='default.png' || `detail`='') and (`bar_code`!='' || `speci_bar_code`!='' ) and `id`>1214";
//$sql="select `id`,`bar_code`,`speci_bar_code`,`title`,`type` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and (`bar_code`!='' || `speci_bar_code`!='' )";

$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$v=de_safe_str($v);
	if($v['bar_code']==''){
		$temp=explode('|',$v['speci_bar_code']);
		$v['bar_code']=$temp[0];
	}
	if(strlen($v['bar_code'])!=13 && strlen($v['bar_code'])!=8){continue;}

	$list.='<a goods_id="'.$v['id'].'" bar_code="'.$v['bar_code'].'" href=./index.php?monxin=mall.goods_edit&id='.$v['id'].'&type='.$v['type'].'&auto_submit=1&c_url= target="_blank">'.$v['title'].'</a>';
}

if($list==''){$list='<span class=no_related_content_span>'.self::$language['no_wait_icon'].'</span>';}else{
	$list='<a href=#>&nbsp;</a>'.$list;
}	
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);