<?php
if(!$this->check_wid_power($pdo,self::$table_pre)){exit("{'state':'fail','info':'<span class=fail>".self::$language['act_noPower']."</span>'}");}
$wid=safe_str(@$_GET['wid']);

$act=@$_GET['act'];
$id=intval(@$_GET['id']);

if($act=='get_user_list'){
	$sql="select `AppId`,`AppSecret` from ".self::$table_pre."account where `wid`='".$wid."'";
	$r=$pdo->query($sql,2)->fetch(2);
	$access_token=receive::get_access_token($pdo,$r['AppId'],$r['AppSecret'],$wid);
	$url='https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$access_token;
	
	$r=file_get_contents($url);
	$r=json_decode($r,1);
	if(isset($r['errcode'])){reset_weixin_info($wid,$pdo);exit("{'state':'fail','info':'<span class=fail>".$r['errmsg']."</span>'}");}
	if(!is_array(@$r['data']['openid'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");}
	//var_dump($r['data']['openid']);
	foreach($r['data']['openid'] as $v){
		receive::weixin_get_user_info($pdo,self::$table_pre,$wid,$v);
	}
	exit("{'state':'success','info':'<span class=success>".$r['count']."</span>'}");
	
}

if($act=='update_state'){
	$_GET['id']=intval(@$_GET['id']);
	$_GET['state']=intval(@$_GET['state']);
	$sql="update ".self::$table_pre."user set `state`='".$_GET['state']."' where `id`='".$_GET['id']."' and `wid`='".$wid."'";	
	$pdo->exec($sql);
	exit();
}

if($act=='del'){
	$sql="select `openid` from ".self::$table_pre."user where `id`='$id' and `wid`='".$wid."'";
	$r=$pdo->query($sql,2)->fetch(2);
	$sql="select `id` from ".self::$table_pre."dialog where `from`='".$r['openid']."' and `to`='".$wid."'";
	$r=$pdo->query($sql,2)->fetch(2);
	
	$sql="delete from ".self::$table_pre."user where `id`='$id' and `wid`='".$wid."'";
	if($pdo->exec($sql)){
		if($r['id']>0){self::del_multiple_dialog($pdo,self::$table_pre,$wid,$r['id']);}
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='del_select'){
	$ids=@$_GET['ids'];
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$ids=explode("|",$ids);
	$ids=array_filter($ids);
	$success='';
	foreach($ids as $id){
		$id=intval($id);
		$sql="delete from ".self::$table_pre."user where `id`='$id' and `wid`='".$wid."'";
		if($pdo->exec($sql)){
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
