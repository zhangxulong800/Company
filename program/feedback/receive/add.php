<?php
$act=@$_GET['act'];
if($act=='add'){	
	$_POST['content']=safe_str(@$_POST['content'],1,0);
	$_POST['authcode']=trim(@$_POST['authcode']);
	$_SESSION['feedback_count']=0;
	if(!isset($_SESSION['feedback_count'])){$_SESSION['feedback_count']=0;}
	if($_SESSION['feedback_count']>self::$config['feedback_max_times']){exit("{'state':'fail','info':'<span class=fail>".self::$language['feedback_max_times_alert']."</span>'}");}	
	if($_POST['content']==''){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['content'].self::$language['is_null']."</span>'}");	
	}
	if(strtolower($_POST['authcode'])!=strtolower($_SESSION["authCode"])){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['authcode_err']."</span>'}");	
	}
	
	$_POST['feedback_sender']=safe_str(@$_POST['feedback_sender'],1,0);
	$_POST['feedback_receive']=safe_str(@$_POST['feedback_receive'],1,0);
	$time=time();
	$start_time=$time-7200*24;
	$ip=get_ip();
	if($_POST['feedback_sender']==''){$_POST['feedback_sender']=$ip;}
	$sql="select count(id) as c from ".self::$table_pre."msg where `ip`='".$ip."' and `time`>$start_time";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']>self::$config['feedback_max_times']){exit("{'state':'fail','info':'<span class=fail>".self::$language['feedback_max_times_alert']."</span>'}");}	
	if(trim($_POST['feedback_sender'])==trim(self::$language['feedback_sender_placeholder'])){$_POST['feedback_sender']='';}
	if(trim($_POST['feedback_receive'])==trim(self::$language['feedback_receive_placeholder'])){$_POST['feedback_receive']='';}
	
	
	$sql="insert into ".self::$table_pre."msg (`content`,`sender`,`receive`,`ip`,`time`,`state`) value ('".$_POST['content']."','".$_POST['feedback_sender']."','".$_POST['feedback_receive']."','".get_ip()."','".$time."',0)";

	if($pdo->exec($sql)){
		$_SESSION["authCode"]=rand(-9999999999,9999999999999999);
		$_SESSION['feedback_count']++;
		if(self::$config['alert']['admin_phone_msg'] && preg_match(self::$config['other']['reg_phone'],self::$config['alert']['admin_phone_account'])){
			//sms(self::$config,self::$language,$pdo,'monxin',self::$config['alert']['admin_phone_account'],self::$config['web']['name'].' '.$_SERVER['HTTP_HOST'].self::$language['feedback_email_to_webmaster_title']);
		}
		if(self::$config['alert']['admin_email_msg'] && is_email(self::$config['alert']['admin_email_account'])){
			$content=self::$language['feedback_content'].":<br />".$_POST['content']."<hr />";
			$content.=self::$language['feedback_sender'].":<br />".$_POST['feedback_sender']."<hr />";
			$content.=self::$language['feedback_receive'].":<br />".$_POST['feedback_receive'];
			email(self::$config,self::$language,$pdo,'monxin',self::$config['alert']['admin_email_account'],self::$config['web']['name'].' '.$_SERVER['HTTP_HOST'].self::$language['feedback_email_to_webmaster_title'],$content);	
		}
		
		echo "{'state':'success','info':'<span class=success>".self::$language['add_success_return_info']."</span>'}";
	}else{
		echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
	}	
	exit;
	
	
}
