<?php
define("TOKEN", "monxin");
libxml_disable_entity_loader(true);
$act=@$_GET['act'];
if($act=='save_image'){save_image($pdo,self::$table_pre,intval(@$_GET['id']));}
if(isset($_GET["echostr"])){weixin_valid();}
weixin_responseMsg($pdo,self::$table_pre,self::$language);


function weixin_subscribe($pdo,$table_pre,$fromUsername,$toUsername){
	$time=time();
	$sql="select count(id) as c from ".$table_pre."user where `openid`='".$fromUsername."' and `wid`='".$toUsername."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']==0){
		$sql="insert into ".$table_pre."user (`openid`,`wid`,`subscribe`,`subscribe_time`,`time`) values ('".$fromUsername."','".$toUsername."',1,$time,$time)";
		$pdo->exec($sql);
	}else{
		$sql="update ".$table_pre."user set `subscribe`=1,`subscribe_time`='".$time."' where `openid`='".$fromUsername."' and `wid`='".$toUsername."'";
		$pdo->exec($sql);
	}
	receive::weixin_get_user_info($pdo,$table_pre,$toUsername,$fromUsername);					
	receive::subscribe_notice_master($pdo,$table_pre,$toUsername,$fromUsername);
}
function weixin_unsubscribe($pdo,$table_pre,$fromUsername,$toUsername){
	$sql="update ".$table_pre."user set `subscribe`=0 where `openid`='".$fromUsername."' and `wid`='".$toUsername."'";
	$pdo->exec($sql);					
}

function save_image($pdo,$table_pre,$id){
	if($id==0){exit;}
	file_put_contents('last_id.txt',$id);
	$sql="select `content`,`from` from ".$table_pre."dialog where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if(strpos($r['content'],'http')===false){exit;}
	$data=file_get_contents($r['content']);
	$temp_path='./temp/'.md5($r['from']).'.jpg';
	file_put_contents($temp_path,$data); 
	$data=getimagesize($temp_path);
	$temp=explode('/',$data['mime']);
	$path=get_date_dir('./program/weixin/image/');
	$image=$path.$r['from'].'_'.time().'.'.$temp[1];
	safe_rename($temp_path,$image);
	$image=str_replace('./program/weixin/image/','',$image);
	$sql="update ".$table_pre."dialog set `content`='".$image."' where `id`=".$id;
	$pdo->exec($sql); 
	exit;
}

function weixin_get_auto_answer_xml($pdo,$table_pre,$r,$openid,$language,$postObj){
	$sql="update ".$table_pre."auto_answer set `vist`=`visit`+1  where `id`=".$r['id'];
	$pdo->exec($sql);
	if($r['output_type']=='text'){
		$v='<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA['.$r['text'].']]></Content>';
	}else{
		switch ($r['input_type']){
			case 'image':
				$data['picurl']=get_monxin_path().'program/weixin/image_thumb/'.$r[$r['input_type']];
				$data['url']=get_monxin_path().'program/weixin/image/'.$r[$r['input_type']].'?openid='.$openid;
				$data['title']='';
				$data['description']='';
				break;
			case 'voice':
				$data['picurl']=get_monxin_path().'program/weixin/img/voice.png';
				$data['url']=get_monxin_path().'index.php?monxin=weixin.index&show=dialog&type=voice&path='.$r[$r['input_type']].'&openid='.$openid;
				$data['title']='';
				$data['description']='';
				break;
			case 'video':
				$data['picurl']=get_monxin_path().'program/weixin/img/video.png';
				$data['url']=get_monxin_path().'index.php?monxin=weixin.index&show=dialog&type=video&path='.$r[$r['input_type']].'&openid='.$openid;
				$data['title']='';
				$data['description']='';
				break;
			case 'single_news':
				$sql="select * from ".$table_pre."single_news where `key_id`=".$r['id'];
				$r2=$pdo->query($sql,2)->fetch(2);
				$data['title']=$r2['title'];
				$data['description']=$r2['description'];
				$data['picurl']=get_monxin_path().'program/weixin/image_thumb/'.$r2['img'];
				$data['url']=$r2['url'];
				break;
			case 'news':
			$sql="select * from ".$table_pre."news where `key_id`='".$r['id']."' order by `sequence` desc,`id` asc   limit 0,9";
			$r2=$pdo->query($sql,2);
			$temp=0;
			foreach($r2 as $v2){
				if($temp==0){
					$data[$temp]['picurl']=get_monxin_path().'program/weixin/image/'.$v2['img'];
				}else{
					$data[$temp]['picurl']=get_monxin_path().'program/weixin/image_thumb/'.$v2['img'];
				}
				$data[$temp]['title']=$v2['title'];
				$data[$temp]['url']=$v2['url'];
				$temp++;
			}
				break;
			case 'function':
				
				$data=receive::call_function($pdo,$table_pre,$language,$r[$r['input_type']],'xml',$openid,$postObj);
				//var_dump($data);
				break;
		}
		$f='weixin_'.$r['input_type'].'_to_xml';
		$v=receive::$f($data);
	}
	return $v;
}
function weixin_add_dialog($pdo,$table_pre,$postObj){
	$time=time();
	switch($postObj->MsgType){
		case 'text':
			$sql="insert into ".$table_pre."dialog (`wid`,`from`,`to`,`type`,`time`,`content`,`input_type`) values ('".$postObj->ToUserName."','".$postObj->FromUserName."','".$postObj->ToUserName."','".$postObj->MsgType."','".$time."','".trim($postObj->Content)."','".$postObj->MsgType."')";
			$pdo->exec($sql); 
		break;
		case 'image':		
			$sql="insert into ".$table_pre."dialog (`wid`,`from`,`to`,`type`,`time`,`content`,`input_type`) values ('".$postObj->ToUserName."','".$postObj->FromUserName."','".$postObj->ToUserName."','".$postObj->MsgType."','".$time."','".$postObj->PicUrl."','".$postObj->MsgType."')";
			$pdo->exec($sql);
			$opts = array('http'=>array('method'=>"GET",'timeout'=>3,));
			$context = stream_context_create($opts);
			$path=get_monxin_path().'receive.php?target=weixin.index&act=save_image&id='.$pdo->lastInsertId();
			//file_put_contents('path.txt',$path);
			//file_get_contents($path,$context);			
		break;
		case 'voice':
			$sql="select `AppId`,`AppSecret` from ".$table_pre."account where `wid`='".$postObj->ToUserName."'";
			$r=$pdo->query($sql,2)->fetch(2);
			$access_token=receive::get_access_token($pdo,$r['AppId'],$r['AppSecret'],$postObj->ToUserName);
			//file_put_contents('meadia_id.txt','id='.$postObj->MediaId);
			if($access_token!=''){
				$url="http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$postObj->MediaId;
				$v=receive::save_media($url,$postObj->MsgType);
			}else{
				$v='default.mp3';
			}
			$sql="insert into ".$table_pre."dialog (`wid`,`from`,`to`,`type`,`time`,`content`,`input_type`) values ('".$postObj->ToUserName."','".$postObj->FromUserName."','".$postObj->ToUserName."','".$postObj->MsgType."','".$time."','".$v."','".$postObj->MsgType."')";
			$pdo->exec($sql);
		break;	
		case 'video':
			$sql="select `AppId`,`AppSecret` from ".$table_pre."account where `wid`='".$postObj->ToUserName."'";
			$r=$pdo->query($sql,2)->fetch(2);
			$access_token=receive::get_access_token($pdo,$r['AppId'],$r['AppSecret'],$postObj->ToUserName);
			if($access_token!=''){
				$url="http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$postObj->MediaId;
				$v=receive::save_media($url,$postObj->MsgType);
			}else{
				$v='default.mp4';
			}
			$sql="insert into ".$table_pre."dialog (`wid`,`from`,`to`,`type`,`time`,`content`,`input_type`) values ('".$postObj->ToUserName."','".$postObj->FromUserName."','".$postObj->ToUserName."','".$postObj->MsgType."','".$time."','".$v."','".$postObj->MsgType."')";
			$pdo->exec($sql);
		break;	
		case 'location':
			//$v=json_encode(array(''=>$postObj->Location_X,'Location_Y'=>$postObj->Location_Y,'Scale'=>$postObj->Scale,'m_label'=>$postObj->m_label));
			$v='{"Location_X":"'.$postObj->Location_X.'","Location_Y":"'.$postObj->Location_Y.'","Scale":"'.$postObj->Scale.'","m_label":"'.$postObj->m_label.'"}';
			$sql="insert into ".$table_pre."dialog (`wid`,`from`,`to`,`type`,`time`,`content`,`input_type`) values ('".$postObj->ToUserName."','".$postObj->FromUserName."','".$postObj->ToUserName."','".$postObj->MsgType."','".$time."','".$v."','".$postObj->MsgType."')";
			$pdo->exec($sql); 
		break;
		case 'link':
			$v='{"Title":"'.$postObj->Title.'","Description":"'.$postObj->Description.'","Url":"'.$postObj->Url.'"}';
			$sql="insert into ".$table_pre."dialog (`wid`,`from`,`to`,`type`,`time`,`content`,`input_type`) values ('".$postObj->ToUserName."','".$postObj->FromUserName."','".$postObj->ToUserName."','".$postObj->MsgType."','".$time."','".$v."','".$postObj->MsgType."')";
			$pdo->exec($sql); 
		break;
	}
}
$information_email=false;
$information_weixin=false;

function weixin_send_email($account,$title,$content){
	require("./plugin/mail/class.phpmailer.php"); 
	$mail_info=$account['smtp_url']."|".$account['smtp_account']."|".$account['smtp_password'];
	$result=sendmail($account['name'],$account['if_email'],$title,$content,$mail_info);
	ob_clean(); 
	ob_end_flush(); 
}

function weixin_information_master($pdo,$table_pre,$language,$account,$v,$type){
	global $information_email,$information_weixin;
	if($information_weixin && $information_email){return true;}
	//var_dump($information);
	$sql="select `username`,`nickname` from ".$table_pre."user where `wid`='".$v->ToUserName."' and `openid`='".$v->FromUserName."'";
	$r=$pdo->query($sql,2)->fetch(2);
	
	$name='';
	if($r['nickname']!=''){$name=$r['nickname'];}elseif($r['username']!=''){$name=$r['username'];}
	
	if($account['if_email']!='' && $account['smtp_url']!=''  && $account['smtp_account']!=''  && $account['smtp_password']!=''){
		if($information_email){return true;}
		if(($type=='receive' && $account['receive_if_email']==1) || ($type=='no_keyword' && $account['no_keyword_if_email']==1) || ($type=='no_search' && $account['no_search_if_email']==1)){
			if($name==''){
				$title=$account['name'].$language['receive_msg'].':'.@$v->Content;
			}else{
				$title='《'.$account['name'].'》'.$language['receive2'].' '.$r['nickname'].' '.$language['msg'].':'.@$v->Content;
			}
			$content=$language['view'].$language['url'].':<a href="'.get_monxin_path().'index.php?monxin=weixin.dialog&wid='.$v->ToUserName.'&openid='.$v->FromUserName.'" target=_blank>'.get_monxin_path().'index.php?monxin=weixin.dialog&wid='.$v->ToUserName.'&openid='.$v->FromUserName.'</a>';
			$information_email=true;
			weixin_send_email($account,$title,$content);
		}
		
	}
	//var_dump($account['if_weixin']);
	if($account['if_weixin']!='' && $account['AppId']!=''  && $account['AppSecret']!=''){
		if($information_weixin){return true;}
		
		$url=get_monxin_path().'index.php?monxin=weixin.dialog&wid='.$v->ToUserName.'&openid='.$v->FromUserName;
		$first=str_replace('{name}',$account['name'],$language['you_wexin_have_new_msg']);
		$config=require('./config.php');
		
		$sql="select `nickname` from ".$table_pre."user where `openid`='".$v->FromUserName."' and `wid`='".$v->ToUserName."' limit 0,1";
		$temp=$pdo->query($sql,2)->fetch(2);
		
		push_new_msg_info($pdo,$config,$language,$account['if_weixin'],@$temp['nickname'],@$v->Content,$url,$first);
		//exit;
		/*
		$token=receive::get_access_token($pdo,$account['AppId'],$account['AppSecret']);
		//var_dump($token);
		if($token===false){return false;}
		if(($type=='receive' && $account['receive_if_weixin']==1) || ($type=='no_keyword' && $account['no_keyword_if_weixin']==1) || ($type=='no_search' && $account['no_search_if_weixin']==1)){
			if($name==''){
				$title=$account['name'].$language['receive_msg'].':'.@$v->Content;
			}else{
				$title='《'.$account['name'].'》'.$language['receive2'].' '.$r['nickname'].' '.$language['msg'].':'.@$v->Content;
			}
			$content=$language['view'].$language['url'].':'.get_monxin_path().'index.php?monxin=weixin.dialog&wid='.$v->ToUserName.'&openid='.$v->FromUserName;
			$information_weixin=true;
			$str='{
    "touser":"'.$account['if_weixin'].'",
    "msgtype":"text",
     "text":
    {
         "content":"'.$title.'
		 
		 '.$content.'"
    }
}';
			$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$token;
			//echo $url;
			$r=https_post($url,$str);
		}
	*/	
	}
	$information=true;
}
function transfer_customer_service($fromUsername,$toUsername){
	$str='<xml>
				<ToUserName><![CDATA['.$fromUsername.']]></ToUserName>
				<FromUserName><![CDATA['.$toUsername.']]></FromUserName>
				<CreateTime>'.time().'</CreateTime>
				<MsgType><![CDATA[transfer_customer_service]]></MsgType>
				</xml>';		
	ob_end_clean(); 
	//file_put_contents('./tr.txt',$str);
	echo $str;
	exit();
}

function weixin_responseMsg($pdo,$table_pre,$language){
	//get post data, May be due to the different environments
	//if(weixin_checkSignature()===false){return false;} 
	libxml_disable_entity_loader(true);
	$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
	$postStr=safe_str($postStr);
	//file_put_contents('responseMsg.txt',$postStr);
	//extract post data
	if (!empty($postStr)){
			
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$last_msgid='./program/weixin/last_msgid.txt';
			if(isset($postObj->MsgId)){
				if($postObj->MsgId==file_get_contents($last_msgid)){exit;}
				file_put_contents($last_msgid,$postObj->MsgId);
			}
			$fromUsername = $postObj->FromUserName;
			$toUsername = $postObj->ToUserName;
			$keyword =trim($postObj->Content);
			$MsgType=$postObj->MsgType;
			$Event=@$postObj->Event;
			$EventKey=@$postObj->EventKey;
			$time = time();
			
			$sql="select * from ".$table_pre."account where `wid`='".$toUsername."'";
			$account=$pdo->query($sql,2)->fetch(2);
			if($account['state']!=1){exit;}
			if($MsgType!='event' && $account['receptionist_power']){weixin_information_master($pdo,$table_pre,$language,$account,$postObj,'receive');}
			switch ($MsgType) {
				case 'text':
					weixin_add_dialog($pdo,$table_pre,$postObj);
				break;

				case 'event':
				//file_put_contents('event_key.txt','event'.$Event);
					switch ($Event) {
						case 'subscribe':
							weixin_subscribe($pdo,$table_pre,$fromUsername,$toUsername);
							$keyword=$language['while'].':'.$language['receive_subscribe'].'|MsgType:event|Event:subscribe';
							if($EventKey!='' && strpos($EventKey,'last_trade_no_')===false){$keyword='SCAN:'.str_replace('qrscene_','',$EventKey);}
						break;
						case 'unsubscribe':
							weixin_unsubscribe($pdo,$table_pre,$fromUsername,$toUsername);
							$keyword=$language['while'].':'.$language['receive_unsubscribe'].'|MsgType:event|Event:unsubscribe';
						break;
						case 'SCAN':
							$keyword='SCAN:'.$EventKey;
						break;
						case 'CLICK':
							$sql="select `name` from ".$table_pre."menu where `url`='".$EventKey."' and `wid`='".$toUsername."'";
							$temp=$pdo->query($sql,2)->fetch(2);
							$keyword=$language['menu'].':'.$temp['name'].'|EventKey:'.$EventKey.'|MsgType:event|Event:CLICK';
						break;
						case 'LOCATION':
							$latitude=$postObj->Latitude;
							$longitude=$postObj->Longitude;
							$precision=$postObj->Precision;
							$t_time=time()-60;
							$sql="select `id` from ".$table_pre."user_location where `openid`='".$fromUsername."' and `wid`='".$toUsername."' and `time`>".$t_time." and `latitude`='".$latitude."' and `longitude`='".$longitude."' limit 0,1";
							$temp=$pdo->query($sql,2)->fetch(2);
							if($temp['id']==''){
								$sql="insert into ".$table_pre."user_location (`wid`,`openid`,`time`,`latitude`,`longitude`,`precision`) values ('".$toUsername."','".$fromUsername."','".time()."','".$latitude."','".$longitude."','".$precision."')";
								$pdo->exec($sql);
								
								$sql="update ".$table_pre."user set `latitude`='".$latitude."',`longitude`='".$longitude."' where `wid`='".$toUsername."' and `openid`='".$fromUsername."' ";
								$pdo->exec($sql);
								
							}
							$keyword='';
						break;

					}
				break;
				case 'location':
					weixin_add_dialog($pdo,$table_pre,$postObj);
					$keyword=$language['while'].':'.$language['receive_location'].'|MsgType:location';
				break;
				case 'image':
					weixin_add_dialog($pdo,$table_pre,$postObj);
					$keyword=$language['while'].':'.$language['receive_image'].'|MsgType:image';
				break;
				case 'voice':
					weixin_add_dialog($pdo,$table_pre,$postObj);
					$keyword=$language['while'].':'.$language['receive_voice'].'|MsgType:voice';
				break;
				case 'video':
					weixin_add_dialog($pdo,$table_pre,$postObj);
					$keyword=$language['while'].':'.$language['receive_video'].'|MsgType:video';
				break;
				case 'link':
					weixin_add_dialog($pdo,$table_pre,$postObj);
					$keyword=$language['while'].':'.$language['receive_link'].'|MsgType:link';
				break;
			}
			
			if(stripos($keyword,'SCAN:new_user__')!==false){
				$temp=explode('__',$keyword);
				if(isset($temp[1])){
					$sql="select `username` from ".$pdo->index_pre."user where `id`=".intval($temp[1]);
					$t2=$pdo->query($sql,2)->fetch(2);
					if($t2['username']!=''){wx_diy_qr_crate_user($pdo,$language,$fromUsername,$toUsername,$t2['username']);}
					$keyword=$language['while'].':'.$language['receive_subscribe'].'|MsgType:event|Event:subscribe';
					
				}
			}
			
			
			
			if(stripos($keyword,'SCAN:mall_shop__')!==false){
				$temp=explode('__',$keyword);
				if(is_file('./program/weixin/function/mall_shop.php') && isset($temp[1])){
					$sql="select `username` from ".$pdo->sys_pre."mall_shop where `id`=".intval($temp[1]);
					$t2=$pdo->query($sql,2)->fetch(2);
					wx_diy_qr_crate_user($pdo,$language,$fromUsername,$toUsername,$t2['username']);
					require('./program/weixin/function/mall_shop.php');
					$data=mall_shop($pdo,$table_pre,$language,$fromUsername,$postObj,$temp[1]);
					$f='weixin_news_to_xml';
					$v=receive::$f($data);
					$fromUsername=de_safe_str($fromUsername);
					$toUsername=de_safe_str($toUsername);					
					$str = '<xml>
								<ToUserName><![CDATA['.$fromUsername.']]></ToUserName>
								<FromUserName><![CDATA['.$toUsername.']]></FromUserName>
								<CreateTime>'.$time.'</CreateTime>
								'.$v.'
							</xml>'; 
					ob_end_clean(); 
					echo $str;exit;
				}
			}
			
			
			if(stripos($keyword,'SCAN:trip_shop__')!==false){
				$temp=explode('__',$keyword);
				if(is_file('./program/weixin/function/trip_shop.php') && isset($temp[1])){
					$sql="select `username` from ".$pdo->sys_pre."trip_shop where `id`=".intval($temp[1]);
					$t2=$pdo->query($sql,2)->fetch(2);
					wx_diy_qr_crate_user($pdo,$language,$fromUsername,$toUsername,$t2['username']);
					require('./program/weixin/function/trip_shop.php');
					$data=trip_shop($pdo,$table_pre,$language,$fromUsername,$postObj,$temp[1]);
					$f='weixin_news_to_xml';
					$v=receive::$f($data);
					$fromUsername=de_safe_str($fromUsername);
					$toUsername=de_safe_str($toUsername);					
					$str = '<xml>
								<ToUserName><![CDATA['.$fromUsername.']]></ToUserName>
								<FromUserName><![CDATA['.$toUsername.']]></FromUserName>
								<CreateTime>'.$time.'</CreateTime>
								'.$v.'
							</xml>'; 
					ob_end_clean(); 
					echo $str;exit;
				}
			}
			
			

        if(stripos($keyword,'SCAN:agency_store__')!==false){			
            $temp=explode('__',$keyword);
            if(is_file('./program/weixin/function/agency_store.php') && isset($temp[1])){
				$sql="select `username` from ".$pdo->sys_pre."agency_store where `id`=".intval($temp[1]);
				$t2=$pdo->query($sql,2)->fetch(2);
				wx_diy_qr_crate_user($pdo,$language,$fromUsername,$toUsername,$t2['username']);				
				
                require('./program/weixin/function/agency_store.php');				
                $data=agency_store($pdo,$table_pre,$language,$fromUsername,$postObj,$temp[1]);
                $f='weixin_news_to_xml';
                $v=receive::$f($data);
                $fromUsername=de_safe_str($fromUsername);
                $toUsername=de_safe_str($toUsername);
                $str = '<xml>
								<ToUserName><![CDATA['.$fromUsername.']]></ToUserName>
								<FromUserName><![CDATA['.$toUsername.']]></FromUserName>
								<CreateTime>'.$time.'</CreateTime>
								'.$v.'
						</xml>';				
                ob_end_clean();
                echo $str;
				exit;
            }
        }

        if(stripos($keyword,'SCAN:bargain__')!==false){			
            $temp=explode('__',$keyword);
            if(is_file('./program/weixin/function/bargain.php') && isset($temp[1])){
				$sql="select `username` from ".$pdo->sys_pre."bargain_log where `id`=".intval($temp[1]);
				$t2=$pdo->query($sql,2)->fetch(2);
				wx_diy_qr_crate_user($pdo,$language,$fromUsername,$toUsername,$t2['username']);				
				
                require('./program/weixin/function/bargain.php');				
                $data=bargain($pdo,$table_pre,$language,$fromUsername,$postObj,$temp[1]);
                $f='weixin_news_to_xml';
                $v=receive::$f($data);
                $fromUsername=de_safe_str($fromUsername);
                $toUsername=de_safe_str($toUsername);
                $str = '<xml>
								<ToUserName><![CDATA['.$fromUsername.']]></ToUserName>
								<FromUserName><![CDATA['.$toUsername.']]></FromUserName>
								<CreateTime>'.$time.'</CreateTime>
								'.$v.'
						</xml>';				
                ob_end_clean();
                echo $str;
				exit;
            }
        }


			
			
			if($account['receptionist_power']==1 && $account['receptionist_open']==1 && $account['receptionist_where']==0){transfer_customer_service($fromUsername,$toUsername);}
			$v='';
			$sql="select `id`,`input_type`,`output_type`,`text`,`image`,`voice`,`video`,`function` from ".$table_pre."auto_answer where `wid`='".$toUsername."' and `key`='".$keyword."' and `state`=1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']==''){
			
				$sql="select `id`,`input_type`,`output_type`,`text`,`image`,`voice`,`video`,`function` from ".$table_pre."auto_answer where `wid`='".$toUsername."' and `like`=1 and `key` like '%".$keyword."%' and `state`=1";
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['id']==''){
					if($account['receptionist_power']==1 && $account['receptionist_open']==1 && $account['receptionist_where']==1){
						transfer_customer_service($fromUsername,$toUsername);
					}
					if($MsgType!='event'){weixin_information_master($pdo,$table_pre,$language,$account,$postObj,'receive');}
					if($account['open_search']){
						$v=receive::call_search_function($account,$pdo,$language,$keyword,$toUsername);				
					}					
					
					if($v==''){
						if($account['receptionist_power']==1 && $account['receptionist_open']==1 && $account['receptionist_where']==2){
							transfer_customer_service($fromUsername,$toUsername);
						}
						if($MsgType!='event'){weixin_information_master($pdo,$table_pre,$language,$account,$postObj,'receive');}
						$keyword=$language['no_keyword_and_no_search_then_answer'].':no_keyword_and_no_search_then_answer';
						$sql="select `id`,`input_type`,`output_type`,`text`,`image`,`voice`,`video`,`function`,`state` from ".$table_pre."auto_answer where `wid`='".$toUsername."' and `key`='".$keyword."'";
						$r=$pdo->query($sql,2)->fetch(2);
						if($r['state']!=1){exit;}
						if($r['id']!=''){$v=weixin_get_auto_answer_xml($pdo,$table_pre,$r,$fromUsername,$language,$postObj);}	
									
					}
					
				}else{
					$v=weixin_get_auto_answer_xml($pdo,$table_pre,$r,$fromUsername,$language,$postObj);
				}
			}else{
				$v=weixin_get_auto_answer_xml($pdo,$table_pre,$r,$fromUsername,$language,$postObj);
			}
			
			$fromUsername=de_safe_str($fromUsername);
			$toUsername=de_safe_str($toUsername);
			
			$str = '<xml>
						<ToUserName><![CDATA['.$fromUsername.']]></ToUserName>
						<FromUserName><![CDATA['.$toUsername.']]></FromUserName>
						<CreateTime>'.$time.'</CreateTime>
						'.$v.'
						</xml>'; 
			
			/*$str='<xml>
						<ToUserName><![CDATA['.$fromUsername.']]></ToUserName>
						<FromUserName><![CDATA['.$toUsername.']]></FromUserName>
						<CreateTime>'.$time.'</CreateTime>
						<MsgType><![CDATA[transfer_customer_service]]></MsgType>
						</xml>';		
			*/
			//file_put_contents('testwww.txt',$str);
			//$resultStr = sprintf($str, $fromUsername, $toUsername, $time);
			//$resultStr=$str;
			ob_end_clean(); 
			echo $str;
	}else {
		echo "";
		exit;
	}
}




function weixin_checkSignature(){
	$signature = $_GET["signature"];
	$timestamp = $_GET["timestamp"];
	$nonce = $_GET["nonce"];	
			
	$token = TOKEN;
	$tmpArr = array($token, $timestamp, $nonce);
	sort($tmpArr, SORT_STRING);
	$tmpStr = implode( $tmpArr );
	$tmpStr = sha1( $tmpStr );	
	if( $tmpStr == $signature ){
		return true;
	}else{
		return false;
	}
}

function weixin_valid(){
	$echoStr = $_GET["echostr"];
	//valid signature , option
	if(weixin_checkSignature()){
		echo $echoStr;
		exit;
	}else{
		//file_put_contents('test.txt',$_GET["echostr"].'='.$_GET["signature"]);
	}
}	

