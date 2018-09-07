<?php
$act=@$_GET['act'];
if($act=='get_verification_code'){
	$_SESSION['verification_code']=get_verification_code(6);
	$email=@$_POST['email'];
	if(!is_email($email)){exit("{'state':'fail','info':'".self::$language['email'].self::$language['pattern_err']."','key':'email'}");}
	if(email_frequency($pdo,$email)==false){exit("{'state':'fail','info':'".self::$language['sms_frequent']."'}");}
	
	$sql="select `id` from ".$pdo->index_pre."user where `email`='".$email."' and `id`!=".$_SESSION['monxin']['id'];
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit("{'state':'fail','info':'".self::$language['email'].self::$language['exist']."','key':'email'}");}
	
	$sql="select `email` from ".$pdo->index_pre."user where `id`=".$_SESSION['monxin']['id'];
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['email']==$email){exit("{'state':'fail','info':'".self::$language['email'].self::$language['not_modified']."','key':'phone'}");}
	
	$title=self::$config['web']['name']."-".self::$language['authcode'];
	$content=self::$config['web']['name']."-".self::$language['authcode'].":".$_SESSION['verification_code'];		
	if(email(self::$config,self::$language,$pdo,'monxin',$email,$title,$content)){
		$_SESSION['reg_email']=$email;
		$success=str_replace('{device}',self::$language['email'],self::$language['verification_code_sent_notice']);
		exit("{'state':'success','info':'".$success."'}");
	}else{
		exit("{'state':'fail','info':'".self::$language['fail']."'}"); 
	}

	
}

if($act=='update'){
	$email=@$_POST['email'];
	if($_POST['authcode']=='' || @$_SESSION['verification_code']!=$_POST['authcode']){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['authcode'].self::$language['err']."</span>','key':'authcode'}");
	}
	if(!is_email($email)){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['email'].self::$language['pattern_err']."</span>','key':'email'}");
	}
	$sql="select `id` from ".$pdo->index_pre."user where `email`='".$email."' and `id`!=".$_SESSION['monxin']['id'];
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit("{'state':'fail','info':'".self::$language['email'].self::$language['exist']."','key':'email'}");}
	if($_SESSION['reg_email']!=$email){exit("{'key':'email','state':'fail','info':'".self::$language['email'].'!='.$_SESSION['reg_email']."'}");}

	$sql="update ".$pdo->index_pre."user set `email`='".$email."' where `id`=".$_SESSION['monxin']['id'];
	if($pdo->exec($sql)){
		$_SESSION['verification_code']='';
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span]>'}"); 
	}
	
}