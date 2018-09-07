<?php
$act=@$_GET['act'];
$_GET['username']=safe_str(@$_GET['username']);
if($act=='sendCheckCode'){
	if(strtolower(@$_GET['authcode'])!=strtolower($_SESSION["authCode"])){
		$errType='authcode';
		$errInfo=self::$language['authcode_err'];
		exit ("{'errType':'$errType','errInfo':'$errInfo'}");		
	}
	$errType='';	
	$errInfo='';
	$identifying=rand(100000,999999);
	
	$sql="select `id`,`phone_country` from ".$pdo->index_pre."user where `phone`='".$_GET['username']."' or `email`='".$_GET['username']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	$phone_country=$r['phone_country'];	
	$sql="update ".$pdo->index_pre."user set `identifying`='$identifying' where `phone`='".$_GET['username']."' or `email`='".$_GET['username']."'";
	$affected_rows=$pdo->exec($sql);
	if($affected_rows==0){
		$errType='username';
		if(is_email($_GET['username'])){$errInfo=self::$language['email_not_exist'];}
		if(preg_match(self::$config['other']['reg_phone'],$_GET['username'])){$errInfo=self::$language['phone_not_exist'];}
		if($errInfo==''){$errInfo=self::$language['email_or_phone'];}
		exit ("{'errType':'$errType','errInfo':'$errInfo'}");		
	}
	
	
	$title=self::$config['web']['name']."-".self::$language['identifying'];
	$content=self::$config['web']['name']."-".self::$language['identifying'].":".$identifying;
	if(is_email($_GET['username'])){
		if(email_frequency($pdo,$_GET['username'])==false){exit("{'errType':'username','errInfo':'".self::$language['email_frequent']."'}");}
		
		$state=email(self::$config,self::$language,$pdo,'monxin',$_GET['username'],$title,$content);
		if($state){
			$state='success';
			$info=self::$language['sent'];	
		}else{
			$state='fail';
			$info=self::$language['unsent'];	
		}
	}
	if(preg_match(self::$config['phone_country_reg'][$phone_country],$_GET['username'])){
		if(sms_frequency($pdo,$_GET['username'],self::$config['sms']['frequency_limit'])==false){exit("{'errType':'username','errInfo':'".self::$language['sms_frequent']."'}");}

		$state=sms(self::$config,self::$language,$pdo,'monxin','+'.$phone_country.$_GET['username'],$identifying);
		//$state=true;
		if($state){
			$state='success';
			$info=self::$language['sent'];	
		}else{
			$state='fail';
			$info=self::$language['unsent'];	
		}
	}
exit ("{'errType':'none','info':'$info','state':'$state'}");		
}
if($act=='reset'){
	if(strtolower(@$_GET['authcode'])!=strtolower($_SESSION["authCode"])){
		$errType='authcode';
		$errInfo=self::$language['authcode_err'];
		exit ("{'errType':'$errType','errInfo':'$errInfo'}");			
	}
	$errType='';	
	$errInfo='';
	$sql="select  `identifying`,count(id) as c from ".$pdo->index_pre."user where `phone`='".$_GET['username']."' or `email`='".$_GET['username']."'";
	$stmt=$pdo->query($sql,2);
	$v=$stmt->fetch(2);
	if($v['c']==0){exit ("{'errType':'username','errInfo':'".self::$language['username_err']."'}");}
	if($v['identifying']==''){exit ("{'errType':'identifying','errInfo':'".self::$language['identifying_expire']."<a href=index.php?monxin=index.resetPassword>".self::$language['reset']."</a>'}");	}

	$_GET['password']=md5(@$_GET['password']);
	$_GET['field']=safe_str(@$_GET['field']);
	$_GET['identifying']=safe_str(@$_GET['identifying']);
	if($_GET['field']!='transaction_password' && $_GET['field']!='password'){exit('filed err');}
	$sql="update ".$pdo->index_pre."user set `identifying`='',`".$_GET['field']."`='".$_GET['password']."' where (`phone`='".$_GET['username']."' or `email`='".$_GET['username']."') and `identifying`='".$_GET['identifying']."'";
	$affected_rows=$pdo->exec($sql);
	if($affected_rows==0){
		$sql="select count(id) as c from ".$pdo->index_pre."user where `phone`='".$_GET['username']."' or `email`='".$_GET['username']."'";
		$stmt=$pdo->query($sql,2);
		$v=$stmt->fetch(2);
		if($v['c']==0){
			$errType='username';
			$errInfo=self::$language['username_err'];	
		}else{
			$errType='identifying';
			$errInfo=self::$language['identifying_err'];	
		}
	}else{
		$_SESSION["authCode"]=rand(-9999999999,9999999999999999);
		$errType='none';
		$errInfo=self::$language['success'];	

	}
	exit ("{'errType':'$errType','errInfo':'$errInfo'}");		
}
