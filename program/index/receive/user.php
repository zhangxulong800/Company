<?php
if(@$_GET['act']=='unlogin'){
	@session_destroy();
	setcookie(session_name(),'',time()-3600);
	$_SESSION = array();
	setcookie("monxin_nickname",'',time()-3600);
	setcookie("monxin_icon",'',time()-3600);
	setcookie("edit_page_layout",'',time()-3600);
	setcookie("monxin_id",'',time()-3600);
	//echo "退出成功！";
	$backurl=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'./index.php?monxin=index.login';
	if(!strpos($backurl,'?')){$backurl.='?refresh='.time();}else{$backurl.='&refresh='.time();}
	//$backurl=isset($_GET['backurl'])?$_GET['backurl']:'index.php?monxin=index.login';
	echo "backurl=".$backurl;exit;	
}	