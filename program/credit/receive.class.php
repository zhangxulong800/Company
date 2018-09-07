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
	
	function delete_relevant($pdo,$credit_id){
		$sql="select `imgs` from ".self::$table_pre."log where `g_id`=".$credit_id;
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			if($v['imgs']==''){continue;}
			$imgs=explode('|',$v['imgs']);
			foreach($imgs as $img){
				if($img==''){continue;}
				@safe_unlink('./program/credit/img/'.$img);	
			}
		}
		$sql="delete from ".self::$table_pre."log where `g_id`=".$credit_id;
		$pdo->exec($sql);	
		$sql="delete from ".self::$table_pre."type where `g_id`=".$credit_id;
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
	
	
	
}
?>