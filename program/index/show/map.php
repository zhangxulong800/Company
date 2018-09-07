<?php

$module['url']='';
$sql="select `id`,`page_power`,`map`,`map_update_token` from ".$pdo->index_pre."group where `id`='".$_SESSION['monxin']['group_id']."'";
//echo $sql;
$v=$pdo->query($sql,2)->fetch(2);
$module['map']=de_safe_str($v['map']);
if($v['map_update_token']!=md5($v['page_power'])){
	$url_template=get_url();
	$map_update_token=md5($v['page_power']);
	$sql="select `url` from ".$pdo->index_pre."group_menu where `group_id`=".$_SESSION['monxin']['group_id']." order by `sequence` desc";
	$r=$pdo->query($sql,2);
	$map='';
	$url='';
	foreach($r as $v){
		if($v=='index.map'){continue;}
		$url.=','.$v['url'];
	}
	$module['url']=trim($url,',');
}


$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);