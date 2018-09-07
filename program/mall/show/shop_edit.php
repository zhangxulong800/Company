<?php
if(intval(@$_GET['id'])==0){echo 'need id';return false;}
$id=intval(@$_GET['id']);

$sql="select * from ".self::$table_pre."shop where `id`=".$id;
$module=$pdo->query($sql,2)->fetch(2);
if($module['id']==''){echo 'id err';return false;}

$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&id=".$id;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['map_api']=self::$config['web']['map_api'];

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);

require "./plugin/html4Upfile/createHtml4.class.php";
$html4Upfile=new createHtml4();
$html4Upfile->echo_input("icon",'100%','./temp/','true','false','jpg|gif|png|jpeg','2048','1');
$html4Upfile->echo_input("certificate",'100%','./temp/','true','false','jpg|gif|png|jpeg','2048','1');
$html4Upfile->echo_input("self_certificate",'100%','./temp/','true','false','jpg|gif|png|jpeg','2048','1');
//echo_input("控件名称",'控件宽度(百分比或像素)','保存目录','文件夹是否附加日期','是否原名保存','允许文件后缀','文件大小 上限','文件大小 下限','指定保存名');
//指定保存名时，要先设置权限 $_SESSION['replace_file']=true;  ，否则将无效
