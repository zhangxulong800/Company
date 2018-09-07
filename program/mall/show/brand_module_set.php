<?php
if(@$_GET['args']==''){echo 'need args';return false;}
if(@$_GET['url']==''){echo 'need url';return false;}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$attribute=format_attribute($_GET['args']);
$module=array_merge($module,$attribute);
$module['action_url']="receive.php?target=index::edit_page_layout&act=update_attribute&old_module=mall.brand_module".$_GET['args'].'&url='.$_GET['url'].'&new_module=mall.brand_module';
$module['action_url_img']="receive.php?target=".$method;

$module['data_src_option']='<option value="0">'.self::$language['top_menu'].'</option>';
$sql="select `id`,`name` from ".self::$table_pre."brand where `visible`=1 and `parent`=0 order by `sequence` desc";
$r=$pdo->query($sql,2);
foreach($r as $v){
	$module['data_src_option'].='<option value="'.$v['id'].'">'.$v['name'].' '.self::$language['sub_menu'].'</option>';	
}

		
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
