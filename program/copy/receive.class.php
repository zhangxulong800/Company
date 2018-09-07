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
		
	function gat_task_list($pdo,$r,$id,$url){
		$result=curl_open($url);
		if($r['page_charset']!='' && $r['page_charset']!='utf-8'){
			$result=iconv($r['page_charset'],"utf-8",$result);  
		}
		//echo $result;
		$r['detail_url_reg']=str_replace('!!',"\\",$r['detail_url_reg']);
		
		preg_match_all($r['detail_url_reg'],$result,$a);
		$new=0;
		for($i=0;$i<count($a[1]);$i++){
			$url=$r['detail_url_prefix'].$a[1][$i];
			$a[1][$i]=$url;
			$sql="select count(id) as c from ".self::$table_pre."task where `regular_id`='".$id."' and `url`='".$url."'";
			$r2=$pdo->query($sql,2)->fetch(2);
			if($r2['c']==0){
				$sql="insert into ".self::$table_pre."task (`regular_id`,`url`,`title`,`icon`,`state`,`time`) values ('".$id."','".$a[$r['detail_url']+1][$i]."','".$a[$r['detail_title']+1][$i]."','".get_img_absolute_path($a[$r['detail_icon']+1][$i],$url)."','0','0')";
				$pdo->exec($sql);
				$new++;	
			}
		}
		$re['sum']=$i++;
		$re['new']=$new;
		return $re;
	}
}
?>