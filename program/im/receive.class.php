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
	
	function delete_relevant($pdo,$im_id){
		$sql="select `imgs` from ".self::$table_pre."log where `g_id`=".$im_id;
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			if($v['imgs']==''){continue;}
			$imgs=explode('|',$v['imgs']);
			foreach($imgs as $img){
				if($img==''){continue;}
				@safe_unlink('./program/im/img/'.$img);	
			}
		}
		$sql="delete from ".self::$table_pre."log where `g_id`=".$im_id;
		$pdo->exec($sql);	
		$sql="delete from ".self::$table_pre."type where `g_id`=".$im_id;
		$pdo->exec($sql);	
	}
	
	function check_group_power($pdo,$g_id){
		$sql="select `username` from ".self::$table_pre."group where `id`=".$g_id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['username']!=$_SESSION['monxin']['username']){return false;}else{return true;}
	}
	
	function update_group_sum($pdo,$method,$g_id){
		$sql="select sum(`money`) as c from ".self::$table_pre."log where `method`=".$method." and `g_id`=".$g_id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['c']==''){$r['c']=0;}
		if($method==1){
			$sql="update ".self::$table_pre."group set `income`=".$r['c']." where `id`=".$g_id;	
		}else{
			$sql="update ".self::$table_pre."group set `expenditure`=".$r['c']." where `id`=".$g_id;		
		}
		$pdo->exec($sql);		
	}
	
	function update_type_sum($pdo,$method,$g_id,$type){
		$sql="select sum(`money`) as `money`,count(`id`) as `count` from ".self::$table_pre."log where `method`=".$method." and `g_id`=".$g_id." and `type`=".$type;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['money']==''){$r['money']=0;}
		if($r['count']==''){$r['count']=0;}
		$sql="update ".self::$table_pre."type set `sum_money`=".$r['money']." where `id`=".$type." and `g_id`=".$g_id;
		$pdo->exec($sql);		
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
	function get_msg_content($pdo,$id){
		$sql="select `content` from ".self::$table_pre."msg where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		return de_safe_str($r['content']);
	}
	
	function get_before_log($pdo,$a_id,$addressee,$icon,$my_icon,$max_id){
		$sql="select `time`,`sender`,`msg_id`,`id`,`addressee_state` from ".self::$table_pre."msg_info where `id`<".$max_id." and (`sender`='".$_SESSION['monxin']['username']."' or `sender`='".$addressee."') and (`addressee`='".$_SESSION['monxin']['username']."' or `addressee`='".$addressee."') and `delete_a`!='".$_SESSION['monxin']['username']."' and  `delete_b`!='".$_SESSION['monxin']['username']."' order by `time` desc limit 0,10";
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
		$sql="update ".self::$table_pre."msg_info set `addressee_state`=2 where `id` in (".$ids.") and `addressee`='".$_SESSION['monxin']['username']."' ";
		$r=$pdo->exec($sql);
		$list='';
		foreach($a as $v){
			$list=$v.$list;
		}
		if($list!=''){$list.='<div class=effect effect='.$r.'></div>';}
		return $list;
		
	}
	
	function delete_addressee_info($pdo,$addressee,$username){
		$sql="update ".self::$table_pre."msg_info set `delete_a`='".$username."' where `delete_a`='0' and (`sender`='".$username."' or `sender`='".$addressee."') and (`addressee`='".$username."' or `addressee`='".$addressee."')";
		$pdo->exec($sql);
		$sql="update ".self::$table_pre."msg_info set `delete_b`='".$username."' where `delete_b`='0' and `delete_a`!='".$username."' and (`sender`='".$username."' or `sender`='".$addressee."') and (`addressee`='".$username."' or `addressee`='".$addressee."')";
		$pdo->exec($sql);
		
	}
	
}
?>