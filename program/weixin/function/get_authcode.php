<?php
function get_authcode($pdo,$table_pre,$language,$openid,$postObj){
	if($openid==''){$openid=@$_GET['openid'];}
	$config=require('./config.php');
	$min_time=time()-600;
	$sql="select `code` from ".$table_pre."authcode where `time`>".$min_time." and `openid`='".$openid."' and `wid`='".$postObj->ToUserName."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['code']!=''){
		$verification_code=$r['code'];	
	}else{
		$verification_code=get_verification_code(6);
		
		$sql="delete from ".$table_pre."authcode where `code`='".$verification_code."'";
		$pdo->exec($sql);
		
		$sql="insert into ".$table_pre."authcode (`openid`,`code`,`time`,`wid`) values ('".$openid."','".$verification_code."','".time()."','".$postObj->ToUserName."')";
		$pdo->exec($sql);
	}

	$data[0]['title']=$language['authcode'].':'.$verification_code;
	$data[0]['description']=$config['web']['name'];
	$data[0]['url']='';
	$data[0]['picurl']=get_monxin_path().'logo.png';
	return $data;	
}
