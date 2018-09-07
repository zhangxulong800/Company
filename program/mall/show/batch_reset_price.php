<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;

//=====================================================================================================================old_start
$sql="select `name`,`id`,`discount` from ".self::$table_pre."shop_buyer_group where `shop_id`='".SHOP_ID."' order by `discount` desc";
$r=$pdo->query($sql,2);

$group_field_a='';
$group_field_b='';
foreach($r as $v){
	$v['name']=de_safe_str($v['name']);
	$group_field_a.=','.$v['name'].self::$language['price2'];
	$group_field_b.=','.$v['name'].self::$language['discount_rate'];
}

self::$language['batch_reset_price_field'].=$group_field_a.$group_field_b.','.self::$language['introducer'].self::$language['introducer_rate']."(%)";

require "./plugin/html5Upfile/createHtml5.class.php";
$html5Upfile=new createHtml5();
$html5Upfile->echo_input(self::$language,"import_file",'100%','','./temp/','true','false','csv|txt',1024*10,'0');
//echo_input(语言数组,"house_model",'控件宽度(百分比或像素)','multiple','保存到文件夹','文件夹是否附加日期','是否原名保存','允许文件类型','文件最大值','文件最小值');
//=====================================================================================================================old_end





$sql="select * from ".self::$table_pre."shop_buyer_group where `shop_id`=".SHOP_ID." order by `credits` asc";
$r=$pdo->query($sql,2);
$group=array();
foreach($r as $v){
	$group[$v['id']]=array();
	$group[$v['id']]['name']=de_safe_str($v['name']);
	$group[$v['id']]['discount']=$v['discount'];
	
}




$_GET['visible']=@$_GET['visible'];
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select `id`,`title`,`unit`,`option_enable`,`w_price`,`min_price`,`e_price`,`discount`,`sales_promotion` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID;
if(isset($_GET['short_code'])){
	//$sql="update ".self::$table_pre."goods set `bar_code`='0' where `option_enable`=1";
	//$pdo->exec($sql);
	$b=1;
	$c='';
	$max=intval($_GET['short_code']);
	for($i=0;$i<$max;$i++){$b.='0';$c.='_';}
	$sql="select `id`,`title`,`unit`,`option_enable`,`w_price`,`min_price`,`e_price`,`discount`,`sales_promotion` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and (`bar_code`<".$b." or `speci_bar_code` like '".$c."|%' or `speci_bar_code` like '%|".$c."|%') and (`bar_code`!=0 or `speci_bar_code`!=NULL)";
}


$where="";
if(intval(@$_GET['id'])!=0){
	$where=" and `id`=".intval($_GET['id']);
	echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=mall.goods_admin">'.self::$language['pages']['mall.goods_admin']['name'].'</a><span class=text>'.$_GET['id'].'</span></div>';
}

if(isset($_GET['type'])){
	$_GET['type']=intval(@$_GET['type']);
	$type_ids=$this->get_shop_type_ids($pdo,$_GET['type']);
	if($_GET['type']=='0'){$type_ids='0';}
	$where.=" and `shop_type` in (".$type_ids.")";
}
$_GET['tag']=intval(@$_GET['tag']);
if($_GET['tag']>0){
	$where.=" and `shop_tag` like '%|".$_GET['tag']."|%'";
}
$_GET['position']=intval(@$_GET['position']);
if($_GET['position']>0){$where.=" and `position` ='".$_GET['position']."'";}
$_GET['supplier']=intval(@$_GET['supplier']);
if($_GET['supplier']>0){$where.=" and `supplier` ='".$_GET['supplier']."'";}


if($_GET['search']!=''){$where=" and (`title` like '%".$_GET['search']."%' or `advantage` like '%".$_GET['search']."%' or `bar_code` like '%".$_GET['search']."%' or `speci_bar_code` like '%".$_GET['search']."%' or `store_code` like '%".$_GET['search']."%' or `speci_store_code` like '%".$_GET['search']."%' or `detail` like '%".$_GET['search']."%')";}
$_GET['order']=safe_str(@$_GET['order']);
if($_GET['order']==''){
	$order=" order by `id` desc";
}else{
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" `id`,`title`,`unit`,`option_enable`,`w_price`,`min_price`,`e_price`,`discount`,`sales_promotion` "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_goods and","_goods where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_goods and","_goods where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';

function get_mall_position_name($pdo,$table_pre,$id){
	$sql="select `name` from ".$table_pre."position where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	return $r['name'];	
}
function get_mall_storehouse_name($pdo,$table_pre,$id){
	$sql="select `name` from ".$table_pre."storehouse where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	return $r['name'];	
}
function get_mall_supplier_name($pdo,$table_pre,$id){
	$sql="select `name` from ".$table_pre."supplier where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	return $r['name'];	
}


foreach($r as $v){
	$v=de_safe_str($v);
	if($v['min_price']==0){$v['min_price']=$v['w_price'];}
	$v['cost_price']=self::get_cost_price_new_3($pdo,$v['id'],$v['option_enable']);
	
	
	$sql="select * from ".self::$table_pre."goods_group_discount where `goods_id`=".$v['id'];
	$g=$pdo->query($sql,2);
	foreach($g as $gv){
		//var_dump($gv['discount']);
		$group[$gv['group_id']][$v['id']]['g_discount']=$gv['discount'];
	}
	
	
	$price_div='';
	if($v['option_enable']==1){
		$v['cost_price'].='<span class=qi>'.self::$language['more_than'].'</span>';
		$v['w_price']=$v['min_price'].'<span class=qi>'.self::$language['more_than'].'</span><span class=show_more></span>';
		$v['e_price']=$v['min_price'].'<span class=qi>'.self::$language['more_than'].'</span><span class=show_more></span>';
		
		$sql="select * from ".self::$table_pre."goods_specifications where `goods_id`=".$v['id']."";
		$s=$pdo->query($sql,2);
		//echo $sql.'<br />';
		$price=$v['min_price'];
		foreach($s as $sv){
			$sv=de_safe_str($sv);
			$batch_write='';
			//if($sv['color_name']==0){$sv['color_name']='';}
			$name=self::get_type_option_name($pdo,$sv['option_id']).' '.$sv['color_name'];
			if($price_div==''){$batch_write='<a class=batch_write>↓</a>';}
			$price_div.="<div class=s_price id=s_".$sv['id']."><span class=name>".$name."</span><span class=cprice>".self::get_cost_price_new($pdo,$v['id'].'_'.$sv['id'])."</span><span class=eprice><input type=text class=e_price value=".$sv['e_price']." /></span><span class=wprice><input type=text class=w_price value=".$sv['w_price']." />".$batch_write."</span></div>";
		}
		
	}else{
		$price=$v['w_price'];
		$v['w_price']="<input type=text class=w_price value=".$v['w_price']." />";
		$v['e_price']="<input type=text class=e_price value=".$v['e_price']." />";
		
		
	}
	
	
	$group_html='';
	foreach($group as $k=>$gv){
		//var_dump($gv);exit;
		if(isset($gv[$v['id']]['g_discount'])){$discount=$gv[$v['id']]['g_discount'];}else{$discount=$gv['discount'];}
		$gv['price']=$price*$discount/10;
		if(isset($gv[$v['id']]['g_discount'])){
			$group_html.="<div gg=".$k."_".$v['id']." group_id=".$k." price=".$price." goods_id=".$v['id']."><input type=text class=discount value=".trim(trim($discount,'0'),'.')." />".self::$language['discount']." <input type=text class=discount_money value=".$gv['price']." /> ".self::$language['yuan']." ".$gv['name']."</div>";
		}else{
			$group_html.="<div  gg=".$k."_".$v['id']."  group_id=".$k." price=".$price." goods_id=".$v['id']."><input type=text class=discount placeholder='".self::$language['default'].trim(trim($discount,'0'),'.')."' />".self::$language['discount']." <input type=text class=discount_money /> ".self::$language['yuan']." ".$gv['name']."</div>";
		}
	}
	
	$list.="<div id='tr_".$v['id']."' class=g><span class=g_title><a href=./index.php?monxin=mall.goods&id=".$v['id']." target=_blank>".$v['title']."</a></span><span class=g_cprice>".$v['cost_price']."</span><span class=g_e_price>".$v['e_price']."</span><span class=g_w_price>".$v['w_price']."</span><span class=g_discount_rate><span class=show_more></span></span><div class=more_set id=more_".$v['id']."><div class=price_div>".$price_div."</div><div class=discount_div>".$group_html."</div></div></div>";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

function get_position_filter($pdo,$language,$table_pre){
	$list="<option value='-1'>".$language['goods_position']."</option>";
	$list.="<option value='' selected>".$language['all'].$language['goods_position']."</option>";
	$sql="select * from ".$table_pre."position where `shop_id`=".SHOP_ID." order by `sequence` desc";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$list.='<option value="'.$v['id'].'">'.$v['name'].'</option>';	
	}
	$list="<select name='position_filter' id='position_filter'>{$list}</select>";
	return $list;
}
function get_supplier_filter($pdo,$language,$table_pre){
	$list="<option value='-1'>".$language['goods_supplier']."</option>";
	$list.="<option value='' selected>".$language['all'].$language['goods_supplier']."</option>";
	$sql="select * from ".$table_pre."supplier where `shop_id`=".SHOP_ID." order by `sequence` desc";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$list.='<option value="'.$v['id'].'">'.$v['name'].'</option>';	
	}
	$list="<select name='supplier_filter' id='supplier_filter'>{$list}</select>";
	return $list;
}
function get_tag_filter($pdo,$language,$table_pre){
	$list="<option value='-1'>".$language['visible_state']."</option>";
	$list.="<option value='' selected>".$language['all'].$language['tag']."</option>";
	$sql="select * from ".$table_pre."shop_tag where `shop_id`=".SHOP_ID."  order by `sequence` desc";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$list.='<option value="'.$v['id'].'">'.$v['name'].'</option>';	
	}
	$list="<select name='tag_filter' id='tag_filter'>{$list}</select>";
	return $list;
}
function get_type_filter($pdo,$language,$list){
$list2="<option value='-1'>".$language['belong']."</option>";
$list2.="<option value='' selected>".$language['all'].$language['type']."</option>";
$_GET['type']=@$_GET['type']?@$_GET['type']:0;
$list2.=$list;
$list="<select name='type_filter' id='type_filter'>{$list2}<option value=0>".$language['no_type']."</option></select>";
return $list;
}

$list=$this->get_shop_parent($pdo,0,3);
$module['filter']=get_type_filter($pdo,self::$language,$list);
$module['filter'].=get_tag_filter($pdo,self::$language,self::$table_pre);
$module['filter'].=get_position_filter($pdo,self::$language,self::$table_pre);
$module['filter'].=get_supplier_filter($pdo,self::$language,self::$table_pre);



function get_position_p_filter($pdo,$language,$table_pre){
	$list="<option value='-1'>".$language['goods_position']."</option>";
	$list.="<option value='' selected>".$language['all'].$language['goods_position']."</option>";
	$sql="select * from ".$table_pre."position where `shop_id`=".SHOP_ID." order by `sequence` desc";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$list.='<option value="'.$v['id'].'">'.$v['name'].'</option>';	
	}
	$list="<select name='position_p' id='position_p'>{$list}</select>";
	return $list;
}
function get_supplier_p_filter($pdo,$language,$table_pre){
	$list="<option value='-1'>".$language['goods_supplier']."</option>";
	$list.="<option value='' selected>".$language['all'].$language['goods_supplier']."</option>";
	$sql="select * from ".$table_pre."supplier where `shop_id`=".SHOP_ID." order by `sequence` desc";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$list.='<option value="'.$v['id'].'">'.$v['name'].'</option>';	
	}
	$list="<select name='supplier_p' id='supplier_p'>{$list}</select>";
	return $list;
}
function get_tag_p_filter($pdo,$language,$table_pre){
	$list="<option value='-1'>".$language['visible_state']."</option>";
	$list.="<option value='' selected>".$language['all'].$language['tag']."</option>";
	$sql="select * from ".$table_pre."shop_tag where `shop_id`=".SHOP_ID." order by `sequence` desc";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$list.='<option value="'.$v['id'].'">'.$v['name'].'</option>';	
	}
	$list="<select name='tag_p' id='tag_p'>{$list}</select>";
	return $list;
}
function get_type_p_filter($pdo,$language,$list){
$list2="<option value='-1'>".$language['belong']."</option>";
$list2.="<option value='' selected>".$language['all'].$language['type']."</option>";
$_GET['type']=@$_GET['type']?@$_GET['type']:0;
$list2.=$list;
$list="<select name='type_p' id='type_p'>{$list2}<option value=0>".$language['no_type']."</option></select>";
return $list;
}


$module['where_price']=get_type_p_filter($pdo,self::$language,$list);
$module['where_price'].=get_tag_p_filter($pdo,self::$language,self::$table_pre);
$module['where_price'].=get_position_p_filter($pdo,self::$language,self::$table_pre);
$module['where_price'].=get_supplier_p_filter($pdo,self::$language,self::$table_pre);





$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);

