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
	
	function delete_relevant($pdo,$pk_id){
		$sql="delete from ".self::$table_pre."item where `pk_id`=".$pk_id;
		$pdo->exec($sql);	
		$sql="delete from ".self::$table_pre."object where `pk_id`=".$pk_id;
		$pdo->exec($sql);	
		$sql="delete from ".self::$table_pre."value where `pk_id`=".$pk_id;
		$pdo->exec($sql);	
	}
}
?>