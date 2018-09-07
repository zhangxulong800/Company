<?php
$act=@$_GET['act'];
if($act=='update'){
	$module_name=@$_GET['module_name'];
	$quantity=intval(@$_GET['quantity']);
	$t=explode('.',$module_name);
	if(!file_exists('./program/'.$t[0].'/module_config.php')){return false;}
	$module_config=require('./program/'.$t[0].'/module_config.php');
	if(!isset($module_config[$module_name])){return false;}
	
	$module_config[$module_name]['pagesize']=$quantity;
	if(file_put_contents('./program/'.$t[0].'/module_config.php','<?php return '.var_export($module_config,true).'?>')){
		echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
	}else{
		echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
	}
	
	
}

