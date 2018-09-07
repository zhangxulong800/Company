<?php
clear_temp_file();
if(isset($_GET['act'])){
	if($_GET['act']=='get_sms'){
		
		$phone=safe_str($_POST['phone']);
		$phone_country=intval($_POST['phone_country']);
		if(!is_match(self::$config['phone_country_reg'][$phone_country],$phone)){exit("{'state':'fail','info':'".self::$language['phone'].self::$language['pattern_err']."','key':'phone'}");}
		$phone='+'.$phone_country.$phone;
		if(sms_frequency($pdo,$phone,self::$config['sms']['frequency_limit'])==false){exit("{'state':'fail','info':'".self::$language['sms_frequent']."'}");}
		
		$_SESSION['verification_code']=get_verification_code(6);
		if(sms(self::$config,self::$language,$pdo,'monxin',$phone,$_SESSION['verification_code'])){
			$_SESSION['login_phone']=$phone;
			$success=str_replace('{device}',self::$language['phone'],self::$language['verification_code_sent_notice']);
			exit("{'state':'success','info':'".self::$language['success']."'}");

		}else{
			exit("{'state':'fail','info':'".self::$language['fail']."'}"); 
		}
		exit;
	}
//==========================================================================================================================================
	if($_GET['act']=='sms_login'){
		$sms=safe_str($_POST['sms']);
		$phone=safe_str($_POST['phone']);
		if($sms=='' || $phone==''){exit("{'state':'fail','info':'".self::$language['is_null']."'}"); }
		if($sms!=@$_SESSION['verification_code']){
			exit("{'state':'fail','info':'".self::$language['authcode_err']."'}"); 
		}
		$phone_country=intval($_POST['phone_country']);
		if(!is_match(self::$config['phone_country_reg'][$phone_country],$phone)){exit("{'state':'fail','info':'".self::$language['phone'].self::$language['pattern_err']."','key':'phone'}");}
		
		$sql="select `id` from ".$pdo->index_pre."user where `phone`='".$phone."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){
			$sql="select `reg_able`,`require_check` from ".$pdo->index_pre."group where `id`='".self::$config['reg_set']['default_group_id']."' limit 0,1";
			$stmt=$pdo->query($sql,2);
			$v=$stmt->fetch(2);
			if($v['reg_able']!=1){exit("{'state':'fail','info':'".self::$language['no_registration']."'}");}
			$state=($v['require_check']==1)?0:1;
			$time=time();
			$ip=get_ip();
			$manager=$this->get_manager($pdo,self::$config['reg_set']['default_group_id']);;

			$sql="insert into ".$pdo->index_pre."user (`username`,`nickname`,`reg_time`,`reg_ip`,`group`,`state`,`manager`,`phone`,`phone_country`) values ('".$phone."','".$phone."','$time','$ip','".self::$config['reg_set']['default_group_id']."',$state,$manager,'".$phone."','".$phone_country."')";
			$re=$pdo->exec($sql);
			if($re){
				$u_id=$pdo->lastInsertId();
				
				if(isset($_SESSION['share'])){
					$sql="select `username`,`group` from ".$pdo->index_pre."user where `id`=".$_SESSION['share'];
					$r=$pdo->query($sql,2)->fetch(2);
					$share_username=$r['username'];
					
					$sql="update ".$pdo->index_pre."user set `introducer`='".$share_username."' where `id`=".$u_id;
					$pdo->exec($sql);
					
					//注册推荐人，返积分
					self::$config['credits_set']['introduce']=intval(self::$config['credits_set']['introduce']);
					$reason=self::$language['new_user_introduce'].$phone;
					operation_credits($pdo,self::$config,self::$language,$share_username,self::$config['credits_set']['introduce'],$reason,'introduce');	
								
					//=======================================================================================如是注册推荐是店主，则添加到店内会员
					if(is_file('./program/mall/config.php')){
						$sql="select `id` from ".$pdo->sys_pre."mall_shop where `username`='".$share_username."' and `state`=2 limit 0,1";
						$r2=$pdo->query($sql,2)->fetch(2);
						if($r2['id']!=''){
							$sql="select `id` from ".$pdo->sys_pre."mall_shop_buyer where `shop_id`=".$r2['id']." and `username`='".$phone."' limit 0,1";
							$r3=$pdo->query($sql,2)->fetch(2);
							if($r3['id']==''){
								$sql="select `id` from ".$pdo->sys_pre."mall_shop_buyer_group where `shop_id`=".$r2['id']." order by `discount` desc limit 0,1";
								$r4=$pdo->query($sql,2)->fetch(2);
								$sql="insert into ".$pdo->sys_pre."mall_shop_buyer (`username`,`phone`,`time`,`shop_id`,`group_id`) value ('".$phone."','".$phone."','".time()."','".$r2['id']."','".$r4['id']."')";
								$pdo->exec($sql);	
							}
						}
					}
					

				}
				
				
				
			}
			
			
			$r['id']=$u_id;
		}
		$id=$r['id'];
		$sql="select {$pdo->index_pre}user.id as userid,{$pdo->index_pre}group.id as group_id,`nickname`,`username`,`name`,`page_power`,`function_power`,`state`,`icon`,`recommendation`,`introducer` from ".$pdo->index_pre."user,".$pdo->index_pre."group where ".$pdo->index_pre."user.id=".$id." and `group`=".$pdo->index_pre."group.id";
		$stmt=$pdo->query($sql,2);
		$v=$stmt->fetch(2);	
		//var_dump($v);
		
		if($v){
			if(intval(@$_GET['oauth'])==1 && @$_SESSION['oauth']['open_id']!=''){
				$_GET['backurl']=$_SESSION['oauth']['backurl'];
				oauth_bind($pdo,$v['userid']);			
			}
			
			if($v['state']!=1){
				$errInfo=self::$language['user_state'][$v['state']];
				exit("{'state':'fail','info':'".$errInfo."'}");
				
			}else{
				$_SESSION['verification_code']='';
				push_login_info($pdo,self::$config,self::$language,$v['username']);
				login_credits($pdo,self::$config,self::$language,$v['userid'],$v['username'],self::$config['credits_set']['login'],self::$language['login_credits'],self::$config['other']['timeoffset']);
				
	
				if($v['recommendation']==''){
					$recommendation=$v['userid'].get_random_str(8-strlen($v['userid']));
					$sql="update ".$pdo->index_pre."user set `recommendation`='".$recommendation."' where `id`=".$v['userid'];
					$pdo->exec($sql);	
				}
				if(!is_url($v['icon'])){
					if($v['icon']==''){$v['icon']='default.png';}
					$v['icon']="./program/index/user_icon/".$v['icon'];
				}
				$_SESSION['monxin']['id']=$v['userid'];
				$_SESSION['monxin']['introducer']=$v['introducer'];
				$_SESSION['monxin']['username']=$v['username'];
				$_SESSION['monxin']['nickname']=$v['nickname'];
				$_SESSION['monxin']['icon']=$v['icon'];
				//if($v['icon']==''){$_SESSION['monxin']['icon']='default.png';}
				$_SESSION['monxin']['group']=$v['name'];
				$_SESSION['monxin']['group_id']=$v['group_id'];
				$_SESSION['monxin']['page']=explode(",",$v['page_power']);
				$_SESSION['monxin']['function']=explode(",",$v['function_power']);
				@setcookie("monxin_id",$v['userid']);
				@setcookie("monxin_nickname",$v['nickname']);
				@setcookie("monxin_icon",$_SESSION['monxin']['icon']);
				if(in_array('index.edit_page_layout',$_SESSION['monxin']['function'])){
					@setcookie("edit_page_layout",'true');	
				}
				//user_set cookie					
				send_user_set_cookie($pdo);
				$backurl=@$_GET['backurl'];
				
				$backurl=str_replace('|||','&',$backurl);
				if(!strpos($backurl,'?')){$backurl.='?refresh='.time();}else{$backurl.='&refresh='.time();}
				$errType='none';
				$errInfo='none';
				$backurl=explode('index.php',$backurl);
				$backurl=(isset($backurl[1]))?$backurl[1]:'./index.php?monxin=index.user';
				$script= "<script>window.location.href='$backurl';</script>";
				$time=time();
				$ip=get_ip();
				$sql="update ".$pdo->index_pre."user set `last_time`='$time',`last_ip`='$ip' where `id`='".$_SESSION['monxin']['id']."'";
				$pdo->exec($sql);
				$sql="select count(id) as c from ".$pdo->index_pre."user_login where `userid`='".$_SESSION['monxin']['id']."'";
				$stmt=$pdo->query($sql,2);
				$v=$stmt->fetch(2);
				if(self::$config['web']['login_position']){
					$login_position=get_ip_position($ip,self::$config['web']['map_secret']);	
				}else{
					$login_position='';
				}
				
				if($v['c']<self::$config['other']['user_login_log']){
					
					$sql="insert into ".$pdo->index_pre."user_login (`userid`,`ip`,`time`,`position`) values ('".$_SESSION['monxin']['id']."','$ip','$time','".$login_position."')";
					
				}else{
					$sql="select `id` from ".$pdo->index_pre."user_login where `userid`='".$_SESSION['monxin']['id']."' order by time asc limit 0,1";
					$stmt=$pdo->query($sql,2);
					$v=$stmt->fetch(2);
					$sql="update ".$pdo->index_pre."user_login set `ip`='$ip',`time`='$time',`position`='".$login_position."' where `id`='".$v['id']."'";
				}
				$pdo->exec($sql);
				$sql="update ".$pdo->index_pre."user set `login_num`=login_num+1 where `id`='".$_SESSION['monxin']['id']."'";
				$pdo->exec($sql);
				
				$_SESSION["authCode"]=rand(-9999999999,9999999999999999);
				if(intval(@$_GET['oauth'])==1 && @$_SESSION['oauth']['open_id']!=''){
					if($_COOKIE['monxin_device']=='phone'){
						exit('<script>window.location.href="'.str_replace('|||','&',$_SESSION['oauth']['backurl']).'";</script>');
					}						
					exit("<script>window.close();</script>");
				}
				//exit($script);
	
			}
	
			
			
		}		
			
	}
	
	exit("{'state':'success','info':'".self::$language['success']."'}");
}
//==========================================================================================================================================
$script='';	
$password=md5(@$_GET['password']);
$username=safe_str(@$_GET['username']);
$authcode=@$_GET['authcode'];
if(intval(@$_SESSION['monxin']['login_count'])>3){
	if(strtolower($authcode)!=strtolower($_SESSION["authCode"])){
		$errType='authcode';
		$errInfo=self::$language['authcode_err'];
		exit ("{'errType':'$errType','errInfo':'$errInfo'}|".$script);			
	}
}
	$sql="select {$pdo->index_pre}user.id as userid,{$pdo->index_pre}group.id as group_id,`nickname`,`username`,`name`,`page_power`,`function_power`,`state`,`icon`,`recommendation`,`introducer` from ".$pdo->index_pre."user,".$pdo->index_pre."group where (`username`='$username' or `phone`='$username' or `email`='$username') and `password`='$password' and `group`=".$pdo->index_pre."group.id";
	//exit($sql);
	$stmt=$pdo->query($sql,2);
	$v=$stmt->fetch(2);	
	//var_dump($v);
	
	if($v){
		if(intval(@$_GET['oauth'])==1 && @$_SESSION['oauth']['open_id']!=''){
			$_GET['backurl']=$_SESSION['oauth']['backurl'];
			oauth_bind($pdo,$v['userid']);			
		}
		
		if($v['state']!=1){
			$errType='submit';
			$errInfo=self::$language['user_state'][$v['state']];
		}else{
			push_login_info($pdo,self::$config,self::$language,$v['username']);
			login_credits($pdo,self::$config,self::$language,$v['userid'],$v['username'],self::$config['credits_set']['login'],self::$language['login_credits'],self::$config['other']['timeoffset']);
			

			if($v['recommendation']==''){
				$recommendation=$v['userid'].get_random_str(8-strlen($v['userid']));
				$sql="update ".$pdo->index_pre."user set `recommendation`='".$recommendation."' where `id`=".$v['userid'];
				$pdo->exec($sql);	
			}
			if(!is_url($v['icon'])){
				if($v['icon']==''){$v['icon']='default.png';}
				$v['icon']="./program/index/user_icon/".$v['icon'];
			}
			$_SESSION['monxin']['id']=$v['userid'];
			$_SESSION['monxin']['introducer']=$v['introducer'];
			$_SESSION['monxin']['username']=$v['username'];
			$_SESSION['monxin']['nickname']=$v['nickname'];
			$_SESSION['monxin']['icon']=$v['icon'];
			//if($v['icon']==''){$_SESSION['monxin']['icon']='default.png';}
			$_SESSION['monxin']['group']=$v['name'];
			$_SESSION['monxin']['group_id']=$v['group_id'];
			$_SESSION['monxin']['page']=explode(",",$v['page_power']);
			$_SESSION['monxin']['function']=explode(",",$v['function_power']);
			@setcookie("monxin_id",$v['userid']);
			@setcookie("monxin_nickname",$v['nickname']);
			@setcookie("monxin_icon",$_SESSION['monxin']['icon']);
			if(in_array('index.edit_page_layout',$_SESSION['monxin']['function'])){
				@setcookie("edit_page_layout",'true');	
			}
			//user_set cookie					
			send_user_set_cookie($pdo);
			$backurl=@$_GET['backurl'];
			
			$backurl=str_replace('|||','&',$backurl);
			if(!strpos($backurl,'?')){$backurl.='?refresh='.time();}else{$backurl.='&refresh='.time();}
			$errType='none';
			$errInfo='none';
			$backurl=explode('index.php',$backurl);
			$backurl=(isset($backurl[1]))?$backurl[1]:'./index.php?monxin=index.user';
			$script= "<script>window.location.href='$backurl';</script>";
			$time=time();
			$ip=get_ip();
			$sql="update ".$pdo->index_pre."user set `last_time`='$time',`last_ip`='$ip' where `id`='".$_SESSION['monxin']['id']."'";
			$pdo->exec($sql);
			$sql="select count(id) as c from ".$pdo->index_pre."user_login where `userid`='".$_SESSION['monxin']['id']."'";
			$stmt=$pdo->query($sql,2);
			$v=$stmt->fetch(2);
			if(self::$config['web']['login_position']){
				$login_position=get_ip_position($ip,self::$config['web']['map_secret']);	
			}else{
				$login_position='';
			}
			
			if($v['c']<self::$config['other']['user_login_log']){
				
				$sql="insert into ".$pdo->index_pre."user_login (`userid`,`ip`,`time`,`position`) values ('".$_SESSION['monxin']['id']."','$ip','$time','".$login_position."')";
				
			}else{
				$sql="select `id` from ".$pdo->index_pre."user_login where `userid`='".$_SESSION['monxin']['id']."' order by time asc limit 0,1";
				$stmt=$pdo->query($sql,2);
				$v=$stmt->fetch(2);
				$sql="update ".$pdo->index_pre."user_login set `ip`='$ip',`time`='$time',`position`='".$login_position."' where `id`='".$v['id']."'";
			}
			$pdo->exec($sql);
			$sql="update ".$pdo->index_pre."user set `login_num`=login_num+1 where `id`='".$_SESSION['monxin']['id']."'";
			$pdo->exec($sql);
			
			$_SESSION["authCode"]=rand(-9999999999,9999999999999999);
			if(intval(@$_GET['oauth'])==1 && @$_SESSION['oauth']['open_id']!=''){
				if($_COOKIE['monxin_device']=='phone'){
					exit('<script>window.location.href="'.str_replace('|||','&',$_SESSION['oauth']['backurl']).'";</script>');
				}						
				exit("<script>window.close();</script>");
			}

		}

		
		
	}else{
		@$_SESSION['monxin']['login_count']++;
		$sql="select count(id) as c from ".$pdo->index_pre."user where `username`='$username' or `phone`='$username' or `email`='$username'";
		$stmt=$pdo->query($sql,2);
		$v=$stmt->fetch(2);
		if($v['c']==0){
			$errType='username';
			$errInfo=self::$language['username_err'];	
		}else{
			$errType='password';
			$errInfo=self::$language['password_err'];	
		}	
		
	}
echo "{'errType':'$errType','errInfo':'$errInfo'}|".$script;			
