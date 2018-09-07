<?php
if(!SHOP_ID){header('location:./index.php?monxin=mall.apply_shop');exit;}
$module['mass']='';
if(in_array('weixin.mass',$_SESSION['monxin']['page'])){
	$sql="select `wid` from ".$pdo->sys_pre."weixin_account where `username`='".$_SESSION['monxin']['username']."' or `manager` like '%,".$_SESSION['monxin']['username'].",%' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['wid']!=''){$module['mass']='<li><a href="#" class="mass" onclick="return mass();">'.self::$language['add'].self::$language['mass'].'</a></li>';}
}



if(isset($_GET['delete_re'])){
	$sql="select * from ".self::$table_pre."goods_specifications order by `id` asc";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$sql="select `id` from ".self::$table_pre."goods_specifications where `id`=".$v['id'];
		$t=$pdo->query($sql,2)->fetch(2);
		if($t['id']==''){continue;}
		
		$sql="select `id`,`quantity`,`w_price`,`barcode`,`type` from ".self::$table_pre."goods_specifications where `goods_id`='".$v['goods_id']."' and `option_id`='".$v['option_id']."' and `color_id`='".$v['color_id']."' and `id`!=".$v['id']." ";
		$r2=$pdo->query($sql,2);
		foreach($r2 as $v2){
			echo $v2['id'].'&nbsp; &nbsp; &nbsp; '.$v['quantity'].'='.$v2['quantity'].'&nbsp; &nbsp; &nbsp; '.$v['w_price'].'='.$v2['w_price'].'&nbsp; &nbsp; &nbsp; '.$v['type'].'='.$v2['type'].'&nbsp; &nbsp; &nbsp; '.$v['barcode'].'='.$v2['barcode'].'<br />';
			$sql="delete from ".self::$table_pre."goods_specifications where `id`=".$v2['id'];
			$pdo->exec($sql);
		}
	}
}


function resize_thumb($image,$config,$pdo,$id){
	$sql="select `icon`,`multi_angle_img`,`option_enable` from ".$pdo->sys_pre."shop_goods where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	$image->thumb('./program/mall/img/'.$r['icon'],'./program/mall/img_thumb/'.$r['icon'],$config['icon_thumb']['width'],$config['icon_thumb']['height']);
	if($r['multi_angle_img']!=''){
		$temp=explode('|',$r['multi_angle_img']);
		foreach($temp as $v){
			if($v=='' || !is_file('./program/mall/img/'.$v)){continue;}
			$image->thumb('./program/mall/img/'.$v,'./program/mall/img_thumb/'.$v,$config['multi_angle_img_thumb']['width'],$config['multi_angle_img_thumb']['height']);	
		}
	}
	$sql="select `color_img` from ".$pdo->sys_pre."shop_goods_specifications where `goods_id`=".$id;
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		if($v['color_img']=='' || !is_file('./program/mall/img/'.$v['color_img'])){continue;}
		$image->thumb('./program/mall/img/'.$v['color_img'],'./program/mall/img_thumb/'.$v['color_img'],$config['color_img_thumb']['width'],$config['color_img_thumb']['height']);	
	}
}

function compression_img($image,$config,$pdo,$id){
	$sql="select `icon`,`multi_angle_img`,`option_enable`,`detail`,`m_detail` from ".$pdo->sys_pre."shop_goods where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	$img=getimagesize('./program/mall/img/'.$r['icon']);
	$image->thumb('./program/mall/img/'.$r['icon'],'./program/mall/img/'.$r['icon'],$img[0],$img[1]);
	if($r['multi_angle_img']!=''){
		$temp=explode('|',$r['multi_angle_img']);
		foreach($temp as $v){
			if($v=='' || !is_file('./program/mall/img/'.$v)){continue;}
			$img=getimagesize('./program/mall/img/'.$v);
			$image->thumb('./program/mall/img/'.$v,'./program/mall/img/'.$v,$img[0],$img[1]);	
		}
	}

	$reg='#<img.*src=&\#34;(program/mall/attachd/.*)&\#34;.*>#iU';
	$imgs=get_match_all($reg,$r['detail'].$r['m_detail']);
	foreach($imgs as $v){
		if($v=='' || !is_file($v)){continue;}
		  $img=getimagesize($v);
		  $image->thumb($v,$v,$img[0],$img[1]);	
	}
	
	
	$sql="select `color_img` from ".$pdo->sys_pre."shop_goods_specifications where `goods_id`=".$id;
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		if($v['color_img']=='' || !is_file('./program/mall/img/'.$v['color_img'])){continue;}
		$img=getimagesize('./program/mall/img/'.$v['color_img']);
		$image->thumb('./program/mall/img/'.$v['color_img'],'./program/mall/img/'.$v['color_img'],$img[0],$img[1]);
	}
	
}


$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['visible']=@$_GET['visible'];
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select `id`,`type`,`title`,`icon`,`sold`,`position`,`inventory`,`unit`,`supplier`,`visit`,`time`,`shop_sequence`,`state`,`shop_tag`,`shop_type`,`option_enable`,`bidding_show`,`mall_state`,`w_price`,`min_price`,`storehouse` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID;
if(isset($_GET['short_code'])){
	//$sql="update ".self::$table_pre."goods set `bar_code`='0' where `option_enable`=1";
	//$pdo->exec($sql);
	$b=1;
	$c='';
	$max=intval($_GET['short_code']);
	for($i=0;$i<$max;$i++){$b.='0';$c.='_';}
	$sql="select `id`,`type`,`title`,`icon`,`sold`,`position`,`inventory`,`unit`,`supplier`,`visit`,`time`,`shop_sequence`,`state`,`shop_tag`,`shop_type`,`option_enable`,`bidding_show`,`mall_state`,`w_price`,`min_price`,`bar_code` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and (`bar_code`<".$b." or `speci_bar_code` like '".$c."|%' or `speci_bar_code` like '%|".$c."|%') and (`bar_code`!=0 or `speci_bar_code`!=NULL)";
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
	$sum_sql=str_replace(" `id`,`type`,`title`,`icon`,`sold`,`position`,`inventory`,`unit`,`supplier`,`visit`,`time`,`shop_sequence`,`state`,`shop_tag`,`shop_type`,`option_enable`,`bidding_show`,`mall_state`,`w_price`,`min_price`,`storehouse` "," count(id) as c ",$sum_sql);
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



$image=new image();
if((@$_GET['resize_thumb'])==1){$resize_thumb=true;}else{$resize_thumb=false;}
if((@$_GET['compression_img'])==1){$compression_img=true;}else{$compression_img=false;}
foreach($r as $v){
	$v=de_safe_str($v);
	if($resize_thumb){resize_thumb($image,self::$config,$pdo,$v['id']);}
	if($compression_img){compression_img($image,self::$config,$pdo,$v['id']);}
	//if($v['option_enable']==0){$edit_type="<a href=./index.php?monxin=mall.s_type_set&c_id=".$v['id']."&id=".$v['type']." class=set>&nbsp;</a>";}else{$edit_type='';}
	$edit_type='';
	if($v['state']==0){
		$v['state']=self::$language['no'];	
	}else{
		$v['state']=self::$language['yes'];	
	}
	if($v['option_enable']==1){
		$sql="select sum(quantity) as c from ".self::$table_pre."goods_specifications where `goods_id`=".$v['id'];
		$tem=$pdo->query($sql,2)->fetch(2);
		$v['inventory']=$tem['c'];		
	}
	if($v['min_price']==0){$v['min_price']=$v['w_price'];}
	$list.="<tr id='tr_".$v['id']."'>
	<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
	<td><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank class='icon'><img src='./program/mall/img_thumb/".$v['icon']."'></a></td>
	<td><div class=title><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank>".$v['title']."</a></div><div class=type_tag><span class=type>".self::$language['mall'].self::$language['type'].": ".self::get_type_position($pdo,$v['type'])." ".$edit_type."</span><span class=shop_type>".self::$language['store'].self::$language['type'].": ".self::get_shop_type_position($pdo,$v['shop_type'])." <a href=./index.php?monxin=mall.s_shop_type_set&c_id=".$v['id']."&id=".$v['shop_type']." class=set>&nbsp;</a></span><span class=tag>".self::$language['store'].self::$language['tag'].": ".self::get_shop_tags_name($pdo,$v['shop_tag'])." <a href=./index.php?monxin=mall.s_tag_set&c_id=".$v['id']."&id=".$v['shop_tag']." class=set>&nbsp;</a></span></div>
	<div class=supplier>".self::$language['goods_supplier']."：".get_mall_supplier_name($pdo,self::$table_pre,$v['supplier'])."</div>
	<div class=position>".self::$language['goods_position']."：".get_mall_position_name($pdo,self::$table_pre,$v['position'])."</div>
	<div class=storehouse>".self::$language['goods_storehouse']."：".get_mall_storehouse_name($pdo,self::$table_pre,$v['storehouse'])."</div>
	</td>
  <td><a href='./index.php?monxin=mall.goods_quantity_log&id=".$v['id']."' target=_blank class=sold>".$v['sold']."</a></td>
  <td><a href='./index.php?monxin=mall.goods_batch&id=".$v['id']."' target=_blank  class=inventory>".self::format_quantity($v['inventory'])."</a><span class=unit>".self::get_mall_unit_name($pdo,$v['unit'])."</span></td>
  <td><span class=visit>".$v['visit']."</span></td>
  <td><span class=bidding_click_price>".self::$language['bidding_click_price']."</span><input type='text' name='bidding_show_".$v['id']."' id='bidding_show_".$v['id']."' value='".$v['bidding_show']."' class='bidding_show' /><span id=price_state_".$v['id']."></span></td>
  <td><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</span>
  <span class=min_price>".self::$language['money_symbol'].''.$v['min_price'].'<i>'.self::$language['begin']."</i></span>
  </td>
  <td><input type='text' name='sequence_".$v['id']."' id='sequence_".$v['id']."' value='".$v['shop_sequence']."' class='sequence' /></td>
  <td><span class=goods_state>".$v['state']."</span></td>
  <td><span class=mall_state>".self::$language['mall_state'][$v['mall_state']]."</span></td>
  <td class=operation_td>
  <a href='index.php?monxin=".$class.".goods_edit&id=".$v['id']."&type=".$v['type']."'  target=_blank class=edit>".self::$language['edit']."</a><br /> 
  <a href='index.php?monxin=".$class.".relevance_goods&goods_id=".$v['id']."' class=relevance_goods>".self::$language['relevance'].self::$language['goods']."</a><br /> 
  <a href='index.php?monxin=".$class.".relevance_package&goods_id=".$v['id']."' class=relevance_package>".self::$language['relevance'].self::$language['package']."</a><br /> 
  <a href='index.php?monxin=".$class.".group_discount&goods_id=".$v['id']."' class=group_discount>".self::$language['shop_membership_discount']."</a><br /> 

  <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
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
	$sql="select * from ".$table_pre."shop_tag where `shop_id`=".SHOP_ID." order by `sequence` desc";
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