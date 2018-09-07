<?php
$act=@$_GET['act'];
$path=@$_GET['path'];
if(!is_file($path)){exit("{'state':'fail','info':'span class=fail>".self::$language['not_exist_file']."</span>'}");}
//var_dump($_GET);

if($act=='resize'){
	$width=intval(@$_GET['width']);	
	$height=intval(@$_GET['height']);
	if($width==0 || $height==0){exit("{'state':'fail','info':'<span class=fail>width or height err</span>'}");}
	$image=new image();
	$r=$image->thumb($path,$path,$width,$height,false);
	if($r){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>resize err</span>'}");	
	}
	
		
}

