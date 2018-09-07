<?php
self::collect_interest($pdo);
$module['credits_rate']=self::$config['credits_set']['rate'];
$_GET['type']=intval(@$_GET['type']);
$module['data']['top_html']='';
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$show_method=(isset($_GET['show_method']))?$_GET['show_method']:'show_grid';
$module['ad']='';
$search_type=false;
if($_GET['search']!='' && !isset($_GET['no_search_type'])){
	$_GET['type']='';
	$sql="select `id` from ".self::$table_pre."type where `visible`=1 and (`url`='' or `url` is null) and `name`='".$_GET['search']."' order by `parent` asc,`sequence` desc limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']=='' && strlen($_GET['search'])>5){
		$sql="select `id` from ".self::$table_pre."type where `visible`=1 and (`url`='' or `url` is null) and  `name` like '%".$_GET['search']."%' order by `parent` asc,`sequence` desc  limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
	}
	if($r['id']!=''){$_GET['type']=$r['id'];$_GET['search']='';$search_type=true;}
}

if($_GET['search']==''){
	if($_GET['type']!=0){
		$sql="select `remark` from ".self::$table_pre."type where `id`=".$_GET['type'];
		$r=$pdo->query($sql,2)->fetch(2);
		$r=de_safe_str($r);
		$module['ad']='<div class=ad>'.@$r['remark'].'</div>';
	}
	
	$sql="select `name`,`id` from ".self::$table_pre."type where `visible`=1 and `parent`=".$_GET['type']." order by `sequence` desc";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$module['data']['top_html'].='<a href=index.php?monxin=mall.goods_list&type='.$v['id'].' id=type_a_'.$v['id'].'>'.$v['name'].'</a>';	
	}
	if($module['data']['top_html']!=''){$module['data']['top_html']='<div id=type><div class=top_label>'.self::$language['type'].'</div><div class=top_html>'.$module['data']['top_html'].'</div></div>';}
	
}


$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);
if(self::$config['online_forbid_show']){
	$online_forbid='';
}else{
	$online_forbid=' and `online_forbid`=0';
}

$sql="select `id`,`icon`,`title`,`w_price`,`min_price`,`max_price`,`option_enable`,`monthly`,`satisfaction`,`sales_promotion`,`discount`,`discount_start_time`,`discount_end_time`,`shop_id`,`bidding_show`,`unit` from ".self::$table_pre."goods where `state`!=0 and `share`=0 and `mall_state`=1".$online_forbid;

$where="";
if($_GET['type']>0){
	$type_ids=$this->get_type_ids($pdo,$_GET['type']);
	$where.=" and `type` in (".$type_ids.")";
	
	
	$t_sql="select * from ".self::$table_pre."type where `id`=".$_GET['type'];
	$type_r=$pdo->query($t_sql,2)->fetch(2);
	
//=================================================================================================================================【获取当前分类品牌，用于筛选商品】
	$brand_type_id=0;
	$r=$type_r;
	if($r['brand_source']){
		$brand_type_id=$r['id'];
	}elseif($r['parent']!=0){
		$t_sql="select `id`,`brand_source`,`parent` from ".self::$table_pre."type where `id`=".$r['parent'];
		$r=$pdo->query($t_sql,2)->fetch(2);
		if($r['brand_source']){
			$brand_type_id=$r['id'];
		}elseif($r['parent']!=0){
			$t_sql="select `id`,`brand_source`,`parent` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($t_sql,2)->fetch(2);
			if($r['brand_source']){
				$brand_type_id=$r['id'];
			}
		}
	}
	if($brand_type_id>0){
		$t_sql="select `id`,`name` from ".self::$table_pre."type_brand where `type_id`=".$brand_type_id."  order by `sequence` desc limit 0,20";
		$r=$pdo->query($t_sql,2);
		$temp='';
		foreach($r as $v){
			$v=de_safe_str($v);
			$temp.='<a href=# brand='.$v['id'].'>'.$v['name'].'</a>';	
		}
		if($temp!=''){
			$module['data']['top_html'].='<div id=brand><div class=top_label>'.self::$language['brand'].'</div><div class=top_html><a href=# brand=0>'.self::$language['unlimited'].'</a>'.$temp.'</div></div>';	
		}	
	}

//===========================================================================================================================【获取当前分类下商品颜色，用于筛选商品】
	$r=$type_r;
	if($r['contain_color']!=''){
		$temp2=explode(',',$r['contain_color']);
		$r['contain_color']=trim($r['contain_color'],',');
		$t_sql="select `id`,`name` from ".self::$table_pre."color where `id` in (".$r['contain_color'].") limit 0,20";
		$r=$pdo->query($t_sql,2);
		$temp='';
		$temp3=array();
		foreach($r as $v){
			$v=de_safe_str($v);
			$temp3[$v['id']]='<a href=# color='.$v['id'].'>'.$v['name'].'</a>';	
		}
		foreach($temp2 as $k=>$v){
			$temp.=@$temp3[$v];
		}
		if($temp!=''){
			$module['data']['top_html'].='<div id=color><div class=top_label>'.self::$language['color'].'</div><div class=top_html><a href=# color=0>'.self::$language['unlimited'].'</a>'.$temp.'</div></div>';	
		}	
		
	}				  


	
//===============================================================================================================================【获取当前分类选项，用于筛选商品】
	$specifications_type_id=0;
	$r=$type_r;
	if($r['specifications_source']){
		$specifications_type_id=$r['id'];
	}elseif($r['parent']!=0){
		$t_sql="select `id`,`specifications_source`,`parent` from ".self::$table_pre."type where `id`=".$r['parent'];
		$r=$pdo->query($t_sql,2)->fetch(2);
		if($r['specifications_source']){
			$specifications_type_id=$r['id'];
		}elseif($r['parent']!=0){
			$t_sql="select `id`,`specifications_source`,`parent` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($t_sql,2)->fetch(2);
			if($r['specifications_source']){
				$specifications_type_id=$r['id'];
			}
		}
	}
	if($specifications_type_id>0){
		$t_sql="select `color`,`diy_option`,`option_name` from ".self::$table_pre."type where `id`=".$specifications_type_id;
		$r=$pdo->query($t_sql,2)->fetch(2);
		$old_r=$r;
		if($old_r['diy_option'] && $old_r['option_name']!=''){
			$t_sql="select `id`,`name` from ".self::$table_pre."type_option where `type_id`=".$specifications_type_id." and `shop_id`=0 order by `sequence` desc limit 0,20";
			$r=$pdo->query($t_sql,2);
			$temp='';
			foreach($r as $v){
				$v=de_safe_str($v);
				$temp.='<a href=# option='.$v['id'].'>'.$v['name'].'</a>';	
			}
			if($temp!=''){
				$module['data']['top_html'].='<div id=option><div class=top_label>'.$old_r['option_name'].'</div><div class=top_html><a href=# option=0>'.self::$language['unlimited'].'</a>'.$temp.'</div></div>';	
			}	
		}
		
	}
	
//===============================================================================================================================【获取当前分类价位，用于筛选商品】
	$r=$type_r;
	
	if($r['price']!=''){
		$r['price']=de_safe_str($r['price']);
		$temp2=explode(',',$r['price']);
		$temp='';
		foreach($temp2 as $v){
			$temp3=explode('-',$v);
			$temp.='<a href=# min_price='.intval($temp3[0]).' max_price='.@$temp3[1].'>'.$v.'</a>';	
		}
		if($temp!=''){
			$module['data']['top_html'].='<div id=price><div class=top_label>'.self::$language['type_price'].'</div><div class=top_html><a href=# min_price=-1 max_price= >'.self::$language['unlimited'].'</a>'.$temp.'</div></div>';	
		}	
	}

	
	
	
//===============================================================================================================================【获取当前分类属性，用于筛选商品】
	$attribute_type_id=0;
	$r=$type_r;
	if($r['attribute_source']){
		$attribute_type_id=$r['id'];
	}elseif($r['parent']!=0){
		$t_sql="select `id`,`attribute_source`,`parent` from ".self::$table_pre."type where `id`=".$r['parent'];
		$r=$pdo->query($t_sql,2)->fetch(2);
		if($r['attribute_source']){
			$attribute_type_id=$r['id'];
		}elseif($r['parent']!=0){
			$t_sql="select `id`,`attribute_source`,`parent` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($t_sql,2)->fetch(2);
			if($r['attribute_source']){
				$attribute_type_id=$r['id'];
			}
		}
	}
	if($attribute_type_id>0){
		$t_sql="select `id`,`name`,`values` from ".self::$table_pre."type_attribute where `type_id`=".$attribute_type_id." and `list_show`=1 order by `sequence` desc limit 0,20";
		$r=$pdo->query($t_sql,2);
		$temp='';
		foreach($r as $v){
			$v=de_safe_str($v);
			$temp2='';
			$values=explode('/',$v['values']);
			foreach($values as $v2){
				$temp2.='<a href=#>'.$v2.'</a>';
			}
			$temp.='<div class=attribute id=a_'.$v['id'].'><div class=top_label old_name="'.$v['name'].'">'.$v['name'].'</div><div class=top_html><a href=# a_'.$v['id'].'=0>'.self::$language['unlimited'].'</a>'.$temp2.'</div></div>';	
		}
		if($temp!=''){
			$module['data']['top_html'].=$temp;	
		}	
	}
	
	
}
$_GET['tag']=intval(@$_GET['tag']);
if($_GET['tag']>0){
	$where.=" and `tag` like '%|".$_GET['tag']."|%'";
}
if(intval(@$_GET['brand'])>0){
	$where.=" and `brand`=".intval($_GET['brand'])."";
}
if(intval(@$_GET['recommendation'])==1){
	$where.=" and `recommendation`=1 ";
}
	
//===============================================================================================================================【生成当前分类 颜色、选项SQL】
$color_goods_ids=array();
$option_goods_ids=array();
$t_where='';
if(intval(@$_GET['color'])>0 && $_GET['type']>0){
	$t_sql="select `goods_id` from ".self::$table_pre."goods_specifications where `color_id`=".intval($_GET['color'])." and `type` in (".$type_ids.")";
	$r=$pdo->query($t_sql,2);
	foreach($r as $v){
		$color_goods_ids[$v['goods_id']]=$v['goods_id'];	
	}
	if(count($color_goods_ids)>0){$t_where.=' and `id` in ('.implode(',',$color_goods_ids).')';}else{$t_where.=' and `id`=0';}
}
if(intval(@$_GET['option'])>0 && $_GET['type']>0){
	$t_sql="select `goods_id` from ".self::$table_pre."goods_specifications where `option_id`=".intval($_GET['option'])." and `type` in (".$type_ids.")";
	$r=$pdo->query($t_sql,2);
	foreach($r as $v){
		$option_goods_ids[$v['goods_id']]=$v['goods_id'];	
	}
	if(count($option_goods_ids)>0){$t_where.=' and `id` in ('.implode(',',$option_goods_ids).')';}else{$t_where.=' and `id`=0';}
}

if(count($color_goods_ids)>0 && count($option_goods_ids)>0){
	$temp=array();
	if(count($option_goods_ids)>count($color_goods_ids)){
		foreach($color_goods_ids as $k=>$v){
			if(isset($option_goods_ids[$k])){$temp[]=$v;}	
		}
	}else{
		foreach($option_goods_ids as $k=>$v){
			if(isset($color_goods_ids[$k])){$temp[]=$v;}	
		}
	}
	
	if(count($temp)>0){$where.=' and `id` in ('.implode(',',$temp).')';}else{$where.=' and `id`=0';}
}else{
	$where.=$t_where;	
}

//===============================================================================================================================【生成当前分类 属性SQL】
foreach($_GET as $k=>$v){
	if(is_match('#a_[0-9]{1}#iU',$k) && $v!=''){
		$a_id=intval(str_replace('a_','',$k));
		$t_sql="select `name` from ".self::$table_pre."type_attribute where `id`=".$a_id;
		$r=$pdo->query($t_sql,2)->fetch(2);
		$a_name=$r['name'];
		$t_sql="select `id` from ".self::$table_pre."type_attribute where `type_id` in (".$type_ids.") and `name`='".$a_name."'";	
		$r=$pdo->query($t_sql,2);
		foreach($r as $v2){
			$a_id.=','.$v2['id'];
		}
		//$t_sql="select `goods_id` from ".self::$table_pre."goods_attribute where `attribute_id` in (".$a_id.") and `value`='".safe_str($v)."' and `type` in (".$type_ids.")";
		$t_sql="select `goods_id` from ".self::$table_pre."goods_attribute where `attribute_id` in (".$a_id.") and `value`='".safe_str($v)."'";
		$r=$pdo->query($t_sql,2);
		$temp=array();
		foreach($r as $v){
			$temp[$v['goods_id']]=$v['goods_id'];	
		}
		if(count($temp)>0){$where.=' and `id` in ('.implode(',',$temp).')';}else{$where.=' and `id`=0';}
	}	
}

if(intval(@$_GET['min_price'])!=0){
	$where.=" and `w_price`>=".intval($_GET['min_price']);	
}
if(intval(@$_GET['max_price'])!=0){
	$where.=" and `w_price`<=".intval($_GET['max_price']);	
}
if($_GET['search']!=''){
	$where.=" and (`title` like '%".$_GET['search']."%' || `py` like '%".$_GET['search']."%')";
	
	if($_GET['current_page']==1 && !isset($_GET['click'])){
		$temp_sql="select `id` from ".self::$table_pre."search_log where `keyword`='".$_GET['search']."' limit 0,1";
		$r=$pdo->query($temp_sql,2)->fetch(2);
		if($r['id']==''){
			$temp_sql="insert into ".self::$table_pre."search_log (`keyword`) values ('".$_GET['search']."')";	
		}else{
			$temp_sql="update ".self::$table_pre."search_log set `sum`=`sum`+1,`year`=`year`+1,`month`=`month`+1,`week`=`week`+1,`day`=`day`+1 where `id`=".$r['id'];
		}
		$pdo->exec($temp_sql);
	}
}


$circle=intval($_COOKIE['circle']);
if($circle>0){
	$circle=get_circle_ids($pdo,$circle);
	$shop_ids=self::get_circle_shop_ids($pdo,$circle);
	if($shop_ids==''){$shop_ids='0';}
	$where.=" and `shop_id` in (".$shop_ids.")";
}

$store_tag=intval(@$_GET['store_tag']);
if($store_tag>0){
	$shop_ids=self::get_store_tag_shop_ids($pdo,$store_tag);
	if($shop_ids==''){$shop_ids='0';}
	$where.=" and `shop_id` in (".$shop_ids.")";
}

$_GET['order']=safe_str(@$_GET['order']);
if($_GET['order']==''){
	$order=" order by `bidding_show` desc,`sequence` desc, `deposit` desc ,`monthly` desc";
}else{
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1].",`bidding_show` desc";}else{$order='';}		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" `id`,`icon`,`title`,`w_price`,`min_price`,`max_price`,`option_enable`,`monthly`,`satisfaction`,`sales_promotion`,`discount`,`discount_start_time`,`discount_end_time`,`shop_id`,`bidding_show`,`unit` "," count(id) as c ",$sum_sql);
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
if($_COOKIE['monxin_device']=='phone'){self::$language['monthly']=self::$language['monthly_sold_short'];}
$s_discount=array();
foreach($r as $v){
	$v=de_safe_str($v);
	if(!isset($s_discount[$v['shop_id']])){
		$s_discount[$v['shop_id']]=self::get_shop_discount($pdo,$v['shop_id']);
	}
	$shop_discount=$s_discount[$v['shop_id']];
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
		$w_price='<span class=money_value>'.$v['w_price'].'<span class=money_symbol>'.self::$language['yuan'].'</span></span>';
		$sv=array();
		$sv['s_id']=0;
		$sv['s_price']=0;
	}else{
		$sv=self::get_goods_s($pdo,$v['id']);
		$sv['s_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$sv['s_price']);
		if($v['min_price']==$v['max_price']){
			$v['min_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['min_price']);
			$w_price='<span class=money_value>'.$v['min_price'].'<span class=money_symbol>'.self::$language['yuan'].'</span></span>';
		}else{
			$v['min_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['min_price']);
			$v['max_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['max_price']);
			$w_price='<span class=money_value>'.$v['min_price'].'-'.$v['max_price'].'<span class=money_symbol>'.self::$language['yuan'].'</span></span>';
		}
	}
	
	
	if($_COOKIE['monxin_device']=='phone' && self::$config['phone_goods_list_show_buy_button']==false){
		$button='';	
	}else{
		if($_COOKIE['monxin_device']=='phone'){
			$button="<div class=button_div><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank  class=add_cart option_enable='".$v['option_enable']."' s_id='".$sv['s_id']."' s_price='".$sv['s_price']."'>".self::$language['add_cart']."</a></div>";
		}else{
			$button="<div class=button_div><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank  class=add_cart option_enable='".$v['option_enable']."' s_id='".$sv['s_id']."' s_price='".$sv['s_price']."'>".self::$language['add_cart']."</a><a href=# class=favorite>".self::$language['favorite']."</a></div>";
		}
		
	}
	if($v['bidding_show']==0){$bidding_show=0;}else{$bidding_show=1;}
	$sum_div='';
	if(self::$config['show_sold']){$sum_div="<span class=sum_div><span class=monthly><span class=m_label>".self::$language['monthly'].':</span><span class=value>'.$v['monthly']."</span></span><span class=satisfaction><span class=m_label>".self::$language['satisfaction'].':</span><span class=value>'.$v['satisfaction']."%</span></span></span>";}
	
	if($show_method!='show_line'){
		$list.="<div class=goods id=g_".$v['id']." bidding=".$bidding_show."><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank class=goods_a><img src='./program/mall/img_thumb/".$v['icon']."' /><span class=title>".$v['title']."</span><span class=price_span>".$w_price."/".self::get_mall_unit_name($pdo,$v['unit'])."</span>".$sum_div."</a>".$button."</div>";
	}else{
		if($_COOKIE['monxin_device']=='phone'){
			$list.="<div class=line id=g_".$v['id']." bidding=".$bidding_show."><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank class=goods_img><img src='./program/mall/img_thumb/".$v['icon']."' /></a><div class=good_info><div class=top2><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank class=title>".$v['title']."</a><span class=price_span>".$w_price."/".self::get_mall_unit_name($pdo,$v['unit'])."</span>".$button."</div><div class=bottom>".$sum_div."</div></div></div>";

		}else{
			$list.="<div class=line id=g_".$v['id']." bidding=".$bidding_show."><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank class=goods_img><img src='./program/mall/img_thumb/".$v['icon']."' /></a><div class=good_info><div class=top2><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank class=title>".$v['title']."</a><span class=price_span>".$w_price."/".self::get_mall_unit_name($pdo,$v['unit'])."</span></div><div class=bottom>".$sum_div."".$button."</div></div></div>";

		}
	}
	
		
}
if($sum==0){
	if($search_type){header('location:http://'.get_url().'&no_search_type=ture');exit;}
	$list='<div align="center"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></div>';
}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],false);


if(@$_GET['tag']!=''){
	$sql="select `name` from ".self::$table_pre."tag where `id`=".intval($_GET['tag']);
	$r=$pdo->query($sql,2)->fetch(2);
	$visitor_position_reset='<div id="visitor_position_reset" style="display:none;"><span id=current_position_text>'.self::$language['current_position'].'</span><a href="./index.php"><span id=visitor_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a><a href="./index.php?monxin=mall.goods_list">'.self::$language['pages']['mall.goods_list']['name'].'</a>'.$r['name'].'</div>';
}elseif(@$_GET['search']!=''){
	$visitor_position_reset='<div id="visitor_position_reset" style="display:none;"><span id=current_position_text>'.self::$language['current_position'].'</span><a href="./index.php"><span id=visitor_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a><a href="./index.php?monxin=mall.goods_list">'.self::$language['pages']['mall.goods_list']['name'].'</a>'.$_GET['search'].'</div>';
}else{
	$visitor_position_reset='<div id="visitor_position_reset" style="display:none;"><span id=current_position_text>'.self::$language['current_position'].'</span><a href="./index.php"><span id=visitor_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a><a href="./index.php?monxin=mall.goods_list">'.self::$language['pages']['mall.goods_list']['name'].'</a>'.$this->get_type_position($pdo,$_GET['type']).'</div>';
}

$module['circle_list']='';
$module['circle_list_sub']='';
$sql="select `id`,`name` from ".$pdo->index_pre."circle where `parent_id`=0 and `visible`=1 order by `sequence` desc,`id` asc";
$r=$pdo->query($sql,2);
$module['circle_list']='<a href="#" circle=0>'.self::$language['unlimited'].'</a>';
foreach($r as $v){
	$sub='';
	$sql="select `id`,`name` from ".$pdo->index_pre."circle where `parent_id`='".$v['id']."' and `visible`=1 order by `sequence` desc,`id` asc";
	$r2=$pdo->query($sql,2);
	foreach($r2 as $v2){
		$sub.='<a href="#" circle='.$v2['id'].'>'.de_safe_str($v2['name']).'</a>';	
	}
	if($sub!=''){$sub='<div upid='.$v['id'].' >'.$sub.'</div>';}
	$module['circle_list_sub'].=$sub;
	$module['circle_list'].='<a href="#"  circle='.$v['id'].'>'.de_safe_str($v['name']).'</a>';
}
$module['data']['top_html']="<div class=circle_filter>
            <div class=top_label>".self::$language['circle']."</div><div class='top_html circle_list'>
                <div class=circle_1>".$module['circle_list']."</div>
                <div class=circle_2>".$module['circle_list_sub']."</div>
            </div>
        </div>".$module['data']['top_html'];

if($_COOKIE['monxin_device']=='pc'){
	if($module['data']['top_html']!=''){$module['data']['top_html']='<div class=top>'.$module['data']['top_html'].'</div>';}
}else{
	if($module['data']['top_html']!=''){$module['data']['top_html']='<div class=top><div class=diy_price><span>'.self::$language['price_region'].'</span><span><input type=text class=min_price placeholder="'.self::$language['min_value'].'" /> - <input type=text class=max_price placeholder="'.self::$language['max_value'].'" /></span></div>'.$module['data']['top_html'].'<div class=confirm_div><a href=# class=left_return>'.self::$language['return'].'</a><a href="./index.php?monxin=mall.goods_list" class=determine user_color=button>'.self::$language['determine'].'</a></div></div>';}
}

$module['shop_master']=SHOP_MASTER;
$module['username']=@$_SESSION['monxin']['username'];




$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);

echo $visitor_position_reset;