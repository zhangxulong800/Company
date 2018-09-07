<?php
class im{
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

	
//=======================================================================================================
	function check_group_power($pdo,$g_id){
		$sql="select `username` from ".self::$table_pre."group where `id`=".$g_id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['username']!=$_SESSION['monxin']['username']){return false;}else{return true;}
	}
	
	function get_msg_content($pdo,$id){
		$sql="select `content` from ".self::$table_pre."msg where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		return de_safe_str($r['content']);
	}
	
	function get_talk_log_div($pdo,$a_id,$addressee,$icon,$my_icon){
		$sql="select `time`,`sender`,`msg_id`,`id` from ".self::$table_pre."msg_info where (`sender`='".$_SESSION['monxin']['username']."' or `sender`='".$addressee."') and (`addressee`='".$_SESSION['monxin']['username']."' or `addressee`='".$addressee."') and `delete_a`!='".$_SESSION['monxin']['username']."' and  `delete_b`!='".$_SESSION['monxin']['username']."' order by `time` desc limit 0,10";
		$r=$pdo->query($sql,2);
		$a=array();
		$ids='';
		foreach($r as $v){
			$list='';
			$list.='<div class=time>'.self::show_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time']).'</div>';
			$msg_c=self::get_msg_content($pdo,$v['msg_id']);
			if($msg_c==''){$list=''; continue;}
			
			if($v['sender']==$_SESSION['monxin']['username']){
				$list.='<div class="info me" id=info_'.$v['id'].'><div class=c><span class=content>'.$msg_c.'</span><span class=horn></span></div><a class=icon><img src="'.$my_icon.'" /></a></div>';
			}else{
				$list.='<div class="info you" id=info_'.$v['id'].'><a class=icon><img src="'.$icon.'" /></a><div class=c><span class=horn></span><span class=content>'.$msg_c.'</span></div></div>';
				$ids.=$v['id'].",";
			}
			$a[]=$list;
			
			
			
		}
		$ids=trim($ids,',');
		
		$list='';
		foreach($a as $v){
			$list=$v.$list;
		}
		if($list!=''){$list='<div class=view_more><a></a></div>'.$list;}
		return '<div class=talk_log id=log_'.$a_id.' ids="'.$ids.'">'.$list.'</div>';
		
	}
	

	function show_time($style,$timeoffset,$language,$time){
		if($time==0){return $language['none'];}
		$stime=$time;
		$time=time()-$time;
		if($time>43200){$time2=get_date($stime,'m/d H:i',$timeoffset);}
		if($time<43200){$time2=get_date($stime,'H:i',$timeoffset);}
		if($time<3600){$time2=get_date($stime,'H:i',$timeoffset);;}
		if($time<60){$time2=get_date($stime,'H:i',$timeoffset);}
		if($time<0){$time2=get_date($stime,'H:i',$timeoffset);}
		return $time2;
	}
	
	
	function add_addressee($pdo,$username,$addressee){
		$sql="select `id` from ".self::$table_pre."addressee where `addressee`='".$addressee."' and `username`='".$username."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){return false;}
		
		$sql="insert into ".self::$table_pre."addressee (`username`,`addressee`,`last_time`) values ('".$username."','".$addressee."','".time()."')";
		if($pdo->exec($sql)){
			return true;
		}else{
			return false;
		}	
		
	}
	
}

?>