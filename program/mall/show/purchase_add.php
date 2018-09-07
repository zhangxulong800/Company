<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$id=intval(@$_GET['id']);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&id='.$id;

$sql="select * from ".self::$table_pre."goods where `id`=".$id;
$module['data']=$pdo->query($sql,2)->fetch(2);
if($module['data']['id']==''){
	
}

$module['data']['cost_price']=self::get_cost_price_new($pdo,$id);
$module['data']['inventory']=self::format_quantity(@$module['data']['inventory']);
$module['data']['supplier']='<select class=supplier monxin_value="'.@$module['data']['supplier'].'">'.self::get_goods_supplier_option($pdo).'</select>';
$module['goods_option']='';

if(isset($module['data']['id'])){
	$module['data']['unit']=self::get_mall_unit_name($pdo,$module['data']['unit']);
	
	if($module['data']['option_enable']){
		$option=array();
		$sql="select `id`,`option_id`,`color_name`,`id`,`cost_price`,`quantity` from ".self::$table_pre."goods_specifications where `goods_id`=".$id;
		$r=$pdo->query($sql,2);
		$module['add_option']='';
		$new_cost_price2=0;
		foreach($r as $v){
			if($new_cost_price2==0){$new_cost_price2=self::get_cost_price_new_2($pdo,$id.'_'.$v['id']);$module['data']['inventory']=self::format_quantity($v['quantity']);}
			$v['cost_price']=self::get_cost_price_new($pdo,$id.'_'.$v['id']);
			$module['data']['cost_price']=$new_cost_price2;
			$option_name='';
			$v['quantity']=self::format_quantity($v['quantity']);
			$option_name=self::get_type_option_name($pdo,$v['option_id']);
			$option[$v['id']]='<td>'.$v['color_name'].' '.$option_name.'</td>';
			$module['add_option'].='<option value="'.$v['id'].'" cost_price='.$v['cost_price'].'  quantity='.$v['quantity'].'>'.$v['color_name'].' '.$option_name.'</option>';	
		}
		$module['goods_option']='<div class=line><span class=m_label>'.self::$language['option'].'</span><span class=m_value><select id=option_id name=option_id><option value="" cost_price='.$new_cost_price2.' >'.self::$language['please_select'].'</option><option value=0 cost_price='.$new_cost_price2.' >--'.self::$language['each'].self::$language['option'].'--</option>'.$module['add_option'].'</select></span></div>';
	}
}
$min_time=time()-(86400*3);
$sql="select `name` from ".self::$table_pre."purchase where `shop_id`=".SHOP_ID." and `time`>".$min_time." order by `id` desc limit 0,10";
$r=$pdo->query($sql,2);
$module['purchase_option']='';
$this_day=date('Ymd');
$find=false;
foreach($r as $v){
	$v['name']=de_safe_str($v['name']);
	if($v['name']==$this_day){$find=true;}
	$module['purchase_option'].='<option value="'.$v['name'].'">'.$v['name'].'</option>';
}
if(!$find){$module['purchase_option']='<option value="'.$this_day.'">'.$this_day.'</option>'.$module['purchase_option'];}
$module['storehouse']=self::get_goods_storehouse_option($pdo);


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);