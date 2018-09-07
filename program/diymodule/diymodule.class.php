<?php
class diymodule{
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
		$pdo=$args[0];
		$temp=explode("_",$method);
		if(count($temp)==2){
			if($temp[0]=='show' && is_numeric($temp[1])){
				$call='show';
				$class=__CLASS__;
				$method=$class."::show";
				if(in_array($class.'.'.$call,self::$config['program_unlogin_function_power'])){$m_require_login=0;}else{$m_require_login=1;}		
				require './program/'.$class.'/show/'.$call.'.php';
			}	
		}else{
			$call=$method;
			$class=__CLASS__;
			$method=$class."::".$method;
			if(in_array($class.'.'.$call,self::$config['program_unlogin_function_power'])){$m_require_login=0;}else{$m_require_login=1;}		
			require './program/'.$class.'/show/'.$call.'.php';
		}
   }


}

?>