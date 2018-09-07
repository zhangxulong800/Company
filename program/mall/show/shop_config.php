<?php
$sql="select * from ".self::$table_pre."shop where `username`='".$_SESSION['monxin']['username']."' and `state`=2 order by `id` desc limit 0,1";
$module=$pdo->query($sql,2)->fetch(2);
if($module['id']==''){echo 'no shop';return false;}
$module['run_type_old']=$module['run_type'];
$module['run_type']=self::$language['run_type'][$module['run_type']];
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['host']=str_replace('www.','',self::$config['web']['domain']);
$module['template_option']='';
$sql="select `dir`,`name` from ".self::$table_pre."template where `state`=1 and (`for_shop`='*' or `for_shop`='".$module['id']."') order by `sequence` desc";
$r=$pdo->query($sql,2);
foreach($r as $v){
	$module['template_option'].='<option value="'.$v['dir'].'">'.$v['name'].'</option>';	
}

$module['talk_option']=self::get_talk_option($pdo,self::$table_pre);
$module['circle_option']=get_circle_option($pdo);
$module['map_api']=self::$config['web']['map_api'];

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);

require "./plugin/html4Upfile/createHtml4.class.php";
$html4Upfile=new createHtml4();
$html4Upfile->echo_input("icon",'100%','./temp/','true','false','jpg|gif|png|jpeg','2048','1');

$html4Upfile->echo_input("ticket_logo",'100%','./temp/','true','false','jpg|gif|png|jpeg','2048','1');

$html4Upfile->echo_input("wxkf",'100%','./temp/','true','false','jpg|gif|png|jpeg','2048','1');
//echo_input("控件名称",'控件宽度(百分比或像素)','保存目录','文件夹是否附加日期','是否原名保存','允许文件后缀','文件大小 上限','文件大小 下限','指定保存名');
//指定保存名时，要先设置权限 $_SESSION['replace_file']=true;  ，否则将无效
