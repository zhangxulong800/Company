<?php
if(@$_GET['act']=='add_option'){
	$type=intval($_GET['type']);
	$new_name=safe_str($_GET['new_name']);
	$sql="select `id` from ".self::$table_pre."type_option where `type_id`=".$type." and `name`='".$new_name."' and (`shop_id`=0 or `shop_id`=".SHOP_ID.") limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['already_exists']."</span>'}");}
	$sql="insert into ".self::$table_pre."type_option (`type_id`,`name`,`shop_id`) values ('".$type."','".$new_name."','".SHOP_ID."')";
	if($pdo->exec($sql)){
		$insret_id=$pdo->lastInsertId();
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','id':'".$insret_id."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}	
}

//=============================================================================================================================【通过网址 采集商品信息】
if(@$_GET['act']=='goods_move'){
	require('./program/mall/goods_move.php');
	$move_url=@$_POST['move_url'];
	$r=goods_move($move_url);
	//file_put_contents('t.txt',serialize($r));
	if($r['state']=='success'){
		$r=format_goods_r($r);	
	}
	if(isset(self::$language[$r['info']])){$r['info']=self::$language[$r['info']];}
	if($r['state']=='success'){$r['info']='<span class=success>'.$r['info'].'</span>';}else{$r['info']='<span class=fail>'.$r['info'].'</span>';}
	$r=json_encode($r);
	exit($r);
			
}

//=======================================================================================================================【格式化采集过来的商品信息，返回给前端自填】
function format_goods_r($r){
	if(@$r['icon']!='' ){
		$icon=get_date_dir('./temp/').md5($r['icon'].time()).'.jpg';
		$img=file_get_contents($r['icon']);
		if(file_put_contents($icon,$img)){
			$r['cover_image_show']=	$icon;
			$r['icon']=trim($icon,'./temp/');
		}
	}
	
	if(@$r['multi_angle_img']!='' ){
		$multi_angle_img='';
		$multi_angle_img_show='';
		$temp=explode(',',$r['multi_angle_img']);
		foreach($temp as $v){
			$path=get_date_dir('./temp/').md5($v.time()).'.jpg';
			$img=file_get_contents($v);
			if(file_put_contents($path,$img)){
				$multi_angle_img.="|".trim($path,'./temp//');
				$multi_angle_img_show.=$path.',';
			}
		}
		$r['multi_angle_img']=$multi_angle_img;
		$r['multi_angle_img_show']=$multi_angle_img_show;
	}
	
	if(@$r['detail_img']!='' ){
		$detail_img='';
		$multi_angle_img_show='';
		$temp=explode(',',$r['detail_img']);
		foreach($temp as $v){
			$path=get_date_dir('./temp/').md5($v.time()).'.jpg';
			$img=@file_get_contents($v);
			//if(!$img){file_put_contents('t.txt',$v);}
			if(file_put_contents($path,$img)){
				$r['detail']=str_replace($v,$path,$r['detail']);
			}
		}
	}
	if(@$r['m_detail_img']!='' ){
		$detail_img='';
		$multi_angle_img_show='';
		$temp=explode(',',$r['m_detail_img']);
		foreach($temp as $v){
			$path=get_date_dir('./temp/').md5($v.time()).'.jpg';
			$img=file_get_contents($v);
			if(file_put_contents($path,$img)){
				$r['m_detail']=str_replace($v,$path,$r['m_detail']);
			}
		}
	}
	return $r;
}










self::update_config_file('goods_update_time',time());
if(SHOP_ID==0){exit("{'state':'fail','info':'shop_id err'}");}
$goods_id=intval(@$_GET['id']);
if($goods_id==0){exit("{'state':'fail','info':'id err'}");}

$sql="select `shop_id`,`state` from ".self::$table_pre."goods where `id`=".$goods_id;
$r=$pdo->query($sql,2)->fetch(2);
if($r['shop_id']!=SHOP_ID){exit("{'state':'fail','info':'id err'}");}
$goods_state=$r['state'];

$time=time();
$_POST=safe_str($_POST,0);
//var_dump($_POST['color_info']);
$check_field=array('type','unit','title');


foreach($check_field as $v){
	if($_POST[$v]=='' || $_POST[$v]<0){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'".$v."'}");}	
}
if(isset($_POST['attribute_stop'])){
	foreach($_POST['attribute'] as $v){
		if($v=='' || $v<0){exit("{'state':'fail','info':'<span class=fail>".self::$language['attribute'].self::$language['is_null']."</span>'}");}	
	}
}

//==================================================================================================================================【检查是否有必填项没填】
if($_POST['option_type']==0){
	$check_field=array('w_price','e_price');
	foreach($check_field as $v){
		if($_POST[$v]=='' || $_POST[$v]<0){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'".$v."'}");}	
	}
}else{
	if(!isset($_POST['specifications'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['specifications'].self::$language['is_null']."</span>'}");}
	if(!is_array($_POST['specifications'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['specifications'].self::$language['is_null']."</span>'}");}
	$specifications=array();
	//var_dump($_POST['specifications']);
	foreach($_POST['specifications'] as $key=>$v){
		//echo $key.'=>'.$v.'<br />';	
		$temp=explode(',,,',$v);
		foreach($temp as $key2=>$v2){
			$temp2=explode('===',$v2);
			if(@$temp2[1]=='' || @$temp2[1]<0){
				if($temp2[0]=='w_price' || $temp2[0]=='e_price' || $temp2[0]=='inventory'){exit("{'state':'fail','info':'<span class=fail>".self::$language['specifications'].self::$language['is_null']."</span>'}");}
			}
			$specifications[$key][$temp2[0]]=$temp2[1];
		}
		
	}
	
}

$goods_state=intval($_POST['goods_state']);

if($goods_state==1){
	$_POST['pre_discount']=max(1,min(10,floatval($_POST['pre_discount'])));
	
	if($_POST['deposit']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'deposit'}");}

	if($_POST['reduction']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'reduction'}");}
	
	if($_POST['last_pay_start_time']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'last_pay_start_time'}");}
	$_POST['last_pay_start_time']=get_unixtime($_POST['last_pay_start_time'],self::$config['other']['date_style']);
	if($_POST['last_pay_start_time']<time()+86400){exit("{'state':'fail','info':'<span class=fail>".self::$language['must_be_greater_than']." 24 ".self::$language['hour']."</span>','id':'last_pay_start_time'}");}
	
	if($_POST['last_pay_end_time']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'last_pay_end_time'}");}
	$_POST['last_pay_end_time']=get_unixtime($_POST['last_pay_end_time'],self::$config['other']['date_style']);
	if($_POST['last_pay_end_time']<$_POST['last_pay_start_time']+86400){exit("{'state':'fail','info':'<span class=fail>".self::$language['must_be_greater_than']." 24 ".self::$language['hour']."</span>','id':'last_pay_end_time'}");}
	
	
	if($_POST['delivered']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'delivered'}");}
	$_POST['delivered']=get_unixtime($_POST['delivered'],self::$config['other']['date_style']);
	if($_POST['delivered']<time()+86400){exit("{'state':'fail','info':'<span class=fail>".self::$language['must_be_greater_than']." 24 ".self::$language['hour']."</span>','id':'delivered'}");}
	
	
}

if($goods_state==3){
	if($_POST['out_delivered']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'out_delivered'}");}
	$_POST['out_delivered']=get_unixtime($_POST['out_delivered'],self::$config['other']['date_style']);
	if($_POST['out_delivered']<time()+86400){exit("{'state':'fail','info':'<span class=fail>".self::$language['must_be_greater_than']." 24 ".self::$language['hour']."</span>','id':'out_delivered'}");}
}

if(in_array('mall.goods_admin',$_SESSION['monxin']['function'])){$exist_view_url="goods_admin";}else{$exist_view_url="goods_db";}

//==================================================================================================================================【检查是否存在重复的条形码】
if(self::barcode_repeat($pdo,SHOP_ID)==0){
	if($_POST['option_type']==0){
		$_POST['bar_code']=trim($_POST['bar_code']);
		if($_POST['bar_code']!=''){
			$sql="select count(id) as c from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and (`bar_code`='".$_POST['bar_code']."' or `speci_bar_code` like '%".$_POST['bar_code']."|%') and `id`!='".$goods_id."'";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['c']>0){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist_same'].self::$language['bar_code']."</span> <a href=./index.php?monxin=mall.".$exist_view_url."&search=".$_POST['bar_code']." target=_blank class=view>".self::$language['view']."</a>','id':'bar_code'}");}
		}
	}else{
		$temp3=array();
		$bar_code_array=array();
		foreach($_POST['specifications'] as $key=>$v){
			$temp=explode(',,,',$v);
			foreach($temp as $key2=>$v2){
				$temp2=explode('===',$v2);
				$temp3[$temp2[0]]=@$temp2[1];
			}
			if($temp3['barcode']!=''){
				$temp3['barcode']=trim($temp3['barcode']);
				$bar_code_array[]=$temp3['barcode'];
				$sql="select count(id) as c from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and (`bar_code`='".$temp3['barcode']."' or `speci_bar_code` like '%".$temp3['barcode']."|%') and `id`!='".$goods_id."'";
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['c']>0){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist_same'].self::$language['bar_code'].": ".$temp3['barcode']." </span> <a href=./index.php?monxin=mall.".$exist_view_url."&search=".$temp3['barcode']." target=_blank class=view>".self::$language['view']."</a>'}");}
			}
		}
		if (count($bar_code_array) != count(array_unique($bar_code_array))) {   
		   //exit("{'state':'fail','info':'<span class=fail>".self::$language['exist_same'].self::$language['bar_code']." </span>'}");
		} 	
	}
}


//==================================================================================================================================【检查是否存在重复的店内编码】
if($_POST['option_type']==0){
	if($_POST['store_code']!=''){
		$_POST['store_code']=trim($_POST['store_code']);
		$sql="select count(id) as c from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and (`store_code`='".$_POST['store_code']."' or `speci_store_code` like '%".$_POST['store_code']."|%') and `id`!='".$goods_id."'";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['c']>0){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist_same'].self::$language['store_code']."</span> <a href=./index.php?monxin=mall.".$exist_view_url."&search=".$_POST['store_code']." target=_blank class=view>".self::$language['view']."</a>','id':'store_code'}");}
	}
}else{
	$temp3=array();
	$store_code_array=array();
	foreach($_POST['specifications'] as $key=>$v){
		$temp=explode(',,,',$v);
		foreach($temp as $key2=>$v2){
			$temp2=explode('===',$v2);
			$temp3[$temp2[0]]=@$temp2[1];
		}
		if($temp3['store_code']!=''){
			$temp3['store_code']=trim($temp3['store_code']);
			$store_code_array[]=$temp3['store_code'];
			$sql="select count(id) as c from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and (`store_code`='".$temp3['store_code']."' or `speci_store_code` like '%".$temp3['store_code']."|%') and `id`!='".$goods_id."'";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['c']>0){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist_same'].self::$language['store_code'].": ".$temp3['store_code']." </span> <a href=./index.php?monxin=mall.".$exist_view_url."&search=".$temp3['store_code']." target=_blank class=view>".self::$language['view']."</a>'}");}
		}
	}
	if (count($store_code_array) != count(array_unique($store_code_array))) {   
	   //exit("{'state':'fail','info':'<span class=fail>".self::$language['exist_same'].self::$language['bar_code']." </span>'}");
	} 	
}


//==================================================================================================================================【处理封面图片及多视角图片】
get_date_dir('./program/mall/img/');	
get_date_dir('./program/mall/img_thumb/');	

$image=new image();
if($_POST['icon']!=''){
	if(!is_file('./temp/'.$_POST['icon'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['cover_image'].self::$language['upload_failed']."</span>','id':'icon'}");}
	$path='./program/mall/img/'.$_POST['icon'];
	if(safe_rename('./temp/'.$_POST['icon'],$path)==false){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['cover_image'].self::$language['upload_failed']."</span>'}");
	}
	$image->thumb($path,'./program/mall/img_thumb/'.$_POST['icon'],self::$config['icon_thumb']['width'],self::$config['icon_thumb']['height']);
	if(self::$config['program']['imageMark']){$image->addMark($path);}
}
if($_POST['multi_angle_img']!=''){
	
	$_POST['multi_angle_img']=str_replace('./program/mall/img/','',$_POST['multi_angle_img']);
	$_POST['multi_angle_img']=str_replace('./temp/','',$_POST['multi_angle_img']);
	$_POST['multi_angle_img']=explode('|',$_POST['multi_angle_img']);
	$_POST['multi_angle_img']=array_filter($_POST['multi_angle_img']);
	$multi_angle_img='';
	foreach($_POST['multi_angle_img'] as $v){
		if(is_file('./temp/'.$v)){
			$path='./program/mall/img/'.$v;
			if(safe_rename('./temp/'.$v,$path)){
				$image->thumb($path,'./program/mall/img_thumb/'.$v,self::$config['multi_angle_img_thumb']['width'],self::$config['multi_angle_img_thumb']['height']);
				if(self::$config['program']['imageMark']){$image->addMark($path);}
				$multi_angle_img.='|'.$v;
			}
		}elseif(is_file('./program/mall/img/'.$v)){
			$multi_angle_img.='|'.$v;
		}
	}
	$_POST['multi_angle_img']=trim($multi_angle_img,'|');
}


//==================================================================================================================================【处理打折信息】

$sql="select * from ".self::$table_pre."goods where `id`=".$goods_id;
$old=$pdo->query($sql,2)->fetch(2);
if($_POST['icon']==''){$_POST['icon']=$old['icon'];}
$discount=min(10,floatval($_POST['discount']));
if($discount==0){$discount=10;}
$discount_start_time=0;
$discount_end_time=0;
if($_POST['discount_start_time']!=''){$discount_start_time=get_unixtime($_POST['discount_start_time'],self::$config['other']['date_style']);}
if($_POST['discount_end_time']!=''){$discount_end_time=get_unixtime($_POST['discount_end_time'],self::$config['other']['date_style']);}


//============================================================================================================================【处理商品位置,品牌,供应商,单位信息】
if(!is_numeric($_POST['shop_type'])){$_POST['shop_type']=self::add_shop_type($pdo,self::$table_pre,$_POST['shop_type']);}
if(!is_numeric($_POST['brand'])){$_POST['brand']=self::add_brand($pdo,self::$table_pre,$_POST['brand'],intval($_POST['type']));}

if(!is_numeric($_POST['position'])){$_POST['position']=self::add_position($pdo,self::$table_pre,$_POST['position']);}
if(!is_numeric($_POST['storehouse'])){$_POST['storehouse']=self::add_storehouse($pdo,self::$table_pre,$_POST['storehouse']);}
if(!is_numeric($_POST['supplier'])){$_POST['supplier']=self::add_supplier($pdo,self::$table_pre,$_POST['supplier']);}
if(!is_numeric($_POST['unit'])){$_POST['unit']=self::add_unit($pdo,self::$table_pre,$_POST['unit']);}

//============================================================================================================================【处理商品位置,品牌,供应商,单位信息】
self::add_grade($pdo,SHOP_ID,$_POST['grade']);
self::add_habitat($pdo,SHOP_ID,$_POST['habitat']);
self::add_contain($pdo,SHOP_ID,$_POST['contain']);

	require('plugin/py/py_class.php');
	$py_class=new py_class(); 
	try { $py=$py_class->str2py($_POST['title']); } catch(Exception $e) { $py='';}


//==================================================================================================================================【生成商品主信息sql start】
if($_POST['option_type']==0){//如商品没选项
	$sql="update ".self::$table_pre."goods set `type`='".intval($_POST['type'])."',`shop_tag`='".$_POST['tag']."',`shop_type`='".$_POST['shop_type']."',`brand`='".intval($_POST['brand'])."',`unit`='".intval($_POST['unit'])."',`logistics_weight`='".intval($_POST['logistics_weight'])."',`logistics_volume`='".floatval($_POST['logistics_volume'])."',`free_shipping`='".intval($_POST['free_shipping'])."',`position`='".intval($_POST['position'])."',`storehouse`='".intval($_POST['storehouse'])."',`supplier`='".intval($_POST['supplier'])."',`title`='".$_POST['title']."',`advantage`='".$_POST['advantage']."',`icon`='".$_POST['icon']."',`multi_angle_img`='".$_POST['multi_angle_img']."',`detail`='".$_POST['detail']."',`m_detail`='".$_POST['m_detail']."',`sales_promotion`='".intval($_POST['sales_promotion'])."',`time`='".$time."',`username`='".$_SESSION['monxin']['username']."',`bar_code`='".$_POST['bar_code']."',`w_price`='".floatval($_POST['w_price'])."',`e_price`='".floatval($_POST['e_price'])."',`shelf_life`='".intval($_POST['shelf_life'])."',`option_enable`='0',`discount`='".$discount."',`discount_start_time`='".$discount_start_time."',`discount_end_time`='".$discount_end_time."',`virtual_auto_delivery`='".$_POST['virtual_auto_delivery']."',`state`='".$goods_state."',`pre_discount`='".$_POST['pre_discount']."',`limit`='".intval($_POST['limit'])."',`limit_cycle`='".$_POST['limit_cycle']."',`grade`='".$_POST['grade']."',`habitat`='".$_POST['habitat']."',`contain`='".$_POST['contain']."',`store_code`='".$_POST['store_code']."',`mall_state`='".self::$config['goods_check']."',`py`='".$py."' where `id`='".$goods_id."'";	
}else{//如商品有选项
	$color_info=array();
	if(isset($_POST['color_info'])){
		foreach($_POST['color_info'] as $key=>$v){
			$temp=explode(',,,',$v);
			foreach($temp as $key2=>$v2){
				$temp2=explode('===',$v2);
				$color_info[str_replace('tr_color_','',$key)][$temp2[0]]=@$temp2[1];
				if($temp2[0]=='img' && @$temp2[1]!=''){
					if(is_file('./temp/'.$temp2[1])){
						if(safe_rename('./temp/'.$temp2[1],'./program/mall/img/'.$temp2[1])){
							$image->thumb('./program/mall/img/'.$temp2[1],'./program/mall/img_thumb/'.$temp2[1],self::$config['color_img_thumb']['width'],self::$config['color_img_thumb']['height']);
						}
					}	
				}	
			}	
		}
		//var_dump($color_info);	
	}
	
	$sql="update ".self::$table_pre."goods set `type`='".intval($_POST['type'])."',`shop_tag`='".$_POST['tag']."',`shop_type`='".$_POST['shop_type']."',`brand`='".intval($_POST['brand'])."',`unit`='".intval($_POST['unit'])."',`logistics_weight`='".intval($_POST['logistics_weight'])."',`logistics_volume`='".floatval($_POST['logistics_volume'])."',`free_shipping`='".intval($_POST['free_shipping'])."',`position`='".intval($_POST['position'])."',`storehouse`='".intval($_POST['storehouse'])."',`supplier`='".intval($_POST['supplier'])."',`title`='".$_POST['title']."',`advantage`='".$_POST['advantage']."',`icon`='".$_POST['icon']."',`multi_angle_img`='".$_POST['multi_angle_img']."',`detail`='".$_POST['detail']."',`m_detail`='".$_POST['m_detail']."',`sales_promotion`='".intval($_POST['sales_promotion'])."',`time`='".$time."',`username`='".$_SESSION['monxin']['username']."',`shelf_life`='".intval($_POST['shelf_life'])."',`option_enable`='1',`discount`='".$discount."',`discount_start_time`='".$discount_start_time."',`discount_end_time`='".$discount_end_time."',`virtual_auto_delivery`='".$_POST['virtual_auto_delivery']."',`state`='".$goods_state."',`pre_discount`='".$_POST['pre_discount']."',`limit`='".intval($_POST['limit'])."',`limit_cycle`='".safe_str($_POST['limit_cycle'])."',`grade`='".$_POST['grade']."',`habitat`='".$_POST['habitat']."',`contain`='".$_POST['contain']."',`mall_state`='".self::$config['goods_check']."',`py`='".$py."' where `id`='".$goods_id."'";	
	
}
//==================================================================================================================================【生成商品主信息sql end】

//==================================================================================================================================【更新商品辅信息 start】
if($pdo->exec($sql)){
		
	if($goods_state==1){
		$sql="select `id` from ".self::$table_pre."pre_sale where `goods_id`=".$goods_id." limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){
			$sql="select `id` from ".self::$table_pre."order_goods where `goods_id`=".$goods_id." and `order_state`=11 limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']!=''){$pre_sale=1;}else{$pre_sale=0;}
			if($pre_sale){
				$sql="update ".self::$table_pre."pre_sale set `last_pay_start_time`='".$_POST['last_pay_start_time']."',`last_pay_end_time`='".$_POST['last_pay_end_time']."',`delivered`='".$_POST['delivered']."' where `goods_id`=".$goods_id." limit 1";

			}else{
				$sql="update ".self::$table_pre."goods set `pre_discount`='".$_POST['pre_discount']."' where `id`=".$goods_id;
				$pdo->exec($sql);
				$sql="update ".self::$table_pre."pre_sale set `deposit`='".$_POST['deposit']."',`reduction`='".$_POST['reduction']."',`last_pay_start_time`='".$_POST['last_pay_start_time']."',`last_pay_end_time`='".$_POST['last_pay_end_time']."',`delivered`='".$_POST['delivered']."' where `goods_id`=".$goods_id." limit 1";
			}

			
			
		}else{
			$sql="insert into ".self::$table_pre."pre_sale (`goods_id`,`deposit`,`reduction`,`last_pay_end_time`,`last_pay_start_time`,`delivered`) values ('".$goods_id."','".$_POST['deposit']."','".$_POST['reduction']."','".$_POST['last_pay_end_time']."','".$_POST['last_pay_start_time']."','".$_POST['delivered']."')";
		}
		$pdo->exec($sql);
		
	}
	
	if($goods_state==3){
		$sql="update ".self::$table_pre."goods set `out_delivered`='".$_POST['out_delivered']."' where `id`=".$goods_id;
		$pdo->exec($sql);
	}
		
	
	$sql="select * from ".self::$table_pre."goods where `id`=".$goods_id;
	$current_goods=$pdo->query($sql,2)->fetch(2);
	self::create_mall_goods_snapshot($pdo,self::$table_pre,$current_goods);
	//==================================================================================================================删除弃用的图片
	if($_POST['icon']!=$old['icon'] && $old['icon']!='default.png'){@safe_unlink('./program/mall/img/'.$old['icon']);@safe_unlink('./program/mall/img_thumb/'.$old['icon']);}
	if($_POST['multi_angle_img']!=$old['multi_angle_img']){
		$temp1=explode('|',$old['multi_angle_img']);
		$temp2=explode('|',$_POST['multi_angle_img']);
		foreach($temp1 as $v){
			if(!in_array($v,$temp2)){
				@safe_unlink('./program/mall/img/'.$v);
				@safe_unlink('./program/mall/img_thumb/'.$v);
			}	
		}
	}
	$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
	$new_imgs=get_match_all($reg,$_POST['detail'].$_POST['m_detail']);
	//var_dump($new_imgs);
	$old_imgs=get_match_all($reg,$old['detail'].$_POST['m_detail']);
	foreach($old_imgs as $v){
		if(!in_array($v,$new_imgs)){
			$sql="select count(id) as c from ".self::$table_pre."goods where `detail` like '%".$v."%'";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['c']==0){
				$path=$v;
				safe_unlink($path);
				reg_attachd_img("del",self::$config['class_name'],$path,$pdo);
			}
		}	
	}
	
	
	
	
	
	//--------------------------------------------------------------------------------------处理采集图片
	$temp_img=get_match_all('#<img.*src=&\#34;(temp/.*)&\#34;.*>#iU',$_POST['detail']);
	$new_detail_img=array();
	if(count($temp_img)>0){
		$dir=get_date_dir('./program/mall/attachd/image/');	
		foreach($temp_img as $v){
			$dir=get_date_dir('./program/mall/attachd/image/');	
			if($v==''){continue;}
			if(!is_file($v)){continue;}
			$name=md5($v).'.jpg';
			if(safe_rename($v,$dir.$name)){
				$new_detail_img[]=$dir.$name;
				$_POST['detail']=str_replace($v,trim($dir.$name,'./'),$_POST['detail']);
			}
		}
		$sql="update ".self::$table_pre."goods set `detail`='".$_POST['detail']."' where `id`=".$goods_id;
		$pdo->exec($sql);	
		reg_attachd_img("add",self::$config['class_name'],$new_detail_img,$pdo,self::$config['program']['imageMark']);

	}
	
	$temp_img=get_match_all('#<img.*src=&\#34;(temp/.*)&\#34;.*>#iU',$_POST['m_detail']);
	if(count($temp_img)>0){
		$new_detail_img=array();
		$dir=get_date_dir('./program/mall/attachd/image/');	
		foreach($temp_img as $v){
			if($v==''){continue;}
			if(!is_file($v)){continue;}
			$name=md5($v).'.jpg';
			if(safe_rename($v,$dir.$name)){
				$new_detail_img[]=$dir.$name;
				$_POST['m_detail']=str_replace($v,trim($dir.$name,'./'),$_POST['m_detail']);
			}
		}
		$sql="update ".self::$table_pre."goods set `m_detail`='".$_POST['m_detail']."' where `id`=".$goods_id;
		$pdo->exec($sql);	
		reg_attachd_img("add",self::$config['class_name'],$new_detail_img,$pdo,self::$config['program']['imageMark']);

	}
	
	
	
	
	
	
	
	//==================================================================================================================处理新图片
	$imgs=array();
	foreach($new_imgs as $v){
		if(!in_array($v,$old_imgs)){$imgs[]=$v;}	
	}
	if(count($imgs)>0){reg_attachd_img("add",self::$config['class_name'],$imgs,$pdo,self::$config['program']['imageMark']);}
	
		
		
		
	//==================================================================================================================处理商品属性
	$attribute=array();
	//var_dump($_POST['attribute']);
	if(isset($_POST['attribute'])){
		$ids='';
		foreach($_POST['attribute'] as $key=>$v){
			if($v!='' && $v!=-1){
				$id=str_replace('attribute_','',$key);
				$id=intval(str_replace('___value','',$id));
				$sql="select id from ".self::$table_pre."goods_attribute where `goods_id`='".$goods_id."' and `attribute_id`=".$id;
				$r=$pdo->query($sql,2)->fetch(2);
				if(@$r['id']==''){
					$sql="insert into ".self::$table_pre."goods_attribute (`attribute_id`,`value`,`goods_id`,`type`) values ('".$id."','".$v."','".$goods_id."','".intval($_POST['type'])."')";
				}else{
					$sql="update ".self::$table_pre."goods_attribute set `value`='".$v."',`type`='".intval($_POST['type'])."' where `goods_id`='".$goods_id."' and `attribute_id`='".$id."'";
				}
				
				//echo $sql;
				$pdo->exec($sql);
				$ids.=$id.',';
				self::update_type_attribute($pdo,self::$table_pre,$id,$v);
			}
			
		}
		if($ids!=''){
			$ids=trim($ids,',');
			$sql="delete from ".self::$table_pre."goods_attribute where `goods_id`='".$goods_id."' and `attribute_id` not in (".$ids.")";	
			$pdo->exec($sql);
		}else{
			$sql="delete from ".self::$table_pre."goods_attribute where `goods_id`='".$goods_id."'";	
			$pdo->exec($sql);
		}
		
			
	}
		
	//==================================================================================================================处理商品选项 start
	if($_POST['option_type']!=0){
		
		$sql="update ".self::$table_pre."goods_specifications set `type`='".intval($_POST['type'])."' where  `goods_id`=".$goods_id;
		$pdo->exec($sql);
		
		$specifications=array();
		$speci_bar_code='';
		$speci_store_code='';
		$sum_quantity=0;
		$ids='';
		$w_price=array();
		

		foreach($_POST['specifications'] as $key=>$v){
			//echo $key;
			$option_id=explode('option_',$key);
			$option_id=intval(@$option_id[1]);
			$color_id=explode('specifications_color_',$key);
			$color_id=explode('__',@$color_id[1]);
			$color_id=intval($color_id[0]);
			$temp=explode(',,,',$v);
			foreach($temp as $key2=>$v2){
				
				$temp2=explode('===',$v2);
				//var_dump($temp2[0].'='.$temp2[1]);
				$specifications[$temp2[0]]=@$temp2[1];
			}
			$sql="select id,`color_img`,`color_id`,`quantity`  from ".self::$table_pre."goods_specifications where `goods_id`='".$goods_id."' and `color_id`='".$color_id."' and `option_id`='".$option_id."'";
			$r=$pdo->query($sql,2)->fetch(2);
			
			
			$sql="select `name` from ".self::$table_pre."color where `id`=".$color_id;
			$temp5=$pdo->query($sql,2)->fetch(2);
			if($temp5['name']!=@$color_info[$color_id]['name']){$color_show=1;}else{$color_show=0;}
			
			if($r['id']==''){
				$sql="insert into ".self::$table_pre."goods_specifications (`color_id`,`option_id`,`color_name`,`color_img`,`color_show`,`goods_id`,`e_price`,`w_price`,`cost_price`,`quantity`,`barcode`,`store_code`) values ('".$color_id."','".$option_id."','".@$color_info[$color_id]['name']."','".@$color_info[$color_id]['img']."','".$color_show."','".$goods_id."','".floatval($specifications['e_price'])."','".floatval($specifications['w_price'])."','".floatval($specifications['cost_price'])."','".floatval($specifications['quantity'])."','".trim($specifications['barcode'])."','".trim($specifications['store_code'])."')";
			}else{
				$specifications['quantity']=$r['quantity'];
				if($r['color_img']!='' && @$color_info[$color_id]['img']!='' && $r['color_img']!=@$color_info[$color_id]['img']){
					@safe_unlink('./program/mall/img/'.$r['color_img']);@safe_unlink('./program/mall/img_thumb/'.$r['color_img']);
				}
				if(@$color_info[$color_id]['img']==''){@$color_info[$color_id]['img']=$r['color_img'];}
				$color_img=$color_info[$color_id]['img'];
				if(@$color_info[$color_id]['img']=='del'){$color_img='';@safe_unlink('./program/mall/img/'.$r['color_img']);@safe_unlink('./program/mall/img_thumb/'.$r['color_img']);}
				
				
				$sql="update ".self::$table_pre."goods_specifications set `color_name`='".@$color_info[$color_id]['name']."',`color_img`='".$color_img."',`e_price`='".floatval($specifications['e_price'])."',`w_price`='".floatval($specifications['w_price'])."',`barcode`='".trim($specifications['barcode'])."',`store_code`='".trim($specifications['store_code'])."',`color_show`='".$color_show."' where `goods_id`='".$goods_id."' and `color_id`='".$color_id."' and `option_id`='".$option_id."'";
				//echo $sql;
			}
			$w_price[]=floatval($specifications['w_price']);
			$pdo->exec($sql);
			if($r['id']==''){$ids.=$pdo->lastInsertId().',';}else{$ids.=$r['id'].',';}
			if($r['id']==''){
				self::add_goods_batch($pdo,$goods_id.'_'.$pdo->lastInsertId(),floatval($specifications['quantity']),floatval($specifications['cost_price']),intval($_POST['supplier']));	
			}
			if($specifications['barcode']!=''){$speci_bar_code.=$specifications['barcode'].'|';}
			if($specifications['store_code']!=''){$speci_store_code.=$specifications['store_code'].'|';}
			$sum_quantity+=floatval($specifications['quantity']);
		}
		if($ids!=''){
			$ids=trim($ids,',');
			$sql="select `color_img` from ".self::$table_pre."goods_specifications where `goods_id`='".$goods_id."' and `id` not in (".$ids.")";
			$r=$pdo->query($sql,2);
			foreach($r as $v){
				if($v['color_img']!=''){@safe_unlink('./program/mall/img/'.$v['color_img']);@safe_unlink('./program/mall/img_thumb/'.$v['color_img']);}	
			}
			$sql="delete from ".self::$table_pre."goods_specifications where `goods_id`='".$goods_id."' and `id` not in (".$ids.")";	
			$pdo->exec($sql);
		}
		
		$sql="update ".self::$table_pre."goods set `speci_bar_code`='".$speci_bar_code."',`speci_store_code`='".$speci_store_code."',`inventory`='".$sum_quantity."',`min_price`='".min($w_price)."',`max_price`='".max($w_price)."',`w_price`='".((min($w_price)+max($w_price))/2)."' where `id`=".$goods_id;
		$pdo->exec($sql);	
		
	}
	//==================================================================================================================处理商品选项 end
	
	
	$tb_path='./program/tb/mall_update.php';
	if(is_file($tb_path)){
		$sql="select `id` from ".$pdo->sys_pre."tb_csv where `goods_id`=".$goods_id.' limit 0,1';
		$r=$pdo->query($sql,2)->fetch(2);
		$csv_id=$r['id'];
		if($csv_id!=''){
			require($tb_path);
			$tb=new mall_update($pdo);
			$tb->update_csv($pdo,$csv_id);
		}
	}
	
	
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span><script>window.location.href=\"./index.php?monxin=".self::$config['class_name'].".goods&id=".$goods_id."\";</script>'}");
}else{
	exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
}

//==================================================================================================================================【更新商品辅信息 end】
	



