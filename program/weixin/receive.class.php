<?php
class receive{
	public static $config,$language,$table_pre;
	function __construct($pdo){
		if(!self::$config){
			//echo 'construct<br>';
			global $config,$language,$program,$page;
			$program_config=require_once './program/'.$program.'/config.php';
			$program_language=require_once './program/'.$program.'/language/'.$program_config['program']['language'].'.php';
			self::$config=array_merge($config,$program_config);
			self::$language=array_merge($language,$program_language);
			self::$table_pre=$pdo->sys_pre.self::$config['class_name']."_";
		}		
	
	}
	
	function __call($method,$args){
		//var_dump( $args);
		@require "./plugin/set_magic_quotes_gpc_off/set_magic_quotes_gpc_off.php";
		$pdo=$args[0];
		$call=$method;
		$class=__CLASS__;
		$method=$class."::".$method;
		require './program/'.self::$config['class_name'].'/receive/'.$call.'.php';
   }
	//=================================================================================================check_wid_power	
	static function check_wid_power($pdo,$table_pre){
		$wid=safe_str(@$_GET['wid']);
		$sql="select `username`,`state`,`manager` from ".$table_pre."account where `wid`='".$wid."'";
		$r=$pdo->query($sql,2)->fetch(2);
		$manager=explode(',',de_safe_str($r['manager']));
		if($_SESSION['monxin']['username']!=$r['username'] && !in_array($_SESSION['monxin']['username'],$manager)){return false;}
		return $r['state'];
	}
	static function subscribe_notice_master($pdo,$table_pre,$toUsername,$fromUsername){
		$sql="select `nickname` from ".$table_pre."user where `wid`='".$toUsername."' and `openid`='".$fromUsername."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['nickname']!=''){$nickname=de_safe_str($r['nickname']);}else{$nickname=$fromUsername;}
		$sql="select `if_weixin`,`name` from ".$table_pre."account where `wid`='".$toUsername."' limit 0,1";
		//file_put_contents('sql.txt',$sql);
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['if_weixin']!=''){	
			$url=get_monxin_path().'index.php?monxin=weixin.dialog&wid='.$toUsername.'&openid='.$fromUsername;
			$first=str_replace('{name}',$r['name'],self::$language['you_wexin_have_new_msg']);	
			push_new_msg_info($pdo,self::$config,self::$language,$r['if_weixin'],$nickname,'刚关注了公众号',$url,$first);
			
			/*
			$v='{
			"touser":"'.de_safe_str($r['if_weixin']).'",
			"msgtype":"text",
			"text":
			{
				 "content":"'.$nickname.' 刚关注了公众号：'.de_safe_str($r['name']).',聊天链接 http://'.self::$config['web']['domain'].'/index.php?monxin=weixin.dialog&wid='.$toUsername.'&openid='.$fromUsername.'"
			}
		}  ';
			$r=self::weixin_send_msg($pdo,$table_pre,$toUsername,$v);
			//file_put_contents('send.txt',$v.'  '.var_export($r));
			*/
		}
	}
	function del_account_receive_data($pdo,$table_pre,$wid){
		$sql="delete from ".$table_pre."menu where `wid`='".$wid."'";
		$pdo->exec($sql);
		
		$sql="select * from ".$table_pre."auto_answer where `wid`='".$wid."'";
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			$sql="delete from ".$table_pre."auto_answer where `id`='".$v['id']."'";
			if($pdo->exec($sql)){
				$this->del_auto_answer_files($pdo,self::$table_pre,$v,$v['id']);
			}
		}

		$sql="delete from ".$table_pre."user where `wid`='".$wid."'";
		$pdo->exec($sql);
		
		$sql="select * from ".$table_pre."dialog where `wid`='".$wid."'";
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			$sql="select * from ".$table_pre."dialog where `id`='".$v['id']."'";
			$r2=$pdo->query($sql,2)->fetch(2);
			$sql="delete from ".$table_pre."dialog where `id`='".$v['id']."'";
			if($pdo->exec($sql)){
				self::del_dialog_file($r2,$wid);
				//$this->del_dialog_files($pdo,self::$table_pre,$v,$v['id']);
			}
		}
		
		$sql="select * from ".$table_pre."mass where `wid`='".$wid."'";
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			$sql="delete from ".$table_pre."mass where `id`='".$v['id']."'";
			if($pdo->exec($sql)){
				safe_unlink('./program/weixin/image/'.$v['icon']);
			}
		}
	}

	
	function del_auto_answer_files($pdo,$table_pre,$r,$id){
		if($r['image']!=''){@safe_unlink('./program/weixin/image/'.$r['image']);@safe_unlink('./program/weixin/image_thumb/'.$r['image']);}
		if($r['voice']!=''){@safe_unlink('./program/weixin/voice/'.$r['voice']);}
		if($r['video']!=''){@safe_unlink('./program/weixin/video/'.$r['video']);}
		if($r['input_type']=='single_news'){
			$sql="select `img` from ".$table_pre."single_news where `key_id`='".$id."'";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['img']!=''){@safe_unlink('./program/weixin/image/'.$r['img']);@safe_unlink('./program/weixin/image_thumb/'.$r['img']);}
			$sql="delete from ".$table_pre."single_news where `key_id`='".$id."'";
			$pdo->exec($sql);	
		}elseif($r['input_type']=='news'){
			$sql="select `img` from ".$table_pre."news where `key_id`='".$id."'";
			$r=$pdo->query($sql,2);
			foreach($r as $v){
				if($v['img']!=''){@safe_unlink('./program/weixin/image/'.$v['img']);@safe_unlink('./program/weixin/image_thumb/'.$v['img']);}
			}
			
			$sql="delete from ".$table_pre."news where `key_id`='".$id."'";
			$pdo->exec($sql);	
		}
			
	}
	
	static function del_dialog_file($v,$wid){
		if($v['from']!=$wid){
			$file_type=array('image','voice','video');
			if(in_array($v['input_type'],$file_type)){
				if($v['content']!=''){
					@safe_unlink('./program/weixin/'.$v['input_type'].'/'.$v['content']);
				}
			}
		}else{
			$a=json_decode($v['content'],1);
			$img_type=array('image','single_news','news');
			if(in_array($v['input_type'],$img_type)){
				foreach($a['news']['articles'] as $v2){
					if($v2['picurl']!=''){
						$path=explode('/weixin/',$v2['picurl']);
						$path=str_replace('image/','',$path[1]);
						$path=str_replace('image_thumb/','',$path);
						@safe_unlink('./program/weixin/image_thumb/'.$path);	
						@safe_unlink('./program/weixin/image/'.$path);	
					}	
				}
			}
		}
		return true;
	}
	
	static function del_multiple_dialog($pdo,$table_pre,$wid,$id){
		$sql="select `from` from ".$table_pre."dialog where `id`='$id' and `wid`='".$wid."'";
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="select `id` from ".$table_pre."dialog where (`from`='".$r['from']."' or `to`='".$r['from']."') and `wid`='".$wid."'";
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			$sql="select * from ".$table_pre."dialog where `id`='".$v['id']."' and `wid`='".$wid."'";
			$r=$pdo->query($sql,2)->fetch(2);
			$sql="delete from ".$table_pre."dialog where `id`='".$v['id']."' and `wid`='".$wid."'";
			if($pdo->exec($sql)){receive::del_dialog_file($r,$wid);}
				
		}
		return true;
	}
	
	function call_function($pdo,$table_pre,$language,$name,$type,$openid='',$postObj){
		$sql="select `name`,`state` from ".$table_pre."function where `name`='".$name."'";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['name']==''){$r['name']='function_not_found';}
		if($r['state']==0){$r['name']='function_close';}
		if(!is_file('./program/weixin/function/'.$r['name'].'.php')){$r['name']='function_not_found';}
		require('./program/weixin/function/'.$r['name'].'.php');
		$data=$r['name']($pdo,$table_pre,$language,$openid,$postObj);
		if($type!='xml'){
			$v=receive::weixin_news_to_json($data,$openid);		
			$result['data']=$v;
			$result['input_type']='news';
		}else{
			return $data;
		}
		return $result;	
	}
	
	function call_search_function($account,$pdo,$language,$key,$openid=''){
		if($key==''){return '';}
		$sql="select `name` from ".$pdo->sys_pre."weixin_search_function where `state`=1 order by `sequence` desc,`id` asc";
		$r=$pdo->query($sql,2);
		$result='';
		$data='';
		foreach($r as $v){
			if(!is_file('./program/weixin/search_function/'.$v['name'].'.php')){continue;}
			require('./program/weixin/search_function/'.$v['name'].'.php');
			$data=$v['name']($account,$pdo,$language,$key,$openid);
			if($data!=''){break;}
		}
		
		if($data==''){
			if($account['receptionist_power']==1 && $account['receptionist_open']==1 && $account['receptionist_where']==2){return '';}
			require('./program/weixin/search_function/not_found_content.php');
			$data=not_found_content($account,$pdo,$language,$key,$openid);
		}
		$v='';
		$v=receive::weixin_news_to_xml($data,$openid);		
		return $v;	
	}
	
	static function get_appid($pdo,$table_pre,$wid){
		if($wid==''){return false;}
		$sql="select `AppId`,`AppSecret` from ".$table_pre."account where `wid`='".$wid."'";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['AppId']=='' || $r['AppSecret']==''){exit("{'state':'fail','info':'<span class=fail>AppId or AppSecret is null</span>'}");}
		return $r;
	}
	
	static function get_access_token($pdo,$AppId,$AppSecret,$wid=''){
		
		//if($wid!=''){if(isset($_SESSION['monxin'][$wid])){return $_SESSION['monxin'][$wid];}}
		if($wid==''){
			$sql="select `wid` from ".self::$table_pre."account where `AppId`='".$AppId."' limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			$wid=$r['wid'];	
		}
			
		$sql="select `weixin_token` from ".$pdo->sys_pre."weixin_account where `wid`='".$wid."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['weixin_token']==''){
			set_weixin_info($wid,$pdo);
			return get_weixin_info($wid,$pdo);
		}
		
		$r=de_safe_str($r);
		$r=json_decode($r['weixin_token'],1);
		if($r['expires_in']+3600<time()){
			set_weixin_info($wid,$pdo);
			$sql="select `weixin_token` from ".$pdo->sys_pre."weixin_account where `wid`='".$wid."' limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			$r=de_safe_str($r);
			$r=json_decode($r['weixin_token'],1);
		}		
		return $r['token'];
		/*
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$AppId."&secret=".$AppSecret;
		$content = file_get_contents($url);
		$info = json_decode($content);
		if($wid!=''){$_SESSION['monxin'][$wid]=$info->access_token;}
		if(isset($info->access_token)){return $info->access_token;}else{return false;}
		*/
	}
	
	static function weixin_send_msg($pdo,$table_pre,$wid,$v){
		$app=receive::get_appid($pdo,$table_pre,$wid);
		$access_token=receive::get_access_token($pdo,$app['AppId'],$app['AppSecret']);
		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
		$r=https_post($url,$v);
		$r=json_decode($r,1);
		if($r['errcode']!=0){return $r['errmsg'];}else{return true;}
	}
	
	function weixin_text_to_json($data,$touser){
		$json='{"touser":"'.$touser.'","msgtype":"text","text":{"content":"'.$data.'"}}';	
		return $json;
	}
	function weixin_image_to_json($data,$touser){
		$json='{
    "touser":"'.$touser.'",
    "msgtype":"news",
    "news":{
        "articles": [
         {
             "title":"",
             "description":"",
             "url":"'.$data['url'].'",
             "picurl":"'.$data['picurl'].'"
         }
         ]
    }
}';	
		return $json;
	}
	function weixin_voice_to_json($data,$touser){
		$json='{
    "touser":"'.$touser.'",
    "msgtype":"news",
    "news":{
        "articles": [
         {
             "title":"",
             "description":"",
             "url":"'.$data['url'].'",
             "picurl":"'.$data['picurl'].'"
         }
         ]
    }
}';	
		return $json;
	}
	function weixin_video_to_json($data,$touser){
		$json='{
    "touser":"'.$touser.'",
    "msgtype":"news",
    "news":{
        "articles": [
         {
             "title":"",
             "description":"",
             "url":"'.$data['url'].'",
             "picurl":"'.$data['picurl'].'"
         }
         ]
    }
}';	
		return $json;
	}
	function weixin_single_news_to_json($data,$touser){
		$json='{
    "touser":"'.$touser.'",
    "msgtype":"news",
    "news":{
        "articles": [
         {
             "title":"'.$data['title'].'",
             "description":"'.$data['description'].'",
             "url":"'.$data['url'].'",
             "picurl":"'.$data['picurl'].'"
         }
         ]
    }
}';	
		return $json;
	}
	function weixin_news_to_json($data,$touser){
		$i=0;
		$list='';
		foreach($data as $key=>$v){
			if($i>9){break;}
			$list.='{
             "title":"'.$v['title'].'",
             "description":"",
             "url":"'.$v['url'].'",
             "picurl":"'.$v['picurl'].'"
         },';
			
			$i++;	
		}
		
		$json='{
    "touser":"'.$touser.'",
    "msgtype":"news",
    "news":{
        "articles": [
        '.trim($list,',').'
         ]
    }
}';	
		return $json;
	}
	function weixin_image_to_xml($data){
		$xml='<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>1</ArticleCount>
<Articles>
<item>
<Title><![CDATA['.$data['title'].']]></Title> 
<Description><![CDATA['.$data['description'].']]></Description>
<PicUrl><![CDATA['.$data['picurl'].']]></PicUrl>
<Url><![CDATA['.$data['url'].']]></Url>
</item>
</Articles>';	
		return $xml;
	}
	function weixin_voice_to_xml($data){
		$xml='<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>1</ArticleCount>
<Articles>
<item>
<Title><![CDATA['.$data['title'].']]></Title> 
<Description><![CDATA['.$data['description'].']]></Description>
<PicUrl><![CDATA['.$data['picurl'].']]></PicUrl>
<Url><![CDATA['.$data['url'].']]></Url>
</item>
</Articles>';	
		return $xml;
	}
	function weixin_video_to_xml($data){
		$xml='<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>1</ArticleCount>
<Articles>
<item>
<Title><![CDATA['.$data['title'].']]></Title> 
<Description><![CDATA['.$data['description'].']]></Description>
<PicUrl><![CDATA['.$data['picurl'].']]></PicUrl>
<Url><![CDATA['.$data['url'].']]></Url>
</item>
</Articles>';	
		return $xml;
	}
	function weixin_single_news_to_xml($data){
		$xml='<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>1</ArticleCount>
<Articles>
<item>
<Title><![CDATA['.$data['title'].']]></Title> 
<Description><![CDATA['.$data['description'].']]></Description>
<PicUrl><![CDATA['.$data['picurl'].']]></PicUrl>
<Url><![CDATA['.$data['url'].']]></Url>
</item>
</Articles>';	
		return $xml;
	}
	function weixin_news_to_xml($data){
		$i=0;
		$list='';
		foreach($data as $key=>$v){
			if($i>9){break;}
			$list.='<item>
<Title><![CDATA['.$v['title'].']]></Title> 
<Description><![CDATA['.@$v['description'].']]></Description>
<PicUrl><![CDATA['.$v['picurl'].']]></PicUrl>
<Url><![CDATA['.$v['url'].']]></Url>
</item>
';
			
			$i++;	
		}
		$xml='<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>'.$i.'</ArticleCount>
<Articles>'.$list.'</Articles>';
		return $xml;
	}
	function weixin_function_to_xml($data){
		$i=0;
		$list='';
		foreach($data as $key=>$v){
			if($i>9){break;}
			$list.='<item>
<Title><![CDATA['.$v['title'].']]></Title> 
<Description><![CDATA['.@$v['description'].']]></Description>
<PicUrl><![CDATA['.$v['picurl'].']]></PicUrl>
<Url><![CDATA['.$v['url'].']]></Url>
</item>
';
			
			$i++;	
		}
		$xml='<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>'.$i.'</ArticleCount>
<Articles>'.$list.'</Articles>';
		return $xml;
	}
	
	static function save_media($url,$type){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);    
		curl_setopt($ch, CURLOPT_NOBODY, 0);    //对body进行输出。
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$package = curl_exec($ch);
		$httpinfo = curl_getinfo($ch);
		curl_close($ch);
		$media = array_merge(array('mediaBody' => $package), $httpinfo);
		
		//求出文件格式
		preg_match('/\w\/(\w+)/i', $media["content_type"], $extmatches);
		$fileExt = $extmatches[1];
		$filename = time().rand(100,999).".{$fileExt}";
		$dirname = get_date_dir('./program/weixin/'.$type.'/');
		if(!file_exists($dirname)){
			mkdir($dirname,0777,true);
		}
		file_put_contents($dirname.$filename,$media['mediaBody']);
		return str_replace('./program/weixin/'.$type.'/','',$dirname).$filename;
	}	
	
	
	
	
	
	static function weixin_get_user_info($pdo,$table_pre,$wid,$openid){
		$sql="select `id`,`nickname` from ".$table_pre."user where `openid`='".$openid."' and `wid`='".$wid."' limit 0,1";
		$r2=$pdo->query($sql,2)->fetch(2);
		if($r2['id']!=0 && $r2['nickname']!=''){return false;}
		$sql="select `AppId`,`AppSecret` from ".$table_pre."account where `wid`='".$wid."'";
		$r=$pdo->query($sql,2)->fetch(2);
		$access_token=receive::get_access_token($pdo,$r['AppId'],$r['AppSecret'],$wid);
		if($access_token===false){return false;}
		$url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
		$r=file_get_contents($url);
		//echo $r;
		$r=(json_decode($r,1));
		if(!is_array($r)){return false;}
		$r=safe_str($r);
		if($r['sex']==1){$r['sex']='男';}else{$r['sex']='女';}
		$r['nickname']=removeEmoji($r['nickname']);
		
		$sql="select `id`,`nickname` from ".$table_pre."user where `openid`='".$openid."' and `wid`='".$wid."' limit 0,1";
		$r2=$pdo->query($sql,2)->fetch(2);
		if($r2['id']==''){
			$time=time();
			$sql="insert into ".$table_pre."user (`openid`,`wid`,`subscribe`,`subscribe_time`,`time`,`nickname`,`sex`,`headimgurl`,`area`) values ('".$r['openid']."','".$wid."','".$r['subscribe']."','".$r['subscribe_time']."','".$r['subscribe_time']."','".$r['nickname']."','".$r['sex']."','".$r['headimgurl']."','".$r['country'].' '.$r['province'].' '.$r['city']."')";
		}else{
			$sql="update ".$table_pre."user set `subscribe`='".$r['subscribe']."',`nickname`='".$r['nickname']."',`sex`='".$r['sex']."',`headimgurl`='".$r['headimgurl']."',`subscribe_time`='".$r['subscribe_time']."',`area`='".$r['country'].' '.$r['province'].' '.$r['city']."' where `openid`='".$r['openid']."' and `wid`='".$wid."'";
		}
		return $pdo->exec($sql);
}
	
	static function weixin_set_user_tags($pdo,$table_pre,$wid,$openid){
		$sql="select `AppId`,`AppSecret` from ".$table_pre."account where `wid`='".$wid."'";
		$r=$pdo->query($sql,2)->fetch(2);
		$access_token=receive::get_access_token($pdo,$r['AppId'],$r['AppSecret'],$wid);
		if($access_token===false){return false;}
		$str='{
  "openid_list" : [
    "'.$openid.'"
  ],
  "tagid" : 2
}';
		$url="https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token=".$access_token;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $str);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$tmpInfo = curl_exec($ch);
		if (curl_errno($ch)) {
		echo 'Errno'.curl_error($ch);
		}
		curl_close($ch);
		$tmpInfo=json_decode($tmpInfo,true);
		if($tmpInfo['errmsg']!='ok'){return $tmpInfo['errcode'].$tmpInfo['errmsg'];}else{return true;}
}
	
	function get_media_id($access_token,$path){
		$url="http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token={$access_token}&type=thumb";
		//echo $url;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url );
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		//
		if(!class_exists('CURLFile')){
			curl_setopt($ch, CURLOPT_POSTFIELDS, array('media' => new CURLFile(realpath($path)))); 
		}else{
			$temp=__FILE__;
			$temp=explode("\\program\\",$temp);
			$fields	=	array("media" => '@'.str_replace("/","\\",$temp[0].trim($path,'.')));
			@curl_setopt($ch, CURLOPT_POSTFIELDS,$fields);
		}
		curl_setopt($ch, CURLOPT_INFILESIZE,filesize($path));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$tmpInfo = curl_exec($ch);
		if (curl_errno($ch)) {
		echo 'Errno'.curl_error($ch);
		}
		curl_close($ch);
		$tmpInfo=json_decode($tmpInfo,true);
		return $tmpInfo;
	}
	function add_material($access_token,$path){
		$url="https://api.weixin.qq.com/cgi-bin/material/add_material?access_token={$access_token}&type=image";
		//echo $url;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url );
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		//
		if(!class_exists('CURLFile')){
			curl_setopt($ch, CURLOPT_POSTFIELDS, array('media' => new CURLFile(realpath($path)))); 
		}else{
			$temp=__FILE__;
			$temp=explode("\\program\\",$temp);
			$fields	=	array("media" => '@'.str_replace("/","\\",$temp[0].trim($path,'.')));
			@curl_setopt($ch, CURLOPT_POSTFIELDS,$fields);
		}
		curl_setopt($ch, CURLOPT_INFILESIZE,filesize($path));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$tmpInfo = curl_exec($ch);
		if (curl_errno($ch)) {
		echo 'Errno'.curl_error($ch);
		}
		curl_close($ch);
		$tmpInfo=json_decode($tmpInfo,true);
		return $tmpInfo;
	}
}
?>