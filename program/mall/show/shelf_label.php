<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$ids=safe_str(@$_GET['ids']);
$ids=str_replace('|',',',$ids);
$ids=trim($ids,',');
$module['shop_id']=SHOP_ID;

$module['composing_option']='<a composing=4_2>4x2</a><a composing=7_2>7x2</a>';

//获取店内第一个用户组ID
$sql="select `id`,`discount` from ".self::$table_pre."shop_buyer_group where `shop_id`=".SHOP_ID." limit 0,1";
$group=$pdo->query($sql,2)->fetch(2);


$sql="select `id`,`title`,`bar_code`,`grade`,`contain`,`unit`,`habitat`,`e_price`,`discount`,`discount_start_time`,`discount_end_time`,`option_enable` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and `state`=2 and `id` in (".$ids.")";
if($ids==''){
$sql="select `id`,`title`,`bar_code`,`grade`,`contain`,`unit`,`habitat`,`e_price`,`discount`,`discount_start_time`,`discount_end_time`,`option_enable` from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and `state`=2";
}

$r=$pdo->query($sql,2);

if(!isset($_GET['composing'])){$_GET['composing']='4_2';}
$temp=explode('_',$_GET['composing']);

$page_size=$temp[0]*$temp[1];
$pages=array();
$page=1;
$i=1;
$pages[$page]='';
foreach($r as $v){
	$v=de_safe_str($v);
	if( $v['grade']=='0' || $v['grade']=='-1' || $v['grade']==''){$v['grade']='&nbsp;';}
	if($v['contain']=='0'  || $v['contain']=='-1'  || $v['contain']==''){$v['contain']='&nbsp;';}
	if($v['habitat']=='0'  || $v['habitat']=='-1' || $v['habitat']==''){$v['habitat']='&nbsp;';}
	if($v['unit']!=0){$v['unit']=self::get_mall_unit_name($pdo,$v['unit']);}else{$v['unit']='&nbsp;';}
	
	//箱价
	$sql="select `big`,`quantity` from ".self::$table_pre."public_stock where `small`=".$v['id']." and `quantity`>1 limit 0,1";
	$big=$pdo->query($sql,2)->fetch(2);
	if($big['big']!=''){
		$sql="select `e_price`,`option_enable`,`id` from ".self::$table_pre."goods where `id`=".$big['big'];
		$r2=$pdo->query($sql,2)->fetch(2);
		if($r2['id']!=''){
			if($r2['option_enable']==0){
				$v['big_price']=$r2['e_price'];
			}else{
				$sql="select `e_price`,`id` from ".self::$table_pre."goods_specifications where `goods_id`=".$big['big']." limit 0,1";
				$r2=$pdo->query($sql,2)->fetch(2);
				if($r2['id']!=''){$v['big_price']=$r2['e_price'];}
			}
		}
		
	}
	if(!isset($v['big_price'])){$v['big_price']='&nbsp;';}else{$v['big_price'].=self::$language['yuan'].' '.$big['quantity'].$v['unit'];}
	
	//店内会员价
	if($group['id']){
		$sql="select `discount` from ".self::$table_pre."goods_group_discount where `goods_id`=".$v['id']." and `group_id`=".$group['id']." limit 0,1";
		$r2=$pdo->query($sql,2)->fetch(2);
		$g_discount=$group['discount'];
		if($r2['discount']){$g_discount=$r2['discount'];}
	}else{$g_discount=10;}
	
	
	
	if($v['discount']<10){
		$v['discount']=trim($v['discount'],'0').self::$language['discount'];
		$v['duration']=ltrim(date('m月d日',$v['discount_start_time']),'0').'-'.ltrim(date('m月d日',$v['discount_end_time']),'0');
	}else{
		$v['discount']='&nbsp;';
		$v['duration']='&nbsp;';
	}
	
	if($v['option_enable']==0){
		$pages[$page].='<div class=goods><div class=bar_code><img src="http://'.self::$config['web']['domain'].'/plugin/barcode/buildcode.php?codebar=BCGcode128&text='.$v['bar_code'].'" /></div><div class=name>'.$v['title'].'</div><div class=other>
								<div class=grade>'.$v['grade'].'</div>
								<div class=habitat>'.$v['habitat'].'</div>
								<div class=contain>'.$v['contain'].'</div>
</div><div class=price_qr><div class=price_div>
								<div class=big_price>'.self::$language['money_symbol'].$v['big_price'].'</div>
								<div class=price>'.self::$language['money_symbol'].$v['e_price'].'</div>
								<div class=group_price>'.self::$language['money_symbol'].(price_decimal_html(sprintf("%.2f",$v['e_price']*$g_discount/10))).'<span class=unit>/'.$v['unit'].'</span></div>
</div><div class=qr><img src="plugin/qrcode/?text='.str_replace('&','|||','http://'.self::$config['web']['domain'].'/index.php?monxin=mall.goods&id='.$v['id'].'').'" /></div></div></div>';
		$i++;
	}else{
		$sql="select `color_name`,`option_id`,`barcode`,`e_price` from ".self::$table_pre."goods_specifications where `goods_id`=".$v['id'];
		$r2=$pdo->query($sql,2);
		foreach($r2 as $v2){
			
			$pages[$page].='<div class=goods><div class=bar_code><img src="http://'.self::$config['web']['domain'].'/plugin/barcode/buildcode.php?codebar=BCGcode128&text='.$v2['barcode'].'" /></div><div class=name>'.$v['title'].'</div><div class=other>
								<div class=grade>'.$v['grade'].'</div>
								<div class=habitat>'.$v['habitat'].'</div>
								<div class=contain>'.self::get_type_option_name($pdo,$v2['option_id']).' '.$v2['color_name'].'</div>
</div><div class=price_qr><div class=price_div>
								<div class=big_price>'.self::$language['money_symbol'].$v['big_price'].'</div>
								<div class=price>'.self::$language['money_symbol'].$v2['e_price'].'</div>
								<div class=group_price>'.self::$language['money_symbol'].(price_decimal_html(sprintf("%.2f",$v2['e_price']*$g_discount/10))).'<span class=unit>/'.$v['unit'].'</span></div>

</div><div class=qr><img src="plugin/qrcode/?text='.str_replace('&','|||','http://'.self::$config['web']['domain'].'/index.php?monxin=mall.goods&id='.$v['id'].'').'" /></div></div></div>';
			$i++;
		}
	}
	
	if($i>$page_size){
		$pages[$page]='<div class=print_content>'.$pages[$page].'</div>';
		$i=1;$page++;$pages[$page]='';
	
	}	
}
if($i<=$page_size){$pages[$page]='<div class=print_content>'.$pages[$page].'</div>';}

$module['list']='';

foreach($pages as $v){
	$module['list'].=$v;	
}


$path='./program/mall/shelf_label/'.SHOP_ID.'_'.$_GET['composing'].'.png';
if(!is_file($path)){copy('./program/mall/shelf_label/default_'.$_GET['composing'].'.png',$path);}

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'_'.$_GET['composing'].'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'_'.$_GET['composing'].'.php';}
require($t_path);
require "./plugin/html4Upfile/createHtml4.class.php";
$html4Upfile=new createHtml4();
$html4Upfile->echo_input("shelf_label",'auto','./temp/','false','false','jpg|png',1024*10,'1');
//echo_input("控件名称",'控件宽度(百分比或像素)','保存目录','文件夹是否附加日期','是否原名保存','允许文件后缀','文件大小 上限','文件大小 下限','指定保存名');
//指定保存名时，要先设置权限 $_SESSION['replace_file']=true;  ，否则将无效
