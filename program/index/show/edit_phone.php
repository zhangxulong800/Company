<?php
$sql="select `phone`,`phone_country` from ".$pdo->index_pre."user where `id`='".$_SESSION['monxin']['id']."'";
$module=$pdo->query($sql,2)->fetch(2);
$module['phone_country']=self::$config['reg_set']['phone_country'];
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
if($_COOKIE['monxin_device']=='pc'){
	$module['phone_country_select']='<select class=phone_country id=phone_country name=phone_country monxin_value='.$module['phone_country'].'>'.get_phone_country_opton(self::$language['phone_country']).'</select>';
	$module['phone_input']='<div class=line><span class="m_label">'.self::$language['phone'].'：</span><span class=input_span><div class=phone_input_div><span class=phone_country_switch></span><input class="input_text" type="text" name="phone" id="phone" placeholder="'.self::$language['phone'].'" value="'.$module['phone'].'"   /></span><span id=phone_state></span></div></div>'.$module['phone_country_select'];
}else{
	$module['phone_country_select']='<select class=phone_country id=phone_country name=phone_country monxin_value='.$module['phone_country'].'>'.get_phone_country_opton(self::$language['phone_country']).'</select>';
	$module['phone_input']='<div class=line><span class="m_label">'.self::$language['phone'].'：</span><span class=input_span><div class=phone_input_div>'.$module['phone_country_select'].'<input class="input_text" type="text" name="phone" id="phone" placeholder="'.self::$language['phone'].'"   value="'.$module['phone'].'"   /></span><span id=phone_state></span></div></div>';
}

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
