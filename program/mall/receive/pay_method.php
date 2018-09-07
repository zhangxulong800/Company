<?php
$act=@$_GET['act'];
if($act=='update'){
	$config=require('./program/mall/config.php');
	$_GET['visible']=intval($_GET['visible']);
	if($_GET['visible']){$_GET['visible']=true;}else{$_GET['visible']=false;}
	$_GET['sequence']=intval($_GET['sequence']);
	$config['pay_method'][$_GET['id']]=$_GET['visible'];
	$config['pay_method_sequence'][$_GET['id']]=$_GET['sequence'];
	if(file_put_contents('./program/mall/config.php','<?php return '.var_export($config,true).'?>')){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
	}
}

if($act=='pay_time_limit'){
	$config=require('./program/mall/config.php');
	$config['pay_time_limit']=intval(@$_GET['pay_time_limit']);
	if(file_put_contents('./program/mall/config.php','<?php return '.var_export($config,true).'?>')){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
	}
}

if($act=='cash_on_delivery'){
	if(file_put_contents('./program/mall/cash_on_delivery.txt',@$_POST['cash_on_delivery'])){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
	}
}