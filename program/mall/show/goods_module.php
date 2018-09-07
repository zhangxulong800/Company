<?php
//echo $args[1];
//return false;

$cache_path='./program/mall/cache/'.md5($args[1]).'_'.$_COOKIE['circle'].'.txt';
if(is_file($cache_path) ){
	$cache_file_time=@filemtime($cache_path);
	if($cache_file_time>self::$config['type_update_time'] && $cache_file_time>self::$config['goods_update_time']){
		$module=unserialize(file_get_contents($cache_path));
		$module['credits_rate']=self::$config['credits_set']['rate'];
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);	
		return false;
	}
}
$module['credits_rate']=self::$config['credits_set']['rate'];
$attribute=format_attribute($args[1]);
$id=$attribute['id'];
if($attribute['follow_type']=='true' && intval(@$_GET['type'])!=0){$id=intval($_GET['type']);}
$attribute['quantity']=intval($attribute['quantity']);
$attribute['field']=str_replace('`','',@$attribute['field']);
$attribute['field']=explode(',',$attribute['field']);
$current_page=intval(@$_GET['current_page']);
if($attribute['follow_page']=='true' && $current_page>0){$start=$current_page*$attribute['quantity'];}else{$start=0;}
$ids=$this->get_type_ids($pdo,$id);
if($attribute['tag']!=''){
	$tag=explode('/',$attribute['tag']);
	$sub_where='';
	foreach($tag as $v){
		if(is_numeric($v)){
			$sub_where.="`tag` like '%|".$v."|%' or ";	
		}	
	}
	$sub_where=trim($sub_where,'or ');
	$tag_where=' and ('.$sub_where.')';	
}else{
	$tag_where='';	
}
if($attribute['store_tag']!=''){
	$store_tag=explode('/',$attribute['store_tag']);
	$shop_ids='';
	foreach($store_tag as $v){
		if(is_numeric($v)){
			$shop_ids.=self::get_store_tag_shop_ids($pdo,$v).',';
		}	
	}
	$shop_ids=trim($shop_ids,',');
	$temp=explode(',',$shop_ids);
	$temp=array_unique($temp);
	$temp=array_filter($temp);
	$shop_ids='';
	foreach($temp as $v){
		if(is_numeric($v)){$shop_ids.=$v.',';}	
	}
	$shop_ids=trim($shop_ids,',');
	if($shop_ids==''){$shop_ids='0';}
	
	$store_tag_where=' and shop_id in ('.$shop_ids.')';	
}else{
	$store_tag_where='';	
}
$headquarters_shop_id=self::get_headquarters_shop_id($pdo);
if($headquarters_shop_id!=''){$store_tag_where.=' and shop_id not in ('.$headquarters_shop_id.')';}

$attribute['circle']=$_COOKIE['circle'];
if($attribute['circle']>0){
	$circle=get_circle_ids($pdo,$attribute['circle']);
	$shop_ids=self::get_circle_shop_ids($pdo,$circle);
	if($shop_ids==''){$shop_ids='0';}
	$circle_where=' and shop_id in ('.$shop_ids.')';	
}else{
	$circle_where='';	
}


if(self::$config['online_forbid_show']){
	$online_forbid='';
}else{
	$online_forbid='`online_forbid`=0 and ';
}

	$sql="select `id`,`icon`,`title`,`w_price`,`min_price`,`max_price`,`option_enable`,`monthly`,`sales_promotion`,`discount`,`discount_start_time`,`discount_end_time`,`shop_id`,`bidding_show`,`satisfaction`,`unit`,`multi_angle_img` from ".self::$table_pre."goods where `state`!=0 and `mall_state`=1 and ".$online_forbid."`share`=0 and `type` in(".$ids.") ".$tag_where." ".$store_tag_where." ".$circle_where." order by `".$attribute['sequence_field']."` ".$attribute['sequence_type'].",`bidding_show` desc limit ".$start.",".$attribute['quantity'];
	//echo $sql;
	$r=$pdo->query($sql,2);
	$list='';
	$list2='';
	$module['hover_list']='';
	$time=time();
	
	foreach($r as $v){
		$v=de_safe_str($v);
		$v['normal_w_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['w_price']);
		$v['normal_min_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['min_price']);
		$v['normal_max_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['max_price']);
		$v['min_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['min_price']);
		$v['max_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['max_price']);
		$v['w_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['w_price']);
		
		$shop_discount=self::get_shop_discount($pdo,$v['shop_id']);
		if($v['discount']<10 && $time>$v['discount_start_time'] && $time<$v['discount_end_time']){$discount=$v['discount'];$goods_discount=$v['discount'];}else{$discount=$shop_discount;}
		if(($shop_discount<10 && $v['sales_promotion']) || isset($goods_discount)){
			if($v['option_enable']==0){
				$v['w_price']=sprintf("%.2f",$v['w_price']*$discount/10);
			}else{
				$v['min_price']=sprintf("%.2f",$v['min_price']*$discount/10);
				$v['max_price']=sprintf("%.2f",$v['max_price']*$discount/10);
			}
		}
		
		if($v['option_enable']==0){
			$w_price='<span class=money_value>'.$v['w_price'].'<span class=money_symbol>'.self::$language['yuan'].'</span></span>';
			
			if(in_array('unit',$attribute['field'])){$w_price='<span class=money_value>'.$v['w_price'].'</span><span class=money_symbol>'.self::$language['yuan'].'</span><span class=unit>/'.self::get_mall_unit_name($pdo,$v['unit']).'</span>';}
			
			if(in_array('normal_price',$attribute['field']) && $v['w_price']<$v['normal_w_price']){$w_price.='<span class=normal_price>'.$v['normal_w_price'].'<span class=money_symbol>'.self::$language['yuan'].'</span><span class=unit>/'.self::get_mall_unit_name($pdo,$v['unit']).'</span></span>';}
			$sv=array();
			$sv['s_id']=0;
			$sv['s_price']=0;
		}else{
			$sv=self::get_goods_s($pdo,$v['id']);
			$sv['s_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$sv['s_price']);
			if($v['min_price']==$v['max_price']){
				$w_price='<span class=money_value>'.$v['min_price'].'<span class=money_symbol>'.self::$language['yuan'].'</span></span>';
				
				if(in_array('unit',$attribute['field'])){$w_price='<span class=money_value>'.$v['min_price'].'</span><span class=money_symbol>'.self::$language['yuan'].'</span><span class=unit>/'.self::get_mall_unit_name($pdo,$v['unit']).'</span>';}
				
				if(in_array('normal_price',$attribute['field']) && $v['min_price']<$v['normal_min_price']){$w_price.='<span class=normal_price>'.self::$language['money_symbol'].$v['normal_min_price'].'<span class=money_symbol>'.self::$language['yuan'].'</span><span class=unit>/'.self::get_mall_unit_name($pdo,$v['unit']).'</span></span>';}
			}else{
				
				$w_price='<span class=money_value>'.$v['min_price'].'-'.$v['max_price'].'<span class=money_symbol>'.self::$language['yuan'].'</span></span>';
				if(in_array('unit',$attribute['field'])){$w_price='<span class=money_value>'.$v['min_price'].'-'.$v['max_price'].'</span><span class=money_symbol>'.self::$language['yuan'].'</span><span class=unit>/'.self::get_mall_unit_name($pdo,$v['unit']).'</span>';}
				if(in_array('normal_price',$attribute['field']) && $v['min_price']<$v['normal_min_price']){$w_price.='<span class=normal_price>'.self::$language['money_symbol'].$v['normal_min_price'].'-'.$v['normal_max_price'].'</span><span class=money_symbol>'.self::$language['yuan'].'</span><span class=unit>/'.self::get_mall_unit_name($pdo,$v['unit']).'</span>';}

			}
		}
		$buy_button='';
		if(@$attribute[$_COOKIE['monxin_device'].'_buy_button']){$buy_button="<div class=button_div><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank  class=add_cart user_color=button option_enable='".$v['option_enable']."' s_id='".$sv['s_id']."' s_price='".$sv['s_price']."'>".self::$language['add_cart']."</a></div>";}
		if($v['bidding_show']==0){$bidding_show=0;}else{$bidding_show=1;}
		
		$sum_div='';
		if($attribute['show_sold_satisfaction']){$sum_div="<span class=sum_div><span class=monthly><span class=m_label>".self::$language['monthly'].':</span><span class=value>'.$v['monthly']."</span></span><span class=satisfaction><span class=m_label>".self::$language['satisfaction'].':</span><span class=value>'.$v['satisfaction']."%</span></span></span>";}
		
		
		if($attribute['show_method']!='show_line'){
			if(in_array('multi_angle_img',$attribute['field'])){
				$multi_angle_img='<img src="./program/mall/img_thumb/'.$v['icon'].'" />';
				if($v['multi_angle_img']!=''){
					$temp=explode('|',$v['multi_angle_img']);
					foreach($temp as $temp_v){
						$multi_angle_img.='<img src="./program/mall/img_thumb/'.$temp_v.'" />';	
					}	
				}
				$multi_angle_img='<div class=multi_angle_img>'.$multi_angle_img.'</div>';
			}else{
				$multi_angle_img='';	
			}

			if($_COOKIE['monxin_device']=='pc'){
				$list.="<div class=goods id=g_".$v['id']." bidding=".$bidding_show."><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=".$attribute['target']." class=goods_a><span class=goods_img_div><img wsrc='./program/mall/img_thumb/".$v['icon']."' /></span>".$multi_angle_img."<span class=title>".$v['title']."</span></a><span class=price_span>".$w_price."</span>".$sum_div.$buy_button."</div>";
			}else{
				$list.="<div class=goods id=g_".$v['id']." bidding=".$bidding_show."><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=".$attribute['target']." class=goods_a><span class=goods_img_div><img wsrc='./program/mall/img_thumb/".$v['icon']."' /></span><span class=title>".$v['title']."</span></a><span class=price_span>".$w_price."</span>".$buy_button.$sum_div."</div>";
			}
			
		}else{
			if($_COOKIE['monxin_device']=='pc'){
				$list.="<div class=line id=g_".$v['id']." bidding=".$bidding_show."><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank class=goods_img><img wsrc='./program/mall/img_thumb/".$v['icon']."' /></a><div class=good_info><a href='./index.php?monxin=mall.goods&id=".$v['id']."'  target=".$attribute['target']." class=title>".$v['title']."</a><span class=price_span>".$w_price."</span>".$sum_div.$buy_button."</div></div>";
			}else{
				$list.="<div class=line id=g_".$v['id']." bidding=".$bidding_show."><a href='./index.php?monxin=mall.goods&id=".$v['id']."' target=_blank class=goods_img><img wsrc='./program/mall/img_thumb/".$v['icon']."' /></a><div class=good_info><a href='./index.php?monxin=mall.goods&id=".$v['id']."'  target=".$attribute['target']." class=title>".$v['title']."</a><span class=price_span>".$w_price."</span>".$buy_button.$sum_div."</div></div>";
			}
			
		}
	}
	
	
	
	if($list==''){$list='<a href="#">'.self::$language['no_content'].'</a>';}
	
	if(@$attribute['first']>0){
		$sql="select `content` from ".$pdo->sys_pre."diymodule_module where `id`=".intval($attribute['first']);
		$m=$pdo->query($sql,2)->fetch(2);
		$list=de_safe_str($m['content']);
	}

	$module['list']=$list;
	
	$module['scroll']=@$attribute['scroll'];
	$module['target']=$attribute['target'];
	$module['module_diy']=@$attribute['module_diy'];
	$module['title_link']='./index.php?monxin=mall.goods_list&type='.$id.'&tag='.$attribute['tag'];
	$module['title']=$attribute['title'];
	if($module['title']==''){$module['title_show']='none';}else{$module['title_show']='block';}
	$module['module_width']=$attribute['width'];
	$module['module_height']=$attribute['height'];
	$module['module_name']=str_replace("::","_",$method.'_'.$id.'_append_'.$attribute['circle'].'_'.str_replace('/','_',$attribute['tag']).'_'.$attribute['sequence_field'].'_'.$attribute['sequence_type'].'_'.str_replace('/','_',$attribute['store_tag']));
	$module['module_name']='id'.md5(serialize($attribute));
	$module['module_save_name']=str_replace("::","_",$method.$args[1]);
	$module['count_url']="receive.php?target=".$method."&id=".$id;
	
	$module['sub_type']='';
	$attribute['show_sub']=intval(@$attribute['show_sub']);
	if($attribute['show_sub']>0){
		$sql="select `id`,`name` from ".self::$table_pre."type where `parent`='".$attribute['id']."' and `visible`=1  and (`url`='' or `url` is null) order by `sequence` desc limit 0,".$attribute['show_sub'];
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			$module['sub_type'].='<a href="./index.php?monxin=mall.goods_list&type='.$v['id'].'"  target='.$attribute['target'].' d_id="'.$v['id'].'">'.$v['name'].'</a>';
			$sql2="select `id`,`icon`,`title`,`w_price`,`min_price`,`max_price`,`option_enable`,`monthly`,`sales_promotion`,`discount`,`discount_start_time`,`discount_end_time`,`bidding_show`,`satisfaction`,`unit`,`multi_angle_img` from ".self::$table_pre."goods where `state`!=0 and `mall_state`=1 and ".$online_forbid."`share`=0 and `type` in (".$ids=$this->get_type_ids($pdo,$v['id']).") ".$tag_where." ".$store_tag_where." ".$circle_where." order by `".$attribute['sequence_field']."` ".$attribute['sequence_type'].",`bidding_show` desc limit ".$start.",".$attribute['quantity'];
			$r2=$pdo->query($sql2,2);
			//echo $sql2;
			$temp='';
			foreach($r2 as $v2){
				if(!isset($shop_discount)){continue;}
				$v2=de_safe_str($v2);
				$v2['normal_w_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v2['w_price']);
				$v2['normal_min_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v2['min_price']);
				$v2['normal_max_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v2['max_price']);
				$v2['w_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v2['w_price']);
				$v2['min_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v2['min_price']);
				$v2['max_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v2['max_price']);

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
					
					$w_price='<span class=money_value>'.$v2['w_price'].'<span class=money_symbol>'.self::$language['yuan'].'</span></span>';
					
					if(in_array('unit',$attribute['field'])){$w_price='<span class=money_value>'.$v2['w_price'].'</span><span class=money_symbol>'.self::$language['yuan'].'</span><span class=unit>/'.self::get_mall_unit_name($pdo,$v2['unit']).'</span>';}
					
					if(in_array('normal_price',$attribute['field']) && $v2['w_price']<$v2['normal_w_price']){$w_price.='<span class=normal_price>'.$v2['normal_w_price'].'<span class=money_symbol>'.self::$language['yuan'].'</span></span>';}
					$sv=array();
					$sv['s_id']=0;
					$sv['s_price']=0;
				}else{
					$sv=self::get_goods_s($pdo,$v2['id']);
					$sv['s_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$sv['s_price']);
					if($v2['min_price']==$v2['max_price']){
						$w_price='<span class=money_value>'.$v2['min_price'].'<span class=money_symbol>'.self::$language['yuan'].'</span></span>';
						
						if(in_array('unit',$attribute['field'])){$w_price='<span class=money_value>'.$v2['min_price'].'</span><span class=money_symbol>'.self::$language['yuan'].'</span><span class=unit>/'.self::get_mall_unit_name($pdo,$v2['unit']).'</span>';}
						
						if(in_array('normal_price',$attribute['field']) && $v2['min_price']<$v2['normal_min_price']){$w_price.='<span class=normal_price>'.$v2['normal_min_price'].'<span class=money_symbol>'.self::$language['yuan'].'</span></span>';}
					}else{
						$w_price='<span class=money_value>'.$v2['min_price'].'-'.$v2['max_price'].'<span class=money_symbol>'.self::$language['yuan'].'</span></span>';
						if(in_array('unit',$attribute['field'])){$w_price='<span class=money_value>'.$v2['min_price'].'-'.$v2['max_price'].'</span><span class=money_symbol>'.self::$language['yuan'].'</span><span class=unit>/'.self::get_mall_unit_name($pdo,$v2['unit']).'</span>';}
						if(in_array('normal_price',$attribute['field']) && $v2['min_price']<$v2['normal_min_price']){$w_price.='<span class=normal_price>'.$v2['normal_min_price'].'-'.$v2['normal_max_price'].'<span class=money_symbol>'.self::$language['yuan'].'</span></span>';}
		
					}
				}
						
				$buy_button='';
				if(@$attribute[$_COOKIE['monxin_device'].'_buy_button']){$buy_button="<div class=button_div><a href='./index.php?monxin=mall.goods&id=".$v2['id']."' target=_blank  class=add_cart user_color=button option_enable='".$v2['option_enable']."' s_id='".$sv['s_id']."' s_price='".$sv['s_price']."'>".self::$language['add_cart']."</a></div>";}
				
				if($v2['bidding_show']==0){$bidding_show=0;}else{$bidding_show=1;}
						
				$sum_div='';
				if($attribute['show_sold_satisfaction']){$sum_div="<span class=sum_div><span class=monthly><span class=m_label>".self::$language['monthly'].':</span><span class=value>'.$v2['monthly']."</span></span><span class=satisfaction><span class=m_label>".self::$language['satisfaction'].':</span><span class=value>'.$v2['satisfaction']."%</span></span></span>";}
				
				if($attribute['show_method']!='show_line'){
					if(in_array('multi_angle_img',$attribute['field'])){
						$multi_angle_img='<img src="./program/mall/img_thumb/'.$v2['icon'].'" />';
						if($v2['multi_angle_img']!=''){
							
							$temp2=explode('|',$v2['multi_angle_img']);
							foreach($temp2 as $temp_v){
								$multi_angle_img.='<img src="./program/mall/img_thumb/'.$temp_v.'" />';	
							}	
						}
						$multi_angle_img='<div class=multi_angle_img>'.$multi_angle_img.'</div>';
						
					}else{
						$multi_angle_img='';	
					}
					if($_COOKIE['monxin_device']=='pc'){
						$temp.="<div class=goods id=g_".$v2['id']." bidding=".$bidding_show."><a href='./index.php?monxin=mall.goods&id=".$v2['id']."' target=".$attribute['target']." class=goods_a><span class=goods_img_div><img wsrc='./program/mall/img_thumb/".$v2['icon']."' /></span>".$multi_angle_img."<span class=title>".$v2['title']."</span></a><span class=price_span>".$w_price."</span>".$sum_div.$buy_button."</div>";
					}else{
						$temp.="<div class=goods id=g_".$v2['id']." bidding=".$bidding_show."><a href='./index.php?monxin=mall.goods&id=".$v2['id']."' target=".$attribute['target']." class=goods_a><span class=goods_img_div><img wsrc='./program/mall/img_thumb/".$v2['icon']."' /></span><span class=title>".$v2['title']."</span></a><span class=price_span>".$w_price."</span>".$buy_button.$sum_div."</div>";
					}
				}else{
					if($_COOKIE['monxin_device']=='pc'){
						$temp.="<div class=line id=g_".$v2['id']." bidding=".$bidding_show."><a href='./index.php?monxin=mall.goods&id=".$v2['id']."' target=_blank class=goods_img><img wsrc='./program/mall/img_thumb/".$v2['icon']."' /></a><div class=good_info><a href='./index.php?monxin=mall.goods&id=".$v2['id']."'  target=".$attribute['target']." class=title>".$v2['title']."</a><span class=price_span>".$w_price."</span>".$sum_div.$buy_button."</div></div>";
					}else{
						$temp.="<div class=line id=g_".$v2['id']." bidding=".$bidding_show."><a href='./index.php?monxin=mall.goods&id=".$v2['id']."' target=_blank class=goods_img><img wsrc='./program/mall/img_thumb/".$v2['icon']."' /></a><div class=good_info><a href='./index.php?monxin=mall.goods&id=".$v2['id']."'  target=".$attribute['target']." class=title>".$v2['title']."</a><span class=price_span>".$w_price."</span>".$buy_button.$sum_div."</div></div>";
					}
					
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

		$module['cover_image']='<a href="'.$link.'" class=cover_image  target='.$attribute['target'].'><img wsrc="./program/mall/img/'.str_replace('*','.',$attribute['img']).'" /></a>';	
		$module['img_width']=$attribute['img_width'];
	}
	
	$module['shop_master']=SHOP_MASTER;
	$module['username']=@$_SESSION['monxin']['username'];
	file_put_contents($cache_path,serialize($module));
	$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
	if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
	require($t_path);
