<?php
if(@$_GET['args']==''){echo 'need args';return false;}
if(@$_GET['url']==''){echo 'need url';return false;}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$attribute=format_attribute($_GET['args']);
$module=array_merge($module,$attribute);
$all=array('title'=>self::$language['title'],'visit'=>self::$language['visit_count'],'time'=>self::$language['update_time']);
$module['field_checkbox']=get_field_checkbox($attribute['field'],$all);
$module['action_url']="receive.php?target=index::edit_page_layout&act=update_attribute&old_module=diypage.show_page_list".$_GET['args'].'&url='.$_GET['url'].'&new_module=diypage.show_page_list';


$module['sequence_field_option']='
<option value="sequence">'.self::$language['sequence_value'].'</option>
<option value="id">'.self::$language['add_time'].'</option>
<option value="time">'.self::$language['update_time'].'</option>
<option value="visit">'.self::$language['visit_count'].'</option>
';
if(field_exist($pdo,self::$table_pre.'page','discuss_msg')){
	$module['sequence_field_option'].='<option value="discuss_msg">'.self::$language['discuss_msg_count'].'</option>';	
}
if(field_exist($pdo,self::$table_pre.'page','discuss_high')){
	$module['sequence_field_option'].='<option value="discuss_high">'.self::$language['discuss_high_count'].'</option>';	
}
if(field_exist($pdo,self::$table_pre.'page','discuss_medium')){
	$module['sequence_field_option'].='<option value="discuss_medium">'.self::$language['discuss_medium_count'].'</option>';	
}
if(field_exist($pdo,self::$table_pre.'page','discuss_low')){
	$module['sequence_field_option'].='<option value="discuss_low">'.self::$language['discuss_low_count'].'</option>';	
}

$module['sequence_field_type']='<option value="desc">'.self::$language['max_to_min'].'</option>
<option value="asc">'.self::$language['min_to_max'].'</option>';
$module['data_src_option']=$this->get_parent($pdo);

$module['target_option']=get_select_value($pdo,'target',$attribute['target']);
		
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);	