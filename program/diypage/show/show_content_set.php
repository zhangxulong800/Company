<?php
	if(@$_GET['args']==''){echo 'need args';return false;}
	if(@$_GET['url']==''){echo 'need url';return false;}
	$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
	$_GET['search']=safe_str(@$_GET['search']);
	$_GET['search']=trim($_GET['search']);
	$sql="select `id`,`title` from ".self::$table_pre."page";
	$where="";
	if($_GET['search']!=''){$where=" where (`title` like '%".$_GET['search']."%' or `content` like '%".$_GET['search']."%')";}
	$sql.=$where." limit 0,20";
	//echo $sql;
	$r=$pdo->query($sql,2);
	$list='';
	foreach($r as $v){
		$v=de_safe_str($v);
		$list.="<option value=".$v['id'].">".$v['title']."</option>";	
	}
if($list==''){$list='<option value="-1">'.self::$language['no_related_content'].'</option>';}		

$attribute=format_attribute($_GET['args']);
$module=array_merge($module,$attribute);

$all=array('title'=>self::$language['title'],'content'=>self::$language['content']);
$module['field_checkbox']=get_field_checkbox($attribute['field'],$all);
$module['action_url']="receive.php?target=index::edit_page_layout&act=update_attribute&old_module=diypage.show_content".$_GET['args'].'&url='.$_GET['url'].'&new_module=diypage.show_content';


$module['data_src_option']=$list;
		
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);	