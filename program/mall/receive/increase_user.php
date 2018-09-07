<?php
$act=@$_GET['act'];
if($act=='add_exist'){
	$sql="select `id`,`username` from ".$pdo->index_pre."user where `username`='".safe_str($_POST['username'])."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['username']!=''){
		self::add_shop_buyer($pdo,$r['username'],SHOP_ID);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."1</span>'}");
	}	
}


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
			self::add_shop_buyer($pdo,$r['username'],SHOP_ID);
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}
			
	}	


	if($introducer!=''){
		$sql="select `id` from ".$pdo->index_pre."user where `username`='".$introducer."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['not_exist']."</span>','id':'introducer'}");}	
	}else{
		$sql="select `username` from ".self::$table_pre."shop where `id`=".SHOP_ID;
		$r=$pdo->query($sql,2)->fetch(2);
		$introducer=$r['username'];	
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
	require_once('plugin/py/py_class.php');
	$py_class=new py_class();  
	try { $py=$py_class->str2py($username); } catch(Exception $e) { $py='';}

	$sql="insert into ".$pdo->index_pre."user (`username`,`username_py`,`nickname`,`phone`,`email`,`password`,`transaction_password`,`reg_time`,`state`,`group`,`introducer`,`openid`) values ('".$username."','".$py."','".$username."','".$phone."','".$email."','".md5($_POST['password'])."','".md5($_POST['transaction_password'])."','".time()."','1','".$group."','".$introducer."','".$openid."')";
	if($pdo->exec($sql)){
		$new_id=$pdo->lastInsertId();
		$user_id=$new_id;
		$open_id=$openid;
		self::add_shop_buyer($pdo,$username,SHOP_ID);
		if($code!=''){
			$sql="select `id` from ".$pdo->index_pre."oauth where `user_id`=".$user_id." and `open_id`='".$open_id."' limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']==''){
				$sql="insert into ".$pdo->index_pre."oauth (`user_id`,`open_id`,`time`) values ('".$user_id."','".$open_id."','".time()."')";
				$pdo->exec($sql);
			}
		}
		if($chip!=''){
			$sql="select `id` from ".self::$table_pre."shop_buyer where `shop_id`=".SHOP_ID." and `chip`='".$chip."' limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']==''){
				$sql="update ".self::$table_pre."shop_buyer set `chip`='".$chip."' where `shop_id`='".SHOP_ID."' and `username`='".$username."'";	
				$pdo->exec($sql);
			}
		}
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','new_id':'".$new_id."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."2</span>'}");
	}	
}
