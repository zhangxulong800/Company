<?php
$module['module_name']=str_replace("::","_",$method);

$module['data']=self::$config['shop_'.$_COOKIE['monxin_device'].'_menu'];


require('./templates/0/'.$class.'_shop/'.self::$config['shop_template'].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php');