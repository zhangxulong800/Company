<?php
$goods_id=intval(@$_GET['goods_id']);
if($goods_id>0){
	$sql="update ".self::$table_pre."goods set `recommendation`=1 where `id`=".$goods_id." and `shop_id`=".SHOP_ID;	
	$pdo->exec($sql);
	echo '<script>alert("'.self::$language['success'].'");</script>';
}


$sql="select `id`,`recommendation_discount`,`recommendation_rebate` from ".self::$table_pre."shop where `username`='".$_SESSION['monxin']['username']."' and `state`=2 order by `id` desc limit 0,1";
$module=$pdo->query($sql,2)->fetch(2);
if($module['id']==''){echo 'no shop';return false;}
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$sql="select `id` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and `recommendation`=1 limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']!=''){
	$module['recommendation_discount_remark']=str_replace('{discount}',$module['recommendation_discount'],self::$language['recommendation_discount_remark']);	
	$module['recommendation_rebate_remark']=str_replace('{rebate}',$module['recommendation_rebate'],self::$language['recommendation_rebate_remark']);	
}else{
	$module['recommendation_discount_remark']=str_replace('{discount}','<input type="text" class=recommendation_discount value="'.$module['recommendation_discount'].'" />',self::$language['recommendation_discount_remark']);	
	$module['recommendation_rebate_remark']=str_replace('{rebate}','<input type="text" class=recommendation_rebate value="'.$module['recommendation_rebate'].'" />',self::$language['recommendation_rebate_remark']);	
}



$sql="select `min_price`,`max_price`,`w_price`,`option_enable`,`title`,`icon`,`id`,`recommendation_slogan` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and `recommendation`=1 limit 0,10";
//echo $sql;
$r2=$pdo->query($sql,2);
$list='';
foreach($r2 as $v2){
	if($v2['option_enable']==0){
		$w_price='<span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=money_value>'.$v2['w_price'].'</span>';
	}else{
		$w_price='<span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=money_value>'.$v2['min_price'].'-'.$v2['max_price'].'</span>';
	}
	$list.='<div class=goods id=goods_'.$v2['id'].'><a href="./index.php?monxin=mall.goods&id='.$v2['id'].'" target=_blank class=goods_a><img src="./program/mall/img_thumb/'.$v2['icon'].'" /><br />'.$w_price.'<span class=goods_name>'.$v2['title'].'</span></a><textarea placeholder="'.self::$language['promotion_word'].'" >'.$v2['recommendation_slogan'].'</textarea><div class=state></div></div>';	
	
}
if($list==''){$list='<span class=no_related_content_span>'.self::$language['no_related_content'].'</span>';}		

$module['list']=$list;

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
