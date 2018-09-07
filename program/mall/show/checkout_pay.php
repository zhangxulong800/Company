<?php
$id=intval(@$_GET['id']);
if($id==0){return not_find();}
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);


$sql="select * from ".self::$table_pre."checkout where `id`=".$id;
$module['data']=$pdo->query($sql,2)->fetch(2);
if($module['data']['id']==''){return not_find();}
$sql="update ".self::$table_pre."checkout set `state`=1 where `id`=".$id;
$pdo->exec($sql);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/phone/'.str_replace($class."::","",$method).'.php';
require($t_path);