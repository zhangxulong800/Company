<?php
class best{
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
	function show_head_data($pdo){
		$id=intval(@$_GET['id']);
		$p_id=intval(@$_GET['p_id']);
		if($id>0){
			$sql="select `title` from ".self::$table_pre."page where `id`='$id' and `visible`=1";
			$r=$pdo->query($sql,2)->fetch(2);
			$r=de_safe_str($r);
			if($r['title']==''){return  not_find();}
			if($p_id>0){
				$sql="select `title` from ".self::$table_pre."paragraph where `id`=".$p_id;	
				$r2=$pdo->query($sql,2)->fetch(2);
				$r['title'].=' '.$r2['title'];
			}
			$v['title']=$r['title'];	
			$v['keywords']=$r['title'];	
			$v['description']=$r['title'];	
			return $v;
		}
	}
	
}

?>