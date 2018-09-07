<?php
$id=intval(@$_GET['id']);
if($id==0){echo (self::$language['need_params']);	return false;}
$sql="select * from ".self::$table_pre."page where `id`=".$id;
$module['data']=$pdo->query($sql,2)->fetch(2);
if($module['data']['id']==''){echo (self::$language['need_params']);	return false;}
$module['data']=de_safe_str($module['data']);
$module['paragraph_sum']=0;
$module['paragraph']='';
$sql="select `id`,`title` from ".self::$table_pre."paragraph where `best_id`='".$id."' order by `sequence` asc";
$r=$pdo->query($sql,2);
foreach($r as $v){
	$module['paragraph_sum']++;
	$module['paragraph'].='<div class=paragraph><span class=m_label><input type="text" class=p_title value="'.de_safe_str($v['title']).'" /></span><span class=m_input><input type="hidden" class=p_content_pc value='.$v['id'].' /><a href=# class=p_content_pc_button>PC</a> &nbsp; &nbsp; <input type="hidden" class=p_content_phone value='.$v['id'].' /><a href=# class=p_content_phone_button>'.self::$language['phone'].'</a><span class=move></span></span></div>';	
}

$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&id=".$id;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['class_name']=self::$config['class_name'];
$module['web_language']=self::$config['web']['language'];
$module['image_mark_option']=get_image_mark_option(self::$config['program']['imageMark'],self::$language);
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
