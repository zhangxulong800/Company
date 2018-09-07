<?php
if(@$_GET['args']==''){echo 'need args';return false;}
if(@$_GET['url']==''){echo 'need url';return false;}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$attribute=format_attribute($_GET['args']);
$module=array_merge($module,$attribute);
$module['action_url']="receive.php?target=index::edit_page_layout&act=update_attribute&old_module=ci.list_module".$_GET['args'].'&url='.$_GET['url'].'&new_module=ci.list_module';
$module['action_url_img']="receive.php?target=".$method;


$all=array('icon'=>self::$language['image'],'title'=>self::$language['title'],'price'=>self::$language['price'],'reflash'=>self::$language['update_time'],'linkman'=>self::$language['linkman'],'contact'=>self::$language['contact']);
$id=intval($attribute['id']);
if($id>0){
	$sql="select `id`,`name` from ".self::$table_pre."type_attribute where `type_id`=".$id." order by `sequence` desc,`id` asc";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$all[$v['id']]=$v['name'];	
	}
}


$module['field_checkbox']=get_field_checkbox($attribute['field'],$all);


$module['tags']=self::get_tag_html($pdo);
$module['sequence_field_option']='
<option value="sequence">'.self::$language['sequence_value'].'</option>
<option value="id">'.self::$language['add_time'].'</option>
<option value="reflash">'.self::$language['reflash_time'].'</option>
<option value="top_price">'.self::$language['top_price'].'</option>
<option value="visit">'.self::$language['visit_count'].'</option>
';

$module['sequence_field_type']='<option value="desc">'.self::$language['max_to_min'].'</option>
<option value="asc">'.self::$language['min_to_max'].'</option>';
$module['data_src_option']=$this->get_parent($pdo);

$module['target_option']=get_select_value($pdo,'target',$attribute['target']);
$module['img_link']=str_replace('*','.',@$module['img_link']);
$module['img_link']=str_replace('!',':',$module['img_link']);

if(@$module['img']!=''){
	$module['img']=str_replace('*','.',$module['img']);
	$module['img_show']='<a href="./program/ci/img/'.$module['img'].'" target="_blank" class=show_img><img src="./program/ci/img/'.$module['img'].'" ></a> <a href=# class=del>'.self::$language['del'].'</a>';	
}else{
	$module['img_show']='';
}

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);

require "./plugin/html4Upfile/createHtml4.class.php";
$html4Upfile=new createHtml4();
$html4Upfile->echo_input("img_file",'500px','./temp/','true','false','jpg|gif|png|jpeg','1024','1');
//echo_input("控件名称",'控件宽度(百分比或像素)','保存目录','文件夹是否附加日期','是否原名保存','允许文件后缀','文件大小 上限','文件大小 下限','指定保存名');
//指定保存名时，要先设置权限 $_SESSION['replace_file']=true;  ，否则将无效
