<?php
$act=@$_GET['act'];
$config=require('./program/im/config.php');
if(isset($config[$act])){
	$config['forbidden']=safe_str($_POST['v']);
	$config['forbidden']=str_replace('，',',',$config['forbidden']);
	$config['forbidden']=str_replace("\n",',',$config['forbidden']);
	
	if(file_put_contents('./program/im/config.php','<?php return '.var_export($config,true).'?>')){
		echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
	}else{
		echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
	}	
}