<?php
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$module['offline']=file_get_contents('./payment/offline.php');
$module['offline_state']=file_get_contents('./payment/offline_state.php');
$module['pay_info']=file_get_contents('./payment/pay_info.php');
$payment=@$_GET['payment'];
$barpay=@$_GET['barpay'];
if($payment==''){
	$dir="./payment/";
	$r=scandir($dir);
	$online='';
	foreach($r as $v){
		if(is_dir($dir.$v) && $v!='.' && $v!='..'){
			if(!is_file($dir.$v.'/config.php')){ continue;}
			$config=require($dir.$v.'/config.php');
			$online.="<a href='./index.php?monxin=index.payment&payment=".$v."'><img src='".$dir.$v."/".$config['provider_icon']."' alt='".$config['provider_name']."' />".$config['provider_name']."</a>";
		}
	}

}
if($payment!=''){
	$config=require('./payment/'.$payment.'/config.php');
	$online="<div align='center'><img src='./payment/".$payment."/".$config['provider_icon']."' alt='".$config['provider_name']."' title='".$config['provider_name']."'> <a href='./index.php?monxin=index.payment'>".self::$language['return']."</a></div><iframe src='./payment/".$payment."/config_panel.php' width='100%' height='800' scrolling='no'  frameborder='no'></iframe>";	
}

$module['online']=$online;		

$module['opening']=($module['offline_state']=='opening')?'selected':'';
$module['closed']=($module['offline_state']=='closed')?'selected':'';

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);