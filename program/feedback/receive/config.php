<?php
$act=@$_GET['act'];
if($act=='update'){
	$admin_phone_msg=(intval(@$_POST['admin_phone_msg'])==0)?false:true;
	$admin_email_msg=(intval(@$_POST['admin_email_msg'])==0)?false:true;
	$phone_msg=(intval(@$_POST['phone_msg'])==0)?false:true;
	$email_msg=(intval(@$_POST['email_msg'])==0)?false:true;
	$admin_phone_account=safe_str(@$_POST['admin_phone_account']);
	$admin_email_account=safe_str(@$_POST['admin_email_account']);
	if($admin_phone_account!='' && !preg_match(self::$config['other']['reg_phone'],$admin_phone_account)){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['phone'].self::$language['pattern_err']."</span>'}");	
	}
	if($admin_phone_account!='' && !is_email($admin_email_account)){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['email_pattern_err']."</span>'}");	
	}
	
	$config=require('./program/feedback/config.php');
	$config['alert']['admin_phone_msg']=$admin_phone_msg;	
	$config['alert']['admin_email_msg']=$admin_email_msg;	
	$config['alert']['phone_msg']=$phone_msg;	
	$config['alert']['email_msg']=$email_msg;	
	$config['alert']['admin_phone_account']=$admin_phone_account;	
	$config['alert']['admin_email_account']=$admin_email_account;	
	if(file_put_contents('./program/feedback/config.php','<?php return '.var_export($config,true).'?>')){
		echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
	}else{
		echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
	}	
	exit;
	
	
}
