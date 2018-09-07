<?php
$act=@$_GET['act'];
$v=@$_GET['v'];
$v=str_replace('|||','&',$v);
$config=require('./program/distribution/config.php');

if(isset($config[$act])){
	$config[$act]=intval($v);
	if(file_put_contents('./program/distribution/config.php','<?php return '.var_export($config,true).'?>')){
		echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
	}else{
		echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
	}	
}