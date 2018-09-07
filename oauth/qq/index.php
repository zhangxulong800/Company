<?php
header('Content-Type:text/html;charset=utf-8');
$oauth_config=require_once("./config.php");
if($oauth_config['state']!='opening'){exit($oauth_config['state']);}
require_once '../../config/functions.php';
$config=require_once '../../config.php';

session_start();
$_SESSION['oauth']=array();
$_SESSION['oauth']['backurl']=$_GET['backurl'];
$_SESSION['oauth']['name']=$oauth_config['name'];
$_SESSION['oauth_qq']=array();

function qq_login($appid, $scope, $callback)
{
    $_SESSION['oauth_qq']['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
    $login_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=" 
        . $appid . "&redirect_uri=" . urlencode($callback)
        . "&state=" . $_SESSION['oauth_qq']['state']
        . "&scope=".$scope;
		//exit( $login_url);
    header("Location:$login_url");
}

//用户点击qq登录按钮调用此函数
qq_login($oauth_config["appid"], $oauth_config["scope"], 'http://'.$config['web']['domain'].'/'.$oauth_config["callback"]);
?>
