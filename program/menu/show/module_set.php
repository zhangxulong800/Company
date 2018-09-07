<?php
if(@$_GET['args']==''){echo 'need args';return false;}
if(@$_GET['url']==''){echo 'need url';return false;}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$attribute=format_attribute($_GET['args']);
$module=array_merge($module,$attribute);
$module['action_url']="receive.php?target=index::edit_page_layout&act=update_attribute&old_module=menu.module".$_GET['args'].'&url='.$_GET['url'].'&new_module=menu.module';
$module['action_url_img']="receive.php?target=".$method;

$module['data_src_option']='<option value="0">'.self::$language['top_menu'].'</option>';
$sql="select `id`,`name` from ".self::$table_pre."menu where `visible`=1 and `parent_id`=0 order by `sequence` desc";
$r=$pdo->query($sql,2);
foreach($r as $v){
	$module['data_src_option'].='<option value="'.$v['id'].'">'.$v['name'].' '.self::$language['sub_menu'].'</option>';	
}

if(@$module['bg']!=''){
	$module['bg']=str_replace('*','.',$module['bg']);
	$module['img_show']='<a href="./program/0/menu/bg/'.$module['bg'].'" target="_blank" class=show_img><img src="./program/0/menu/bg/'.$module['bg'].'" ></a>';	
}else{
	$module['img_show']='';
}

$r=scandir('./templates/0/menu/');
$module['template_option']='';
foreach($r as $vv){
	if(is_dir('./templates/0/menu/'.$vv)  && $vv!='.' && $vv!='..'){
		$i=get_txt_info('./templates/0/menu/'.$vv.'/info.txt');
		$module['template_option'].='<option value="'.$vv.'">'.$i["name"].'</option>';	
	}	
}

		
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);

require "./plugin/html4Upfile/createHtml4.class.php";
$html4Upfile=new createHtml4();
$html4Upfile->echo_input("bg_file",'500px','./temp/','true','false','jpg|gif|png|jpeg','1024','1');
//echo_input("控件名称",'控件宽度(百分比或像素)','保存目录','文件夹是否附加日期','是否原名保存','允许文件后缀','文件大小 上限','文件大小 下限','指定保存名');
//指定保存名时，要先设置权限 $_SESSION['replace_file']=true;  ，否则将无效
