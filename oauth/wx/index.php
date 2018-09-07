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
$_SESSION['oauth_wx']=array();

$_SESSION['oauth_wx']['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
$url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$oauth_config['appid'].'&redirect_uri='.urlencode('http://'.$config['web']['domain'].'/'.$oauth_config['callback']).'&response_type=code&scope='.$oauth_config['scope'].'&state='.$_SESSION['oauth_wx']['state'].'#wechat_redirect';

if(!isset($_COOKIE['monxin_device']) || $_COOKIE['monxin_device']=='phone' ){
	header("Location:$url");
	//echo $url;
	exit();
}

$url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$oauth_config['appid'].'&redirect_uri='.urlencode('http://'.$config['web']['domain'].'/'.$oauth_config['qr_callback']).'&response_type=code&scope='.$oauth_config['scope'].'&state='.$_SESSION['oauth_wx']['state'].'#wechat_redirect';


$_POST['state']=$_SESSION['oauth_wx']['state'];

$dir="./state_txt/";
$r=scandir($dir);
$time=time()-600;
foreach($r as $v){
	if($v!='.' && $v!='..'){
		//echo filemtime($dir.$v).'<'.$time.'<br />';
		if(filemtime($dir.$v)<$time){unlink($dir.$v);}
	}
}

file_put_contents('./state_txt/'.$_POST['state'].'.txt','');
?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
	<script src="../../public/jquery.js"></script>
	
	
    <title>微信登陆</title>
	<style>
	*{margin:0px;padding:0px;  color:#fff;}
	body{padding: 50px; background-color: rgb(51, 51, 51);font-family: "Microsoft Yahei";}
	.inner_div{text-align:center; margin:auto; overflow:hidden; }
	.top{text-align:center;  line-height:50px; font-size:20px; margin-top:10px; font-weight:noraml;}
	.middle{ text-align:center;}
	.middle .title{ font-size:24px; line-height:80px;}
	.middle .qr{ }
	.middle .qr img{ width:285px;background-color:#fff;}
	.bottom{width:285px; margin:auto; margin-top: 15px;
background-color: #232323;
border-radius: 100px;
-moz-border-radius: 100px;
-webkit-border-radius: 100px;
box-shadow: inset 0 5px 10px -5px #191919, 0 1px 0 0 #444444;
-moz-box-shadow: inset 0 5px 10px -5px #191919, 0 1px 0 0 #444444;
-webkit-box-shadow: inset 0 5px 10px -5px #191919, 0 1px 0 0 #444444;
padding:6px;
}
	.sum{display:none;}
	</style>
</head>
<body>
<script>
var t1 ;
var sum=0;
$(document).ready(function(){

	function update_native_state(){
		sum++;
		if(sum>600){window.clearInterval(t1);return false;}
		if(sum>180){
			m=sum % 10;
			if(m!=0){return false;}
		}	
		$(".sum").html(sum);
		$.get('./qr_state.php?state=<?php echo $_POST['state'];?>',function(data){			
			if(data.length==32){
				window.location.href='./callback.php?state=<?php echo $_POST['state'];?>&code='+data;
			}
		});		
	}
    t1 = window.setInterval(update_native_state,1000); 
	
	
	
	// window 失去焦点，停止输出
	window.onblur = function() {
		clearInterval(t1);
	};
		 
	// window 每次获得焦点
	window.onfocus = function() {
		// 每 1 秒在页面输出一个数
		t1 = setInterval(function() {
			update_native_state();
		}, 1000);
	}	
});
</script>

	<div class=out_div>
		<div class=inner_div>
			<div class=top>微信登陆</div>
			<div class=middle>
				<div class=qr><img src="./qrcode/index.php?text=<?php echo urlencode($url);?>&logo=1" /></div>
			</div>
			<div class=bottom>
				<div class=act_notice>请使用微信扫描二维码登录</div>
				<div class=web_name>"<?php echo $config['web']['name'];?>"</div>
			</div>
			<div class=sum></div>
		</div>
	</div>
	
	
</body>
</html>