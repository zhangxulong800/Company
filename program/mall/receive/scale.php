<?php
$act=@$_GET['act'];

if($act=='submit'){
	$discount=self::get_shop_discount($pdo,SHOP_ID);
	$barcode=safe_str($_GET['barcode']);
	$g=array();
	if(is_numeric($barcode)){
		$sql="select `id`,`title`,`e_price`,`unit`,`bar_code`,`icon`,`sales_promotion`,`shelf_life` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and `bar_code`='".$barcode."' || `speci_bar_code` like '%".$barcode."|%' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){exit('{"state":"fail","info":"<span class=fail>'.self::$language['not_exist'].'</span>"}');}
		if($r['shelf_life']!=0){
			$shelf_life='<div class=time>'.self::$language['shelf_life_b'].':'.date("m-d H:i",time()+($r['shelf_life']*86400)).'</div>';	
		}else{
			$shelf_life='';
		}	
		if($r['bar_code']==$barcode){
			if($discount<10 && ($_POST['discount_join_goods'] || $r['sales_promotion'])){$r['e_price']=sprintf("%.2f",$r['e_price']*$discount/10);}
			$key=$r['id'];
			$g[$key]['icon']='img/'.$r['icon'];	
			$g[$key]['title']=$r['title'];	
			$checkout_desk[$key]['price']=$r['e_price'];
		}else{
			$sql="select `id`,`color_img`,`e_price`,`option_id`,`color_id`,`color_name` from ".self::$table_pre."goods_specifications where `goods_id`='".$r['id']."' and `barcode`='".$barcode."' limit 0,1";
			$r2=$pdo->query($sql,2)->fetch();
			if($r2['id']==''){exit('{"state":"fail","info":"<span class=fail>'.self::$language['not_exist'].'</span>"}');}
			if($discount<10 && ($_POST['discount_join_goods'] || $r['sales_promotion'])){$r2['e_price']=sprintf("%.2f",$r2['e_price']*$discount/10);}
			$key=$r['id'].'_'.$r2['id'];
			
			if($r2['color_img']!=''){
				$g[$key]['icon']='img/'.$r2['color_img'];	
			}else{
				$g[$key]['icon']='img/'.$r['icon'];
			}
			
			$g[$key]['title']=$r['title'].' '.self::get_type_option_name($pdo,$r2['option_id']).' '.$r2['color_name'];	
			$checkout_desk[$key]['quantity']=(isset($checkout_desk[$key]))?$checkout_desk[$key]['quantity']+1:1;
			$checkout_desk[$key]['price']=$r2['e_price'];
		}
		$result=array();
		$result['print_html']='<div class=goods>
        	<div class=title>'.$g[$key]['title'].'</div>
            <div class=price>'.self::$language['money_symbol'].'<span class="price_value">'.$checkout_desk[$key]['price'].'</span>*{quantity}<span class=unit>'.self::get_mall_unit_name($pdo,$r['unit']).'</span>={sum_money}'.self::$language['yuan'].'<span class=unit_gram value='.$_POST['temp_unit_gram'].'></span></div>
            <div class=other><div class=icon><img src=./program/mall/shop_icon/'.SHOP_ID.'.png /></div><div class=remark>
            	<div class=time>'.self::$language['packing_time'].':'.date("m-d H:i",time()).'</div>
				'.$shelf_life.'
			</div>
			<img src=./plugin/barcode/buildcode.php?codebar=BCGcode128&text='.$barcode.'|{quantity}>
        </div>
';
		$result['html']='<div class=goods_title>'.$g[$key]['title'].'</div>
                    <a class=goods_img href="./program/mall/'.$g[$key]['icon'].'"><img src=./program/mall/'.$g[$key]['icon'].' /></a>';
		
		$result['key']=$key;
		$result['state']='success';
		$result['info']='<span class=success>'.self::$language['success'].'</span>';
		echo json_encode($result);
		exit();
	}else{
		$result['state']='fail';
		$result['info']='<span class=success>'.self::$language['not_exist'].'</span>';
		echo json_encode($result);
		exit();
	}	
}
