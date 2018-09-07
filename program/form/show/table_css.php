<?php
$id=intval($_GET['id']);
if($id==0){exit('id err');}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&id='.$id;

$sql="select * from ".self::$table_pre."table where `id`=".$id;
$r=$pdo->query($sql,2)->fetch(2);
$module['data']=de_safe_str($r);
$module['monxin_table_name'].='('.$module['data']['description'].')';
if($module['data']['css_pc_bg']!=''){$module['data']['css_pc_bg']='<img class=css_pc_bg src="./program/form/img/'.$module['data']['css_pc_bg'].'" />';}
if($module['data']['css_phone_bg']!=''){$module['data']['css_phone_bg']='<img class=css_phone_bg src="./program/form/img/'.$module['data']['css_phone_bg'].'" />';}


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);	


require "./plugin/html4Upfile/createHtml4.class.php";
$html4Upfile=new createHtml4();
$html4Upfile->echo_input("css_pc_bg",'100%','./temp/','true','false','jpg|gif|png|jpeg','1024','1');
$html4Upfile->echo_input("css_phone_bg",'100%','./temp/','true','false','jpg|gif|png|jpeg','1024','1');
//echo_input("控件名称",'控件宽度(百分比或像素)','保存目录','文件夹是否附加日期','是否原名保存','允许文件后缀','文件大小 上限','文件大小 下限','指定保存名');


