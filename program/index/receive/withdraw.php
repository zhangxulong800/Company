<?php
$time=time();
$today=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);
$sql="select `id` from ".$pdo->index_pre."withdraw where `username`='".$_SESSION['monxin']['username']."' and `time`>".$today." limit ".self::$config['withdraw_set']['max_time'].",1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['config_language']['withdraw_set']['max_time'].':'.self::$config['withdraw_set']['max_time']."</span>'}");}


$act=@$_GET['act'];
if($act=='submit'){
	$method=intval(@$_POST['method']);
	$money=floatval(@$_POST['money']);
	$billing_info=safe_str(@$_POST['billing_info']);
	if($method==0){
		if(@$_POST['billing_info']==self::$language['billing_info_template'] || @$_POST['billing_info']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['billing_info'].self::$language['is_null']."</span>'}");}
	}
	
	if($money==0 || $money<0){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");}
	if($money<1){exit("{'state':'fail','info':'<span class=fail>".self::$language['less_than_one']."</span>'}");}
	
	$sql="select `real_name`,`money` from ".$pdo->index_pre."user where `id`='".$_SESSION['monxin']['id']."'";
	$user=$pdo->query($sql,2)->fetch(2);
	self::$config['withdraw_set']['rate']=floatval(self::$config['withdraw_set']['rate']);
	$rate_money=$money*self::$config['withdraw_set']['rate']/100;
	if($user['money']<($money+$rate_money)){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['withdraw'].'+'.self::$language['withdraw_rate'].self::$language['must_be_less_than'].self::$language['user_money']."</span>'}");	
	}
	
	
	$sql="insert into ".$pdo->index_pre."withdraw (`username`,`money`,`billing_info`,`time`,`ip`,`state`,`method`,`rate`) values ('".$_SESSION['monxin']['username']."','$money','".$billing_info." ".$user['real_name']."','".time()."','".get_ip()."','1','".$method."','".self::$config['withdraw_set']['rate']."')";
	if($pdo->exec($sql)){
		$id=$pdo->lastInsertId();
		
		if(self::$config['withdraw_set']['before_mode'] ){
			$reason=self::$language['withdraw'].'+'.self::$language['withdraw_rate'].'('.self::$config['withdraw_set']['rate'].'% '.self::$language['money_symbol'].$rate_money.')';
			if(operator_money(self::$config,self::$language,$pdo,$_SESSION['monxin']['username'],'-'.($money+$rate_money),$reason,self::$config['class_name'])){
				$sql="update ".$pdo->index_pre."withdraw set `deduction`='1' where `id`='$id'";
				$pdo->exec($sql);
			}
		
		}
		
		
		if($method==1 && $money<self::$config['withdraw_set']['wx_withdraw_auto_pay']){
			//$r=wexin_transfers($pdo,$_SESSION['monxin']['username'],self::$config['web']['name'].' '.self::$language['withdraw'],$money,'index');
			$r=wexin_red_pack($pdo,$_SESSION['monxin']['username'],self::$config['web']['name'].' '.self::$language['withdraw'],self::$config['web']['name'],$money,'index');
			if($r){
				$sql="update ".$pdo->index_pre."withdraw set `state`='3',`operator`='".$_SESSION['monxin']['username']."',`pay_time`='".time()."' where `id`='$id' and `state`='1'";
				if($pdo->exec($sql)){}
				if(!self::$config['withdraw_set']['before_mode'] ){
					$reason=self::$language['withdraw'].'+'.self::$language['withdraw_rate'].'('.self::$config['withdraw_set']['rate'].'% '.self::$language['money_symbol'].$rate_money.')';
					if(operator_money(self::$config,self::$language,$pdo,$_SESSION['monxin']['username'],'-'.($money+$rate_money),$reason,self::$config['class_name'])){
						$sql="update ".$pdo->index_pre."withdraw set `deduction`='1' where `id`='$id'";
						$pdo->exec($sql);
					}
				}
				
				
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>,".self::$language['withdraw_state'][3]."'}");
			}
				
		}
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>,".self::$language['withdraw_state'][1]."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");	
	}
	
	
}