<?php
$act=@$_GET['act'];
if($act=='get_verification_code'){
	$_SESSION['verification_code']=get_verification_code(6);
	$phone=@$_POST['phone'];
	$phone_country=@$_POST['phone_country'];
	if(!is_match(self::$config['phone_country_reg'][$phone_country],$phone)){exit("{'state':'fail','info':'".self::$language['phone'].self::$language['pattern_err']."','key':'phone'}");}
	if(sms_frequency($pdo,$phone,self::$config['sms']['frequency_limit'])==false){exit("{'state':'fail','info':'".self::$language['sms_frequent']."'}");}
	$password=md5($phone);
	$sql="select `id`,`openid`,`password` from ".$pdo->index_pre."user where `phone`='".$phone."' and `id`!=".$_SESSION['monxin']['id']." limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){
		if($r['openid']!=''){exit("{'state':'fail','info':'".self::$language['phone'].self::$language['exist']."','key':'phone'}");}
	}
	
	$sql="select `phone`,`phone_country` from ".$pdo->index_pre."user where `id`=".$_SESSION['monxin']['id'];
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['phone']==$phone && $r['phone_country']==$phone_country){exit("{'state':'fail','info':'".self::$language['phone'].self::$language['not_modified']."','key':'phone'}");}
	$phone='+'.$phone_country.$phone;
	//exit($phone);
	if(sms(self::$config,self::$language,$pdo,'monxin',$phone,$_SESSION['verification_code'])){
		$_SESSION['reg_phone']=$phone;
		$success=str_replace('{device}',self::$language['phone'],self::$language['verification_code_sent_notice']);
		exit("{'state':'success','info':'".$success."'}");

	}else{
		exit("{'state':'fail','info':'".self::$language['fail']."'}"); 	
	}
}

if($act=='update'){
	$phone=@$_POST['phone'];
	$phone_country=intval(@$_POST['phone_country']);
	if($_POST['authcode']=='' || @$_SESSION['verification_code']!=$_POST['authcode']){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['authcode'].self::$language['err']."</span>','key':'authcode'}");
	}
	if(!is_match(self::$config['phone_country_reg'][$phone_country],$phone)){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['phone'].self::$language['pattern_err']."</span>','key':'phone'}");
	}
	$sql="select `id`,`openid`,`password`,`credits`,`money`,`username` from ".$pdo->index_pre."user where `phone`='".$phone."' and `id`!=".$_SESSION['monxin']['id']." limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	$password=md5($phone);
	if($r['id']!=''){
		exit("{'state':'fail','info':'".self::$language['phone'].self::$language['exist']."','key':'phone'}");
		//if($r['openid']!=''){exit("{'state':'fail','info':'".self::$language['phone'].self::$language['exist']."','key':'phone'}");}
	}

	if($_SESSION['reg_phone']!='+'.$phone_country.$phone){exit("{'key':'phone','state':'fail','info':'".self::$language['phone'].'!='.$_SESSION['reg_phone']."'}");}

	$sql="update ".$pdo->index_pre."user set `phone`='".$phone."',`phone_country`='".$phone_country."' where `id`=".$_SESSION['monxin']['id'];
	if($pdo->exec($sql)){
		if($r['id']!=''){
			if($r['openid']==''){
				
				$reason=$phone.self::$language['member_merge_import'];
				if($r['credits']>0){operation_credits($pdo,self::$config,self::$language,$_SESSION['monxin']['username'],$r['credits'],$reason,'other');}
				if($r['money']>0){operator_money(self::$config,self::$language,$pdo,$_SESSION['monxin']['username'],$r['money'],$reason,'index',false);}
				$sql="delete from ".$pdo->index_pre."user where `id`=".$r['id'];
				$pdo->exec($sql);
				
				$sql="update ".$pdo->index_pre."user set `introducer`='".$_SESSION['monxin']['username']."' where `introducer`='".$r['username']."'";
				$pdo->exec($sql);
				del_user_relevant($pdo,$r);
			}
		}
		
		$_SESSION['verification_code']='';
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span]>'}"); 
	}
	
}