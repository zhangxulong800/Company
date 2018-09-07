<?php
$act=@$_GET['act'];
if($act=='add'){
	$icon_data=$_POST['icon'];
	
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
	
	if($_POST['gender']==1){$_POST['gender']=5;}else{$_POST['gender']=4;}
	$_POST['birthday']=get_unixtime($_POST['birthday'],'Ymd');
	$_POST['yxqs']=get_unixtime($_POST['yxqs'],'Ymd');
	$_POST['yxqe']=get_unixtime($_POST['yxqe'],'Ymd');
	$area_id=address_to_area_id($pdo,$_POST['address']);
	
	if($_POST['icon']!=''){
		$path_pre='./program/index/user_icon/';
		$path=get_date_dir($path_pre).time().'.jpg';
		file_put_contents($path,base64_decode(str_replace('data:image/jpg;base64,','',$icon_data)));
		$_POST['icon']=str_replace($path_pre,'',$path);
	}
	require('plugin/py/py_class.php');
	$py_class=new py_class();  
	try { $py=$py_class->str2py($username); } catch(Exception $e) { $py='';}
	
	$sql="insert into ".$pdo->index_pre."user (`username`,`username_py`,`phone`,`email`,`password`,`transaction_password`,`chip`,`reg_time`,`state`,`group`,`introducer`,`openid`,`icon`,`real_name`,`gender`,`minzu`,`birthday`,`address`,`license_id`,`license_type`,`publisher`,`yxqs`,`yxqe`,`home_area`,`current_area`,`nickname`) values ('".$username."','".$py."','".$phone."','".$email."','".md5($_POST['password'])."','".md5($_POST['transaction_password'])."','".$chip."','".time()."','1','".$group."','".$introducer."','".$openid."','".$_POST['icon']."','".$_POST['real_name']."','".$_POST['gender']."','".intval($_POST['minzu'])."','".$_POST['birthday']."','".$_POST['address']."','".$_POST['license_id']."','1','".$_POST['publisher']."','".$_POST['yxqs']."','".$_POST['yxqe']."',".$area_id.",".$area_id.",'".$_POST['real_name']."')";
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
		exit("{'state':'success','info':'<span class=success>".self::$language['success']." ,<a href=./index.php?monxin=index.user_recharge&id=".$new_id.">".self::$language['recharge']."</a> , <a href=./index.php?monxin=index.admin_edit_user&id=".$new_id.">".self::$language['view']."</a></span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}	
}
