<?php
if(!$this->check_wid_power($pdo,self::$table_pre)){exit("{'state':'fail','info':'<span class=fail>".self::$language['act_noPower']."</span>'}");}
$wid=safe_str(@$_GET['wid']);
$act=@$_GET['act'];
$id=intval(@$_GET['id']);
if($act=='icon'){
	if(@$_POST['diy_qr_icon']==''  || !is_file('./temp/'.$_POST['diy_qr_icon'])){exit("{'state':'fail','info':'<span class=fail>is null</span>'}");}
	@safe_unlink('./program/weixin/diy_qr_icon/'.$wid.'.png');
	if(safe_rename('./temp/'.$_POST['diy_qr_icon'],'./program/weixin/diy_qr_icon/'.$wid.'.png')){
		$image=new image();
		$image->thumb('./program/weixin/diy_qr_icon/'.$wid.'.png','./program/weixin/diy_qr_icon/'.$wid.'.png',28,28);
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>is null</span>'}");
	}	
}
if($act=='add'){
	$_POST=safe_str($_POST);
	$time=time();
	if($_POST['name']=='' || $_POST['key']=='' ){exit("{'state':'fail','info':'<span class=fail>is null</span>'}");}
	$sql="select `id` from ".self::$table_pre."diy_qr where `wid`='".$wid."' and `key`='".$_POST['key']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['already_exists'].":".$_POST['key']."</span>'}");}
	
	$sql="select `AppId`,`AppSecret`,`wid` from ".self::$table_pre."account where `wid`='".$wid."' limit 0,1";
	$account=$pdo->query($sql,2)->fetch(2);
	if($account['AppSecret']==''){exit("{'state':'fail','info':'<span class=fail>AppSecret ".self::$language['is_null']."</span>'}");}
		get_weixin_info($account['wid'],$pdo);
		$r['access_token']=$_POST['monxin_weixin'][$account['wid']]['token'];
	
	
	if(!isset($r['access_token'])){exit("{'state':'fail','info':'<span class=fail>access_token  get err</span>'}");}
	if(intval($_POST['type'])==0){$action_name='QR_SCENE';}else{$action_name='QR_LIMIT_STR_SCENE';}
	
	
	$data='{
			"action_name": "'.$action_name.'", 
			"action_info": {
				"scene": {
					"scene_str": "'.$_POST['key'].'"
				}
			}
		}';	
	$r= https_post('https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$r['access_token'],$data);
	$r=json_decode($r,1);
	if(!isset($r['url'])){exit("{'state':'fail','info':'<span class=fail>ger url err</span>'}");}
	
	$_POST['url']=$r['url'];
	
	$sql="insert into ".self::$table_pre."diy_qr (`wid`,`name`,`key`,`type`,`auto_answer`,`url`,`time`) values ('".$wid."','".$_POST['name']."','".$_POST['key']."','".intval($_POST['type'])."','".intval($_POST['auto_answer'])."','".$_POST['url']."','".$time."')";
	if($pdo->exec($sql)){
		$qr_id=$pdo->lastInsertId();
		if(intval($_POST['auto_answer'])==1){
			$key='SCAN:'.$_POST['key'];
			$sql="insert into ".self::$table_pre."auto_answer (`wid`,`key`,`input_type`,`output_type`,`time`,`text`,`author`) values ('".$wid."','".$key."','text','text','".$time."','".self::$language['auto_answer'].' '.$key."','".$_SESSION['monxin']['username']."')";
			if($pdo->exec($sql)){
				$as_id=$pdo->lastInsertId();
				$sql="update ".self::$table_pre."diy_qr set `auto_answer_id`=".$as_id." where `id`=".$qr_id;
				$pdo->exec($sql);
			}
	
		}
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='del'){
	$sql="select `auto_answer_id` from ".self::$table_pre."diy_qr where `id`='$id' and `wid`='".$wid."'";
	$r=$pdo->query($sql,2)->fetch(2);
	$sql="delete from ".self::$table_pre."diy_qr where `id`='$id' and `wid`='".$wid."'";
	if($pdo->exec($sql)){
		if($r['auto_answer_id']){
			$sql="select * from ".self::$table_pre."auto_answer where id=".$r['auto_answer_id'];
			$r=$pdo->query($sql,2)->fetch(2);
			$sql="delete from ".self::$table_pre."auto_answer where id=".$r['id'];
			if($pdo->exec($sql)){$this->del_auto_answer_files($pdo,self::$table_pre,$r,$r['id']);}
		}
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

		$sql="select `auto_answer_id` from ".self::$table_pre."diy_qr where `id`='$id' and `wid`='".$wid."'";
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="delete from ".self::$table_pre."diy_qr where `id`='$id' and `wid`='".$wid."'";
		if($pdo->exec($sql)){
			if($r['auto_answer_id']){
				$sql="select * from ".self::$table_pre."auto_answer where id=".$r['auto_answer_id'];
				$r=$pdo->query($sql,2)->fetch(2);
				$sql="delete from ".self::$table_pre."auto_answer where id=".$r['id'];
				if($pdo->exec($sql)){$this->del_auto_answer_files($pdo,self::$table_pre,$r,$r['id']);}
			}
			$success.=$id."|";
		}
	}
	
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
