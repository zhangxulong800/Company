<?php
$goods_id=intval(@$_GET['goods_id']);
if($goods_id==0){echo 'goods id err';return false;}
$sql="select `sales_promotion`,`shop_id`,`title`,`option_enable`,`min_price`,`w_price` from ".self::$table_pre."goods where `id`=".$goods_id;
$r=$pdo->query($sql,2)->fetch(2);
if($r['shop_id']!=SHOP_ID){echo 'goods id err';return false;}

$r3=$r;
if($r3['option_enable']==1){
	$price=$r3['min_price'];
	$sql="select `id` from ".self::$table_pre."goods_specifications where `goods_id`=".$goods_id." and `w_price`=".$price." limit 0,1";
	$r4=$pdo->query($sql,2)->fetch(2);
	$r['cost_price']=self::get_cost_price_new($pdo,$goods_id.'_'.$r4['id']);
}else{
	$price=$r3['w_price'];
	$r['cost_price']=self::get_cost_price_new($pdo,$goods_id);
}


$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&goods_id='.$goods_id;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'].'('.$r['title'].' '.self::$language['normal_price'].''.self::$language['money_symbol'].$price.' , '.self::$language['cost_price'].' '.$r['cost_price'].')';
$module['module_name']=str_replace("::","_",$method);

	

$sql="select * from ".self::$table_pre."shop_buyer_group where `shop_id`=".SHOP_ID." order by `credits` asc";
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$price1=$price*$v['discount']/10;
	$sql="select `discount` from ".self::$table_pre."goods_group_discount where `goods_id`=".$goods_id." and `group_id`=".$v['id']." limit 0,1";
	$r2=$pdo->query($sql,2)->fetch(2);
	
	if($r2['discount']==''){$price2='';}else{$price2=sprintf("%.2f",$price*$r2['discount']/10);}
	
	$list.="<tr id=tr_".$v['id'].">
	<td>".$v['name']."</td>
	<td>".self::$language['money_symbol'].$price1."/".$v['discount'].self::$language['discount']."</td>
	<td><input type=text class=price value='".$price2."' placeholder='".self::$language['price']."' old_price='".$price."' /> / <input type=text class=discount value='".$r2['discount']."'    placeholder='".self::$language['discount']."' /></td>
	<td class=operation_td><a href=# class=submit>".self::$language['submit']."</a> <span class='state'></span></td></tr>";	
}
$module['list']=$list;
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);