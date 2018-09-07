<?php
$sql="select * from ".$pdo->index_pre."user where `id`='".$_SESSION['monxin']['id']."'";
$module=$pdo->query($sql,2)->fetch(2);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['weight']=trim($module['weight'],'0');
//$module['birthday']=date(self::$config['other']['date_style'],$module['birthday']);

$sql="select `user_field` from ".$pdo->index_pre."group where `id`=".$_SESSION['monxin']['group_id'];
$r=$pdo->query($sql,2)->fetch(2);
$module['user_field']=','.$r['user_field'];

$module['birthday']=get_date($module['birthday'],self::$config['other']['date_style'],self::$config['other']['timeoffset']);
$module['married']=get_select_id($pdo,'married',$module['married']);
$module['education']=get_select_id($pdo,'education',$module['education']);
$module['blood_type']=get_select_id($pdo,'blood_type',$module['blood_type']);
$module['gender']=get_select_id($pdo,'gender',$module['gender']);
$module['license_type']=get_select_id($pdo,'license_type',$module['license_type']);
$module['annual_income']=get_select_id($pdo,'annual_income',$module['annual_income']);
$module['chat_type']=get_select_id($pdo,'chat_type',$module['chat_type']);
$module['domain_postfix']=str_replace('www.','.',self::$config['web']['domain']);
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['transaction_password_act']=($module['transaction_password']=='')?'add':'update';
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);


require "./plugin/html4Upfile/createHtml4.class.php";
$html4Upfile=new createHtml4();

echo "<span id='icon_ele'>";
$html4Upfile->echo_input("icon",'100%','./program/'.$class.'/user_icon/','true','false','jpg|gif|png|jpeg',1024*10,'1');
echo '</span>';
echo "<span id='banner_ele'>";
$html4Upfile->echo_input("banner",'100%','./program/'.$class.'/user_banner/','true','false','jpg|gif|png|jpeg',1024*10,'1');
echo '</span>';
echo "<span id='license_photo_front_ele'>";
$html4Upfile->echo_input("license_photo_front",'100%','./program/index/user_license_photo_front/','true','false','jpg|gif|png|jpeg',1024*10,'5');
echo '</span>';
echo "<span id='license_photo_reverse_ele'>";
$html4Upfile->echo_input("license_photo_reverse",'100%','./program/index/user_license_photo_reverse/','true','false','jpg|gif|png|jpeg',1024*10,'5');
echo '</span>';


/*	require "./plugin/html5Upfile/createHtml5.class.php";
$html5Upfile=new createHtml5();

echo "<span id='icon_ele'>";			   
$html5Upfile->echo_input("icon",'500px','multiple','./program/index/user_icon/','true','false','jpg|gif|png|rar','500','5');
echo '</span>';
echo "<span id='license_photo_front_ele'>";	
$html5Upfile->echo_input("license_photo_front",'500px','','./program/index/user_license_photo_front/','true','false','jpg|gif|png|rar','500','5');
echo '</span>';	
echo "<span id='license_photo_reverse_ele'>";	
$html5Upfile->echo_input("license_photo_reverse",'500px','','./program/index/user_license_photo_reverse/','true','false','jpg|gif|png|rar','500','5');
echo '</span>';	
*/