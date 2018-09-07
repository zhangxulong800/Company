<?php
header('Content-Type:text/html;charset=utf-8');
if(@$_GET['r']=='success'){
	$state_html='<div><img src="./qr_success.png"><span>授权成功</span></div>';
	
}else{
	
	 $state_html='<div><img src="./qr_fail.png"><span>授权失败</span></div>';
}

?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />	
	
    <title>微信登陆</title>
	<style>
	*{margin:0px;padding:0px; }
	body{text-align:center; padding-top:20%;}
	body img{width:50%;}
	body span{display:block; line-height:100px; font-size:40px;}

	</style>
</head>
<body>
<?php echo $state_html;?>	
</body>
</html>