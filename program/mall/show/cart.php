<?php
if($method==''){$method='mall::cart';}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['mall_cart']='';
$module['cart_html']='';

$module['view_all']='';
$money_count=0;
if(self::$config['cart_show_independent']){$module['cart_show_independent']=1;}else{$module['cart_show_independent']=0;}
if(!isset($_COOKIE['mall_cart'])){
	if(isset($_SESSION['monxin']['username'])){ self::update_cart($pdo,self::$table_pre);}	
}else{
	if(isset($_SESSION['monxin']['username'])){
		$mall_cart=json_decode($_COOKIE['mall_cart'],true);
		if(count($mall_cart)>0){
		$mall_cart=self::array_sort($mall_cart,'time',$type='desc');
			foreach($mall_cart as $key=>$v){
				$sql="select `id` from ".self::$table_pre."cart where `username`='".$_SESSION['monxin']['username']."' and `key`='".$key."' limit 0,1";
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['id']==''){unset($mall_cart[$key]);}
			}
			setcookie("mall_cart",json_encode($mall_cart));
			$_COOKIE['mall_cart']=json_encode($mall_cart);
		}
	}
}
$hidden=0;
$hidden_keys=array();
if(isset($_COOKIE['mall_cart'])){
	if($_COOKIE['mall_cart']!='' && count(json_decode($_COOKIE['mall_cart'],true))>0 ){
		
		$mall_cart=json_decode($_COOKIE['mall_cart'],true);
		$mall_cart=self::array_sort($mall_cart,'time',$type='desc');
		//var_dump($mall_cart);

		$spec=array();
		$spec_ids='';
		$index=0;
		foreach($mall_cart as $key=>$v){
			if($index>9){break;}
			$temp=explode('_',$key);
			if(isset($temp[1])){
				$spec[$temp[0]]=intval($temp[1]);
				$spec_ids.=intval($temp[1]).',';
			}
			$index++;
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
			if($index>9){break;}
			$temp=explode('_',$key);
			$sql="select `id`,`title`,`icon`,`w_price`,`sales_promotion`,`shop_id`,`discount`,`discount_start_time`,`discount_end_time` from ".self::$table_pre."goods where id='".intval($temp[0])."' and `state`!=0";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']==''){$hidden++;$hidden_keys[]=$key;continue;}
			$shop_discount=self::get_shop_discount($pdo,$r['shop_id']);
			if($r['discount']<10 && $time>$r['discount_start_time'] && $time<$r['discount_end_time']){$discount=$r['discount'];$goods_discount=$r['discount'];}else{$discount=$shop_discount;}
			if(isset($temp[1])){
				if(!isset($spec2[$temp[1]])){$hidden++;$hidden_keys[]=$key;continue;}
				if($spec2[$temp[1]]['color_img']!=''){$img='img/'.$spec2[$temp[1]]['color_img'];}else{$img='img_thumb/'.$r['icon'];}
				$price=$spec2[$temp[1]]['w_price'];
				
				$spec_info=$spec2[$temp[1]]['color_name'].' '.$spec2[$temp[1]]['option_name'];
			}else{
				$img='img_thumb/'.$r['icon'];
				$r['w_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$r['w_price']);
				$price=$r['w_price'];
				$spec_info='';
			}
			$price=$mall_cart[$key]['price'];
			$shop_discount=self::get_shop_discount($pdo,$r['shop_id']);
			if($discount<10 && ($_POST['discount_join_goods'] || $r['sales_promotion'])){$price=sprintf("%.2f",$price*$discount/10);}
			$module['mall_cart'].='<div id=cart__'.$key.'>
                    	<a href="./index.php?monxin=mall.goods&id='.$r['id'].'" class=goods_info>
                            <span class=img><img src="./program/mall/'.$img.'" /></span><span class=title_and_other>
                                <span class=title>'.$r['title'].'</span>
                                <span class=other><span class=price>'.$price.'<span class=money_symbol>'.self::$language['yuan'].'</span> * '.$mall_cart[$key]['quantity'].'</span><span class=specifications>'.$spec_info.'</span></span>
                            </span>
                    	</a><a href="#" class=del title="'.self::$language['del'].'">&nbsp;</a>
                    </div>';
			
			$index++;
			$money_count+=$price*$mall_cart[$key]['quantity'];
		}
		if(count($mall_cart)>10){$module['view_all']='<a href="./index.php?monxin=mall.my_cart" class=view_all>'.self::$language['view_all'].'</a>';}
	}	
}
$module['hidden']=$hidden;
$module['hidden_keys']=json_encode($hidden_keys);

if($module['mall_cart']!=''){
	$module['cart_html']='<div class=lately>'.self::$language['cart_lately_goods'].'</div>
				<div class=goods_list_div>'.$module['mall_cart'].'</div>
				'.$module['view_all'].'
				<div class=sum_div>
                	'.self::$language['sum_data'].'<span class=goods_count>'.(count($mall_cart)-$hidden).'</span>'.self::$language['item'].self::$language['goods'].' 
                    <span class=money_count_span>'.self::$language['sum'].'<span class=money_count><span class=money_symbol>'.self::$language['money_symbol'].'</span>'.$money_count.'</span></span>
                	<a href="./index.php?monxin=mall.my_cart" class=go_w_cashier>'.self::$language['settlement'].'</a>
                </div>';
}
if($module['cart_show_independent']==0){
	$module['module_show']='none;';	
}else{
	$module['module_show']='inline-block;';	
}	
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
