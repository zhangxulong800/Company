<?php
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
if(@$_GET['money']!=''){$_POST['money']=$_GET['money'];}
$module['offline']=str_replace("\r\n","<br/>",file_get_contents('./payment/offline.php'));
$module['offline_state']=file_get_contents('./payment/offline_state.php');
$module['pay_info']=file_get_contents('./payment/pay_info.php');
$payment=@$_GET['payment'];

//require_once('./program/index/recharge_credits_back.php');

//index_recharge_credits_back(self::$config,self::$language,$pdo,5,201807081120);

$dir="./payment/";
$r=scandir($dir);
$online='';

foreach($r as $v){
	if(is_dir($dir.$v) && $v!='.' && $v!='..'){
		$config=require($dir.$v.'/config.php');
		if(!isset($config['for'])){$config['for']='pc';}
		if($config['state']=='opening' && $config['for']==$_COOKIE['monxin_device']){
			$online.="<a href=# payment=".$v." class='payment'><img src='".$dir.$v."/icon.png' alt='".$config['provider_name']."' title='".$config['provider_name']."'>".$config['provider_name']."</a>";
		}
	}
}



$module['online']=$online;		

$_SESSION['recharge_id']='';

$module['rate']=self::$config['credits_set']['rate'];

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
