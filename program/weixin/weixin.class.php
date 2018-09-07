<?php
class weixin{
	public static $config,$language,$table_pre,$module_config;
	function __construct($pdo){
		if(!self::$config){
			//echo 'construct<br>';
			global $config,$language,$page;
			$program=__CLASS__;
			$program_config=require './program/'.$program.'/config.php';
			$program_language=require './program/'.$program.'/language/'.$program_config['program']['language'].'.php';
			self::$config=array_merge($config,$program_config);
			self::$language=array_merge($language,$program_language);
			self::$table_pre=$pdo->sys_pre.self::$config['class_name']."_";
			self::$module_config=require './program/'.$program.'/module_config.php';

		}		
	
	}

	function __call($method,$args){
		//echo $args[1];
		//var_dump( $args);
		$pdo=$args[0];
		$call=$method;
		$class=__CLASS__;
		$method=$class."::".$method;
		if(in_array($class.'.'.$call,self::$config['program_unlogin_function_power'])){$m_require_login=0;}else{$m_require_login=1;}		
		require './program/'.$class.'/show/'.$call.'.php';
   }
	//=================================================================================================check_wid_power	
	function check_wid_power($pdo,$table_pre){
		$wid=safe_str(@$_GET['wid']);
		$sql="select `username`,`state`,`manager` from ".$table_pre."account where `wid`='".$wid."'";
		$r=$pdo->query($sql,2)->fetch(2);
		$manager=explode(',',de_safe_str($r['manager']));
		if($_SESSION['monxin']['username']!=$r['username'] && !in_array($_SESSION['monxin']['username'],$manager)){return false;}
		return $r['state'];
	}
	//====================================================================================================get_parent	
	function get_parent($pdo,$id=0,$deep=3,$wid){
		$sql="select `name`,`id` from ".self::$table_pre."menu where `parent`=0 and `id`!='$id' and `wid`='".$wid."' order by `sequence` desc";
		$stmt=$pdo->query($sql,2);
		$module['parent']="";
		foreach($stmt as $v){
			$v['name']=de_safe_str($v['name']);
			$module['parent'].="<option value='".$v['id']."'>&nbsp;&nbsp;&nbsp;&nbsp;".$v['name']."</option>";
			if($deep>1){
				$sql2="select `name`,`id` from ".self::$table_pre."menu where `parent`=".$v['id']." and  `id`!='$id'  and `wid`='".$wid."' order by `sequence` desc";
				$r=$pdo->query($sql2,2);
				foreach($r as $v2){
					$v2['name']=de_safe_str($v2['name']);
					$module['parent'].="<option value='".$v2['id']."' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$v2['name']."</option>";
					if($deep>2){
						
						$sql3="select `name`,`id` from ".self::$table_pre."menu where `parent`=".$v2['id']." and `id`!='$id' and `wid`='".$wid."' order by `sequence` desc";
						$r3=$pdo->query($sql3,2);
						foreach($r3 as $v3){
							
							$v3['name']=de_safe_str($v3['name']);
							$module['parent'].="<option value='".$v3['id']."'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$v3['name']."</option>";
						}	
					}
					
				}	
			}
		}
		return $module['parent'];			
	}
	
	function weixin_send_to_text($data){
		$data=str_replace("\r\n",'<br />',$data);
		$data=str_replace("\r",'<br />',$data);
		$data=str_replace("\n",'<br />',$data);
		$v=json_decode($data,1);
		return $v['text']['content'];
	}
	function weixin_send_to_image($data){
		$v=json_decode($data,1);
		$v='<a href='.$v['news']['articles'][0]['url'].' target="_blank"><img src='.$v['news']['articles'][0]['picurl'].' class=send_image></a>';
		return $v;
	}
	function weixin_send_to_voice($data){
		$v=json_decode($data,1);
		$path=$v['news']['articles'][0]['url'];
		$path=explode('path=',$path);
		$path=explode('&',$path[1]);
		$v='<audio src="./program/weixin/voice/'.$path[0].'" controls="controls">'.self::$language['your_browser_does_not_support_the_audio_tag'].'</audio>';
		return $v;
	}
	function weixin_send_to_video($data){
		$v=json_decode($data,1);
		$path=$v['news']['articles'][0]['url'];
		$path=explode('path=',$path);
		$path=explode('&',$path[1]);
		$v='<video src="./program/weixin/video/'.$path[0].'" controls="controls">'.self::$language['your_browser_does_not_support_the_video_tag'].'</video>';
		return $v;
	}
	function weixin_send_to_single_news($data){
		$v=json_decode($data,1);
		$path=$v['news']['articles'][0]['url'];
		$v='<a href="'.$v['news']['articles'][0]['url'].'" target="_blank" class=single_news><div class=title>'.$v['news']['articles'][0]['title'].'</div><div class=thumb_img><img src='.$v['news']['articles'][0]['picurl'].' /></div><div class=title>'.$v['news']['articles'][0]['description'].'</div></div>';
		return $v;
	}
	function weixin_send_to_news($data){
		$v=json_decode($data,1);
		$i=0;
		$list='';
		if(!is_array($v['news']['articles'])){return '';}
		foreach($v['news']['articles'] as $v){
			if($i==0){
				$list.='<a href="'.$v['url'].'" class=news_head target="_blank"><img src='.$v['picurl'].' class=head_img /><span class=title>'.$v['title'].'</span></a>';	
			}else{
				$list.='<a href="'.$v['url'].'" class=news_list target="_blank"><span class=title>'.$v['title'].'</span><img src='.$v['picurl'].' class=right_img /></a>';	
			}
			$i++;
		}
		$v='<div class=news>'.$list.'</div>';
		return $v;
	}
	function weixin_receive_to_text($data){
		return $data;
	}
	function weixin_receive_to_image($data){
		if(strpos($data,'http')===false){$data='./program/weixin/image/'.$data;}
		return '<a href="'.$data.'" target="_blank"><img src='.$data.'  class=receive_image /></a>';
	}
	function weixin_receive_to_voice($data){
		return '<audio src="./program/weixin/voice/'.$data.'" controls="controls">'.self::$language['your_browser_does_not_support_the_audio_tag'].'</audio>';
	}
	function weixin_receive_to_video($data){
		return '<video src="./program/weixin/video/'.$data.'" controls="controls">'.self::$language['your_browser_does_not_support_the_video_tag'].'</video>';
	}
	function weixin_receive_to_location($data){
		$data=json_decode($data,1);
		//var_dump($data);
		//$url='http://st.map.qq.com/api?size=604*300&center='.$data['Location_Y'].','.$data['Location_X'].'&zoom='.$data['Scale'].'&markers='.$data['Location_Y'].','.$data['Location_X'].','.urlencode($data['m_label']);
		$url='http://st.map.qq.com/api?size=604*300&center='.$data['Location_Y'].','.$data['Location_X'].'&zoom='.$data['Scale'].'&markers='.$data['Location_Y'].','.$data['Location_X'].',.';
		return '<a href="http://www.monxin.com/index.php?monxin=server.map&x='.$data['Location_X'].'&y='.$data['Location_Y'].'&zoom='.$data['Scale'].'" target="_blank" class=receive_location ><img src='.$url.' /></a>';
	}
	function weixin_receive_to_link($data){
		$data=json_decode($data,1);
		return '<a href="'.$data['Url'].'" title="'.$data['Description'].'" target="_blank" class=receive_link>'.$data['Title'].'</a>';
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
		if($r['weixin_token']==''){return set_weixin_info($wid,$pdo);}
		
		$r=de_safe_str($r);
		$r=json_decode($r['weixin_token'],1);
				
		return $r['token'];
		/*
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$AppId."&secret=".$AppSecret;
		$content = file_get_contents($url);
		$info = json_decode($content);
		if($wid!=''){$_SESSION['monxin'][$wid]=$info->access_token;}
		if(isset($info->access_token)){return $info->access_token;}else{return false;}
		*/
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
			$f['media'] = new CURLFile(realpath($path));
			curl_setopt($ch, CURLOPT_POSTFIELDS,  $f['media']); 
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
			$f['media'] = new CURLFile(realpath($path));
			curl_setopt($ch, CURLOPT_POSTFIELDS,  $f['media']); 
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