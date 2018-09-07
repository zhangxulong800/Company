<?php
if(@$_GET['act']=='scanpay'){
	echo '<form id="payment_form" name="payment_form" method="post" action="./index.php?monxin=scanpay.pay&id='.$_GET['id'].'&iframe=1">
  <input type="hidden" name="success_fun" id="success_fun" value="parent.scanpay_submit_checkout" />
  <input type="hidden" name="money" id="money" value="'.$_GET['money'].'" />
  <input type="hidden" name="payer" id="payer" value="'.$_GET['user'].'" />
  <input type="hidden" name="reason" id="reason" value="'.self::$language['checkout_pay'].'" />
</form>
<script> $(document).ready(function(){$("#payment_form").submit();});</script>
';
	return false;	
}


$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select `id`,`icon`,`title`,`e_price`,`min_price`,`max_price`,`option_enable`,`monthly`,`satisfaction`,`sales_promotion`,`discount`,`discount_start_time`,`discount_end_time`,`inventory`,`unit` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and `state`!=0";

$where="";
if(intval(@$_GET['min_price'])!=0){
	$where.=" and `w_price`>=".intval($_GET['min_price']);	
}
if(intval(@$_GET['max_price'])!=0){
	$where.=" and `w_price`<=".intval($_GET['max_price']);	
}
if($_GET['search']!=''){
	$where.=" and (`title` like '%".$_GET['search']."%' or `advantage` like '%".$_GET['search']."%' or `bar_code` like '%".$_GET['search']."%' or `speci_bar_code` like '%".$_GET['search']."%' or `store_code` like '%".$_GET['search']."%' or `speci_store_code` like '%".$_GET['search']."%' or `detail` like '%".$_GET['search']."%')";
}
$_GET['tag']=intval(@$_GET['tag']);
if($_GET['tag']>0){
	$where.=" and `shop_tag` like '%|".$_GET['tag']."|%'";
}
$_GET['type']=intval(@$_GET['type']);
if($_GET['type']>0){
	$type_ids=$this->get_shop_type_ids($pdo,$_GET['type']);
	$where.=" and `shop_type` in (".$type_ids.")";
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
	$sum_sql=str_replace(" `id`,`icon`,`title`,`e_price`,`min_price`,`max_price`,`option_enable`,`monthly`,`satisfaction`,`sales_promotion`,`discount`,`discount_start_time`,`discount_end_time`,`inventory`,`unit` "," count(id) as c ",$sum_sql);
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
	$module['option_html']='';
	$v=de_safe_str($v);
	if($v['discount']<10 && $time>$v['discount_start_time'] && $time<$v['discount_end_time']){
		$discount=$v['discount'];$goods_discount=$v['discount'];
	}else{
		if($_POST['discount_join_goods'] || $v['sales_promotion']){$discount=$shop_discount;}else{$discount=10;}
	}
	if(($shop_discount<10  && ($_POST['discount_join_goods'] || $v['sales_promotion'])) || isset($goods_discount)){
		if($v['option_enable']==0){
			$v['e_price']=sprintf("%.2f",$v['e_price']*$discount/10);
		}else{
			$v['min_price']=sprintf("%.2f",$v['min_price']*$discount/10);
			$v['max_price']=sprintf("%.2f",$v['max_price']*$discount/10);
		}
	}
	
	if($v['option_enable']==0){
		$style='';
		$e_price='<span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=money_value>'.$v['e_price'].'</span>';
	}else{
		$style=' append_option';
		if($v['min_price']==$v['max_price']){
			$e_price='<span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=money_value>'.$v['min_price'].'</span>';
		}else{
			$e_price='<span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=money_value>'.$v['min_price'].'-'.$v['max_price'].'</span>';
		}
		
		
		
		
		
		
		
		
		
		
		
	$sql="select `option_id`,`e_price` from ".self::$table_pre."goods_specifications where `goods_id`='".$v['id']."' and `option_id`!='0' group by `option_id`";
	$r2=$pdo->query($sql,2);
	$ids='';
	foreach($r2 as $v2){
		$ids.=$v2['option_id'].',';
		if($v['min_price']<$v2['e_price']){$e_price='<span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=money_value>'.$v2['e_price'].'</span>';}
	}
	$ids=trim($ids,',');
	if($ids!=''){
		$sql="select `id`,`type_id`,`name` from ".self::$table_pre."type_option where `id` in (".$ids.") order by `sequence` desc";
		$r2=$pdo->query($sql,2);
		$list2='';
		foreach($r2 as $v2){
			$list2.='<a href="#" id=option_'.$v2['id'].'>'.$v2['name'].'</a>';
			$type_id=$v2['type_id'];
		}
		if($list2!=''){
			$sql="select `option_name` from ".self::$table_pre."type where `id`=".$type_id;
			$r3=$pdo->query($sql,2)->fetch(2);
			$module['option_html'].='<div class=option_line_div><div class=option_label>'.$r3['option_name'].'</div><div class=option_option>'.$list2.'</div></div>';
		}
	}
	
	$sql="select `color_id`,`option_id`,`id`,`e_price`,`quantity` from ".self::$table_pre."goods_specifications where `goods_id`='".$v['id']."'";
	$r2=$pdo->query($sql,2);
	$list2=array();
	$module['inventory']=0;
	foreach($r2 as $v2){
		if(($shop_discount<10  && ($_POST['discount_join_goods'] || $v['sales_promotion'])) || isset($goods_discount)){$v2['e_price']=sprintf("%.2f",$v2['e_price']*$discount/10);}
		$list2[$v2['id']]['color_id']=$v2['color_id'];
		$list2[$v2['id']]['option_id']=$v2['option_id'];
		$list2[$v2['id']]['e_price']=$v2['e_price'];
		$list2[$v2['id']]['quantity']=self::format_quantity($v2['quantity']);
	}
	$module['specifications']='';
	if(count($list2)!=0){$module['specifications']=json_encode($list2);}
	$list2='';
	
	
	
	$sql="select `color_id`,`color_name`,`color_show`,`color_img` from ".self::$table_pre."goods_specifications where `goods_id`='".$v['id']."' and `color_id`!='0' group by `color_id` order by `color_img` desc,`color_show` asc,`quantity` desc";
	$r2=$pdo->query($sql,2);
	$list2='';
	foreach($r2 as $v2){
		$temp='';
		if($v2['color_img']==''){
			if($v2['color_show']==0){
				$temp='<img src="./program/mall/color_icon/'.$v2['color_id'].'.png" />';	
			}else{
				$temp='<span class=color_name>'.$v2['color_name'].'</span>';	
			}
		}else{
			$temp='<img src="./program/mall/img_thumb/'.$v2['color_img'].'" />';	
		}
		$list2.='<a href="#" id=color_'.$v2['color_id'].' title="'.$v2['color_name'].'">'.$temp.'</a>';	
	}
	if($list2!=''){$module['option_html'].='<div class=color_line_div><div class=color_label>'.self::$language['color'].'</div><div class=color_option>'.$list2.'</div></div>';}
	
		$module['option_html']="<div class=specifications>".$module['option_html']."<span class=json>".$module['specifications']."</span></div>";
		
	}
	
	$list.="<div class='goods".$style."' id=g_".$v['id'].">
	<div class=goods_icon>
		<a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank class=goods_a><img src='./program/mall/img_thumb/".$v['icon']."' old='./program/mall/img_thumb/".$v['icon']."' /></a>
	</div><div class=goods_info>
		<span class=title>".$v['title']."</span>".$module['option_html']."
	</div><div class=price_div><span class=price_span  price='".$e_price."'>".$e_price."</span></div><div class=quantity_div>
		<input type=text class=quantity  />
		<div class=inventory><span value=".self::format_quantity($v['inventory']).">".self::format_quantity($v['inventory'])."</span>".self::get_mall_unit_name($pdo,$v['unit'])."</div>
	</div><div class=act_div>
		<a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank  class=add_checkout option_enable='".$v['option_enable']."'>".self::$language['add_checkout']."</a> <span class=add_state></span>
	</div>
</div>";
	
		
}
if($sum==0){$list='<div align="center"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></div>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

$module['goods_filter']='';
$sql="select * from ".self::$table_pre."shop_tag where `shop_id`=".SHOP_ID." order by `sequence` desc,`id` asc";
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$module['goods_filter'].="<li><a data='&tag=".$v['id']."'>".de_safe_str($v['name'])."</a></li>";
}

$sql="select * from ".self::$table_pre."shop_type where `shop_id`=".SHOP_ID." and `parent`=0 order by `sequence` desc,`id` asc";
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$sql="select * from ".self::$table_pre."shop_type where `shop_id`=".SHOP_ID." and `parent`=".$v['id']." order by `sequence` desc,`id` asc";
	$r2=$pdo->query($sql,2);
	$temp='';
	foreach($r2 as $v2){
		$temp.="<li><a data='&type=".$v2['id']."'>".de_safe_str($v2['name'])."</a></li>";	
	}
	if($temp!=''){$temp="<ul>".$temp."</ul>";}
	
	$module['goods_filter'].="<li><a data='&type=".$v['id']."'>".de_safe_str($v['name'])."</a>".$temp."</li>";
}


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);