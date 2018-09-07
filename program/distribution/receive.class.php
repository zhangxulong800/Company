<?php
/**
 *	商城数据接收类 示例 ./receive.php?target=distribution::goods_add (target=类名::方法名),大部分情况是通过 __call方法 加载执行 ./program/distribution/receive/ 目录下的对应名称的文件。
 */
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
			self::get_shop_id($pdo);
			self::exe_task_($pdo,$program_config);
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
   
//======================================================================================================= 执年任务
	function exe_task_($pdo,$program_config){
		$program_config=self::exe_task_y($pdo,$program_config);
		$program_config=self::exe_task_m($pdo,$program_config);
		$program_config=self::exe_task_d($pdo,$program_config);
		//$program_config=self::exe_task_h($pdo,$program_config);
		//$program_config=self::exe_task_minute($pdo,$program_config);
	}

//======================================================================================================= 执行年任务
	function exe_task_y($pdo,$program_config){
		
		$v=date('Y',time());
		if($v==$program_config['receive_task_y']){return $program_config;}
		$program_config['receive_task_y']=$v;
		
		
		
		file_put_contents('./program/distribution/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 执行月任务
	function exe_task_m($pdo,$program_config){
		$v=date('Y-m',time());
		if($v==$program_config['receive_task_m']){return $program_config;}
		$program_config['receive_task_m']=$v;
		
		
		
		file_put_contents('./program/distribution/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 执行日任务
	function exe_task_d($pdo,$program_config){
		$v=date('Y-m-d',time());
		if($v==$program_config['receive_task_d']){return $program_config;}
		$program_config['receive_task_d']=$v;
		file_put_contents('./program/distribution/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 执行时任务
	function exe_task_h($pdo,$program_config){
		$v=date('Y-m-d H',time());
		if($v==$program_config['receive_task_h']){return $program_config;}
		$program_config['receive_task_h']=$v;
		
		
		
		file_put_contents('./program/distribution/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 执行分钟任务
	function exe_task_minute($pdo,$program_config){
		$v=date('Y-m-d H:i',time());
		if($v==$program_config['receive_task_minute']){return $program_config;}
		$program_config['receive_task_minute']=$v;
		
		file_put_contents('./program/distribution/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 获取 店铺ID
	function get_shop_id($pdo){
		if(defined('SHOP_ID')){return false;}
		if(!isset($_SESSION['monxin']['username'])){define("SHOP_ID", 0);return true;}
		$sql="select `id` from ".$pdo->sys_pre."mall_shop where `username`='".$_SESSION['monxin']['username']."' and `state`=2 order by `id` desc limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){$r['id']=0;}
		define("SHOP_ID", $r['id']);return true;
	}
	
//======================================================================================================= 返回分销店ID 
	function get_store_id($pdo,$username){
		$sql="select `id` from ".self::$table_pre."store where `username`='".$username."'";
		$r=$pdo->query($sql,2)->fetch(2);
		return $r['id'];
	}
	
//======================================================================================================= 生成二维码
	function create_qr($txt,$logo_path,$save_path,$width){
		require('./plugin/qrcode/qrcode.php');
		$txt=str_replace('|||','&',$txt);
		QRcode::png($txt,$save_path);
		ob_end_clean();
		require('./lib/image.class.php');
		$image=new image();
		$image->thumb($save_path,$save_path,$width,$width);
		$image->thumb($logo_path,'./program/mall/temp.png',$width/8,$width/8);
		$image->imageMark($save_path,$save_path,'./program/mall/temp.png',5,100,1);
	}
	
	
//======================================================================================================= 设置分销店微信二维码
	function update_store_qr_path($pdo,$store_id){
		if(self::$config['web']['wid']!=''){
			get_weixin_info(self::$config['web']['wid'],$pdo); 
			$data='{
					"action_name": "QR_LIMIT_STR_SCENE", 
					"action_info": {
						"scene": {
							"scene_str": "distribution_store__'.$store_id.'"
						}
					}
				}';	
			$r= https_post('https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$_POST['monxin_weixin'][self::$config['web']['wid']]['token'],$data);
			$r=json_decode($r,1);
			if(isset($r['url'])){
				$sql="update ".self::$table_pre."store set `qr_path`='".safe_str($r['url'])."' where `id`='".$store_id."'";
				$pdo->exec($sql);
				return $r['url'];	
			}
		}
		return '';
	}	
	
	
	
	
}
?>