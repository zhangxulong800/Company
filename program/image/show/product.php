<?php
$id=intval(@$_GET['id']);
$type=intval(@$_GET['type']);
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);


if($id==0){echo (self::$language['need_params']);return false;}

$sql="select * from ".self::$table_pre."img where `id`=$id";			
$v=$pdo->query($sql,2)->fetch(2);
$module=de_safe_str($v);
$v['src']="./program/image/img/".$v['src'];
$_GET['type']=$v['type'];



$module['count_url']="receive.php?target=".$method."&id=".$id;
$module['module_name']=str_replace("::","_",$method);
$module['module_save_name']=str_replace("::","_",$method);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
echo '<div id="visitor_position_reset" style="display:none;"><span id=current_position_text>'.self::$language['current_position'].'</span><a href="./index.php"><span id=visitor_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a>'.$this->get_type_position($pdo,$v['type']).'</div>';
	
