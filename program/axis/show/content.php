<?php
$id=intval(@$_GET['id']);
$axis_id=intval(@$_GET['axis_id']);
if($id>0){
	$sql="select * from ".self::$table_pre."log where `id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	$module['data']=de_safe_str($r);
	if($module['data']['icon']!=''){$module['data']['icon']='./program/axis/img/'.$module['data']['icon'];}
	$module['data']['date']=get_date($module['data']['date'],self::$config['other']['date_style']." H:i:s",self::$config['other']['timeoffset']);

}else{
	$module['data']['date']=get_date(time(),self::$config['other']['date_style']." H:i:s",self::$config['other']['timeoffset']);	
}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&axis_id=".$axis_id."&id=".$id;
$module['class_name']=self::$config['class_name'];
$module['web_language']=self::$config['web']['language'];

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);

require "./plugin/html4Upfile/createHtml4.class.php";
$html4Upfile=new createHtml4();

$html4Upfile->echo_input("icon",'auto','./temp/','true','false','jpg|png','1024','1');
//echo_input("控件名称",'控件宽度(百分比或像素)','保存目录','文件夹是否附加日期','是否原名保存','允许文件后缀','文件大小 上限','文件大小 下限','指定保存名');
//指定保存名时，要先设置权限 $_SESSION['replace_file']=true;  ，否则将无效
