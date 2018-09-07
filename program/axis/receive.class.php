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
	
	function delete_relevant($pdo,$axis_id){
		$sql="select `icon`,`content` from ".self::$table_pre."log where `g_id`=".$axis_id;
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			self::delete_log_img($pdo,$v);
		}
		$sql="delete from ".self::$table_pre."log where `g_id`=".$axis_id;
		$pdo->exec($sql);	
	}
	
	function delete_log_img($pdo,$r){
		@safe_unlink("./program/axis/img/".$r['icon']);
		
		$reg='#<img.*src=&\#34;(program/axis/attachd/.*)&\#34;.*>#iU';
		$imgs=get_match_all($reg,$r['content']);
		reg_attachd_img("del",'axis',$imgs,$pdo);				

	}
	
	function get_log_html($pdo,$language,$v){
		if($v['icon']==''){$v['icon']='<b bold="'.$v['bold'].'"></b>';}else{$v['icon']='<img src="./program/axis/img/'.$v['icon'].'" />';}
		if($v['date_name']==''){$v['date_name']=get_date($v['date'],'Y'.self::$language['Y'].'m'.self::$language['m'].'d'.self::$language['d'],self::$config['other']['timeoffset']);}
		$html="<div class=log_detail id=log_".$v['id']."><span class=date_name>".$v['date_name']."</span><span class=icon >".$v['icon']."<span class=bg_line></span></span><div class=content>".$v['content']."</div></div>";
		return $html;
	}
	
}
?>