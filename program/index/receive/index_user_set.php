<?php
$act=@$_GET['act'];
if($act=='set'){
	$config=require('./program/index/config.php');
	//var_dump($_POST);
	
	if(isset($config[$_POST['variable']])){
		$config[$_POST['variable']]=$_POST['value'];
		if(file_put_contents('./program/index/config.php','<?php return '.var_export($config,true).'?>')){
			echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
		}else{
			echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
		}	
	}
	
}
