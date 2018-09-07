<?php
$act=@$_GET['act'];
if($act=='add'){
	foreach($_POST as $k=>$v){
		if($v=='' && $k!='email' && $k!='chip' && $k!='introducer' && $k!='openid'){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'".$k."'}");}	
	}
	$_POST=safe_str($_POST);
	$username=$_POST['username'];
	$phone=$_POST['phone'];
	$email=$_POST['email'];
	$chip=$_POST['chip'];
	$introducer=$_POST['introducer'];
	$code=$_POST['openid'];
	$openid='';
	if($code!=''){
		$min_time=time()-600;
		$sql="select `openid`,`time`,`wid` from ".$pdo->sys_pre."weixin_authcode where `code`='".safe_str($code,1,0)."' order by `id` desc limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['openid']=='')exit ("{'state':'fail','info':'<span class=fail>".self::$language['authcode_err']."'}");
		if($r['time']<$min_time)exit ("{'state':'fail','info':'<span class=fail>".self::$language['authcode_expire']."'}");
		if($r['wid']!=self::$config['web']['wid'])exit ("{'state':'fail','info':'<span class=fail>".self::$language['weixin_is_not_web_master']."'}");
		$openid=$r['openid'];
		
		$sql="select `username` from ".$pdo->index_pre."user where `openid`='".$openid."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['username']!=''){
			exit("{'state':'fail','info':'<span class=fail>".self::$language['openid_name'].self::$language['exist']."</span>'}");
		}
			
	}	

	if($introducer!=''){
		$sql="select `id` from ".$pdo->index_pre."user where `username`='".$introducer."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['not_exist']."</span>','id':'introducer'}");}	
	}
	
	if(!is_match(self::$config['other']['reg_phone'],$phone)){exit("{'state':'fail','info':'<span class=fail>".self::$language['pattern_err']."</span>','id':'phone'}");}
	
	$sql="select `id` from ".$pdo->index_pre."user where `username`='".$username."' or `phone`='".$username."' or `email`='".$username."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['already_exists']."</span>','id':'username'}");}	
	
	$sql="select `id` from ".$pdo->index_pre."user where `username`='".$phone."' or `phone`='".$phone."' or `email`='".$phone."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['already_exists']."</span>','id':'phone'}");}	
	
	if($email!=''){
		if(!is_email($email)){exit("{'state':'fail','info':'<span class=fail>".self::$language['pattern_err']."</span>','id':'email'}");}	
		$sql="select `id` from ".$pdo->index_pre."user where `username`='".$email."' or `phone`='".$email."' or `email`='".$email."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['already_exists']."</span>','id':'email'}");}	
	}
	if($chip!=''){
		$sql="select `id` from ".$pdo->index_pre."user where `chip`='".$chip."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['already_exists']."</span>','id':'chip'}");}	
	}
	$group=self::$config['reg_set']['default_group_id'];
	
	require('plugin/py/py_class.php');
	$py_class=new py_class();  
	try { $py=$py_class->str2py($username); } catch(Exception $e) { $py='';}
	
	$sql="insert into ".$pdo->index_pre."user (`username`,`username_py`,`phone`,`email`,`password`,`transaction_password`,`chip`,`reg_time`,`state`,`group`,`introducer`,`openid`) values ('".$username."','".$py."','".$phone."','".$email."','".md5($_POST['password'])."','".md5($_POST['transaction_password'])."','".$chip."','".time()."','1','".$group."','".$introducer."','".$openid."')";
	if($pdo->exec($sql)){
		$new_id=$pdo->lastInsertId();
		$user_id=$new_id;
		$open_id=$openid;
		if($code!=''){
			$sql="select `id` from ".$pdo->index_pre."oauth where `user_id`=".$user_id." and `open_id`='".$open_id."' limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']==''){
				$sql="insert into ".$pdo->index_pre."oauth (`user_id`,`open_id`,`time`) values ('".$user_id."','".$open_id."','".time()."')";
				$pdo->exec($sql);
			}
		}
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}	
}
