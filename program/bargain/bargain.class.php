<?php
/**
 *	商城数据显示类 示例 ./index.php?monxin=bargain.goods_add (monxin=类名.方法名)，大部分情况是通过 __call方法 加载执行 ./program/bargain/show/ 目录下的对应名称的文件
 */
class bargain{
	public static $config,$language,$table_pre,$module_config,$one_task;
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
			self::$one_task=false;
			if($_COOKIE['monxin_device']=='phone'){self::$one_task=true;}
			self::exe_task_($pdo,$program_config);
			self::get_shop_id($pdo);
			//echo '!isset<hr>';	
		}
		//echo '__construct<hr>';		
	}

	function __call($method,$args){
		$call_old_method=$method;
		$pdo=$args[0];
		$call=$method;
		$class=__CLASS__;
		$method=$call_old_method;
		$call=$method;
		$method=$class."::".$method;
		if(in_array($class.'.'.$call,self::$config['program_unlogin_function_power'])){$m_require_login=0;}else{$m_require_login=1;}		
		require './program/'.$class.'/show/'.$call.'.php';
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
		if($v==$program_config['task_y']){return $program_config;}
		$program_config['task_y']=$v;
		
		
		
		file_put_contents('./program/bargain/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 执行月任务
	function exe_task_m($pdo,$program_config){
		$v=date('Y-m',time());
		if($v==$program_config['task_m']){return $program_config;}
		$program_config['task_m']=$v;
		
		
		
		file_put_contents('./program/bargain/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 执行日任务
	function exe_task_d($pdo,$program_config){
		$v=date('Y-m-d',time());
		if($v==$program_config['task_d']){return $program_config;}
		$program_config['task_d']=$v;
		
		file_put_contents('./program/bargain/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 执行时任务
	function exe_task_h($pdo,$program_config){
		$v=date('Y-m-d H',time());
		if($v==$program_config['task_h']){return $program_config;}
		$program_config['task_h']=$v;
		file_put_contents('./program/bargain/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 执行分钟任务
	function exe_task_minute($pdo,$program_config){
		$v=date('Y-m-d H:i',time());
		if($v==$program_config['task_minute']){return $program_config;}
		$program_config['task_minute']=$v;
		
		file_put_contents('./program/bargain/config.php','<?php return '.var_export($program_config,true).'?>');
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
	
//======================================================================================================= 格式化商品数量后缀
	function format_quantity($v){
		if(!is_numeric($v)){return 0;}
		$v=sprintf("%.3f",$v);
		$v=rtrim($v,'0');
		$v=rtrim($v,'0');
		$v=rtrim($v,'.');
		return $v;
	}

	
//======================================================================================================= 获取商品原 网售价
	function get_goods_price($pdo,$goods_id){
		$sql="select `w_price`,`min_price`,`max_price`,`option_enable` from ".$pdo->sys_pre."mall_goods where `id`=".$goods_id;
		$r=$pdo->query($sql,2)->fetch();
		if($r['option_enable']==1){
			if($r['min_price']==$r['max_price']){
				$r['w_price']=$r['min_price'];
			}else{
				$r['w_price']=$r['min_price'].'-'.$r['max_price'];
			}
		}
		return $r['w_price'];
	}
	
	
	function delete_bargain($pdo,$id){
		$sql="delete from ".self::$table_pre."goods where `id`=".$id;
		if($pdo->exec($sql)){
			$sql="delete from ".self::$table_pre."log where `b_id`=".$id;
			$pdo->exec($sql);
			$sql="delete from ".self::$table_pre."detail where `b_id`=".$id;
			$pdo->exec($sql);
			return true;
		}
		return false;
	}
	
	function get_bargain_money($pdo,$gb,$log){
		$bargain=$gb['normal']-$gb['final_price'];
		if($bargain<=0){return 0;}
		if($log['money']>=$bargain){return 0;}
		$remain=$bargain-$log['money'];
		
		$average=$bargain/$gb['quantity'];
		$b=0;
		if($gb['method']==1){
			if($log['quantity']==0){$b=$gb['max_money'];}else{
				$b=self::get_bargain_index_money($bargain,$gb['quantity'],$log['quantity'],$gb['min_money'],$gb['max_money'],$gb['method']);
			}
		}
		if($gb['method']==2){
			$b=rand($gb['min_money']*100,$gb['max_money']*100);
			$b=$b/100;
		}
		if($gb['method']==3){
			if($log['quantity']==0){$b=$gb['min_money'];}else{
				$b=self::get_bargain_index_money($bargain,$gb['quantity'],$log['quantity'],$gb['min_money'],$gb['max_money'],$gb['method']);
			}
		}
		if($b>$remain){$b=$remain;}
		return $b;
	}
		
	function get_bargain_index_money($bargin,$quantity,$log_quantity,$min,$max,$sort){
		$average=$bargin/$quantity;
		$t=$max-$min;
		$step=$t/$quantity;
		$v=$quantity/2;
		$r=array();
		for($i=1;$i<=$v;$i++){
			$r[]=$average+$step*$i;
		}
		for($i=1;$i<=$v;$i++){
			$r[]=$average-$step*$i;
		}
		if($sort==1){
			rsort($r);
		}else{
			sort($r);
		}
		if(!isset($r[$log_quantity])){$r[$log_quantity]=0;}
		return $r[$log_quantity];
	}
	
	function detail_head_data($pdo){
		$id=intval(@$_GET['id']);
		$sql="select `g_id` from ".self::$table_pre."goods where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['g_id']==''){return '';}
		$sql="select `title` from ".$pdo->sys_pre."mall_goods where `id`=".$r['g_id'];
		$r=$pdo->query($sql,2)->fetch(2);
		$r=de_safe_str($r);
		$r['title']=@$r['title'];
		$v['title']=@$r['title'];	
		$v['keywords']=@$r['title'];	
		$v['description']=@$r['title'];	
		return $v;
	}
	
	
}
?>