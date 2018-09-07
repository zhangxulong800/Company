<?php 
$re=array('err_code'=>'0','err_msg'=>$language['err_msg'][0]);

//$sql="insert into ".$pdo->index_pre."user (`nickname`,`email`,`username`,`password`,`reg_time`,`reg_ip`,`group`,`state`,`manager`,`phone`,`openid`,`phone_country`) values ('".$_POST['username']."','".$_POST['email']."','".$_POST['username']."','".$_POST['password']."','$time','$ip','".$_POST['group']."',$state,$manager,'".$_POST['phone']."','".$openid."','".intval($_POST['phone_country'])."')";

$fields='';
$values='';
$sql="SHOW COLUMNS FROM ".$pdo->index_pre."user";
$r=$pdo->query($sql,2);
foreach($r as $v){
	if($v['Field']=='group' && !isset($_POST[$v['Field']])){
		$_POST[$v['Field']]=$config['reg_set']['default_group_id'];		
	}
	if($v['Field']=='time' && !isset($_POST[$v['Field']])){
		$_POST[$v['Field']]=time();		
	}
	if($v['Field']=='id' || !isset($_POST[$v['Field']])){continue;}
	
	if($v['Field']=='email' && !is_email($_POST[$v['Field']])){
		$re['api_state']='fail';
		$re['api_msg']=$language['email_pattern_err'];
		return_api($re);		
	}
	$fields.='`'.$v['Field'].'`,';
	$values.="'".$_POST[$v['Field']]."',";
}
$fields=trim($fields,',');
$values=trim($values,',');

$need=array('username','nickname','password','transaction_password',);
foreach($need as $v){
	if(!isset($_POST[$v])){
		$re['api_state']='fail';
		$re['api_msg']=$language['lack_params'].':'.$v;
		return_api($re);
	}

}

$sql="select `id` from ".$pdo->index_pre."user where `username`='".$_POST['username']."' limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']!=''){
	$re['api_state']='fail';
	$re['api_msg']='username'.$language['already_exists'];
	return_api($re);			
}
if(isset($_POST['phone'])){
	$sql="select `id` from ".$pdo->index_pre."user where `phone`='".$_POST['phone']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){
		$re['api_state']='fail';
		$re['api_msg']='phone'.$language['already_exists'];
		return_api($re);			
	}
		
}

if(isset($_POST['email'])){
	$sql="select `id` from ".$pdo->index_pre."user where `email`='".$_POST['email']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){
		$re['api_state']='fail';
		$re['api_msg']='email'.$language['already_exists'];
		return_api($re);			
	}	
}


$time=time();
$ip=get_ip();
$sql="insert into ".$pdo->index_pre."user (".$fields.") values (".$values.")";


if($pdo->exec($sql)){
	$user_id=$pdo->lastInsertId();
	$re['api_state']='success';	
	$re['user_id']=$user_id;	
	$re['api_msg']=$language['err_msg'][6];
	
	if(isset($_POST['money']) && $_POST['money']>0){
		$username=$_POST['username'];
		$money=$_POST['money'];
		$reason=$language['new_user_money'];
		$sql="insert into ".$pdo->index_pre."recharge (`username`,`money`,`time`,`state`,`title`,`return_url`,`pay_info`,`pay_photo`,`method`) values ('".$username."','".$money."','".time()."','4','".$reason."','','','','offline_payment')";
		if($pdo->exec($sql)){
			$new_id=$pdo->lastInsertId();
			$in_id=date('Ymdh',time()).$new_id;
			$sql="update ".$pdo->index_pre."recharge set `in_id`='".$in_id."' where `id`=".$new_id;
			$pdo->exec($sql);
			operator_money($config,$language,$pdo,$username,$money,$reason,'index');	
		}
		
	}
	
	if(isset($_POST['credits']) && $_POST['credits']>0){
		operation_credits($pdo,$config,$language,$username,$_POST['credits'],$language['new_user_credits'],'other');
	}
	
}else{
	$re['api_state']='fail';	
}

return_api($re);


