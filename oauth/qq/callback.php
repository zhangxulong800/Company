<?php 
header('Content-Type:text/html;charset=utf-8');
$oauth_config=require_once("./config.php");
require_once '../../config/functions.php';
$config=require_once '../../config.php';
$timeoffset=($config['other']['timeoffset']>0)? "-".$config['other']['timeoffset']:str_replace("-","+",$config['other']['timeoffset']);
date_default_timezone_set("Etc/GMT$timeoffset");

session_start();
function qq_callback($oauth_config,$callback)
{
    if($_REQUEST['state'] == $_SESSION['oauth_qq']['state']) //csrf
    {
        $token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"
            . "client_id=" . $oauth_config["appid"]. "&redirect_uri=" . urlencode($callback)
            . "&client_secret=" . $oauth_config["appkey"]. "&code=" . $_REQUEST["code"];

        $response = file_get_contents($token_url);
        if (strpos($response, "callback") !== false)
        {
            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
            $msg = json_decode($response);
            if (isset($msg->error))
            {
                echo "<h3>error:</h3>" . $msg->error;
                echo "<h3>msg  :</h3>" . $msg->error_description;
                exit;
            }
        }

        $params = array();
        parse_str($response, $params);
        //set access token to session
       $_SESSION['oauth_qq']["access_token"] = $params["access_token"];

    }
    else 
    {
        echo("The state does not match. You may be a victim of CSRF.");
    }
}

function get_openid($oauth_config)
{
    $graph_url = "https://graph.qq.com/oauth2.0/me?access_token=" 
        .  $_SESSION['oauth_qq']["access_token"];

    $str  = file_get_contents($graph_url);
    if (strpos($str, "callback") !== false)
    {
        $lpos = strpos($str, "(");
        $rpos = strrpos($str, ")");
        $str  = substr($str, $lpos + 1, $rpos - $lpos -1);
    }

    $user = json_decode($str);
    if (isset($user->error))
    {
        echo "<h3>error:</h3>" . $user->error;
        echo "<h3>msg  :</h3>" . $user->error_description;
        exit;
    }

    return $user->openid;
}

function get_user_info($oauth_config,$open_id)
{
    $get_user_info = "https://graph.qq.com/user/get_user_info?"
        . "access_token=" . $_SESSION['oauth_qq']["access_token"]
        . "&oauth_consumer_key=" . $oauth_config["appid"]
        . "&openid=" . $open_id
        . "&format=json";

    $info = file_get_contents($get_user_info);
    $arr = json_decode($info, true);

    return $arr;
}



//QQ登录成功后的回调地址,主要保存access token
qq_callback($oauth_config,'http://'.$config['web']['domain'].'/'.$oauth_config["callback"]);

//获取用户标示id
$open_id=get_openid($oauth_config);
//exit($open_id);
if($open_id==''){exit('open_id is null');}


//=============================================================================================================================== start	
	$config=require('../../config.php');
	$language=require('../../language/'.$config['web']['language'].'.php');
	require_once '../../lib/ConnectPDO.class.php';
	$pdo=new  ConnectPDO();
	$_SESSION['oauth']['open_id']=$oauth_config['dir'].":".$open_id;
	if(oauth_login($pdo,$language,$config)==false){
		
		$r=get_user_info($oauth_config,$open_id);
		$_SESSION['oauth']['gender']=$r['gender'];
		$_SESSION['oauth']['nickname']=$r['nickname'];
		$_SESSION['oauth']['icon']=$r['figureurl_2'];
		exit("<script>window.location.href='/index.php?monxin=index.oauth_bind_option#index_oauth_bind_option'</script>");
		//header('location:./index.php?monxin=index.oauth_bind_option#index_oauth_bind_option');
		//var_dump($_SESSION['oauth']);
		
	}
	
//=============================================================================================================================== end	



//echo "<script>window.close();</script>";
?>
