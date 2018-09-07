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
   
	function check_day_add_max($pdo,$table_pre,$max,$contact=''){
		$start_time=get_unixtime(date('Y-m-d',time()),'Y-m-d H:i:s');
		if($contact!=''){
			$sql="select count(id) as c from ".$table_pre."content where `add_time`>".$start_time." and `contact`='".$contact."'";
		}else{
			if(isset($_SESSION['monxin']['username'])){
				$sql="select count(id) as c from ".$table_pre."content where `add_time`>".$start_time." and `username`='".$_SESSION['monxin']['username']."'";
			}else{
				return true;	
			}
			
		}
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['c']>=$max){return false;}else{return true;}
	}
   
	function get_type_option_name($pdo,$id){
		$sql="select `name` from ".self::$table_pre."type_option where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		return $r['name'];	
	}
	
	//===============================================================================================get_type_position	
	function get_type_position($pdo,$id){
		if(intval($id)==0){return '<a href="./index.php?monxin=ci.list&order='.@$_GET['order'].'">'.self::$language['pages']['ci.type']['name'].'</a>';}
		$position='';
		$sql="select `name`,`parent`,`id` from ".self::$table_pre."type where `id`=$id";
		$r=$pdo->query($sql,2)->fetch(2);
		$position='<a href="./index.php?monxin=ci.list&type='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>';
		if($r['parent']>0){
			$sql="select `name`,`parent`,`id` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$position='<a href="./index.php?monxin=ci.list&type='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>'.$position;
		}
		if($r['parent']>0){
			$sql="select `name`,`parent`,`id` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$position='<a href="./index.php?monxin=ci.list&type='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>'.$position;
		}
		return $position;
	}

	function get_tags_name($pdo,$tag){
		$tag=str_replace('|',',',$tag);
		$tag=trim($tag,',');
		if($tag==''){return '';}
		$sql="select `name`,`id` from ".self::$table_pre."tag where `id` in (".$tag.")";
		$r=$pdo->query($sql,2);
		$temp='';
		foreach($r as $v){
			$temp.='<a href=./index.php?monxin=ci.list&tag='.$v['id'].'>'.$v['name'].'</a> , ';
		}
		$temp=trim($temp,' , ');
		return $temp;
			
	}
	//====================================================================================================get_type_ids	
	function get_type_ids($pdo,$id){
		$sql="select `id` from ".self::$table_pre."type where `parent`=$id";
		$r=$pdo->query($sql,2);
		$ids=$id.',';
		foreach($r as $v){
			$ids.=$v['id'].',';
			$sql2="select `id` from ".self::$table_pre."type where `parent`=".$v['id']."";
			$r2=$pdo->query($sql2,2);
			foreach($r2 as $v2){
				$ids.=$v2['id'].',';
				$sql3="select `id` from ".self::$table_pre."type where `parent`=".$v2['id']."";
				$r3=$pdo->query($sql3,2);
				foreach($r3 as $v3){
					$ids.=$v3['id'].',';
				}
			}
			
		}
		return trim($ids,',');
	}
}
?>