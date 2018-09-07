<?php
class receive{
	public static $config,$language,$table_pre;
	function __construct($pdo){
		if(!self::$config){
			//echo 'construct<br>';
			global $config,$language,$program,$module;
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

function update_module($pdo,$del_id=0){
	$program='diymodule';
	$module_config=require './program/'.$program.'/module_config.php';
	$program_config=require './program/'.$program.'/config.php';
	$program_language=require './program/'.$program.'/language/'.$program_config['program']['language'].'.php';
	
	if($del_id>0){
		unset($module_config['diymodule.show_'.$del_id]);
		unset($program_language['functions']['diymodule.show_'.$del_id]);
	}
	
	$sql="select `title`,`id` from ".self::$table_pre."module";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$id=$v['id'];
		$module_config['diymodule.show_'.$id]['edit_url']='index.php?monxin=diymodule.edit&id='.$id.'&';
		$module_config['diymodule.show_'.$id]['pagesize']='';
		$module_config['diymodule.show_'.$id]['share']=true;
		$program_language['functions']['diymodule.show_'.$id]['description']=$v['title'];
		$program_language['functions']['diymodule.show_'.$id]['power_suggest']='';
		
	}
	file_put_contents('./program/'.$program.'/module_config.php','<?php return '.var_export($module_config,true).'?>');

	file_put_contents('./program/'.$program.'/language/'.$program_config['program']['language'].'.php','<?php return '.var_export($program_language,true).'?>');
	
	
}
}
?>