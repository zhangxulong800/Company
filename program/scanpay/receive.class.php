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
	static function check_account_power($pdo,$table_pre){
		$wid=safe_str(@$_GET['wid']);
		$sql="select `username`,`state` from ".$table_pre."account where `wid`='".$wid."'";
		$r=$pdo->query($sql,2)->fetch(2);
		if($_SESSION['monxin']['username']!=$r['username']){return false;}
		return $r['state'];
	}
	
	function del_account_receive_data($pdo,$id){
		$sql="delete from ".self::$table_pre."pay where `a_id`='".$id."'";
		$pdo->exec($sql);	
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