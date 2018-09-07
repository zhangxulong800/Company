<?php
if(!isset($_SESSION['oauth']['nickname'])){return false;}
if(isset($_SESSION['monxin']['username'])){header('location:./index.php?monxin=index.user');exit;}


if(@$_SESSION['oauth']['open_id']!='' && $_SESSION['oauth']['nickname']==''){
	if(strpos($_SESSION['oauth']['open_id'],'wx:')!==false){
		$sql="select `qr_code` from ".$pdo->sys_pre."weixin_account  where `wid`='".self::$config['web']['wid']."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		exit('<!DOCTYPE html><head><meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" /><meta http-equiv="Content-type" content="text/html; charset=utf-8" /></head><body><div style="text-align:center; padding:20px; font-size:18px;"><img src="./program/weixin/qr_code/'.@$r['qr_code'].'" width=80% style="max-width:300px" /><br /><br />'.self::$language['please_attention_weixin'].'</div></body></html>');
	}
	
}


$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['class_name']=self::$config['class_name'];
$module['icon']=$_SESSION['oauth']['icon'];
$module['nickname']=$_SESSION['oauth']['nickname'];
$module['oauth_name']=$_SESSION['oauth']['name'];
$module['oauth_name']=$_SESSION['oauth']['name'];
$module['default_group_id']=self::$config['reg_set']['default_group_id'];
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&act=create";

if(!self::$config['web']['auth_login_direct_create']){
	$alert='';
	if($_COOKIE['monxin_device']=='phone'){
		$alert='alert("'.self::$language['first_oath_login_alert'].'");';
	}
	//var_dump($_SESSION['oauth']);//exit;
	if(isWeiXin()){
		header('location:./'.$module['action_url']);exit;
	}
	
	echo '<script>
	 $(document).ready(function(){
		$("body").html("<i class=\'fa fa-spinner fa-spin\' ></i><br /><div style=\'font-size:14px;\'>'.self::$language['initial_account'].'</div>").css("padding-top","150px").css("text-align","center").css("font-size","60px");
		window.location.href="'.$module['action_url'].'"; 
		'.$alert.'
	});
	</script>';
	
	return false;
}

echo '<div style="display:none;" id="visitor_position_append"><append>'.self::$language['pages']['index.oauth_bind_option']['name'].'</append></div>';

$module['title']=self::$language['bind'].' '.self::$config['web']['name'].' '.self::$language['account'];
$module['notice']=str_replace('{oauth_name}',$_SESSION['oauth']['name'],self::$language['not_bound']).' '.self::$config['web']['name'].' '.self::$language['account'];

$module['skip']='';
if($_SESSION['oauth']['nickname']!=''){
	$module['skip']='<a href=# class=skip>'.self::$language['skip_reg'].'</a>';
}

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
