<?php
$id=intval(@$_GET['id']);
if($id==0){echo 'id err';return false;}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&id=".$id;

$sql="select * from ".self::$table_pre."receiver where `id`='".$id."' limit 0,1";
$module['data']=$pdo->query($sql,2)->fetch(2);
if($module['data']['id']==''){echo 'id err';return false;}
$power=false;
if(isset($_SESSION['monxin']['username'])){
	if($_SESSION['monxin']['username']==$module['data']['username']){$power=true;}
}else{
	if($module['data']['id']==$_SESSION['receiver_id']){$power=true;}
}
if(!$power){echo 'no power';return false;}
$module['data']=de_safe_str($module['data']);
if($module['data']['post_code']==0){$module['data']['post_code']='';}
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);