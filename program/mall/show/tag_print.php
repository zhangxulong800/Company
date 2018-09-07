<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$ids=safe_str(@$_GET['ids']);
if($ids==''){echo self::$language['select_null'];return false;}
$ids=str_replace('|',',',$ids);
$ids=trim($ids,',');

$sql="select `title`,`transaction_price`,`quantity`,`order_id`,`unit`,`s_id`,`goods_id` from ".self::$table_pre."order_goods where `shop_id`=".SHOP_ID." and `id` in (".$ids.")";
$r=$pdo->query($sql,2);
$module['list']='';
$time=date('Y-m-d H:i',time());
foreach($r as $v){
	$sql="select `bar_code`,`shelf_life` from ".self::$table_pre."goods where `id`=".$v['goods_id'];
	$r2=$pdo->query($sql,2)->fetch(2);	
	$barcode=$r2['bar_code'];
	if($r2['shelf_life']>0){
		$remark='<div class=order_id>'.self::$language['order_number'].'：'.$v['order_id'].'</div>
            	<div class=time>'.self::$language['packing_time'].':'.date("m-d H:i",time()).'</div>
				<div class=time>'.self::$language['shelf_life_b'].':'.date("m-d H:i",time()+($r2['shelf_life']*86400)).'</div>'
				;	
		 $module['remark_line_height']='style="line-height:17px;";';			
	}else{
		$remark='<div class=order_id>'.self::$language['order_number'].'：'.$v['order_id'].'</div>
            	<div class=time>'.$time.'</div>';
		$module['remark_line_height']='style="line-height:25px;";';			
	}
	
	if($v['s_id']!=0){
		$sql="select `barcode` from ".self::$table_pre."goods_specifications where `id`=".$v['s_id'];	
		$r2=$pdo->query($sql,2)->fetch(2);	
		$barcode=$r2['barcode'];
	}
	
	$module['list'].='
		<div class=goods>
        	<div class=title>'.$v['title'].'</div>
            <div class=price>'.self::$language['money_symbol'].str_replace('.00','',$v['transaction_price']).'*'.self::format_quantity($v['quantity']).$v['unit'].'='.str_replace('.00','',$v['transaction_price']*self::format_quantity($v['quantity'])).self::$language['yuan'].'</div>
            <div class=other><div class=icon><img src=./program/mall/shop_icon/'.SHOP_ID.'.png /></div><div class=remark '.$module['remark_line_height'].'>'.$remark.'</div></div>
			<img src=./plugin/barcode/buildcode.php?codebar=BCGcode128&text='.$barcode.'|'.self::format_quantity($v['quantity']).'>
        </div>
	';		
}

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
