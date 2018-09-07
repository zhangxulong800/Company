<?php
$id=intval(@$_GET['id']);
if($id==0){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}

if(strtolower($_POST['authcode'])!=strtolower($_SESSION["authCode"])){
	exit("{'state':'fail','info':'<span class=fail>".self::$language['authcode_err']."</span>'}");			
}

if(self::update_content($pdo,$id,$_POST['content'],safe_str($_POST['email']))){
	$_SESSION["authCode"]=rand(-9999999999,9999999999999999);
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span><a href=".self::get_content_link($pdo,$id)." class=view>".self::$language['view']."</a>'}");	
}else{
	exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
}