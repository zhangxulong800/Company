<?php
$act=@$_GET['act'];

if($act=='update_cart'){self::update_cart($pdo,self::$table_pre);exit();}

if($act=='update'){
$module['ci_cart']='';
$module['cart_html']='';

$module['view_all']='';
$money_count=0;
if(isset($_COOKIE['ci_cart'])){
	if($_COOKIE['ci_cart']!=''){
		$discount=self::get_ci_discount($pdo);
		
		$ci_cart=json_decode($_COOKIE['ci_cart'],true);
		$ci_cart=self::array_sort($ci_cart,'time',$type='desc');
		//var_dump($ci_cart);

		$spec=array();
		$spec_ids='';
		$index=0;
		foreach($ci_cart as $key=>$v){
			if($index>9){break;}
			$temp=explode('_',$key);
			if(isset($temp[1])){
				$spec[$temp[0]]=$temp[1];
				$spec_ids.=$temp[1].',';
			}
			$index++;
		}
		
		$spec_ids=trim($spec_ids,',');
		if($spec_ids!=''){
			$sql="select `id`,`color_name`,`color_img`,`option_id`,`w_price` from ".self::$table_pre."goods_specifications where `id` in (".$spec_ids.")";
			$r=$pdo->query($sql,2);
			$spec2=array();
			foreach($r as $v){
				$spec2[$v['id']]['w_price']=$v['w_price'];
				$spec2[$v['id']]['color_name']=$v['color_name'];
				$spec2[$v['id']]['color_img']=$v['color_img'];
				$spec2[$v['id']]['option_name']=self::get_type_option_name($pdo,$v['option_id']);
			}	
		}
		$index=0;
		foreach($ci_cart as $key=>$v){
			if($index>9){break;}
			$temp=explode('_',$key);
			$sql="select `id`,`title`,`icon`,`w_price`,`sales_promotion` from ".self::$table_pre."goods where id='".intval($temp[0])."' and `state`=1";
			$r=$pdo->query($sql,2)->fetch(2);
			if(isset($temp[1])){
				if($spec2[$temp[1]]['color_img']!=''){$img='img/'.$spec2[$temp[1]]['color_img'];}else{$img='img_thumb/'.$r['icon'];}
				$price=$spec2[$temp[1]]['w_price'];
				$spec_info=$spec2[$temp[1]]['color_name'].' '.$spec2[$temp[1]]['option_name'];
			}else{
				$img='img_thumb/'.$r['icon'];
				$price=$r['w_price'];
				$spec_info='';
			}
			if($discount<10 && ($_POST['discount_join_goods'] || $r['sales_promotion'])){$price=sprintf("%.2f",$price*$discount/10);}
			$module['ci_cart'].='<div id=cart__'.$key.'>
                    	<a href="./index.php?monxin=ci.goods&id='.$r['id'].'" class=goods_info>
                            <span class=img><img src="./program/ci/'.$img.'" /></span><span class=title_and_other>
                                <span class=title>'.$r['title'].'</span>
                                <span class=other><span class=specifications>'.$spec_info.'</span><span class=price><span class=money_symbol>'.self::$language['money_symbol'].'</span>'.$price.'*'.$ci_cart[$key]['quantity'].'</span></span>
                            </span>
                    	</a><a href="#" class=del title="'.self::$language['del'].'">&nbsp;</a>
                    </div>';
			
			$index++;
			$money_count+=$price*$ci_cart[$key]['quantity'];
		}
		if(count($ci_cart)>10){$module['view_all']='<a href="#" class=view_all>'.self::$language['view_all'].'</a>';}
	}	
}
if($module['ci_cart']!=''){
	$module['cart_html']='<div class=lately>'.self::$language['cart_lately_goods'].'</div>
				<div class=list_div>'.$module['ci_cart'].'</div>
				'.$module['view_all'].'
				<div class=sum_div>
                	'.self::$language['sum_data'].'<span class=goods_count>'.count($ci_cart).'</span>'.self::$language['item'].self::$language['goods'].' 
                    <span class=money_count_span>'.self::$language['sum'].'<span class=money_count><span class=money_symbol>'.self::$language['money_symbol'].'</span>'.$money_count.'</span></span>
                	<a href="./index.php?monxin=ci.my_cart" class=go_w_cashier>'.self::$language['settlement'].'</a>
                </div>';
}
	exit($module['cart_html']);	
	
}