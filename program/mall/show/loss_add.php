<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$id=intval(@$_GET['id']);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&id='.$id;

$sql="select * from ".self::$table_pre."goods where `id`=".$id;
$module['data']=$pdo->query($sql,2)->fetch(2);
if($module['data']['id']==''){
	
}


$module['data']['inventory']=self::format_quantity(@$module['data']['inventory']);

$module['data']['supplier']='<select class=supplier monxin_value="'.@$module['data']['supplier'].'">'.self::get_goods_supplier_option($pdo).'</select>';
$module['goods_option']='';
$module['loss_reason_option']='';

if(isset($module['data']['id'])){
	$module['data']['unit']=self::get_mall_unit_name($pdo,$module['data']['unit']);
	if($module['data']['option_enable']){
		$option=array();
		$sql="select `option_id`,`color_name`,`id`,`cost_price`,`quantity` from ".self::$table_pre."goods_specifications where `goods_id`=".$id;
		$r=$pdo->query($sql,2);
		$module['add_option']='';
		foreach($r as $v){
			$option_name='';
			$option_name=self::get_type_option_name($pdo,$v['option_id']);
			$option[$v['id']]='<td>'.$v['color_name'].' '.$option_name.'</td>';
			$module['add_option'].='<option value="'.$v['id'].'" cost_price='.$v['cost_price'].' quantity='.self::format_quantity($v['quantity']).'>'.$v['color_name'].' '.$option_name.'</option>';	
		}
		$module['data']['inventory']=self::format_quantity($v['quantity']);
		$module['goods_option']='<div class=line><span class=m_label>'.self::$language['option'].'</span><span class=m_value><select id=option_id name=option_id><option value="">'.self::$language['please_select'].'</option>'.$module['add_option'].'</select> <span class=state></span></span></div>';
	
		
	}
	
	$sql="select `reason` from ".self::$table_pre."goods_loss where `goods_id`=".$id." group by `reason` order by `id` desc limit 0,10";
	$r=$pdo->query($sql,2);
	$i=0;
	foreach($r as $v){
		$v['reason']=de_safe_str($v['reason']);
		$module['loss_reason_option'].='<option value="'.$v['reason'].'">'.$v['reason'].'</option>';
		$i++;	
	}

	if($i<10){
		$sql="select `reason` from ".self::$table_pre."goods_loss where `goods_id`!=".$id." group by `reason` order by `id` desc limit 0,".(10-$i);
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			$v['reason']=de_safe_str($v['reason']);
			$module['loss_reason_option'].='<option value="'.$v['reason'].'">'.$v['reason'].'</option>';
		}
	}
	if($module['loss_reason_option']!=''){$module['loss_reason_option'].='<option value="0">'.self::$language['other'].'</option>';}
}




$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);