<?php header('Content-Type:text/html;charset=utf-8');?><head>
<title>自动登录中...</title>
<link href="../../public/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
<style>.return_false{ line-height:100px; text-align:center; font-weight: bold; color:red;}</style>
<div style="text-align:center; font-size:100px; padding-top:100px;" class=loading><i class='fa fa-spinner fa-spin' ></i></div>
<?php 
$oauth_config=require_once("./config.php");
require_once '../../config/functions.php';
$config=require_once '../../config.php';

session_start();

if($_REQUEST['state'] != $_SESSION['oauth_wx']['state'] || @$_GET['code']==''){
 exit('<div class=return_false>授权出错,<a href=../../index.php?index.user>返回</a></div>'); 
}

include('./class_weixin_adv.php');
$weixin=new class_weixin_adv($oauth_config['appid'], $oauth_config['appsecret']);
$url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$oauth_config['appid'].'&secret='.$oauth_config['appsecret'].'&code='.$_GET['code'].'&grant_type=authorization_code';

$r = $weixin->https_request($url);
$r=(json_decode($r, true));
//var_dump($_SESSION['oauth']['backurl']);
//
 
if (!isset($r['openid'])) {
	if(isset($_SESSION['monxin']['username'])){
		exit('<script>window.location.href="../../index.php?monxin=index.user";</script>');	
	}
	exit('<div class=return_false>授权出错,<a href=../../index.php?index.user>返回</a></div>');         
}
$open_id=$r['openid'];


//=============================================================================================================================== start	
	$language=require('../../language/'.$config['web']['language'].'.php');
	require_once '../../lib/ConnectPDO.class.php';
	$pdo=new  ConnectPDO();
	$_SESSION['oauth']['open_id']=$oauth_config['dir'].":".$open_id;
	//var_dump($_SESSION['oauth']);exit;
	if(oauth_login($pdo,$language,$config)==false){
		$r=$weixin->get_user_info($open_id);
		if(!isset($r['nickname'])){
			$r['sex']='';
			$r['nickname']='';
			$r['headimgurl']='';
		}
		if($r['sex']==1){$r['sex']=='男';}
		if($r['sex']==2){$r['sex']=='女';}
		if($r['sex']==0){$r['sex']=='';}
		$_SESSION['oauth']['gender']=$r['sex'];
		$_SESSION['oauth']['nickname']=$r['nickname'];
		$_SESSION['oauth']['icon']=$r['headimgurl'];
		//exit('<a href=index.php?monxin=index.oauth_bind_option#index_oauth_bind_option>index.php?monxin=index.oauth_bind_option#index_oauth_bind_option</a>');
		//var_dump($_SESSION['oauth']);exit;
		exit("<script>window.location.href='../../index.php?monxin=index.oauth_bind_option#index_oauth_bind_option'</script>");
		//header('location:./index.php?monxin=index.oauth_bind_option#index_oauth_bind_option');
		
		
	}
	
//=============================================================================================================================== end	



//echo "<script>window.close();</script>";
?>
