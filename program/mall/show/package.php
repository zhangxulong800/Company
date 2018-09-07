<?php
$id=intval(@$_GET['id']);
if($id==0){return not_find();}
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&id=".$id;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$sql="select * from ".self::$table_pre."package where `id`='".$id."'";
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']==''){return not_find();}
if(!($r['discount']>0)){echo self::$language['not_set'].self::$language['discount_rate']; return false;}
$discount=$r['discount'];
$free_shipping=$r['free_shipping'];
if($r['goods_ids']==''){echo self::$language['not_set'].self::$language['goods']; return false;}

function get_option_html($language,$pdo,$table_pre,$id){
	//get_option_html====================================================================================================================================
	$module['option_html']='';
	$sql="select `option_id` from ".$table_pre."goods_specifications where `goods_id`='".$id."' and `option_id`!='0' group by `option_id`";
	$r=$pdo->query($sql,2);
	$ids='';
	foreach($r as $v){
		$ids.=$v['option_id'].',';
	}
	$ids=trim($ids,',');
	if($ids!=''){
		$sql="select `id`,`type_id`,`name` from ".$table_pre."type_option where `id` in (".$ids.") order by `sequence` desc";
		$r=$pdo->query($sql,2);
		$list='';
		foreach($r as $v){
			$list.='<a href="#" id=option_'.$v['id'].'>'.$v['name'].'</a>';
			$type_id=$v['type_id'];
		}
		if($list!=''){
			$sql="select `option_name` from ".$table_pre."type where `id`=".$type_id;
			$r=$pdo->query($sql,2)->fetch(2);
			$module['option_html'].='<div class=option_line_div><div class=option_label>'.$r['option_name'].'</div><div class=option_option value=0>'.$list.'</div></div>';
		}
	}
	
	$sql="select `color_id`,`option_id`,`id`,`w_price`,`quantity` from ".$table_pre."goods_specifications where `goods_id`='".$id."'";
	$r=$pdo->query($sql,2);
	$list=array();
	$module['inventory']=0;
	foreach($r as $v){
		$list[$v['id']]['color_id']=$v['color_id'];
		$list[$v['id']]['option_id']=$v['option_id'];
		$list[$v['id']]['w_price']=$v['w_price'];
		//$list[$v['id']]['quantity']=self::format_quantity($v['quantity']);
		
		$v['quantity']=sprintf("%.3f",$v['quantity']);
		$v['quantity']=rtrim($v['quantity'],'0');
		$v['quantity']=rtrim($v['quantity'],'0');
		$v['quantity']=rtrim($v['quantity'],'.');
		
		$list[$v['id']]['quantity']=$v['quantity'];
		$module['inventory']+=$v['quantity'];
	}
	$module['specifications']='';
	if(count($list)!=0){$_POST['specifications']=json_encode($list);}else{$_POST['specifications']='';}
	$list='';
	
	
	
	$sql="select `color_id`,`color_name`,`color_show`,`color_img` from ".$table_pre."goods_specifications where `goods_id`='".$id."' and `color_id`!='0' group by `color_id` order by `color_img` desc,`color_show` asc,`quantity` desc";
	$r=$pdo->query($sql,2);
	$list='';
	foreach($r as $v){
		$temp='';
		if($v['color_img']==''){
			if($v['color_show']==0){
				$temp='<img src="./program/mall/color_icon/'.$v['color_id'].'.png" />';	
			}else{
				$temp='<span class=color_name>'.$v['color_name'].'</span>';	
			}
		}else{
			$temp='<img src="./program/mall/img_thumb/'.$v['color_img'].'" />';	
		}
		$list.='<a href="#" id=color_'.$v['color_id'].' title="'.$v['color_name'].'">'.$temp.'</a>';	
	}
	if($list!=''){$module['option_html'].='<div class=color_line_div><div class=color_label>'.$language['color'].'</div><div class=color_option value=0>'.$list.'</div></div>';}
	return $module['option_html'];


}

$temp=explode(',',$r['goods_ids']);


$sql="select `id`,`title`,`icon`,`w_price`,`min_price`,`max_price`,`unit`,`sales_promotion`,`inventory`,`option_enable` from ".self::$table_pre."goods where `id` in (".$r['goods_ids'].") and `state`!=0";
$r=$pdo->query($sql,2);
$module['list']='';
$goods_info=array();
foreach($r as $v){
	$v=de_safe_str($v);
	$v['w_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['w_price']);
	$v['min_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['min_price']);
	$v['max_price']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['max_price']);
	
	if($v['option_enable']){
		$normal_price=$v['min_price'].'-'.$v['max_price'];
		$discount_price=sprintf("%.2f",$v['min_price']*$discount/10).'-'.sprintf("%.2f",$v['max_price']*$discount/10);
	}else{
		$normal_price=$v['w_price'];
		$discount_price=sprintf("%.2f",$v['w_price']*$discount/10);
	}
	$goods_info[$v['id']]='<div class=g id=g_'.$v['id'].' spec=0 discount="'.$discount.'"><div class=color_selected_symbol>&nbsp;</div><div class=option_selected_symbol>&nbsp;</div><a href="./index.php?monxin=mall.goods&id='.$v['id'].'" target=_balnk class=icon><img src="./program/mall/img_thumb/'.$v['icon'].'" /></a><span class=other><span class=title>'.$v['title'].'</span><span class=price_inventory><span class=normal><span class=m_label>'.self::$language['normal_price'].'</span><span class=value value="'.$normal_price.'">'.$normal_price.'</span><span class=money_symbol>'.self::$language['yuan'].'</span></span><span class=discount><span class=m_label>'.self::$language['package_price'].'</span><span class=value value="'.$discount_price.'">'.$discount_price.'</span><span class=money_symbol>'.self::$language['yuan'].'</span></span> <span class=inventory><span class=m_label>'.self::$language['inventory'].'</span><span class=value value='.self::format_quantity($v['inventory']).'>'.self::format_quantity($v['inventory']).'</span><span class=unit>'.self::get_mall_unit_name($pdo,$v['unit']).'</span></span></span><div class=spec>'.get_option_html(self::$language,$pdo,self::$table_pre,$v['id']).'<span class=json>'.@$_POST['specifications'].'</span></div></span></div>';
	
	
	
}
foreach($temp as $v){
	$module['list'].=@$goods_info[$v];	
}



$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
echo '<div id="visitor_position_reset" style="display:none;"><span id=current_position_text>'.self::$language['current_position'].'</span><a href="./index.php"><span id=visitor_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a>'.self::$language['pages']['mall.package']['name'].'</div>';
		