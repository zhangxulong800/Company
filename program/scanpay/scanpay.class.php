<?php
class scanpay{
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
		$sql="select `username`,`state` from ".$table_pre."account where `wid`='".$wid."'";
		$r=$pdo->query($sql,2)->fetch(2);
		if($_SESSION['monxin']['username']!=$r['username']){return false;}
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
	
	function scanpay_send_to_text($data){
		$v=json_decode($data,1);
		return $v['text']['content'];
	}
	function scanpay_send_to_image($data){
		$v=json_decode($data,1);
		$v='<a href='.$v['news']['articles'][0]['url'].' target="_blank"><img src='.$v['news']['articles'][0]['picurl'].' class=send_image></a>';
		return $v;
	}
	function scanpay_send_to_voice($data){
		$v=json_decode($data,1);
		$path=$v['news']['articles'][0]['url'];
		$path=explode('path=',$path);
		$path=explode('&',$path[1]);
		$v='<audio src="./program/scanpay/voice/'.$path[0].'" controls="controls">'.self::$language['your_browser_does_not_support_the_audio_tag'].'</audio>';
		return $v;
	}
	function scanpay_send_to_video($data){
		$v=json_decode($data,1);
		$path=$v['news']['articles'][0]['url'];
		$path=explode('path=',$path);
		$path=explode('&',$path[1]);
		$v='<video src="./program/scanpay/video/'.$path[0].'" controls="controls">'.self::$language['your_browser_does_not_support_the_video_tag'].'</video>';
		return $v;
	}
	function scanpay_send_to_single_news($data){
		$v=json_decode($data,1);
		$path=$v['news']['articles'][0]['url'];
		$v='<a href="'.$v['news']['articles'][0]['url'].'" target="_blank" class=single_news><div class=title>'.$v['news']['articles'][0]['title'].'</div><div class=thumb_img><img src='.$v['news']['articles'][0]['picurl'].' /></div><div class=title>'.$v['news']['articles'][0]['description'].'</div></div>';
		return $v;
	}
	function scanpay_send_to_news($data){
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
	function scanpay_receive_to_text($data){
		return $data;
	}
	function scanpay_receive_to_image($data){
		if(strpos($data,'http')===false){$data='./program/scanpay/image/'.$data;}
		return '<a href="'.$data.'" target="_blank"><img src='.$data.'  class=receive_image /></a>';
	}
	function scanpay_receive_to_voice($data){
		return '<audio src="./program/scanpay/voice/'.$data.'" controls="controls">'.self::$language['your_browser_does_not_support_the_audio_tag'].'</audio>';
	}
	function scanpay_receive_to_video($data){
		return '<video src="./program/scanpay/video/'.$data.'" controls="controls">'.self::$language['your_browser_does_not_support_the_video_tag'].'</video>';
	}
	function scanpay_receive_to_location($data){
		$data=json_decode($data,1);
		//var_dump($data);
		//$url='http://st.map.qq.com/api?size=604*300&center='.$data['Location_Y'].','.$data['Location_X'].'&zoom='.$data['Scale'].'&markers='.$data['Location_Y'].','.$data['Location_X'].','.urlencode($data['m_label']);
		$url='http://st.map.qq.com/api?size=604*300&center='.$data['Location_Y'].','.$data['Location_X'].'&zoom='.$data['Scale'].'&markers='.$data['Location_Y'].','.$data['Location_X'].',.';
		return '<a href="http://www.monxin.com/index.php?monxin=server.map&x='.$data['Location_X'].'&y='.$data['Location_Y'].'&zoom='.$data['Scale'].'" target="_blank" class=receive_location ><img src='.$url.' /></a>';
	}
	function scanpay_receive_to_link($data){
		$data=json_decode($data,1);
		return '<a href="'.$data['Url'].'" title="'.$data['Description'].'" target="_blank" class=receive_link>'.$data['Title'].'</a>';
	}
	
	function check_pay_power($pdo,$r){
		$temp=explode(',',de_safe_str($r['operator']));
		$temp[]=$r['username'];
		if($r['is_web']==1){
			return true;
		}else{
			if(in_array($_SESSION['monxin']['username'],$temp)){return true;}else{return false;}
		}
	}
	
}

?>