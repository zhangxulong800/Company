<?php
if($method==''){$method='mall::cart';}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;

$sql="select * from ".self::$table_pre."shop_order_set where `shop_id`=".SHOP_ID;
$order_set=$pdo->query($sql,2)->fetch(2);
$module['shop_credits_rate']=1/$order_set['credits_rate'];
$module['web_credits_rate']=self::$config['credits_set']['rate'];

$module['checkout_desk']='';
$module['fulfil_preferential']=self::get_fulfil_preferential_method($pdo,self::$table_pre,self::$language,SHOP_ID);
if($module['fulfil_preferential']!=''){
	$module['fulfil_preferential']='<div class=fulfil_preferential>'.$module['fulfil_preferential'].'<span class=fulfil_json style="display:none;">'.self::get_fulfil_preferential_json($pdo,self::$table_pre,SHOP_ID).'</span></div>';
}

$money_count=0;
if(isset($_COOKIE['checkout_desk'])){
	if($_COOKIE['checkout_desk']!=''){
		
		//var_dump($_COOKIE['checkout_desk']);
		//打折...
		$discount=self::get_shop_discount($pdo,SHOP_ID);
		
		$checkout_desk=json_decode($_COOKIE['checkout_desk'],true);
		$checkout_desk=self::array_sort($checkout_desk,'time',$type='desc');
		//var_dump($checkout_desk);

		$spec=array();
		$spec_ids='';
		foreach($checkout_desk as $key=>$v){
			$temp=explode('_',$key);
			if(isset($temp[1])){
				$spec[$temp[0]]=$temp[1];
				$spec_ids.=$temp[1].',';
			}
		}
		
		$spec_ids=trim($spec_ids,',');
		if($spec_ids!=''){
			$sql="select `id`,`color_name`,`color_img`,`option_id`,`e_price` from ".self::$table_pre."goods_specifications where `id` in (".$spec_ids.")";
			$r=$pdo->query($sql,2);
			$spec2=array();
			foreach($r as $v){
				$spec2[$v['id']]['e_price']=$v['e_price'];
				$spec2[$v['id']]['color_name']=$v['color_name'];
				$spec2[$v['id']]['color_img']=$v['color_img'];
				$spec2[$v['id']]['option_name']=self::get_type_option_name($pdo,$v['option_id']);
			}	
		}
		foreach($checkout_desk as $key=>$v){
			$temp=explode('_',$key);
			$sql="select `id`,`title`,`icon`,`e_price`,`unit`,`sales_promotion` from ".self::$table_pre."goods where id='".intval($temp[0])."' and `state`!=0 and `shop_id`=".SHOP_ID;
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']==''){continue;}
			if(isset($temp[1])){
				if($spec2[$temp[1]]['color_img']!=''){
					$img='img/'.$spec2[$temp[1]]['color_img'];
				}else{
					$img='img_thumb/'.$r['icon'];
				}
				$price=$spec2[$temp[1]]['e_price'];
				$spec_info=$spec2[$temp[1]]['color_name'].' '.$spec2[$temp[1]]['option_name'];
			}else{
				$img='img_thumb/'.$r['icon'];
				$price=$r['e_price'];
				$spec_info='';
			}
			$normal_price=$price;
			$favorite='';
			if($discount<10 && ($_POST['discount_join_goods'] || $r['sales_promotion'])){$price=sprintf("%.2f",$price*$discount/10);}
			if($r['sales_promotion']){$sales_promotion='<span class=sales_promotion>'.self::$language['sales_promotion_short'].'</span>';}else{$sales_promotion='';}
			
			$module['checkout_desk'].="<tr id='tr_".$key."' normal_price='".$normal_price."' promotion='".$price."'  ".self::get_goods_group_discount($pdo,$r['id'])." >
	<td class=goods_td><a href='./index.php?monxin=mall.goods&id=".$r['id']."' target=_blank class=goods_info>
                            <span class=img><img src='./program/mall/".$img."' /></span><span class=title>
                                ".$r['title']." ".$spec_info."</span>
                    	</a></td>
  <td class=price_td><div class=normal><span class=price>".$price."</span>".$sales_promotion."</div><div class=group></div><span class=g_discount></span></td>
  <td class='quantity_div'><a href=# class=decrease_quantity title='-1'></a><input type='text' class=quantity kg_rate='".self::get_kg_rate($pdo,$r['unit'])."' value='".$checkout_desk[$key]['quantity']."' /><a href=# class=add_quantity title='+1'></a><span class=unit >".self::get_mall_unit_name($pdo,$r['unit'])."<span class=unit_gram value=".$_POST['temp_unit_gram']."></span></span></td>
  <td class=subtotal_td><span class=subtotal>".$price*$checkout_desk[$key]['quantity']."</span></td>
  <td class=operation_td>
  <a href='#' class='del'>".self::$language['del']."</a> <span class='state'></span></td>
</tr>
";	
			$money_count+=$price*$checkout_desk[$key]['quantity'];
		}
	}	
}


$module['preferential_way_option']='<option value="2" selected>'.self::$language['preferential_way_option'][2].'</option><option value="4">'.self::$language['preferential_way_option'][4].'</option><option value="7">'.self::$language['preferential_way_option'][7].'</option><option value="8">'.self::$language['preferential_way_option'][8].'</option>';

$module['preferential_way_option_2']='<option value="2" selected>'.self::$language['preferential_way_option'][2].'</option><option value="4">'.self::$language['preferential_way_option'][4].'</option><option value="7">'.self::$language['preferential_way_option'][7].'</option><option value="5">'.self::$language['preferential_way_option'][5].'</option><option value="8">'.self::$language['preferential_way_option'][8].'</option>';

$sql="select * from ".self::$table_pre."shop where `id`=".SHOP_ID;
$r=$pdo->query($sql,2)->fetch(2);
$module['shop_name']=$r['name'];
$seller=$r['username'];
$all_user=$r['all_user'];
$ex=explode(',',$r['payment']);
$module['web_c_password']=$r['web_c_password'];
$module['shop_c_password']=$r['shop_c_password'];

$scanpay_option='';

if(is_dir('./scanpay_type/')){
	foreach(self::$language['scan_pay_account_type_option'] as $k=>$v){
		if(!in_array($k,$ex)){continue;}
		$sql="select * from ".$pdo->sys_pre."scanpay_account where `username`='".$seller."' and `type`='".$k."' and `state`=1 order by `sequence` desc limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){
			$scanpay_option.='<option value="'.$k.'" account_id='.$r['id'].'>'.$v.'('.self::$language['scan_pay_is_web_option'][0].')</option>';
		}else{
			$sql="select * from ".$pdo->sys_pre."scanpay_account where `is_web`=1 and `type`='".$k."' and `state`=1  order by `sequence` desc limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']!=''){$scanpay_option.='<option value="'.$k.'" account_id='.$r['id'].'>'.$v.'('.self::$language['scan_pay_is_web_option'][1].')</option>';}
			
		}
	}
}

$module['pay_method']='';
if(in_array('cash',$ex)){$module['pay_method'].='<option value="cash" selected>'.self::$language['pay_method']['cash'].'</option>';}
if(in_array('pos',$ex)){$module['pay_method'].='<option value="pos">'.self::$language['pay_method']['pos'].'</option>';}
$module['pay_method'].=$scanpay_option;
if(in_array('alipay_p',$ex)){$module['pay_method'].='<option value="alipay_p" >'.self::$language['pay_method']['alipay_p'].'</option>';}
if(in_array('weixin_p',$ex)){$module['pay_method'].='<option value="weixin_p" >'.self::$language['pay_method']['weixin_p'].'</option>';}
if(in_array('meituan',$ex)){$module['pay_method'].='<option value="meituan" >'.self::$language['pay_method']['meituan'].'</option>';}
if(in_array('nuomi',$ex)){$module['pay_method'].='<option value="nuomi" >'.self::$language['pay_method']['nuomi'].'</option>';}
if(in_array('other',$ex)){$module['pay_method'].='<option value="other" >'.self::$language['pay_method']['other'].'</option>';}

$module['pay_method_2']=$module['pay_method'];	

if(in_array('balance',$ex)){$module['pay_method'].='<option value="other" >'.self::$language['pay_method']['other'].'</option>';$module['pay_method_full_no_shop']=$module['pay_method_2'].'<option value="balance">'.self::$language['pay_method']['balance'].'</option>';}
if(in_array('shop_balance',$ex)){$module['pay_method_full_no_web']=$module['pay_method_2'].'<option value="shop_balance">'.self::$language['pay_method']['shop_balance'].'</option>';}

$module['pay_method_full']=$module['pay_method_2'];

if(in_array('balance',$ex)){$module['pay_method_full'].='<option value="balance">'.self::$language['pay_method']['balance'].'</option>';}
if(in_array('shop_balance',$ex)){$module['pay_method_full'].='<option value="shop_balance">'.self::$language['pay_method']['shop_balance'].'</option>';}

if($order_set['credit'] && in_array('credit',$ex)){
	$module['pay_method_full'].='<option value="credit">'.self::$language['pay_method']['credit'].'</option>';
}




$module['print_set_list']='';
foreach(self::$language['print_set'] as $k=>$v){
	$module['print_set_list'].="<option value='".$k."'>".$v."</option>";
}

$sql="select `id`,`icon`,`title`,`option_enable`,`e_price` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and `quick_sequence`!=0 and `state`!=0 and `share`=0 and `mall_state`=1  order by `quick_sequence` desc";
$r=$pdo->query($sql,2);
$module['quick_goods']='';
foreach($r as $v){
	$v['title']=de_safe_str($v['title']);
	if($v['option_enable']==1){
		$sql="select `id`,`color_name`,`option_id`,`e_price` from ".self::$table_pre."goods_specifications where `goods_id`=".$v['id'];
		$r2=$pdo->query($sql,2);
		foreach($r2 as $v2){
			$module['quick_goods'].="<a goods_id=".$v2['id']." id_type=s_id key=".$v['id']."_".$v2['id']."><div class=img_div><img src=./program/mall/img_thumb/".$v['icon']." /></div><span><div class=e_price>".self::$language['money_symbol'].$v2['e_price']."</div>".$v2['color_name']." ".self::get_type_option_name($pdo,$v2['option_id'])." ".$v['title']."</span></a>";
		}	
	}else{
		$module['quick_goods'].="<a goods_id=".$v['id']." id_type=g_id key=".$v['id']."><div class=img_div><img src=./program/mall/img_thumb/".$v['icon']." /></div><span><div class=e_price>".self::$language['money_symbol'].$v['e_price']."</div>".$v['title']."</span></a>";
	}
	
}




	$sql="select `id`,`title`,`e_price`,`unit`,`option_enable`,`py` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and `state`!=0 and `share`=0 and `mall_state`=1 order by `sold` desc,`id` asc limit 0,500";
	$g=$pdo->query($sql,2);
	$module['goods']='';
	foreach($g as $gv){
		if($gv['option_enable']==1){
			$sql="select `id`,`e_price`,`color_id`,`color_name`,`option_id` from ".self::$table_pre."goods_specifications where `goods_id`=".$gv['id']."";
			$sg=$pdo->query($sql,2);
			foreach($sg as $sgv){
				$option_name='';
				$color_name='';
				if($sgv['option_id']!=0){$option_name='<span>'.self::get_type_option_name($pdo,$sgv['option_id']).'</span>';}
				if($sgv['color_name']!=''){$color_name='<span>'.de_safe_str($sgv['color_name']).'</span>';}
				$module['goods'].='<a goods_id='.$sgv['id'].' py="'.$gv['py'].'"  id_type=s_id key='.$gv['id'].'_'.$sgv['id'].'>'.de_safe_str($gv['title']).'<i class=option>'.$option_name.''.$color_name.'</i><i class=price price='.$sgv['e_price'].'>'.self::$language['money_symbol'].$sgv['e_price'].'/'.self::get_mall_unit_name($pdo,$gv['unit']).'</i></a>';	
			}
			
			
		}else{
			$module['goods'].='<a goods_id='.$gv['id'].' py="'.$gv['py'].'"  id_type=g_id key='.$gv['id'].'>'.de_safe_str($gv['title']).'<i class=price price='.$gv['e_price'].'>'.self::$language['money_symbol'].$gv['e_price'].'/'.self::get_mall_unit_name($pdo,$gv['unit']).'</i></a>';
			
		}
		
	}



$module['shop_id']=SHOP_ID;
$module['username']=$_SESSION['monxin']['username'];

if($all_user){
	$sql="select `username`,`username_py`,`phone` from ".$pdo->index_pre."user where `state`=1 limit 0,100000";
}else{
	$sql="select `username`,`username_py`,`phone` from ".self::$table_pre."shop_buyer";
}
$r=$pdo->query($sql,2);
$module['user']='';
foreach($r as $v){
	$v=de_safe_str($v);
	$module['user'].="<a upy=".$v['username_py']." user_n='".$v['username']."' m_show=0>".$v['username']." ".$v['phone']."</a>";
}



$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
