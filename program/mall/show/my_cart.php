<?php
if($method==''){$method='mall::cart';}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;

$module['mall_cart']='';
$discount=10;
$money_count=0;
$shops=array();
if(isset($_COOKIE['mall_cart'])){
	if($_COOKIE['mall_cart']!=''){
		
		$mall_cart=json_decode($_COOKIE['mall_cart'],true);
		if(count($mall_cart)==0){}
		$mall_cart=self::array_sort($mall_cart,'time',$type='desc');
		//var_dump($mall_cart);

		$spec=array();
		$spec_ids='';
		foreach($mall_cart as $key=>$v){
			$temp=explode('_',$key);
			if(isset($temp[1])){
				$spec[$temp[0]]=intval($temp[1]);
				$spec_ids.=intval($temp[1]).',';
			}
		}
		
		$spec_ids=trim($spec_ids,',');
		if($spec_ids!=''){
			$sql="select `id`,`color_name`,`color_img`,`option_id`,`w_price`,`goods_id` from ".self::$table_pre."goods_specifications where `id` in (".$spec_ids.")";
			$r=$pdo->query($sql,2);
			$spec2=array();
			foreach($r as $v){
				//$spec2[$v['id']]['w_price']=$v['w_price'];
				$spec2[$v['id']]['w_price']=$mall_cart[$v['goods_id'].'_'.$v['id']]['price'];
				$spec2[$v['id']]['color_name']=$v['color_name'];
				$spec2[$v['id']]['color_img']=$v['color_img'];
				$spec2[$v['id']]['option_name']=self::get_type_option_name($pdo,$v['option_id']);
			}	
		}
		
		$index=0;
		$time=time();
		foreach($mall_cart as $key=>$v){
			$temp=explode('_',$key);
			$sql="select `id`,`title`,`icon`,`w_price`,`unit`,`sales_promotion`,`shop_id`,`discount`,`discount_start_time`,`discount_end_time` from ".self::$table_pre."goods where id='".intval($temp[0])."' and `state`!=0";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']==''){continue;}
			$shop_discount=self::get_shop_discount($pdo,$r['shop_id']);
			if($r['discount']<10 && $time>$r['discount_start_time'] && $time<$r['discount_end_time']){$discount=$r['discount'];$goods_discount=$r['discount'];}else{$discount=$shop_discount;}
			if(isset($temp[1])){
				if(!isset($spec2[$temp[1]])){continue;}

				if($spec2[$temp[1]]['color_img']!=''){
					$img='img/'.$spec2[$temp[1]]['color_img'];
				}else{
					$img='img_thumb/'.$r['icon'];
				}
				$price=$spec2[$temp[1]]['w_price'];
				$spec_info=$spec2[$temp[1]]['color_name'].' '.$spec2[$temp[1]]['option_name'];
			}else{
				$img='img_thumb/'.$r['icon'];
				$price=$r['w_price'];
				$spec_info='';
			}
			if($discount<10 && ($_POST['discount_join_goods'] || $r['sales_promotion'])){$price=sprintf("%.2f",$price*$discount/10);}
			if($price>$mall_cart[$key]['price']){$price=$mall_cart[$key]['price'];}
			//var_dump($price);
			$favorite='';
			if(isset($_SESSION['monxin'])){$favorite="<a href='#' class=move_to_favorites>".self::$language['move_to_favorites']."</a><br />";}		
			if($r['sales_promotion']){$sales_promotion='<span class=sales_promotion>'.self::$language['sales_promotion_short'].'</span>';}else{$sales_promotion='';}
			if(!isset($shops[$r['shop_id']]['index'])){
				$shops[$r['shop_id']]['index']=$index;$index++;
				$sql="select `name`,`domain`,`evaluation_0`,`evaluation_1`,`evaluation_2` from ".self::$table_pre."shop where `id`=".$r['shop_id'];
				$r2=$pdo->query($sql,2)->fetch(2);
				$r2=de_safe_str($r2);
				if($r2['evaluation_2']==0 && $r2['evaluation_0']==0){
					$satisfaction=100;
				}elseif($r2['evaluation_2']==0 && $r2['evaluation_0']!=0){
					$satisfaction=0;
				}else{
					$satisfaction=intval($r2['evaluation_2']/($r2['evaluation_2']+$r2['evaluation_0'])*100);
				}
				$fulfil_preferential=self::get_fulfil_preferential_method($pdo,self::$table_pre,self::$language,$r['shop_id']);
				
				if($_COOKIE['monxin_device']=='pc'){
					$shops[$r['shop_id']]['shop_info']="<div class=shop_info><input type='checkbox' id=shop_".$r['shop_id']."  class=shop_id /><span class=name_l>".self::$language['store2']."：</span><span class=name_v>".$r2['name']."</span><span class=satisfaction_l>".self::$language['satisfaction'].":</span><span class=satisfaction_v>".$satisfaction."%	</span><span class=fulfil_preferential>".$fulfil_preferential."</span></div>";
				}else{
					$shops[$r['shop_id']]['shop_info']="<div class=shop_info><div class=checkbox_td><a href=# class='m_checkbox shop_checkbox'></a></div><div class=text>
            	<a class=name href='./index.php?monxin=mall.shop_index&shop_id=".$r['shop_id']."' target=_blank>".$r2['name']."</a>
            	<div class=fulfil_preferential>".$fulfil_preferential."</div>
            </div></div>";
				
				}
				$shops[$r['shop_id']]['shop_goods']='';
				
			}
			if($_COOKIE['monxin_device']=='pc'){
				$shops[$r['shop_id']]['shop_goods'].="
				<div class=tr id='tr_".$key."'>
                    <div class=checkbox_td><input type='checkbox' name='".$key."' id='".$key."' class='id' /></div><div class=goods_td>
                    <a class=goods_info href=./index.php?monxin=mall.goods&id=".$r['id']." target=_blank><img src='./program/mall/".$img."' /><div class=title_model><div class=title>".$r['title']."</div><div class=model>".$spec_info."</div></div></a>
                    </div><div class=unit_price_td>
                    <span class=price>".$price."</span>".$sales_promotion."
                    </div><div class=quantity_td>
                    <a href=# class=decrease_quantity title='-1'>&nbsp;</a><input type='text' class=quantity value='".$mall_cart[$key]['quantity']."' /><a href=# class=add_quantity title='+1'>&nbsp;</a> <span class=unit>".self::get_mall_unit_name($pdo,$r['unit'])."</span><span class=unit_gram value=".$_POST['temp_unit_gram']."></span>
                    </div><div class=subtotal_td>
                    <span class=subtotal>".$price*$mall_cart[$key]['quantity']."</span>
                    </div><div class=operation_td>
                     ".$favorite."
  <a href='#' class='del'>".self::$language['del']."</a> <span class='state'></span>
                    </div>
                </div>
				";				
			}else{
				
				$shops[$r['shop_id']]['shop_goods'].="<div class=goods id='goods_".$key."'>
                    <div class=checkbox_td><a  href=# class='m_checkbox goods_checkbox' d_id=".$key."></a></div><div class=goods_td>
                        <span class=icon><img src='./program/mall/".$img."' /></span><div class=goods_info>
                            <a href=./index.php?monxin=mall.goods&id=".$r['id']." target=_blank class=title>".$r['title']."</a>
                            <div class=quantity_td>
                    <a href=# class=decrease_quantity title='-1'></a><input type='text' class=quantity value='".$mall_cart[$key]['quantity']."' /><a href=# class=add_quantity title='+1'></a> <span class=unit>".self::get_mall_unit_name($pdo,$r['unit'])."</span><span class=unit_gram value=".$_POST['temp_unit_gram']."></span>
                    		</div>
                        </div>
                    </div><div class=act_td>
                        <div class=goods_other>
                            <div class=model>".$spec_info."</div>
                           	<div class=subtotal price='".$price."'>".$price*$mall_cart[$key]['quantity']."</div>
                        </div>
                        <div class=edit_div>".$favorite."<a href='#' class='del'>".self::$language['del']."</a></div>
                    </div>
                </div>";				
			
			

			}
			
			
			$money_count+=$price*$mall_cart[$key]['quantity'];
		}
	}	
}
$shops=self::array_sort($shops,'index',$type='asc');
$module['mall_cart']='';

foreach($shops as $k=>$v){
	$module['mall_cart'].="<div class=shop_div id=shop_".$k.">".$shops[$k]['shop_info']."<div class=shop_goods>".$shops[$k]['shop_goods']."</div></div>";
}

if($module['mall_cart']!=''){
	if($_COOKIE['monxin_device']=='pc'){
		$module['sum_info']='<div class=sum_div>
                	'.self::$language['selected'].'<span class=goods_count>'.count($mall_cart).'</span>'.self::$language['item'].self::$language['goods'].' 
                    <span class=money_count_span>'.self::$language['sum'].'('.self::$language['excluding_freight_costs'].')<span class=money_count>'.$money_count.'</span><span class=money_symbol>'.self::$language['yuan'].'</span></span>
                	<a href="./index.php" class=continue_mallping>'.self::$language['continue_mallping'].'</a>
                	<a href="./index.php?monxin=mall.confirm_order&goods_src=selected_goods" class=go_w_cashier user_color=button>'.self::$language['settlement'].'</a>
                </div>';
	}else{
		$module['sum_info']='<div class=sum_div><span class=money_count_span>'.self::$language['sum'].': <span class=money_count>'.$money_count.'</span><span class=money_symbol>'.self::$language['yuan'].'</span></span></div>';
	}
	
}else{
	$module['mall_cart']='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['cart_is_null'].'</span></td></tr>';	
	$module['sum_info']='<div class=sum_div></div>';
}

if(isset($_SESSION['monxin'])){$module['operation_td_line_height']=10;}else{$module['operation_td_line_height']=45;}
	
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);


echo '<div style="display:none;" id="visitor_position_append">'.self::$language['pages']['mall.my_cart']['name'].'</div>';
