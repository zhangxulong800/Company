<?php
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['class_name']=self::$config['class_name'];
$module['web_language']=self::$config['web']['language'];
$module['type_option']='<option value="">'.self::$language['please_select'].'</option>';
$dir="./scanpay_type/";
$r=scandir($dir);
foreach($r as $v){
	if(is_dir($dir.$v) && $v!='.' && $v!='..'){
		if(!is_file($dir.$v.'/config.php')){ continue;}
		$xx=require($dir.$v.'/config.php');
		if($config['state']=='opening'){
			//$module['type_option'].="<a href=# payment=".$v." class='payment'><img src='".$dir.$v."/".$config['provider_icon']."' alt='".$config['provider_name']."' title='".$config['provider_name']."'></a>";
			$module['type_option'].='<option value="'.$v.'">'.$config['provider_name'].'</option>';
		}
	}
}

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);

require "./plugin/html4Upfile/createHtml4.class.php";
$html4Upfile=new createHtml4();
$html4Upfile->echo_input("banner",'60%','./temp/','true','false','jpg|gif|png|jpeg',1024*10,'1');
//echo_input("控件名称",'控件宽度(百分比或像素)','保存目录','文件夹是否附加日期','是否原名保存','允许文件后缀','文件大小 上限','文件大小 下限','指定保存名');
//指定保存名时，要先设置权限 $_SESSION['replace_file']=true;  ，否则将无效
