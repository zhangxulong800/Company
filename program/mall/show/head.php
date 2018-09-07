<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$sql="select `id`,`head_".$_COOKIE['monxin_device']."` from ".self::$table_pre."shop where `id`='".SHOP_ID."'";
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']==''){echo 'no shop';return false;}

$module['module_content']=de_safe_str($r['head_'.$_COOKIE['monxin_device']]);
require('./templates/0/'.$class.'_shop/'.self::$config['shop_template'].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php');	
