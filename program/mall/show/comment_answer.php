<?php
$id=intval(@$_GET['id']);
if($id==0){echo 'id null';return false;}

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&id=".$id;

$sql="select * from ".self::$table_pre."comment where `id`='".$id."' limit 0,1";
$module['data']=$pdo->query($sql,2)->fetch(2);

//echo $sql;
if($module['data']['id']==''){echo 'id err';return false;}

$sql="select `title` from ".self::$table_pre."order_goods where `order_id`='".$module['data']['order_id']."' and `goods_id`='".$module['data']['goods_id']."' limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
$module['data']['title']=$r['title'];
$module['data']=de_safe_str($module['data']);
$module['data']['time']=get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$module['data']['time']);
$moduel['data']['level']=self::$language['comment_option'][$module['data']['level']];

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
