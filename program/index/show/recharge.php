<?php
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
if(@$_GET['money']!=''){$_POST['money']=$_GET['money'];}
$module['offline']=str_replace("\r\n","<br/>",file_get_contents('./payment/offline.php'));
$module['offline_state']=file_get_contents('./payment/offline_state.php');
$module['pay_info']=file_get_contents('./payment/pay_info.php');
$payment=@$_GET['payment'];
if($payment==''){
	$dir="./payment/";
	$r=scandir($dir);
	$online='';
	foreach($r as $v){
		if(is_dir($dir.$v) && $v!='.' && $v!='..'){
			if(!is_file($dir.$v.'/config.php')){ continue;}
			$config=require($dir.$v.'/config.php');
			if(!isset($config['for'])){@$config['for']='pc';}
			if($config['state']=='opening' && $config['for']==$_COOKIE['monxin_device']){
				$online.="<a href=# payment=".$v." class='payment'><img src='".$dir.$v."/".$config['provider_icon']."' alt='".$config['provider_name']."' title='".$config['provider_name']."'><div class=provider_name>".$config['provider_name']."</div></a>";
			}
		}
	}

	$dir="./scanpay_type_stop/";
	if(is_dir($dir) && table_exist($pdo,$pdo->sys_pre."scanpay_account")){
		$r=scandir($dir);
		//$online='';
		foreach($r as $v){
			if(is_dir($dir.$v) && $v!='.' && $v!='..'){
				if(!is_file($dir.$v.'/config.php')){ continue;}
				require($dir.$v.'/config.php');
				if($config['state']=='opening'){
					$sql="select `id` from ".$pdo->sys_pre."scanpay_account where `type`='".$v."' and `is_web`=1 and `state`=1 limit 0,1";
					$t=$pdo->query($sql,2)->fetch(2);
					if($t['id']!=''){$online.="<a href=# payment=scanpay_".$v." class='payment'><img src='".$dir.$v."/".$config['provider_icon']."' alt='".$config['provider_name']."' title='".$config['provider_name']."'><div class=provider_name>".$config['provider_name']."</div></a>";}
					
				}
			}
		}
	}

}
$module['online']=$online;		
$_SESSION['recharge_id']='';

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);

require "./plugin/html4Upfile/createHtml4.class.php";
$html4Upfile=new createHtml4();

echo "<span id='pay_photo_ele'>";
$html4Upfile->echo_input("pay_photo",'100%','./temp/','true','false','jpg|gif|png|jpeg','500','3');
echo '</span>';
