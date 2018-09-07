<?php
$module['credits_rate']=self::$config['credits_set']['rate'];
$sql="select `phone_goods_list_show_buy_button` from ".self::$table_pre."shop_order_set where `shop_id`=".SHOP_ID;
$r=$pdo->query($sql,2)->fetch(2);
$phone_goods_list_show_buy_button=$r['phone_goods_list_show_buy_button'];
$_GET['type']=intval(@$_GET['type']);
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['old_search']=$_GET['search'];
$show_method=(isset($_GET['show_method']))?$_GET['show_method']:'show_grid';
$module['ad']='';
$search_type=false;
if($_GET['search']!='' && !isset($_GET['no_search_type'])){
	$sql="select `id` from ".self::$table_pre."shop_type where `shop_id`=".SHOP_ID." and `visible`=1 and `name`='".$_GET['search']."' order by `parent` asc,`sequence` desc limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']=='' && strlen($_GET['search'])>5){
		
		$sql="select `id` from ".self::$table_pre."shop_type where `shop_id`=".SHOP_ID." and `visible`=1 and  `name` like '%".$_GET['search']."%' order by `parent` asc,`sequence` desc  limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
	}
	if($r['id']!=''){$_GET['type']=$r['id'];$_GET['search']='';$search_type=true;}
}

if($_GET['search']==''){
	if($_GET['type']!=0){
		$sql="select `remark` from ".self::$table_pre."shop_type where `id`=".$_GET['type']." and `shop_id`=".SHOP_ID;
		$r=$pdo->query($sql,2)->fetch(2);
		$r=de_safe_str($r);
		$module['ad']='<div class=ad>'.$r['remark'].'</div>';
	}

}


$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
if(PAGE_LAYOUT=='full'){$page_size=15;}else{$page_size=12;}
if(self::$config['online_forbid_show']){
	$sql="select `id`,`icon`,`title`,`w_price`,`min_price`,`max_price`,`option_enable`,`monthly`,`satisfaction`,`sales_promotion`,`discount`,`discount_start_time`,`discount_end_time`,`unit` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and `state`!=0 and  `mall_state`=1";
}else{
	$sql="select `id`,`icon`,`title`,`w_price`,`min_price`,`max_price`,`option_enable`,`monthly`,`satisfaction`,`sales_promotion`,`discount`,`discount_start_time`,`discount_end_time`,`unit` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and `state`!=0 and  `mall_state`=1 and `online_forbid`=0";

}

$where="";
if($_GET['type']>0){
	$type_ids=$this->get_shop_type_ids($pdo,$_GET['type']);
	$where.=" and `shop_type` in (".$type_ids.")";
}

$_GET['tag']=intval(@$_GET['tag']);
if($_GET['tag']>0){
	$where.=" and `shop_tag` like '%|".$_GET['tag']."|%'";
}

if(intval(@$_GET['min_price'])!=0){
	$where.=" and `w_price`>=".intval($_GET['min_price']);	
}
if(intval(@$_GET['max_price'])!=0){
	$where.=" and `w_price`<=".intval($_GET['max_price']);	
}
if($_GET['search']!=''){$where.=" and (`title` like '%".$_GET['search']."%' || `py` like '%".$_GET['search']."%')";}
if($_GET['old_search']!=''){
	if($_GET['current_page']==1 && !isset($_GET['click'])){
		$temp_sql="select `id` from ".self::$table_pre."search_log where `keyword`='".$_GET['old_search']."' limit 0,1";
		$r=$pdo->query($temp_sql,2)->fetch(2);
		if($r['id']==''){
			$temp_sql="insert into ".self::$table_pre."search_log (`keyword`) values ('".$_GET['old_search']."')";	
		}else{
			$temp_sql="update ".self::$table_pre."search_log set `sum`=`sum`+1,`year`=`year`+1,`month`=`month`+1,`week`=`week`+1,`day`=`day`+1 where `id`=".$r['id'];
		}
		$pdo->exec($temp_sql);
		
		$temp_sql="select `id` from ".self::$table_pre."shop_search_log where `shop_id`=".SHOP_ID."  and `keyword`='".$_GET['old_search']."' limit 0,1";
		$r=$pdo->query($temp_sql,2)->fetch(2);
		if($r['id']==''){
			$temp_sql="insert into ".self::$table_pre."shop_search_log (`keyword`,`shop_id`) values ('".$_GET['old_search']."','".SHOP_ID."')";	
		}else{
			$temp_sql="update ".self::$table_pre."shop_search_log set `sum`=`sum`+1,`year`=`year`+1,`month`=`month`+1,`week`=`week`+1,`day`=`day`+1 where `id`=".$r['id'];
		}
		$pdo->exec($temp_sql);
		
		
	}
}

$_GET['order']=safe_str(@$_GET['order']);
if($_GET['order']==''){
	$order=" order by `sequence` desc,`monthly` desc";
}else{
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" `id`,`icon`,`title`,`w_price`,`min_price`,`max_price`,`option_enable`,`monthly`,`satisfaction`,`sales_promotion`,`discount`,`discount_start_time`,`discount_end_time`,`unit` "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_goods and","_goods where",$sum_sql);
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_goods and","_goods where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
$time=time();
$shop_discount=self::get_shop_discount($pdo,SHOP_ID);
if($_COOKIE['monxin_device']=='phone'){self::$language['monthly']=self::$language['monthly_sold_short'];}
foreach($r as $v){
	$v=de_safe_str($v);
	if($v['discount']<10 && $time>$v['discount_start_time'] && $time<$v['discount_end_time']){
		$discount=$v['discount'];$goods_discount=$v['discount'];
	}else{
		if($_POST['discount_join_goods'] || $v['sales_promotion']){$discount=$shop_discount;}else{$discount=10;}
	}
	if(($shop_discount<10  && ($_POST['discount_join_goods'] || $v['sales_promotion'])) || isset($goods_discount)){
		if($v['option_enable']==0){
			$v['w_price']=sprintf("%.2f",$v['w_price']*$discount/10);
		}else{
			$v['min_price']=sprintf("%.2f",$v['min_price']*$discount/10);
			$v['max_price']=sprintf("%.2f",$v['max_price']*$discount/10);
		}
	}
	
		if($v['option_enable']==0){
			$v['w_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['w_price']);
			$w_price='<span class=money_value>'.$v['w_price'].'</span><span class=money_symbol>'.self::$language['yuan'].'</span>';
			$sv=array();
			$sv['s_id']=0;
			$sv['s_price']=0;
		}else{
			$sv=self::get_goods_s($pdo,$v['id']);
			$sv['s_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$sv['s_price']);
			if($v['min_price']==$v['max_price']){
				$v['min_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['min_price']);
				$w_price='<span class=money_value>'.$v['min_price'].'</span><span class=money_symbol>'.self::$language['yuan'].'</span>';
			}else{
				$v['min_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['min_price']);
				$v['max_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['max_price']);
				$w_price='<span class=money_value>'.$v['min_price'].'-'.$v['max_price'].'</span><span class=money_symbol>'.self::$language['yuan'].'</span>';
			}
		}
	if($_COOKIE['monxin_device']=='phone' && $phone_goods_list_show_buy_button==0){
		$button='';	
	}else{
		if($_COOKIE['monxin_device']=='phone'){
			$button="<div class=button_div><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank  class=add_cart user_color=button option_enable='".$v['option_enable']."'  s_id='".$sv['s_id']."' s_price='".$sv['s_price']."'>".self::$language['add_cart']."</a></div>";
		}else{
			$button="<div class=button_div><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank  class=add_cart user_color=button option_enable='".$v['option_enable']."'  s_id='".$sv['s_id']."' s_price='".$sv['s_price']."'>".self::$language['add_cart']."</a><a href=# class=favorite>".self::$language['favorite']."</a></div>";
		}
		
	}
	
	$sum_div='';
	if(self::$config['show_sold']){$sum_div="<span class=sum_div><span class=monthly><span class=m_label>".self::$language['monthly'].':</span><span class=value>'.$v['monthly']."</span></span><span class=satisfaction><span class=m_label>".self::$language['satisfaction'].':</span><span class=value>'.$v['satisfaction']."%</span></span></span>";}
	
	if($show_method!='show_line'){
		
		$list.="<div class=goods id=g_".$v['id']."><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank class=goods_a><img src='./program/mall/img_thumb/".$v['icon']."' /><span class=title>".$v['title']."</span><span class=price_span>".$w_price."/".self::get_mall_unit_name($pdo,$v['unit'])."</span>".$sum_div."</a>".$button."</div>";
	}else{
		if($_COOKIE['monxin_device']=='phone'){
			$list.="<div class=line id=g_".$v['id']."><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank class=goods_img><img src='./program/mall/img_thumb/".$v['icon']."' /></a><div class=good_info><div class=top2><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank class=title>".$v['title']."</a><span class=price_span>".$w_price."/".self::get_mall_unit_name($pdo,$v['unit'])."</span>".$button."</div><div class=bottom>".$sum_div."</div></div></div>";

		}else{
			$list.="<div class=line id=g_".$v['id']."><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank class=goods_img><img src='./program/mall/img_thumb/".$v['icon']."' /></a><div class=good_info><div class=top2><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank class=title>".$v['title']."</a><span class=price_span>".$w_price."/".self::get_mall_unit_name($pdo,$v['unit'])."</span></div><div class=bottom>".$sum_div."".$button."</div></div></div>";

		}
	}
	
		
}
if($sum==0){
	if($search_type){header('location:http://'.get_url().'&no_search_type=ture');exit;}
	$list='<div align="center"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></div>';
}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

$module['position']="<span id=current_position_text>".self::$language['current_position']."</span><a href='./index.php?monxin=mall.shop_index&shop_id=".SHOP_ID."'><span id=visitor_position_icon>&nbsp;</span>".self::$config['shop_name']."</a><a href=./index.php?monxin=mall.shop_goods_list&shop_id=".SHOP_ID.">".self::$language['all_goods']."</a>";

if(@$_GET['tag']!=''){
	$sql="select `name` from ".self::$table_pre."shop_tag where `id`=".intval($_GET['tag']);
	$r=$pdo->query($sql,2)->fetch(2);
	$module['position'].=$r['name'];
}elseif(@$_GET['search']!=''){
	$module['position'].=$_GET['search'];
}else{
	$module['position'].=$this->get_shop_type_position($pdo,$_GET['type']);
}

$module['shop_master']=SHOP_MASTER;
$module['username']=@$_SESSION['monxin']['username'];
require('./templates/0/'.$class.'_shop/'.self::$config['shop_template'].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php');