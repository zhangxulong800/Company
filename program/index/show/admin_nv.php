<?php
$module['url']='';
$sql="select `id`,`page_power`,`map`,`map_update_token` from ".$pdo->index_pre."group where `id`='".$_SESSION['monxin']['group_id']."'";
//echo $sql;
$v=$pdo->query($sql,2)->fetch(2);
$module['map']=de_safe_str($v['map']);
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['search_url']=self::$config['web']['search_url'];
$module['search_placeholder']=self::$config['web']['search_placeholder'];


		$json=array();
		$json['msg']=0;
		$json['nickname']=$_SESSION['monxin']['nickname'];
		$json['group']=$_SESSION['monxin']['group'];
		$json['icon']=$_SESSION['monxin']['icon'];

		$sql="select count(id) as c from ".$pdo->index_pre."site_msg where `addressee_state`=1 and `addressee`='".$_SESSION['monxin']['username']."'";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['c']>0){
			$json['msg']=$r['c'];
		}
			
		$module['user_json']=json_encode($json);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);