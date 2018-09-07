<?php
$id=intval(@$_GET['id']);
if($id==0){return not_find();}
$sql="select * from ".self::$table_pre."regular where `id`=".$id;
$module['data']=$pdo->query($sql,2)->fetch(2);
if($module['data']['id']==''){return not_find();}
$module['data']=de_safe_str($module['data']);
echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=copy.regular&id='.$id.'">'.$module['data']['name'].'</a><span class=text>'.self::$language['pages']['copy.regular']['name'].'</span></div>';

$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&id='.$id;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['class_name']=self::$config['class_name'];



		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
