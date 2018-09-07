<?php
$act=@$_GET['act'];
if($act=='create'){
	
	if(isset($_SESSION['monxin']['username'])){
		exit('<script>window.location.href="../../index.php?monxin=index.user";</script>');	
	}

	if(@$_SESSION['oauth']['open_id']!='' && $_SESSION['oauth']['nickname']==''){
		if(strpos($_SESSION['oauth']['open_id'],'wx:')!==false){
			$sql="select `qr_code` from ".$pdo->sys_pre."weixin_account  where `wid`='".self::$config['web']['wid']."' limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			exit('<!DOCTYPE html><head><meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" /><meta http-equiv="Content-type" content="text/html; charset=utf-8" /></head><body><div style="text-align:center; padding:20px; font-size:18px;"><img src="./program/weixin/qr_code/'.@$r['qr_code'].'" width=80% style="max-width:300px" /><br /><br />'.self::$language['please_attention_weixin'].'</div></body></html>');
		}
		
	}
	//var_dump($_SESSION['oauth']);
	if(@$_SESSION['oauth']['open_id']=='' || @$_SESSION['oauth']['nickname']==''){exit("{'state':'fail','info':'oauth is null'}");	}
	
	$_GET['username']=safe_str( $_SESSION['oauth']['nickname']);
	$_GET['username']=strip_tags($_GET['username']);
	$_GET['username']=mb_substr($_GET['username'],0,30,'utf-8');		
	$_GET['group']=self::$config['reg_set']['default_group_id'];
	
	$sql="select `id` from ".$pdo->index_pre."user where `username`='".$_GET['username']."' limit 0,1";
	$stmt=$pdo->query($sql,2);
	$v=$stmt->fetch(2);
	if($v['id']!='' || strtolower($_GET['username'])=='monxin'){$_GET['username'].='_'.get_verification_code(5);}
	$sql="select `id` from ".$pdo->index_pre."user where `username`='".$_GET['username']."' limit 0,1";
	$stmt=$pdo->query($sql,2);
	$v=$stmt->fetch(2);
	if($v['id']!='' || strtolower($_GET['username'])=='monxin'){exit("{'state':'fail','info':'exist'}");	}
	$_GET['password']=md5(get_verification_code(10));
	
	$time=time();
	$ip=get_ip();
	$manager=$this->get_manager($pdo,$_GET['group']);;
	//echo $manager;
	
	//get gender
	$sql="select `id` from ".$pdo->index_pre."select where `type`='gender' and `value`='".safe_str($_SESSION['oauth']['gender'])."'";
	$r=$pdo->query($sql,2)->fetch(2);
	$gender=$r['id'];
	
	$openid='';
	//file_put_contents('oauth_add.txt',$_SESSION['oauth']['open_id']);
	if(substr($_SESSION['oauth']['open_id'],0,3)=='wx:' && self::$config['web']['wid']!=''){
		//file_put_contents('oauth_add2.txt',$_SESSION['oauth']['open_id']);
		$sql2="select `id` from ".$pdo->sys_pre."weixin_user where `wid`='".self::$config['web']['wid']."' and `openid`='".str_replace('wx:','',$_SESSION['oauth']['open_id'])."' limit 0,1";
		$r2=$pdo->query($sql,2)->fetch(2);
		//if($r2['id']>0){$openid=str_replace('wx:','',$_SESSION['oauth']['open_id']);}
		$openid=str_replace('wx:','',$_SESSION['oauth']['open_id']);
		$sql="select `id` from ".$pdo->index_pre."user where `openid`='".$openid."' limit 0,1";
		$rr=$pdo->query($sql,2)->fetch(2);
		if($rr['id']!=''){
			$sql="insert into ".$pdo->index_pre."oauth (`user_id`,`open_id`,`time`) values ('".$rr['id']."','wx:".$openid."','".time()."')";
			if($pdo->exec($sql)){oauth_login($pdo,self::$language,self::$config);}	
		}
		
	}
	
	require_once('plugin/py/py_class.php');
	$py_class=new py_class();  
	try { $py=$py_class->str2py($_GET['username']); } catch(Exception $e) { $py='';}

	
	$sql="insert into ".$pdo->index_pre."user (`nickname`,`username`,`username_py`,`reg_time`,`reg_ip`,`group`,`state`,`manager`,`gender`,`reg_oauth`,`openid`,`icon`) values ('".$_GET['username']."','".$_GET['username']."','".$py."','$time','$ip','".$_GET['group']."',1,$manager,'".$gender."',1,'".$openid."','".$_SESSION['oauth']['icon']."')";
	
	/*
	if($_SESSION['oauth']['icon']!=''){
		$path=get_date_dir('./program/index/user_icon/').time().'.png';
		if(file_put_contents($path,file_get_contents($_SESSION['oauth']['icon']))){
			$sql="insert into ".$pdo->index_pre."user (`nickname`,`username`,`password`,`reg_time`,`reg_ip`,`group`,`state`,`manager`,`gender`,`reg_oauth`,`icon`,`openid`) values ('".$_GET['username']."','".$_GET['username']."','".$_GET['password']."','$time','$ip','".$_GET['group']."',1,$manager,'".$gender."',1,'".str_replace('./program/index/user_icon/','',$path)."','".$openid."')";			
		}
		
		
	}*/
	
	if($pdo->exec($sql)){
		$user_id=$pdo->lastInsertId();
		oauth_bind($pdo,$user_id);
		oauth_login($pdo,self::$language,self::$config);		
		exit("{'state':'success','info':'".self::$language['success']."'}");
	}else{
		exit("{'state':'fail','info':'".self::$language['fail']."'}");	
	}
	
}
		
