<?php
if(intval(@$_GET['id'])==0){echo 'need id';return false;}
$id=intval(@$_GET['id']);
$act=@$_GET['act'];
if($act==''){echo 'need act';return false;}
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&act=".$act."&id=".$id;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

function get_express_option($pdo,$table_pre){
	$sql="select `express` from ".$table_pre."shop where `id`=".SHOP_ID;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['express']==''){return '';}
	$sql="select `id`,`name` from ".$table_pre."express where `id` in (".trim($r['express'],',').") order by `sequence` desc";
	$r=$pdo->query($sql,2);
	$list='';
	foreach($r as $v){
		$list.='<option value="'.$v['id'].'">'.$v['name'].'</option>';
	}
	return $list;	
}

if($act=='edit_quantity'){
	$sql="select * from ".self::$table_pre."order_goods where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){echo 'id err';return false;}
	$module['html']='<div class=goods_title><span class=m_label>'.self::$language['name'].'</span><span class=input>'.$r['title'].'</span></div>
	<div class=edit_goods_quantity><span class=m_label>'.self::$language['quantity'].'</span><span class=input><input style=" width:50px;" type=text value="'.self::format_quantity($r['quantity']).'" /> '.$r['unit'].' <a href="" class=submit>'.self::$language['submit'].'</a> <span class=state></span></span></div>
	';
	
			$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
	return false;
}



$sql="select * from ".self::$table_pre."order where `id`='".$id."' and `shop_id`='".SHOP_ID."' limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']==''){echo 'id err';return false;}
$module['html']='';
switch($act){
	case 'express_cost_buyer':
		if($r['state']!=0){echo self::$language['state'].':'.self::$language['order_state'][$r['state']]." ".self::$language['forbidden_modify'];return false;}
		$module['html']='<div class=express_cost_buyer><span class=m_label>'.self::$language['express_cost_buyer'].'</span><span class=input><input type=text value="'.$r['express_cost_buyer'].'" /> <a href="" class=submit>'.self::$language['submit'].'</a> <span class=state></span></span></div>';
		break;	
	case 'express_cost_seller':
		$module['html']='<div class=express_cost_seller><span class=m_label>'.self::$language['express_cost_seller'].'</span><span class=input><input type=text value="'.$r['express_cost_seller'].'" /> <a href="" class=submit>'.self::$language['submit'].'</a> <span class=state></span></span></div>';
		break;	
	case 'seller_remark':
		$module['html']='<div class=seller_remark><span class=m_label>'.self::$language['remark'].'</span><span class=input><input type=text value="'.$r['seller_remark'].'" /> <a href="" class=submit>'.self::$language['submit'].'</a> <span class=state></span></span></div>';
		break;	
	case 'actual_money':
		if($r['state']>1){echo self::$language['state'].':'.self::$language['order_state'][$r['state']]." ".self::$language['forbidden_modify'];return false;}
		$module['html']='<div class=actual_money_div>
		<span class=m_label>'.self::$language['actual_money'].'</span><span class=input><input type=text value="'.$r['actual_money'].'" id=actual_money  /></span><br />
		<span class=m_label>'.self::$language['change_price_reason'].'</span><span class=input><input type=text value="'.$r['change_price_reason'].'" id=change_price_reason  /></span><br />
		<span class=m_label>&nbsp;</span><span class=input><a href="" class=submit>'.self::$language['submit'].'</a> <span class=state></span></span>
		</div>';
		break;	
	case 'order_state_2':
		if($r['state']>2 && $r['state']!=14){echo self::$language['state'].':'.self::$language['order_state'][$r['state']]." ".self::$language['forbidden_modify'];return false;}
		$module['html']='<div class=order_state_2><div class=top_label><a show=express_div>'.self::$language['by_express'].'</a><a show=container_div>'.self::$language['by_container'].'</a></div><div class=express_div>
		<span class=m_label>'.self::$language['express'].'</span><span class=input><select id=express monxin_value="'.$r['express'].'">'.get_express_option($pdo,self::$table_pre).'</select> <a href=./index.php?monxin=mall.s_express target=_blank>'.self::$language['set'].'</a></span><br />
		<span class=m_label>'.self::$language['express_code'].'</span><span class=input><input type=text value="'.$r['express_code'].'" id=express_code  /> '.self::$language['multi_separated_by_commas'].'</span><br />
		<span class=m_label>&nbsp;</span><span class=input><a href="" class=submit>'.self::$language['submit'].'</a> <span class=state></span></span>
		</div>
		<div class=container_div>
			<textarea class=container_info placeholder="'.self::$language['container_demo'].'">'.de_safe_str($r['express_code']).'</textarea>
			<div class=submit_container_div><a href="" class=submit id=submit_container>'.self::$language['submit'].'</a> <span class=state></span></div>
		</div>
		</div>';
		break;	
	case 'receiving_extension':
		$module['html']='<div class=receiving_extension>
		<span class=m_label>'.self::$language['receiving_extension'].'</span><span class=input><input type=text value="'.$r['receiving_extension'].'" id=receiving_extension  /> '.self::$language['day'].'</span><br />
		<span class=m_label>&nbsp;</span><span class=input><a href="" class=submit>'.self::$language['submit'].'</a> <span class=state></span></span>
		</div>';
		break;	
	case 'show_bank_transfer':
		$sql="select * from ".self::$table_pre."bank_transfer where `order_id`=".$id." limit 0,1";
		$r2=$pdo->query($sql,2)->fetch(2);
		if($r2['id']==''){echo self::$language['state'].':'.self::$language['order_state'][$r['state']];return false;}
		if($r2['pay_photo']!=''){$r2['pay_photo']='<img src=./program/mall/img/'.$r2['pay_photo'].' />';}
		
		$module['html']='<div class=show_bank_transfer>'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$r2['time']).'<br />'.$r2['pay_info'].'<br />'.$r2['pay_photo'].'</div>';
		break;	
		
	case '':
		
		break;	
}

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
