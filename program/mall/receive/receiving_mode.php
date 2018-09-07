<?php
foreach($_GET as $key=>$v){
	if($v==''){exit("{'state':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");}
}
$act=@$_GET['act'];
if($act=='add'){
	$lang=require('./program/mall/language/'.self::$config['program']['language'].'.php');
	$lang['delivery_time_info'][count($lang['delivery_time_info'])]=$_GET['name'];
	$lang['delivery_time_info2'][count($lang['delivery_time_info2'])]=$_GET['remark'];
	
	if(file_put_contents('./program/mall/language/'.self::$config['program']['language'].'.php','<?php return '.var_export($lang,true).'?>')){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}


if($act=='update'){
	$_GET['id']=intval(@$_GET['id']);
	$lang=require('./program/mall/language/'.self::$config['program']['language'].'.php');
	$lang['delivery_time_info'][$_GET['id']]=$_GET['name'];
	$lang['delivery_time_info2'][$_GET['id']]=$_GET['remark'];
	if(file_put_contents('./program/mall/language/'.self::$config['program']['language'].'.php','<?php return '.var_export($lang,true).'?>')){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
	}
}
if($act=='del'){
	$_GET['id']=intval(@$_GET['id']);
	$lang=require('./program/mall/language/'.self::$config['program']['language'].'.php');
	unset($lang['delivery_time_info'][$_GET['id']]);
	unset($lang['delivery_time_info2'][$_GET['id']]);
	$lang['delivery_time_info']=array_merge($lang['delivery_time_info']);
	$lang['delivery_time_info2']=array_merge($lang['delivery_time_info2']);
	if(file_put_contents('./program/mall/language/'.self::$config['program']['language'].'.php','<?php return '.var_export($lang,true).'?>')){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}

}

