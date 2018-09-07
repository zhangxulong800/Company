<?php
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$sql="select * from ".self::$table_pre."distributor where `username`='".$_SESSION['monxin']['username']."' limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']!='' && $r['state']!=1){
	echo '<div class=return_false>'.self::$language['distributor_state'][$r['state']].'</div>';return false;
}

$sql="select * from ".$pdo->index_pre."user where `username`='".$_SESSION['monxin']['username']."' limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
$module['data']=$r;

if(self::$config['check']==0){
	$sql="insert into ".self::$table_pre."distributor (`username`,`phone`,`time`,`state`,`superior`) values ('".$_SESSION['monxin']['username']."','".$r['phone']."','".time()."',1,'".$r['introducer']."')";
	$r=$pdo->exec($sql);
	if($r){header('location:./index.php?monxin=distribution.user');exit;}
}



$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);

