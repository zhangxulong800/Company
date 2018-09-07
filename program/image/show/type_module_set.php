<?php
if(@$_GET['args']==''){echo 'need args';return false;}
if(@$_GET['url']==''){echo 'need url';return false;}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$attribute=format_attribute($_GET['args']);
$module=array_merge($module,$attribute);
$all=array('title'=>self::$language['title'],'src'=>self::$language['image'],'visit'=>self::$language['visit_count'],'time'=>self::$language['update_time']);
$module['action_url']="receive.php?target=index::edit_page_layout&act=update_attribute&old_module=image.type_module".$_GET['args'].'&url='.$_GET['url'].'&new_module=image.type_module';


$module['sequence_field_option']='
<option value="sequence">'.self::$language['sequence_value'].'</option>
<option value="id">'.self::$language['add_time'].'</option>
';
$module['sequence_field_type']='<option value="desc">'.self::$language['max_to_min'].'</option>
<option value="asc">'.self::$language['min_to_max'].'</option>';
$module['data_src_option']=$this->get_parent($pdo);

$module['target_option']=get_select_value($pdo,'target',$attribute['target']);
		
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);