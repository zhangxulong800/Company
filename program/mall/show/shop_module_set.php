<?php
if(@$_GET['args']==''){echo 'need args';return false;}
if(@$_GET['url']==''){echo 'need url';return false;}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$attribute=format_attribute($_GET['args']);
$module=array_merge($module,$attribute);

$module['action_url']="receive.php?target=index::edit_page_layout&act=update_attribute&old_module=mall.shop_module".$_GET['args'].'&url='.$_GET['url'].'&new_module=mall.shop_module';
$module['action_url_img']="receive.php?target=".$method;


$module['tags']=self::get_tag_html($pdo);
$module['store_tags']=self::get_store_tag_html($pdo);
$module['circle_option']=get_circle_option($pdo);
$module['sequence_field_option']='
<option value="deposit">'.self::$language['deposit'].'</option>
<option value="sequence">'.self::$language['sequence_value'].'</option>
<option value="id">'.self::$language['shop_join_time'].'</option>
<option value="goods">'.self::$language['shop_goods'].'</option>
<option value="order">'.self::$language['shop_order'].'</option>
<option value="money">'.self::$language['shop_money'].'</option>
';

$module['sequence_field_type']='<option value="desc">'.self::$language['max_to_min'].'</option>
<option value="asc">'.self::$language['min_to_max'].'</option>';
$module['data_src_option']=$this->get_parent($pdo);

$module['target_option']=get_select_value($pdo,'target',$attribute['target']);
$all=array('unit'=>self::$language['goods_unit'],'normal_price'=>self::$language['original_price'],'multi_angle_img'=>self::$language['multi_angle_img']);
$module['field_checkbox']=get_field_checkbox(@$attribute['field'],$all);


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
