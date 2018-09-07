<?php
$module['module_name']=str_replace("::","_",$method);
if(SHOP_ID==0){return false;}
$sql="select sum(`visit`) as c from ".self::$table_pre."goods where `shop_id`='".SHOP_ID."'";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['visit']=$r['c'];

$sql="select `low_inventory` from ".self::$table_pre."shop where `id`='".SHOP_ID."'";
$r=$pdo->query($sql,2)->fetch(2);
if($r['low_inventory']==''){return false;}

$sql="select count(`id`) as c from ".self::$table_pre."goods where `shop_id`='".SHOP_ID."' and `inventory`<".$r['low_inventory'];
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['low_inventory']=$r['c'];

$sql="select count(`id`) as c from ".self::$table_pre."comment where `shop_id`='".SHOP_ID."'";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['comment']=$r['c'];


$sql="select count(`id`) as c from ".self::$table_pre."order where `shop_id`='".SHOP_ID."' and `state`=0";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['order_0']=$r['c'];

$sql="select count(`id`) as c from ".self::$table_pre."order where `shop_id`='".SHOP_ID."' and `state`=1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['order_1']=$r['c'];

$sql="select count(`id`) as c from ".self::$table_pre."order where `shop_id`='".SHOP_ID."' and `state`=6";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['order_6']=$r['c'];

$sql="select count(`id`) as c from ".self::$table_pre."order where `shop_id`='".SHOP_ID."' and `state`=8";
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['order_8']=$r['c'];

$module['expiration']='';
$sql="select `expiration` from ".self::$table_pre."shop where `id`=".SHOP_ID;
$r=$pdo->query($sql,2)->fetch(2);
$notice_time=time()+$r['expiration']*86400;
$sql="select * from ".self::$table_pre."goods_batch where `shop_id`='".SHOP_ID."' and `left`>0 and `expiration`>0 and `expiration`<".$notice_time." order by `expiration` asc limit 0,5";
$r=$pdo->query($sql,2);
foreach($r as $v){
	$sql="select `id`,`title`,`option_enable`,`unit`,`icon` from ".self::$table_pre."goods where `id`=".intval($v['goods_id']);
	$goods=$pdo->query($sql,2)->fetch(2);
	if($goods['option_enable']){
		$temp=explode('_',$v['goods_id']);
		if(isset($temp[1])){
			$sql="select `option_id`,`color_name` from ".self::$table_pre."goods_specifications where `id`=".$temp[1];
			$s=$pdo->query($sql,2)->fetch(2);
			$goods['title'].='<span class=option>'.self::get_type_option_name($pdo,$s['option_id']).' '.$s['color_name'].'</span>';				
		}else{
			continue;
		}
	}
	$unit=self::get_mall_unit_name($pdo,$goods['unit']);
	$module['expiration'].='<tr>
	<td><a href=./index.php?monxin=mall.shelf_life class=goods_info><img src=./program/mall/img_thumb/'.$goods['icon'].' /><span>'.$goods['title'].'</span></a></td>
	<td>'.self::format_quantity($v['left']).' '.$unit.'</td>
	<td>'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['expiration']).'</td>
	</tr>';	
}

if($module['expiration']){
	$module['expiration']='<table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="'.$module['module_name'].'_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td class=goods_td>'.self::$language['goods'].'</td>
                <td  class=left_td>'.self::$language['left'].'</td>
                <td  class=expiration_td>'.self::$language['expiration'].'</td>
            </tr>
        </thead>
        <tbody>'.$module['expiration'].'</tbody>
    </table>';	
}

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);