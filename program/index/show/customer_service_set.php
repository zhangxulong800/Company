<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['class_name']=self::$config['class_name'];
$module['web_language']=self::$config['web']['language'];
$type=@$_GET['type'];
$type=($type=='phone')?'phone':'pc';
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&type='.$type;

$module['data']=de_safe_str(@file_get_contents('./program/index/customer_service_'.$type.'_data.txt'));

echo " <script>
$(document).ready(function(){
$('#edit_page_layout_div').attr('id','').css('display','none');
        
    });
    </script>
    
";

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'_'.$type.'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'_'.$type.'.php';}
require($t_path);	
