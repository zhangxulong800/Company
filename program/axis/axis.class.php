<?php
class axis{
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
		if($id>0){
			$sql="select `name` from ".self::$table_pre."group where `id`='$id' and `state`=1";
			$r=$pdo->query($sql,2)->fetch(2);
			$r=de_safe_str($r);
			if($r['name']==''){return  not_find();}
			$v['title']=$r['name'];	
			$v['keywords']=$r['name'];	
			$v['description']=$r['name'];	
			return $v;
		}
	}
	
	function get_log_html($pdo,$language,$v){
		if($v['icon']==''){$v['icon']='<b bold="'.$v['bold'].'"></b>';}else{$v['icon']='<img src="./program/axis/img/'.$v['icon'].'" />';}
		if($v['date_name']==''){
			if($_COOKIE['monxin_device']=='pc'){
				$v['date_name']=get_date($v['date'],'Y'.self::$language['Y'].'m'.self::$language['m'].'d'.self::$language['d'],self::$config['other']['timeoffset']);
			}else{
				$v['date_name']='<div class=Y>'.get_date($v['date'],'Y',self::$config['other']['timeoffset']).'</div>'.get_date($v['date'],'m.d',self::$config['other']['timeoffset']);
			}
			
			}
		$html="<div class=log_detail id=log_".$v['id']."><span class=date_name>".$v['date_name']."</span><span class=icon >".$v['icon']."<span class=bg_line></span></span><div class=content>".$v['content']."</div></div>";
		return $html;
	}
	
}

?>