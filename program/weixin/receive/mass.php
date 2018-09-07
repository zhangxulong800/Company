<?php
if(!$this->check_wid_power($pdo,self::$table_pre)){exit("{'state':'fail','info':'<span class=fail>".self::$language['act_noPower']."</span>'}");}
$wid=safe_str(@$_GET['wid']);
$act=@$_GET['act'];
$id=intval(@$_GET['id']);
if($act=='update_icon'){
	$icon=safe_str($_POST['icon']);
	$path=$icon;
	$temp=explode('/weixin/image/',$icon);
	$icon=@$temp[1];
	$sql="select `id` from ".self::$table_pre."mass where `wid`='".$wid."' and `icon`='".$icon."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit;}
	$update_id=$r['id'];
	$sql="select `AppId`,`AppSecret` from ".self::$table_pre."account where `wid`='".$wid."'";
	$r=$pdo->query($sql,2)->fetch(2);
	$access_token=self::get_access_token($pdo,$r['AppId'],$r['AppSecret'],$wid);
	if($access_token===false){exit("{'state':'fail','info':'<span class=fail>".self::$language['AppId'].self::$language['or'].self::$language['AppSecret'].self::$language['err']." </span>'}");}
	
	$path2='./temp.jpg';
	$image=new image();
	$image->thumb($path,$path2,512,512);
	$tmpInfo=self::get_media_id($access_token,$path2);
	if(isset($tmpInfo['thumb_media_id'])){
		$sql="update ".self::$table_pre."mass set `media_id`='".$tmpInfo['thumb_media_id']."' where `id`=".$update_id;
		$pdo->exec($sql);
		//file_put_contents('tt.txt',$sql);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		reset_weixin_info($wid,$pdo);
		$access_token=self::get_access_token($pdo,$r['AppId'],$r['AppSecret'],$wid);
		$tmpInfo=self::get_media_id($access_token,$path2);
		$sql="update ".self::$table_pre."mass set `media_id`='".$tmpInfo['thumb_media_id']."' where `id`=".$update_id;
		$pdo->exec($sql);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}
}
if($act=='add'){
	$_POST=safe_str($_POST);
	$time=time();
	if($_POST['icon']=='' || $_POST['title']==''  || $_POST['url']=='' ){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
	
	if(!is_file('./temp/'.$_POST['icon'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
	$path=get_date_dir('./program/weixin/image/');
	$dir=str_replace('./program/weixin/image/','',$path);
	$_POST['new_icon']=$dir.$_POST['icon'];
	$sql="insert into ".self::$table_pre."mass (`wid`,`title`,`icon`,`url`,`last_time`) values ('".$wid."','".$_POST['title']."','".$_POST['new_icon']."','".$_POST['url']."','".$time."')";
	if($pdo->exec($sql)){
			$new_id=$pdo->lastInsertId();		
		if(safe_rename('./temp/'.$_POST['icon'],'./program/weixin/image/'.$_POST['new_icon'].'')){
			$sql="select `AppId`,`AppSecret` from ".self::$table_pre."account where `wid`='".$wid."'";
			$r=$pdo->query($sql,2)->fetch(2);
			$access_token=self::get_access_token($pdo,$r['AppId'],$r['AppSecret'],$wid);
			if($access_token===false){exit("{'state':'fail','info':'<span class=fail>".self::$language['AppId'].self::$language['or'].self::$language['AppSecret'].self::$language['err']." </span>'}");}
			
			$path='./program/weixin/image/'.$_POST['new_icon'];
			$path2='./temp.jpg';
			$image=new image();
			$image->thumb($path,$path2,512,512);
			$tmpInfo=self::get_media_id($access_token,$path2);
			if(isset($tmpInfo['thumb_media_id'])){
				$sql="update ".self::$table_pre."mass set `media_id`='".$tmpInfo['thumb_media_id']."' where `id`=".$new_id;
				$pdo->exec($sql);
			}else{
				reset_weixin_info($wid,$pdo);
				$access_token=self::get_access_token($pdo,$r['AppId'],$r['AppSecret'],$wid);
				$tmpInfo=self::get_media_id($access_token,$path2);
				$sql="update ".self::$table_pre."mass set `media_id`='".$tmpInfo['thumb_media_id']."' where `id`=".$new_id;
				$pdo->exec($sql);
			}
			
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>is null</span>'}");
		}	
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='update'){
	$time=time();
	$_GET['title']=safe_str(@$_GET['title']);
	$_GET['url']=safe_str(@$_GET['url']);
	$_GET['sequence']=intval(@$_GET['sequence']);
	$sql="update ".self::$table_pre."mass set `title`='".$_GET['title']."',`url`='".$_GET['url']."',`sequence`='".$_GET['sequence']."' where `id`='".$_GET['id']."'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
	}
}

if($act=='del'){
	$sql="select `icon` from ".self::$table_pre."mass where `id`='$id' and `wid`='".$wid."'";
	$r=$pdo->query($sql,2)->fetch(2);
	$sql="delete from ".self::$table_pre."mass where `id`='$id' and `wid`='".$wid."'";
	if($pdo->exec($sql)){
		@safe_unlink('./program/weixin/image/'.$r['icon']);
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
		$sql="select `icon` from ".self::$table_pre."mass where `id`='$id' and `wid`='".$wid."'";
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="delete from ".self::$table_pre."mass where `id`='$id' and `wid`='".$wid."'";
		if($pdo->exec($sql)){
			@safe_unlink('./program/weixin/image/'.$r['icon']);
			$success.=$id."|";
		}
	}
	
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}

if($act=='mass'){
	$ids=safe_str(@$_GET['ids']);
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$ids=str_replace("|",',',$ids);
	$ids=trim($ids,',');
	$success='';
	$sql="select * from ".self::$table_pre."mass where `id` in (".$ids.") order by `sequence` desc";
	$r=$pdo->query($sql,2);
	$data='';
	$index=0;
	foreach($r as $v){
		if($v['media_id']==''){continue;}
		if($index==0){$show_cover_pic=1;}else{$show_cover_pic=0;}
		
		$source_url='http://'.self::$config['web']['domain'].'/index.php?monxin=weixin.index&show=mass&id='.$v['id'];
		$data.='{
				"thumb_media_id":"'.$v['media_id'].'",
				"author":"'.self::$config['web']['name'].'",
				"title":"'.$v['title'].'",
				"content_source_url":"'.$source_url.'",
				"content":"<img src=\'https://mmbiz.qlogo.cn/mmbiz_gif/sibEeicAP0oFhTzANr95ups3eibK662TTmEhkJkq6ZB56mW2icZ2qEle8wJF0B9OmCAsViaOER7CK3xCicm0qWOOsV6g/0?wx_fmt=gif\' /> '.self::$language['click_view_detail'].'",
				"digest":"digest",
				"show_cover_pic":'.$show_cover_pic.'				
			},';
		$index++;
		if($index==8){break;}	
	}
	if($data!=''){
		
		$data='{
   "articles": ['.$data.']
}';
	}else{exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." media_id all null</span>'}");}
	//file_put_contents('t.txt',$data);
	$sql="select `AppId`,`AppSecret`,`if_weixin`,`id` from ".self::$table_pre."account where `wid`='".$wid."'";
	$r=$pdo->query($sql,2)->fetch(2);
	$if_weixin=de_safe_str($r['if_weixin']);
	$wx_id=$r['id'];
	$access_token=self::get_access_token($pdo,$r['AppId'],$r['AppSecret'],$wid);
	if($access_token===false){exit("{'state':'fail','info':'<span class=fail>".self::$language['AppId'].self::$language['or'].self::$language['AppSecret'].self::$language['err']." </span>'}");}

		$url="https://api.weixin.qq.com/cgi-bin/media/uploadnews?access_token={$access_token}";
		//echo $url;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$tmpInfo = curl_exec($ch);
		if (curl_errno($ch)) {echo 'Errno'.curl_error($ch);}
		curl_close($ch);
		$tmpInfo=json_decode($tmpInfo,true);
		if(isset($tmpInfo['media_id'])){
			$data='{
   "filter":{
      "is_to_all":true
   },
   "mpnews":{
      "media_id":"'.$tmpInfo['media_id'].'"
   },
    "msgtype":"mpnews",
    "send_ignore_reprint":0
}';	
	if(isset($_GET['test'])){
		if($if_weixin==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['addressee'].self::$language['weixin'].'openId'.self::$language['is_null']."</span> <a href=\"./index.php?monxin=weixin.account_edit&id=".$wx_id."#if_weixin\" target=_blank>".self::$language['set']."</a>'}");}
		self::weixin_set_user_tags($pdo,self::$table_pre,$wid,$if_weixin);
		$data='{
		   "filter":{
			  "is_to_all":false,
			   "tag_id":2
		   },
			"touser":[
			"'.$if_weixin.'"
		   ],
		   "mpnews":{
			  "media_id":"'.$tmpInfo['media_id'].'"
		   },
			"msgtype":"mpnews",
			"send_ignore_reprint":0
		}';		
	}
		$url="https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token={$access_token}";
		//echo $url;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$tmpInfo = curl_exec($ch);
		if (curl_errno($ch)) {echo 'Errno'.curl_error($ch);}
		curl_close($ch);
		$tmpInfo=json_decode($tmpInfo,true);
		//var_dump($tmpInfo);
		if($tmpInfo['errcode']==0){
			exit("{'state':'success','info':'<span class=success><b>".self::$language['executed'].self::$language['please_wait']."</b></span>'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail'].$tmpInfo['errmsg']."</span>'}");
		}


		}
	
}
