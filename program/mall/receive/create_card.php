<?php
$act=@$_GET['act'];

if($act=='add'){
	//var_dump($_POST);exit();
	$_POST=safe_str($_POST);
	$usernames=array();
	$group=self::$config['reg_set']['default_group_id'];
	if($_POST['source']=='phones'){
		$path='./temp/'.$_POST['phones'];
		if($_POST['phones']=='' || !is_file($path)){
			exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'phones'}");	
		}
		$r=file_get_contents($path);
		$r=iconv(self::$config['other']['export_csv_charset'].'//IGNORE',"UTF-8",$r);
		$r=explode("\r\n",$r);
		foreach($r as $v){
			if(is_numeric($v)){
				$usernames[]=$v;
			}	
		}
		$name=date('Y-m-d',time());
		
	}else{
		if($_POST['username']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'username'}");}
		if($_POST['quantity']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'quantity'}");}
		$quantity=intval($_POST['quantity']);
		if($_POST['quantity']<0){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'quantity'}");}
		
		for($i=1;$i<=$quantity;$i++){
			$usernames[]=$_POST['username'].$i;
		}
		$name=$_POST['username'];
	}
	
	if($_POST['balance']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'balance'}");}
	$balance=floatval($_POST['balance']);
	if($balance<0){$balance=0;}
	$diy_chip_start=0;
	if($_POST['diy_chip_start']!=''){
		$diy_chip_start=floatval($_POST['diy_chip_start']);
		if($diy_chip_start<0){$diy_chip_start=0;}
		$sql="select `id`,`chip` from ".self::$table_pre."create_card where `chip`>=".$diy_chip_start." limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){
			exit("{'state':'fail','info':'<span class=fail>".self::$language['must_be_greater_than'].$r['chip']."</span>','id':'diy_chip_start'}");
		}	
	}
	
	if(count($usernames)<1){exit("{'state':'fail','info':'<span class=fail>".self::$language['username'].self::$language['is_null']."</span>'}");}
	
	$time=time();
	$group=self::$config['reg_set']['default_group_id'];
	
	
	
	$sql="insert into ".self::$table_pre."create_card_batch (`name`,`time`,`quantity`,`money`) values ('".$name."','".$time."','".count($usernames)."','".$balance."')";
	if(!$pdo->exec($sql)){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");}
	$batch_id=$pdo->lastInsertId();
	$success=0;
	foreach($usernames as $v){
		$sql="select `id` from ".$pdo->index_pre."user where `username`='".$v."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){$v.='_2';}
		$sql="select `id` from ".$pdo->index_pre."user where `username`='".$v."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){$v.='_3';}
		$sql="select `id` from ".$pdo->index_pre."user where `username`='".$v."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){continue;}
		if(!is_match(self::$config['other']['reg_phone'],$v)){$phone=$v;}else{$phone='';}
		$password=strtolower(get_random_str(6));
		$transaction_password=get_verification_code(6);
		if($diy_chip_start==0){$chip=0;}else{
			if(!isset($chip)){$chip=$diy_chip_start;}else{$chip++;}	
		}
		
		$sql="insert into ".$pdo->index_pre."user (`username`,`nickname`,`phone`,`email`,`password`,`transaction_password`,`reg_time`,`state`,`group`,`chip`) values ('".$v."','".$v."','".$phone."','','".md5($password)."','".md5($transaction_password)."','".$time."','1','".$group."','".$chip."')";
		if($pdo->exec($sql)){			
			if($balance>0){
				$sql="insert into ".$pdo->index_pre."recharge (`username`,`money`,`time`,`state`,`title`,`return_url`,`pay_info`,`pay_photo`,`method`) values ('".$v."','".$balance."','".$time."','4','".self::$language['operator'].$_SESSION['monxin']['username']."','','','','offline_payment')";
				if($pdo->exec($sql)){
					if(!operator_money(self::$config,self::$language,$pdo,$v,$balance,self::$language['recharge'],'mall')){
						add_err_log($v.'rechare '.$balance.' err');
					}
				}							
			}
			
			$sql="insert into ".self::$table_pre."create_card (`username`,`state`,`money`,`password`,`transaction_password`,`batch_id`,`chip`) values ('".$v."','0','".$balance."','".$password."','".$transaction_password."','".$batch_id."','".$chip."')";
			if(!$pdo->exec($sql)){add_err_log($sql);}
			$success++;
		}
			
	}
	
	
	if($success){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}	
}
