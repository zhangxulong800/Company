<?php
//echo $args[1];
$module['credits_rate']=self::$config['credits_set']['rate'];
$attribute=format_attribute($args[1]);
$id=$attribute['id'];
//var_dump($_GET['type']);
if($attribute['follow_type']=='true' && intval(@$_GET['type'])!=0){$id=intval($_GET['type']);}
$attribute['quantity']=intval($attribute['quantity']);
$current_page=intval(@$_GET['current_page']);
if($attribute['follow_page']=='true' && $current_page>0){$start=$current_page*$attribute['quantity'];}else{$start=0;}
if($id==0){$ids='';}else{$ids=$this->get_shop_type_ids($pdo,$id);}

if($attribute['tag']!=''){
	$tag=explode('/',$attribute['tag']);
	$sub_where='';
	foreach($tag as $v){
		if(is_numeric($v)){
			$sub_where.="`shop_tag` like '%|".$v."|%' or ";	
		}	
	}
	$sub_where=trim($sub_where,'or ');
	$tag_where=' and ('.$sub_where.')';	
}else{
	$tag_where='';	
}

if(self::$config['online_forbid_show']){
	$sql="select `id`,`icon`,`title`,`w_price`,`min_price`,`max_price`,`option_enable`,`monthly`,`sales_promotion`,`discount`,`discount_start_time`,`discount_end_time`,`unit` from ".self::$table_pre."goods where `shop_id`='".SHOP_ID."' and `state`!=0 and `mall_state`=1 and `shop_type` in(".$ids.") ".$tag_where." order by `".$attribute['sequence_field']."` ".$attribute['sequence_type']." limit ".$start.",".$attribute['quantity'];
	if($ids==''){$sql="select `id`,`icon`,`title`,`w_price`,`min_price`,`max_price`,`option_enable`,`monthly`,`sales_promotion`,`discount`,`discount_start_time`,`discount_end_time`,`unit` from ".self::$table_pre."goods where `shop_id`='".SHOP_ID."' and `state`!=0 and  `mall_state`=1 ".$tag_where." order by `".$attribute['sequence_field']."` ".$attribute['sequence_type']." limit ".$start.",".$attribute['quantity'];}
}else{
	$sql="select `id`,`icon`,`title`,`w_price`,`min_price`,`max_price`,`option_enable`,`monthly`,`sales_promotion`,`discount`,`discount_start_time`,`discount_end_time`,`unit` from ".self::$table_pre."goods where `shop_id`='".SHOP_ID."' and `state`!=0 and `mall_state`=1 and `online_forbid`=0 and `shop_type` in(".$ids.") ".$tag_where." order by `".$attribute['sequence_field']."` ".$attribute['sequence_type']." limit ".$start.",".$attribute['quantity'];
	if($ids==''){$sql="select `id`,`icon`,`title`,`w_price`,`min_price`,`max_price`,`option_enable`,`monthly`,`sales_promotion`,`discount`,`discount_start_time`,`discount_end_time`,`unit` from ".self::$table_pre."goods where `shop_id`='".SHOP_ID."' and `state`!=0 and  `mall_state`=1 and `online_forbid`=0 ".$tag_where." order by `".$attribute['sequence_field']."` ".$attribute['sequence_type']." limit ".$start.",".$attribute['quantity'];}
}

//file_put_contents('t.txt',$sql);

	$r=$pdo->query($sql,2);
	$list='';
	$list2='';
	$module['hover_list']='';
	$time=time();
	$shop_discount=self::get_shop_discount($pdo,SHOP_ID);
	foreach($r as $v){
		$v=de_safe_str($v);
		
		if($v['discount']<10 && $time>$v['discount_start_time'] && $time<$v['discount_end_time']){$discount=$v['discount'];$goods_discount=$v['discount'];}else{$discount=$shop_discount;}
		if(($shop_discount<10 && ($v['sales_promotion'] ||  $_POST['discount_join_goods'])) || isset($goods_discount)){
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
		$buy_button='';
		
		if(@$attribute[$_COOKIE['monxin_device'].'_buy_button']){$buy_button="<div class=button_div><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank  class=add_cart option_enable='".$v['option_enable']."'  s_id='".$sv['s_id']."' s_price='".$sv['s_price']."'  title='".self::$language['add_cart']."'></a></div>";}
		
		if($attribute['show_method']!='show_line'){
			$list.="<div class=goods><a href='./index.php?monxin=mall.goods&shop_id=".SHOP_ID."&id=".$v['id']."' target=".$attribute['target']." class=goods_a><img src='./program/mall/img_thumb/".$v['icon']."' /><span class=title>".$v['title']."</span></a><span class=price_span>".$w_price."/".self::get_mall_unit_name($pdo,$v['unit'])."</span>".$buy_button."</div>";
		}else{
			$list.="<div class=line><a href='./index.php?monxin=mall.goods&shop_id=".SHOP_ID."&id=".$v['id']."' target=_blank class=goods_img><img src='./program/mall/img_thumb/".$v['icon']."' /></a><div class=good_info><a href='./index.php?monxin=mall.goods&id=".$v['id']."'  target=".$attribute['target']." class=title>".$v['title']."</a><span class=price_span>".$w_price."/".self::get_mall_unit_name($pdo,$v['unit'])."</span>".$buy_button."</div></div>";
		}
	}
	
	
	
	if($list==''){$list='<a href="#">'.self::$language['no_content'].'</a>';}
	$module['list']=$list;
	
	
	$module['target']=$attribute['target'];
	$module['title_link']='./index.php?monxin=mall.shop_goods_list&shop_id='.SHOP_ID.'&type='.$id.'&tag='.$attribute['tag'];
	$module['title']=$attribute['title'];
	if($module['title']==''){$module['title_show']='none';}else{$module['title_show']='block';}
	$module['module_width']=$attribute['width'];
	$module['module_height']=$attribute['height'];
	$module['module_name']=str_replace("::","_",$method.'_'.$id.'_append_'.str_replace('/','_',$attribute['tag']).'_'.$attribute['sequence_field'].'_'.$attribute['sequence_type']);
	$module['module_save_name']=str_replace("::","_",$method.$args[1]);
	$module['count_url']="receive.php?target=".$method."&id=".$id;
	
	$module['sub_type']='';
	$attribute['show_sub']=intval(@$attribute['show_sub']);
	if($attribute['show_sub']>0){
		$sql="select `id`,`name` from ".self::$table_pre."shop_type where `shop_id`='".SHOP_ID."' and `parent`='".$attribute['id']."' and `visible`=1 order by `sequence` desc limit 0,".$attribute['show_sub'];
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			$module['sub_type'].='<a href="./index.php?monxin=mall.shop_goods_list&shop_id='.SHOP_ID.'&type='.$v['id'].'"  target='.$attribute['target'].' d_id="'.$v['id'].'">'.$v['name'].'</a>';
			if(self::$config['online_forbid_show']){
				$sql2="select `id`,`icon`,`title`,`w_price`,`min_price`,`max_price`,`option_enable`,`monthly`,`sales_promotion`,`discount`,`discount_start_time`,`discount_end_time`,`unit` from ".self::$table_pre."goods where `shop_id`='".SHOP_ID."' and `state`!=0 and  `mall_state`=1 and `shop_type` in (".$ids=$this->get_shop_type_ids($pdo,$v['id']).") ".$tag_where." limit ".$start.",".$attribute['quantity'];
				if($ids==''){$sql2="select `id`,`icon`,`title`,`w_price`,`min_price`,`max_price`,`option_enable`,`monthly`,`sales_promotion`,`discount`,`discount_start_time`,`discount_end_time`,`unit` from ".self::$table_pre."goods where `shop_id`='".SHOP_ID."' and `state`!=0 `mall_state`=1 and  ".$tag_where." limit ".$start.",".$attribute['quantity'];}
			}else{
				$sql2="select `id`,`icon`,`title`,`w_price`,`min_price`,`max_price`,`option_enable`,`monthly`,`sales_promotion`,`discount`,`discount_start_time`,`discount_end_time`,`unit` from ".self::$table_pre."goods where `shop_id`='".SHOP_ID."' and `state`!=0 and  `mall_state`=1 and `online_forbid`=0 and `shop_type` in (".$ids=$this->get_shop_type_ids($pdo,$v['id']).") ".$tag_where." limit ".$start.",".$attribute['quantity'];
				if($ids==''){$sql2="select `id`,`icon`,`title`,`w_price`,`min_price`,`max_price`,`option_enable`,`monthly`,`sales_promotion`,`discount`,`discount_start_time`,`discount_end_time`,`unit` from ".self::$table_pre."goods where `shop_id`='".SHOP_ID."' and `state`!=0 `mall_state`=1 and `online_forbid`=0 and  ".$tag_where." limit ".$start.",".$attribute['quantity'];}
			}
			
			
			//echo $sql2;
			$r2=$pdo->query($sql2,2);
			$temp='';
			foreach($r2 as $v2){
				$v2=de_safe_str($v2);
				if($v2['discount']<10 && $time>$v2['discount_start_time'] && $time<$v2['discount_end_time']){$discount=$v2['discount'];$goods_discount=$v2['discount'];}else{$discount=$shop_discount;}
				if(($shop_discount<10 && $v2['sales_promotion']) || isset($goods_discount)){
					if($v2['option_enable']==0){
						$v2['w_price']=sprintf("%.2f",$v2['w_price']*$discount/10);
					}else{
						$v2['min_price']=sprintf("%.2f",$v2['min_price']*$discount/10);
						$v2['max_price']=sprintf("%.2f",$v2['max_price']*$discount/10);
					}
				}
				
				if($v2['option_enable']==0){
					$w_price='<span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=money_value>'.$v2['w_price'].'</span>';
					$sv=array();
					$sv['s_id']=0;
					$sv['s_price']=0;
				}else{
					$sv=self::get_goods_s($pdo,$v2['id']);
					$sv['s_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$sv['s_price']);
					if($v2['min_price']==$v2['max_price']){
						$w_price='<span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=money_value>'.$v2['min_price'].'</span>';
					}else{
						$w_price='<span class=money_symbol>'.self::$language['money_symbol'].'</span><span class=money_value>'.$v2['min_price'].'-'.$v2['max_price'].'</span>';
					}
				}
				$buy_button='';
				if(@$attribute[$_COOKIE['monxin_device'].'_buy_button']){$buy_button="<div class=button_div><a href='./index.php?monxin=mall.goods&shop_id=".SHOP_ID."&id=".$v2['id']."' target=_blank  class=add_cart option_enable='".$v2['option_enable']."'  s_id='".$sv['s_id']."' s_price='".$sv['s_price']."' title='".self::$language['add_cart']."'></a></div>";}
				if($attribute['show_method']!='show_line'){
					$temp.="<div class=goods><a href='./index.php?monxin=mall.goods&shop_id=".SHOP_ID."&id=".$v2['id']."' target=".$attribute['target']." class=goods_a><img wsrc='./program/mall/img_thumb/".$v2['icon']."' /><span class=title>".$v2['title']."/".self::get_mall_unit_name($pdo,$v2['unit'])."</span></a><span class=price_span>".$w_price."</span>".$buy_button."</div>";
				}else{
					$temp.="<div class=line><a href='./index.php?monxin=mall.goods&shop_id=".SHOP_ID."&id=".$v2['id']."' target=_blank class=goods_img><img wsrc='./program/mall/img_thumb/".$v2['icon']."' /></a><div class=good_info><a href='./index.php?monxin=mall.goods&id=".$v2['id']."'  target=".$attribute['target']." class=title>".$v2['title']."</a><span class=price_span>".$w_price."/".self::get_mall_unit_name($pdo,$v2['unit'])."</span>".$buy_button."</div></div>";
				}
				
				
				
			}
			$module['hover_list'].='<div class="list hover_list" id=hover_'.$v['id'].'>'.$temp.'</div>';

		}
		$module['sub_type']=trim($module['sub_type'],'|');
	}
	
	$module['cover_image']='';
	if($attribute['img']!=''){
		$link=str_replace('*','.',@$attribute['img_link']);
		$link=str_replace('!',':',$link);
		$link=str_replace('andand','&',$link);

		$module['cover_image']='<a href="'.$link.'" class=cover_image  target='.$attribute['target'].'><img src="./program/mall/img/'.str_replace('*','.',$attribute['img']).'" /></a>';	
		$module['img_width']=$attribute['img_width'];
	}
	
$module['shop_master']=SHOP_MASTER;
$module['username']=@$_SESSION['monxin']['username'];
require('./templates/0/'.$class.'_shop/'.self::$config['shop_template'].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php');	
