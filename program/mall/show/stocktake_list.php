<?php
$stocktake_id=intval($_GET['stocktake_id']);
if($stocktake_id==0){echo 'stocktake_id err';return false;}
$sql="select * from ".self::$table_pre."stocktake where `id`=".$stocktake_id;
$stocktake=$pdo->query($sql,2)->fetch(2);
if($stocktake['id']==''){echo 'stocktake_id err';return false;}
if($stocktake['shop_id']!=SHOP_ID){echo 'shop_id err';return false;}
$module['s_name']=de_safe_str($stocktake['name']);
if($stocktake['state']==0){$module['sum_display']='';}else{$module['sum_display']='none';}
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&stocktake_id=".$stocktake_id;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['visible']=@$_GET['visible'];
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."stocktake_goods where `stocktake_id`='".$stocktake_id."' and `shop_id`=".SHOP_ID;

$where="";
$_GET['type']=intval(@$_GET['type']);
if($_GET['type']>0){
	$type_ids=$this->get_shop_type_ids($pdo,$_GET['type']);
	$where.=" and `shop_type` in (".$type_ids.")";
}
$_GET['position']=intval(@$_GET['position']);
if($_GET['position']>0){$where.=" and `position` ='".$_GET['position']."'";}


if($_GET['search']!=''){$where=" and (`title` like '%".$_GET['search']."%')";}
$_GET['order']=safe_str(@$_GET['order']);
if($_GET['order']==''){
	$order=" order by `loss` desc,`time` desc";
}else{
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_stocktake_goods and","_stocktake_goods where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_stocktake_goods and","_stocktake_goods where",$sql);
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
	$sql="select `icon`,`unit`,`inventory` from ".self::$table_pre."goods where `id`=".$v['goods_id'];
	$goods=$pdo->query($sql,2)->fetch(2);
	$unit=self::get_mall_unit_name($pdo,$goods['unit']);
	if($v['loss']>0){
		$loss=self::format_quantity($v['loss'])." <span class=unit>".$unit;
	}else{
		$loss='';
		$v['quantity']=$goods['inventory'];	
		if($v['s_id']!=0){
			$sql="select `quantity` from ".self::$table_pre."goods_specifications  where `id`=".$v['s_id'];
			$s=$pdo->query($sql,2)->fetch(2);
			$v['quantity']=$s['quantity'];	
		}
	}
	if(isset($v['quantity'])){$quantity="<span class=quantity>".self::format_quantity($v['quantity'])."</span> <span class=unit>".$unit;}else{$quantity='';}
	if($v['state']==0){
		$disabled='';
		$act="<a href='#' onclick='return update(".$v['id'].")'  class='submit'>".self::$language['submit']."</a>
  <a href='#' d_id=".$v['id']." class=loss>".self::$language['stocktake_end'].self::$language['correction']."</a>";
	}else{
		$act='';
		$disabled='disabled=disabled';
		$quantity='';	
	}
	
	$list.="<tr id='tr_".$v['id']."'>
	<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
	<td><a href='./index.php?monxin=mall.goods&id=".$v['goods_id']."' target=_blank class='icon'><img src='./program/mall/img_thumb/".$goods['icon']."'></a></td>
	<td><div class=title><a href='./index.php?monxin=mall.goods&id=".$v['goods_id']."' target=_blank>".$v['title']."</a></div>
	<div class=position>".self::$language['goods_position']."：".get_mall_position_name($pdo,self::$table_pre,$v['position'])."</div>
	</td>
  <td class=inventory>".$quantity."</span></td>
  <td><input type='text' ".$disabled." class=stocktake id=stocktake_".$v['id']." name=stocktake_".$v['id']." value='".self::format_quantity($v['stocktake'])."' /> <span class=unit>".$unit."</span></td>
  <td>".$loss."</span></td>
  <td><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</span></td>
  <td class=operation_td>
  ".$act."
  <span id=state_".$v['id']." class='state'></span></td>
</tr>
";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
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

$sql="select sum(stocktake) as c,sum(`loss`) as c2 from ".self::$table_pre."stocktake_goods where `stocktake_id`='".$stocktake_id."' and `shop_id`=".SHOP_ID." ";
$r=$pdo->query($sql,2)->fetch(2);
$module['sum_quantity']=self::format_quantity($r['c']);

$module['sum_loss']=$module['sum_inventory']-$module['sum_quantity']-$r['c2'];

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);