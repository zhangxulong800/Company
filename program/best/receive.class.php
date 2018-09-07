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
	
	function del_relevant($pdo,$id){
		$sql="select `content_pc`,`content_phone` from ".self::$table_pre."paragraph where `best_id`='$id'";
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
			$imgs=get_match_all($reg,$v['content_pc']);
			reg_attachd_img("del",self::$config['class_name'],$imgs,$pdo);	
			$imgs=get_match_all($reg,$v['content_phone']);
			reg_attachd_img("del",self::$config['class_name'],$imgs,$pdo);	
		}
		$sql="delete from ".self::$table_pre."paragraph where `best_id`='$id'";
		$pdo->exec($sql);
					
	}
	
	
	
}
?>