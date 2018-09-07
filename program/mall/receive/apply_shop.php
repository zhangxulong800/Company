<?php
if(!isset($_SESSION['monxin']['username'])){exit('unlogin');}
$act=@$_GET['act'];

if($act=='check_agent'){
	$agent=intval(@$_POST['agent']);
	if($agent==0){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
	$sql="select `group` from ".$pdo->index_pre."user where `id`=".$agent;
	$r=$pdo->query($sql,2)->fetch(2);
	
	if($r['group']!=self::$config['agent_group_id']){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['err']."</span>'}"); 
	}else{
		exit("{'state':'success','info':'<span class=success>".self::$language['right']."</span>'}"); 
	}	
}



if($act=='get_verification_code'){
	$phone=safe_str(@$_POST['phone']);
	
	//是否被占用
	$sql="select `id` from ".self::$table_pre."shop where `phone`='".$phone."' and `state`!=1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".$phone.' '.self::$language['exist']."</span>','key':'phone'}");}
		
	if(sms_frequency($pdo,$phone,self::$config['sms']['frequency_limit'])==false){exit("{'state':'fail','info':'<span class=fail>".self::$language['sms_frequent']."</span>'}");}
	$_SESSION['verification_code']=get_verification_code(6);
	if(sms(self::$config,self::$language,$pdo,'monxin',$phone,$_SESSION['verification_code'])){
		
		exit("{'state':'success','info':'<span class=success>".self::$language['sms_success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['sms_fail']."</span>'}"); 
	}
	
}

if($act=='check_verification_code'){
	if($_POST['verification_code']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['err']."</span>'}");}
	if($_SESSION['verification_code']!=$_POST['verification_code']){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['err']."</span>'}"); 
	}else{
		exit("{'state':'success','info':'<span class=success>".self::$language['right']."</span>'}"); 
	}	
}


if($act=='add'){
	$agent=intval(@$_POST['agent']);
	if($agent==0){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','key':'agent'}");}
	$sql="select `group`,`username` from ".$pdo->index_pre."user where `id`=".$agent;
	$r=$pdo->query($sql,2)->fetch(2);
	
	if($r['group']!=self::$config['agent_group_id']){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['err']."</span>','key':'agent'}"); 
	}else{
		$agent=$r['username'];
	}	
	
	/*
	if($_POST['sms_verification_code']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['err']."</span>','key':'sms_verification_code'}");}
	if($_SESSION['verification_code']!=$_POST['sms_verification_code']){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['err']."</span>','key':'sms_verification_code'}"); 
	}
	*/
	$sql="select `state` from ".self::$table_pre."shop where `username`='".$_SESSION['monxin']['username']."' order by `id` desc limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['state']!=''){
		switch($r['state']){
			case 0:
				$v='<div style="line-height:100px; text-align:center;">'.self::$language['shop_state_add_info'][$r['state']].'</div>';
				exit("{'state':'fail','info':'<span class=fail>".$v."</span>'}"); 
				break;	
			case 1:
				
				break;	
			case 2:
				$v='<div style="line-height:100px; text-align:center;">'.self::$language['shop_state_add_info'][$r['state']].'</div>';
				exit("{'state':'fail','info':'<span class=fail>".$v."</span>'}"); 
				break;	
			case 3:
				$v='<div style="line-height:100px; text-align:center;">'.self::$language['shop_state_add_info'][$r['state']].'</div>';
				exit("{'state':'fail','info':'<span class=fail>".$v."</span>'}"); 
				break;	
			case 4:
				$v='<div style="line-height:100px; text-align:center;">'.self::$language['shop_state_add_info'][$r['state']].'</div>';
				exit("{'state':'fail','info':'<span class=fail>".$v."</span>'}"); 
				break;	
			case 5:
				$v='<div style="line-height:100px; text-align:center;">'.self::$language['shop_state_add_info'][$r['state']].'</div>'; 
				exit("{'state':'fail','info':'<span class=fail>".$v."</span>'}"); 
				break;	
		}	
	}
	
	
	$field=array('run_type','certificate','certificate_id','name','self_certificate','self_certificate_id','main_business','area','address','position','phone','email','icon','ticket_logo');
	foreach($field as $v){
		if(@$_POST[$v]==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','key':'".$v."'}");}
	}
	if($_POST['run_type']=='0'){
		if(!is_match(self::$config['certificate_reg'],$_POST['certificate_id'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['pattern_err']."</span>','key':'certificate_id'}");}
	}else{
		if(!is_match(self::$config['business_license_reg'],$_POST['certificate_id'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['pattern_err']."</span>','key':'certificate_id'}");}
	}
	if(!is_match(self::$config['certificate_reg'],$_POST['self_certificate_id'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['pattern_err']."</span>','key':'self_certificate_id'}");}
	if(!is_match(self::$config['other']['reg_phone'],$_POST['phone'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['pattern_err']."</span>','key':'phone'}");}
	if(!is_email($_POST['email'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['pattern_err']."</span>','key':'email'}");}
	$_POST=safe_str($_POST);
	
	$sql="select `id` from ".self::$table_pre."shop where `certificate_id`='".$_POST['certificate_id']."' and `state`!=1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>','key':'certificate_id'}");}
	
	$sql="select `id` from ".self::$table_pre."shop where `name`='".$_POST['name']."' and `state`!=1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>','key':'name'}");}
	
	$sql="select `id` from ".self::$table_pre."shop where `self_certificate_id`='".$_POST['self_certificate_id']."' and `state`!=1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>','key':'self_certificate_id'}");}
	
	$sql="select `id` from ".self::$table_pre."shop where `email`='".$_POST['email']."' and `state`!=1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>','key':'email'}");}
	
	$sql="select `id` from ".self::$table_pre."shop where `phone`='".$_POST['phone']."' and `state`!=1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>','key':'phone'}");}
	
	if(!is_file('./temp/'.$_POST['certificate'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','key':'certificate'}");}
	if(!is_file('./temp/'.$_POST['self_certificate'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','key':'self_certificate'}");}
	
	$time=time();
	$sql="select `dir` from ".self::$table_pre."template where `state`=1 and `for_shop`='*' order by `sequence` desc limit 0,1";
	$r3=$pdo->query($sql,2)->fetch(2);
	$template=$r3['dir'];
	if(@$_POST['talk_type']==''){$_POST['talk_type']=1;}

	$geohash=new Geohash;
	$temp=explode(',',$_POST['position']);
	$geohash_str=$geohash->encode($temp[1],$temp[0]);
	
	$sql="insert into ".self::$table_pre."shop (`username`,`reg_username`,`name`,`main_business`,`address`,`run_type`,`certificate_id`,`state`,`position`,`area`,`self_certificate_id`,`phone`,`email`,`reg_time`,`last_time`,`name_log`,`template`,`talk_type`,`talk_account`,`agent`,`circle`,`geohash`) values ('".$_SESSION['monxin']['username']."','".$_SESSION['monxin']['username']."','".$_POST['name']."','".$_POST['main_business']."','".$_POST['address']."','".$_POST['run_type']."','".$_POST['certificate_id']."','0','".$_POST['position']."','".$_POST['area']."','".$_POST['self_certificate_id']."','".$_POST['phone']."','".$_POST['email']."',".$time.",".$time.",'".$_POST['name']." ".date('Y-m-d H:i')."','".$template."','".intval($_POST['talk_type'])."','".$_POST['talk_account']."','".$agent."','".intval($_POST['circle'])."','".$geohash_str."')";
	if($pdo->exec($sql)){
		$id=$pdo->lastInsertId();
		if(safe_rename('./temp/'.$_POST['certificate'],'./program/mall/certificate/'.$id.'.png')==false){
			$sql="delete from ".self::$table_pre."shop where `id`=".$id;
			$pdo->exec($sql);
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");	
		}
		if(safe_rename('./temp/'.$_POST['self_certificate'],'./program/mall/certificate/self_'.$id.'.png')==false){
			$sql="delete from ".self::$table_pre."shop where `id`=".$id;
			$pdo->exec($sql);
			@safe_unlink('./program/mall/certificate/'.$id.'.png');
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");	
		}
		if(safe_rename('./temp/'.$_POST['icon'],'./program/mall/shop_icon/'.$id.'.png')==false){
			$sql="delete from ".self::$table_pre."shop where `id`=".$id;
			$pdo->exec($sql);
			@safe_unlink('./program/mall/certificate/'.$id.'.png');
			@safe_unlink('./program/mall/certificate/self_'.$id.'.png');
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");	
		}
		if(safe_rename('./temp/'.$_POST['ticket_logo'],'./program/mall/ticket_logo/'.$id.'.png')==false){
			$sql="delete from ".self::$table_pre."shop where `id`=".$id;
			$pdo->exec($sql);
			@safe_unlink('./program/mall/shop_icon/'.$id.'.png');
			@safe_unlink('./program/mall/certificate/'.$id.'.png');
			@safe_unlink('./program/mall/certificate/self_'.$id.'.png');
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");	
		}
		$title=$_POST['name'].' '.self::$language['pages']['mall.apply_shop']['name'].'【'.self::$config['web']['name'].'】';
		$content=$title;
		email(self::$config,self::$language,$pdo,'monxin',self::$config['mall_master_email'],$title,$content);
		
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success'].','.self::$language['please_wait_check']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
		
}