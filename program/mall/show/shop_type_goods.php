<?php
$module['credits_rate']=self::$config['credits_set']['rate'];
if($method==''){$method='mall::cart';}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;

$m_config=require('./program/mall/module_config.php');
$time=time();
$shop_discount=self::get_shop_discount($pdo,SHOP_ID);

$module['type_list']='';
$module['goods_list']='';
$module['type_list'].='<a href=# class="type_0 current" go=g_module_quick>'.self::$language['recommend_goods'].'</a>';
if(self::$config['online_forbid_show']){
	$sql="select `id`,`icon`,`title`,`w_price`,`min_price`,`max_price`,`option_enable`,`monthly`,`sales_promotion`,`discount`,`discount_start_time`,`discount_end_time`,`unit` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and `state`!=0 and `share`=0 and `mall_state`=1  order by `shop_sequence` desc limit 0,".$m_config['mall.shop_type_goods']['pagesize'];
}else{
	$sql="select `id`,`icon`,`title`,`w_price`,`min_price`,`max_price`,`option_enable`,`monthly`,`sales_promotion`,`discount`,`discount_start_time`,`discount_end_time`,`unit` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and `online_forbid`=0 and `state`!=0 and `share`=0 and `mall_state`=1  order by `shop_sequence` desc limit 0,".$m_config['mall.shop_type_goods']['pagesize'];
}
$r=$pdo->query($sql,2);
$goods='';
foreach($r as $gv){
		if($gv['discount']<10 && $time>$gv['discount_start_time'] && $time<$gv['discount_end_time']){$discount=$gv['discount'];$goods_discount=$gv['discount'];}else{$discount=$shop_discount;}
		if(($shop_discount<10 && ($gv['sales_promotion'] ||  $_POST['discount_join_goods'])) || isset($goods_discount)){
			if($gv['option_enable']==0){
				$gv['w_price']=sprintf("%.2f",$gv['w_price']*$discount/10);
			}else{
				$gv['min_price']=sprintf("%.2f",$gv['min_price']*$discount/10);
				$gv['max_price']=sprintf("%.2f",$gv['max_price']*$discount/10);
			}
		}
		if($gv['option_enable']==0){
			$gv['w_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$gv['w_price']);
			$w_price='<span class=money_value>'.$gv['w_price'].'</span><span class=money_symbol>'.self::$language['yuan'].'</span>';
			$sv=array();
			$sv['s_id']=0;
			$sv['s_price']=0;
		}else{
			$sv=self::get_goods_s($pdo,$gv['id']);
			$sv['s_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$sv['s_price']);
			if($gv['min_price']==$gv['max_price']){
				$gv['min_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$gv['min_price']);
				$w_price='<span class=money_value>'.$gv['min_price'].'</span><span class=money_symbol>'.self::$language['yuan'].'</span>';
			}else{
				$gv['min_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$gv['min_price']);
				$gv['max_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$gv['max_price']);
				$w_price='<span class=money_value>'.$gv['min_price'].'-'.$gv['max_price'].'</span><span class=money_symbol>'.self::$language['yuan'].'</span>';
			}
		}
		$buy_button="<div class=button_div><a href='./index.php?monxin=mall.goods&id=".$gv['id']."' target=_blank  class=add_cart option_enable='".$gv['option_enable']."'  s_id='".$sv['s_id']."' s_price='".$sv['s_price']."' title='".self::$language['add_cart']."'></a></div>";
		$goods.="<div class=goods><a href='./index.php?monxin=mall.goods&shop_id=".SHOP_ID."&id=".$gv['id']."' target=_blank class=goods_a><img wsrc='./program/mall/img_thumb/".$gv['icon']."' /><span class=title>".de_safe_str($gv['title'])."</span></a><span class=price_span>".$w_price."/".self::get_mall_unit_name($pdo,$gv['unit'])."</span>".$buy_button."</div>";

}
	if($goods!=''){$module['goods_list'].='<div class=g_module_name><span>'.self::$language['recommend_goods'].'</span></div><div  class=g_module id=g_module_quick>'.$goods.'</div>';}



$sql="select * from ".self::$table_pre."shop_type where `shop_id`=".SHOP_ID." and `parent`=0 and `visible`=1 order by `sequence` desc";
$r=$pdo->query($sql,2);
foreach($r as $v){
	$module['type_list'].='<a href=# class=type_0 go=g_module_'.$v['id'].'>'.de_safe_str($v['name']).'</a>';
	if(self::$config['online_forbid_show']){
		$sql="select `id`,`icon`,`title`,`w_price`,`min_price`,`max_price`,`option_enable`,`monthly`,`sales_promotion`,`discount`,`discount_start_time`,`discount_end_time`,`unit` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and `shop_type`=".$v['id']." and `state`!=0 and `share`=0 and `mall_state`=1 order by `shop_sequence` desc,`id` asc limit 0,".$m_config['mall.shop_type_goods']['pagesize'];
	}else{
		$sql="select `id`,`icon`,`title`,`w_price`,`min_price`,`max_price`,`option_enable`,`monthly`,`sales_promotion`,`discount`,`discount_start_time`,`discount_end_time`,`unit` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and `online_forbid`=0 and `shop_type`=".$v['id']." and `state`!=0 and `share`=0 and `mall_state`=1 order by `shop_sequence` desc,`id` asc limit 0,".$m_config['mall.shop_type_goods']['pagesize'];
	}
	$g=$pdo->query($sql,2);
	$goods='';
	foreach($g as $gv){
		if($gv['discount']<10 && $time>$gv['discount_start_time'] && $time<$gv['discount_end_time']){$discount=$gv['discount'];$goods_discount=$gv['discount'];}else{$discount=$shop_discount;}
		if(($shop_discount<10 && ($gv['sales_promotion'] ||  $_POST['discount_join_goods'])) || isset($goods_discount)){
			if($gv['option_enable']==0){
				$gv['w_price']=sprintf("%.2f",$gv['w_price']*$discount/10);
			}else{
				$gv['min_price']=sprintf("%.2f",$gv['min_price']*$discount/10);
				$gv['max_price']=sprintf("%.2f",$gv['max_price']*$discount/10);
			}
		}
		if($gv['option_enable']==0){
			$gv['w_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$gv['w_price']);
			$w_price='<span class=money_value>'.$gv['w_price'].'</span><span class=money_symbol>'.self::$language['yuan'].'</span>';
			$sv=array();
			$sv['s_id']=0;
			$sv['s_price']=0;
		}else{
			$sv=self::get_goods_s($pdo,$gv['id']);
			$sv['s_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$sv['s_price']);
			if($gv['min_price']==$gv['max_price']){
				$gv['min_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$gv['min_price']);
				$w_price='<span class=money_value>'.$gv['min_price'].'</span><span class=money_symbol>'.self::$language['yuan'].'</span>';
			}else{
				$gv['min_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$gv['min_price']);
				$gv['max_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$gv['max_price']);
				$w_price='<span class=money_value>'.$gv['min_price'].'-'.$gv['max_price'].'</span><span class=money_symbol>'.self::$language['yuan'].'</span>';
			}
		}
		$buy_button="<div class=button_div><a href='./index.php?monxin=mall.goods&id=".$gv['id']."' target=_blank  class=add_cart option_enable='".$gv['option_enable']."'  s_id='".$sv['s_id']."' s_price='".$sv['s_price']."' title='".self::$language['add_cart']."'></a></div>";
		$goods.="<div class=goods><a href='./index.php?monxin=mall.goods&shop_id=".SHOP_ID."&id=".$gv['id']."' target=_blank class=goods_a><img wsrc='./program/mall/img_thumb/".$gv['icon']."' /><span class=title>".de_safe_str($gv['title'])."</span></a><span class=price_span>".$w_price."/".self::get_mall_unit_name($pdo,$gv['unit'])."</span>".$buy_button."</div>";
		
	}
	if($goods!=''){$module['goods_list'].='<div class=g_module_name><span>'.de_safe_str($v['name']).'</span></div><div  class=g_module id=g_module_'.$v['id'].'>'.$goods.'</div>';}
	
	
	$sql="select * from ".self::$table_pre."shop_type where `shop_id`=".SHOP_ID." and `parent`=".$v['id']." and `visible`=1 order by `sequence` desc";
	$r2=$pdo->query($sql,2);
	foreach($r2 as $v2){
		$module['type_list'].='<a href=# class=type_1 go=g_module_'.$v2['id'].'>'.de_safe_str($v2['name']).'</a>';
			
		$sql="select `id`,`icon`,`title`,`w_price`,`min_price`,`max_price`,`option_enable`,`monthly`,`sales_promotion`,`discount`,`discount_start_time`,`discount_end_time`,`unit` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and `online_forbid`=0 and `shop_type`=".$v2['id']." and `state`!=0 and `share`=0 and `mall_state`=1 order by `shop_sequence` desc,`id` asc limit 0,".$m_config['mall.shop_type_goods']['pagesize'];
		$g=$pdo->query($sql,2);
		$goods='';
		foreach($g as $gv){
			if($gv['discount']<10 && $time>$gv['discount_start_time'] && $time<$gv['discount_end_time']){$discount=$gv['discount'];$goods_discount=$gv['discount'];}else{$discount=$shop_discount;}
			if(($shop_discount<10 && ($gv['sales_promotion'] ||  $_POST['discount_join_goods'])) || isset($goods_discount)){
				if($gv['option_enable']==0){
					$gv['w_price']=sprintf("%.2f",$gv['w_price']*$discount/10);
				}else{
					$gv['min_price']=sprintf("%.2f",$gv['min_price']*$discount/10);
					$gv['max_price']=sprintf("%.2f",$gv['max_price']*$discount/10);
				}
			}
			if($gv['option_enable']==0){
				$gv['w_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$gv['w_price']);
				$w_price='<span class=money_value>'.$gv['w_price'].'</span><span class=money_symbol>'.self::$language['yuan'].'</span>';
				$sv=array();
				$sv['s_id']=0;
				$sv['s_price']=0;
			}else{
				$sv=self::get_goods_s($pdo,$gv['id']);
				$sv['s_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$sv['s_price']);
				if($gv['min_price']==$gv['max_price']){
					$gv['min_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$gv['min_price']);
					$w_price='<span class=money_value>'.$gv['min_price'].'</span><span class=money_symbol>'.self::$language['yuan'].'</span>';
				}else{
					$gv['min_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$gv['min_price']);
					$gv['max_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$gv['max_price']);
					$w_price='<span class=money_value>'.$gv['min_price'].'-'.$gv['max_price'].'</span><span class=money_symbol>'.self::$language['yuan'].'</span>';
				}
			}
			$buy_button="<div class=button_div><a href='./index.php?monxin=mall.goods&id=".$gv['id']."' target=_blank  class=add_cart option_enable='".$gv['option_enable']."'  s_id='".$sv['s_id']."' s_price='".$sv['s_price']."' title='".self::$language['add_cart']."'></a></div>";
			$goods.="<div class=goods><a href='./index.php?monxin=mall.goods&shop_id=".SHOP_ID."&id=".$gv['id']."' target=_blank class=goods_a><img wsrc='./program/mall/img_thumb/".$gv['icon']."' /><span class=title>".de_safe_str($gv['title'])."</span></a><span class=price_span>".$w_price."/".self::get_mall_unit_name($pdo,$gv['unit'])."</span>".$buy_button."</div>";
			
		}
		if($goods!=''){$module['goods_list'].='<div class=g_module_name><span>'.de_safe_str($v2['name']).'</span></div><div  class=g_module id=g_module_'.$v2['id'].'>'.$goods.'</div>';}
			
			
		
		
	}
	//$module['goods_list'].='<div class=parent_0><div class=type_name>'.de_safe_str($v['name']).'</div><div class=sub>'.$sub.'</div></div>';
}

	$module['type_list'].='<a href=# class=type_0 go=g_module_name>'.self::$language['no_type'].'</a>';
	$sql="select `id`,`icon`,`title`,`w_price`,`min_price`,`max_price`,`option_enable`,`monthly`,`sales_promotion`,`discount`,`discount_start_time`,`discount_end_time`,`unit` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and `online_forbid`=0 and `shop_type`=0 and `state`!=0 and `share`=0 and `mall_state`=1 order by `shop_sequence` desc,`id` asc";
	$g=$pdo->query($sql,2);
	$goods='';
	foreach($g as $gv){
		if($gv['discount']<10 && $time>$gv['discount_start_time'] && $time<$gv['discount_end_time']){$discount=$gv['discount'];$goods_discount=$gv['discount'];}else{$discount=$shop_discount;}
		if(($shop_discount<10 && ($gv['sales_promotion'] ||  $_POST['discount_join_goods'])) || isset($goods_discount)){
			if($gv['option_enable']==0){
				$gv['w_price']=sprintf("%.2f",$gv['w_price']*$discount/10);
			}else{
				$gv['min_price']=sprintf("%.2f",$gv['min_price']*$discount/10);
				$gv['max_price']=sprintf("%.2f",$gv['max_price']*$discount/10);
			}
		}
		if($gv['option_enable']==0){
			$gv['w_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$gv['w_price']);
			$w_price='<span class=money_value>'.$gv['w_price'].'</span><span class=money_symbol>'.self::$language['yuan'].'</span>';
			$sv=array();
			$sv['s_id']=0;
			$sv['s_price']=0;
		}else{
			$sv=self::get_goods_s($pdo,$gv['id']);
			$sv['s_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$sv['s_price']);
			if($gv['min_price']==$gv['max_price']){
				$gv['min_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$gv['min_price']);
				$w_price='<span class=money_value>'.$gv['min_price'].'</span><span class=money_symbol>'.self::$language['yuan'].'</span>';
			}else{
				$gv['min_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$gv['min_price']);
				$gv['max_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$gv['max_price']);
				$w_price='<span class=money_value>'.$gv['min_price'].'-'.$gv['max_price'].'</span><span class=money_symbol>'.self::$language['yuan'].'</span>';
			}
		}
		$buy_button="<div class=button_div><a href='./index.php?monxin=mall.goods&id=".$gv['id']."' target=_blank  class=add_cart option_enable='".$gv['option_enable']."'  s_id='".$sv['s_id']."' s_price='".$sv['s_price']."' title='".self::$language['add_cart']."'></a></div>";
		$goods.="<div class=goods><a href='./index.php?monxin=mall.goods&shop_id=".SHOP_ID."&id=".$gv['id']."' target=_blank class=goods_a><img wsrc='./program/mall/img_thumb/".$gv['icon']."' /><span class=title>".de_safe_str($gv['title'])."</span></a><span class=price_span>".$w_price."/".self::get_mall_unit_name($pdo,$gv['unit'])."</span>".$buy_button."</div>";
		
	}
	if($goods!=''){$module['goods_list'].='<div class=g_module_name><span>'.self::$language['no_type'].'</span></div><div  class=g_module id=g_module_name>'.$goods.'</div>';}


$module['shop_master']=SHOP_MASTER;
$module['username']=@$_SESSION['monxin']['username'];

require('./templates/0/'.$class.'_shop/'.self::$config['shop_template'].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php');	
