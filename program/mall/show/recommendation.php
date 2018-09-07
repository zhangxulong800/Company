<?php
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$sql="select `recommendation` from ".$pdo->index_pre."user where `id`='".$_SESSION['monxin']['id']."'";
$r=$pdo->query($sql,2)->fetch(2);
$recommendation=$r['recommendation'];

$sql="select `goods_id` from ".self::$table_pre."order_goods where `buyer`='".$_SESSION['monxin']['username']."' and `recommendation`=1 and `order_state`=6";
$r=$pdo->query($sql,2);
$goods_ids='';
foreach($r as $v){
	$goods_ids.=$v['goods_id'].',';
}
$goods_ids=trim($goods_ids,',');
if($goods_ids==''){
	$module['list']=self::$language['recommendation_buyer_remark'];
	$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
	if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
	require($t_path);
	return false;
}


$sql="select `shop_id` from ".self::$table_pre."goods where `id` in (".$goods_ids.") group by `shop_id`";
$r=$pdo->query($sql,2);
$shop=array();
foreach($r as $v){
	$sql="select `id`,`recommendation_discount`,`recommendation_rebate` from ".self::$table_pre."shop where `id`='".$v['shop_id']."'";
	$v2=$pdo->query($sql,2)->fetch(2);
	$shop[$v2['id']]['recommendation_discount']=$v2['recommendation_discount'];
	$shop[$v2['id']]['recommendation_rebate']=$v2['recommendation_rebate'];
}

$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);


$sql="select `min_price`,`max_price`,`w_price`,`option_enable`,`title`,`icon`,`id`,`recommendation_slogan`,`shop_id` from ".self::$table_pre."goods where `id` in (".$goods_ids.") and `recommendation`=1  limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
//echo $sql;
	$sum_sql="select count(id) as c  from ".self::$table_pre."goods where `id` in (".$goods_ids.") and `recommendation`=1";
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];

$r2=$pdo->query($sql,2);
$list='';
foreach($r2 as $v2){
	$w_price='<span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=money_value>'.$v2['w_price'].'</span>';
	if($v2['option_enable']!=0){
		if($v2['min_price']!=$v2['max_price']){$w_price='<span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=money_value>'.$v2['min_price'].'-'.$v2['max_price'].'</span>';}
	}
		
	if($_COOKIE['monxin_device']=='pc'){
		$list.='<div class=goods id=goods_'.$v2['id'].'><div class=gain><span>'.self::$language['buy'].'<b>'.$shop[$v2['shop_id']]['recommendation_discount'].'</b>'.self::$language['discount'].'</span>,<span>'.self::$language['recommendation_money'].'<b>'.$shop[$v2['shop_id']]['recommendation_rebate'].'</b>%</span></div><a href="./index.php?monxin=mall.goods&id='.$v2['id'].'" target=_blank class=goods_a><img src="./program/mall/img_thumb/'.$v2['icon'].'" /><br />'.$w_price.'<span class=goods_name>'.$v2['title'].'</span></a><textarea placeholder="'.self::$language['promotion_word'].'" >'.str_replace('{code}',$recommendation,$v2['recommendation_slogan']).'</textarea><div class=state></div></div>';
	}else{
		$list.='<div class=goods id=goods_'.$v2['id'].'><div class=icon><a href="./index.php?monxin=mall.goods&id='.$v2['id'].'" target=_blank class=goods_a><img src="./program/mall/img_thumb/'.$v2['icon'].'" /><br />'.$w_price.'</a></div><div class=other>
		<span class=goods_name>'.$v2['title'].'</span>
		<div class=gain><span>'.self::$language['buy'].'<b>'.$shop[$v2['shop_id']]['recommendation_discount'].'</b>'.self::$language['discount'].'</span>,<span>'.self::$language['recommendation_money'].'<b>'.$shop[$v2['shop_id']]['recommendation_rebate'].'</b>%</span></div>
		<textarea placeholder="'.self::$language['promotion_word'].'" >'.str_replace('{code}',$recommendation,$v2['recommendation_slogan']).'</textarea><div class=state></div>
		</div></div>';
	}
}
if($sum==0){$list='<div align="center"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></div>';}		
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
