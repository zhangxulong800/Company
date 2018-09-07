<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;

if($_GET['buy_method']=='unlogin' && !isset($_SESSION['monxin']['username'])){$module['auth_html']='<div class=line id=authcode_div ><span class=m_label>'.self::$language['authcode'].'：</span><span class=value>
        <input type="text" name="authcode" id="authcode" size="8" style="vertical-align:middle; width:80px;" /> <span class=state></span> <a href="#" onclick="return change_authcode();" title="'.self::$language['click_change_authcode'].'"><img id="authcode_img" src="./lib/authCode.class.php" style="vertical-align:middle; border:0px;" /></a>
         </span></div>';}else{$module['auth_html']='';}

$module['gps_x']=self::$config['web']['gps_x'];
$module['gps_y']=self::$config['web']['gps_y'];


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);