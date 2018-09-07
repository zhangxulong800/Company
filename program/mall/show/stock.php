<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['visible']=@$_GET['visible'];
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select `id`,`title`,`icon`,`sold`,`position`,`inventory`,`unit`,`supplier`,`option_enable` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID;

$where="";
if(intval(@$_GET['id'])!=0){
	$where=" and `id`=".intval($_GET['id']);
	echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=mall.goods_admin">'.self::$language['pages']['mall.goods_admin']['name'].'</a><span class=text>'.$_GET['id'].'</span></div>';
}
$_GET['type']=intval(@$_GET['type']);
if($_GET['type']>0){
	$type_ids=$this->get_shop_type_ids($pdo,$_GET['type']);
	$where.=" and `shop_type` in (".$type_ids.")";
}
$_GET['tag']=intval(@$_GET['tag']);
if($_GET['tag']>0){
	$where.=" and `tag` like '%|".$_GET['tag']."|%'";
}
$_GET['position']=intval(@$_GET['position']);
if($_GET['position']>0){$where.=" and `position` ='".$_GET['position']."'";}
$_GET['supplier']=intval(@$_GET['supplier']);
if($_GET['supplier']>0){$where.=" and `supplier` ='".$_GET['supplier']."'";}


if($_GET['search']!=''){$where=" and (`title` like '%".$_GET['search']."%' or `advantage` like '%".$_GET['search']."%' or `bar_code` like '%".$_GET['search']."%' or `speci_bar_code` like '%".$_GET['search']."%' or `detail` like '%".$_GET['search']."%')";}
$_GET['order']=safe_str(@$_GET['order']);
if($_GET['order']==''){
	$order=" order by `inventory` asc";
}else{
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" `id`,`title`,`icon`,`sold`,`position`,`inventory`,`unit`,`supplier`,`option_enable` "," count(id) as c ",$sum_sql);
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
function get_mall_supplier_name($pdo,$table_pre,$id){
	$sql="select `name` from ".$table_pre."supplier where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	return $r['name'];	
}


foreach($r as $v){
	$v=de_safe_str($v);
	if($v['option_enable']==1){
		$sql="select sum(quantity) as c from ".self::$table_pre."goods_batch where `goods_id` like '".$v['id']."_%'";
		$cumulative=$pdo->query($sql,2)->fetch(2);
		$last['add_time']=0;
		$sql="select `add_time` from ".self::$table_pre."goods_batch where `goods_id` like '".$v['id']."_%' order by `id` desc limit 0,1";
		$last=$pdo->query($sql,2)->fetch(2);
		
		$sql="select sum(quantity) as c from ".self::$table_pre."goods_specifications where `goods_id`=".$v['id'];
		$tem=$pdo->query($sql,2)->fetch(2);
		$v['inventory']=$tem['c'];
	}else{
		$sql="select sum(quantity) as c from ".self::$table_pre."goods_batch where `goods_id`=".$v['id'];
		$cumulative=$pdo->query($sql,2)->fetch(2);
		$last['add_time']=0;
		$sql="select `add_time` from ".self::$table_pre."goods_batch where `goods_id`=".$v['id']." order by `id` desc limit 0,1";
		$last=$pdo->query($sql,2)->fetch(2);
	}
	
	
	
	$sql="select sum(quantity) as c from ".self::$table_pre."goods_loss where `goods_id`=".$v['id']."";
	$loss=$pdo->query($sql,2)->fetch(2);
	
	$sql="select sum(quantity) as c from ".self::$table_pre."goods_deduct_stock where `goods_id`=".$v['id']."";
	$deduct_stock=$pdo->query($sql,2)->fetch(2);
	
	$unit=self::get_mall_unit_name($pdo,$v['unit']);
	$list.="<tr id='tr_".$v['id']."'>
	<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
	<td><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank class='icon'><img src='./program/mall/img_thumb/".$v['icon']."'></a></td>
	<td><div class=title><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank>".$v['title']."</a></div>
	<div class=supplier>".self::$language['goods_supplier']."：".get_mall_supplier_name($pdo,self::$table_pre,$v['supplier'])."</div>
	<div class=position>".self::$language['goods_position']."：".get_mall_position_name($pdo,self::$table_pre,$v['position'])."</div>
	</td>
	<td>".self::format_quantity($cumulative['c']).''.$unit."</td>
  <td>".self::format_quantity($v['sold']).'/'.self::format_quantity($loss['c']).'/'.self::format_quantity($deduct_stock['c']).$unit."</td>
  <td>".self::format_quantity($v['inventory'])."<span class=unit>".$unit."</span></td>
  <td><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$last['add_time'])."</span></td>
  <td class=operation_td>
  <a href='./index.php?monxin=mall.purchase_add&id=".$v['id']."' target=_blank class=s_add>".self::$language['purchase']."</a>
  <a href='./index.php?monxin=mall.goods_batch&id=".$v['id']."' class=log>".self::$language['log']."</a><br />
  <a href='./index.php?monxin=mall.loss_add&id=".$v['id']."' target=_blank  class=loss>".self::$language['loss']."</a>
  <a href='./index.php?monxin=mall.loss&id=".$v['id']."' class=log>".self::$language['log']."</a><br />
  <a href='./index.php?monxin=mall.deduct_stock_add&id=".$v['id']."' target=_blank  class=deduct_stock>".self::$language['issue_2']."</a>
  <a href='./index.php?monxin=mall.deduct_stock&id=".$v['id']."' class=log>".self::$language['log']."</a><br />
  <a href='./index.php?monxin=mall.goods_quantity_log&id=".$v['id']."' class=log>".self::$language['sold_log']."</a><br />
  
  
  <span id=state_".$v['id']." class='state'></span></td>
</tr>
";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

function get_position_filter($pdo,$language,$table_pre){
	$list="<option value='-1'>".$language['goods_position']."</option>";
	$list.="<option value='' selected>".$language['all'].$language['goods_position']."</option>";
	$sql="select * from ".$table_pre."position order by `sequence` desc";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$list.='<option value="'.$v['id'].'">'.$v['name'].'</option>';	
	}
	$list="<select name='position_filter' id='position_filter'>{$list}</select>";
	return $list;
}
function get_type_filter($pdo,$language,$list){
$list2="<option value='-1'>".$language['belong']."</option>";
$list2.="<option value='' selected>".$language['all'].$language['type']."</option>";
$_GET['type']=@$_GET['type']?@$_GET['type']:0;
$list2.=$list;
$list="<select name='type_filter' id='type_filter'>{$list2}</select>";
return $list;
}

$list=$this->get_shop_parent($pdo,0,3);
$module['filter']=get_type_filter($pdo,self::$language,$list);
$module['filter'].=get_position_filter($pdo,self::$language,self::$table_pre);

$sql="select sum(`left`) as c from ".self::$table_pre."goods_batch where `shop_id`=".SHOP_ID;
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['sum_inventory']=self::format_quantity($r['c']);

$sql="select `left`,`price` from ".self::$table_pre."goods_batch where `shop_id`=".SHOP_ID." and `left`>0";
$r=$pdo->query($sql,2);
$assets=0;
foreach($r as $v){
	$assets+=$v['left']*$v['price'];	
}
$module['assets']=$assets;

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);