<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$module['data']=self::$config['shop_'.$_COOKIE['monxin_device'].'_menu'];
$module['default_sub_2_data']='';
$module['default_sub_3_data']='';
$module['phone_position_bar_default_data']='<a href="./index.php">'.self::$config['web']['name'].'</a>';


require('./templates/0/'.$class.'_shop/'.self::$config['shop_template'].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php');