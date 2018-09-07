<?php
/**
 *	商城数据显示类 示例 ./index.php?monxin=gbuy.goods_add (monxin=类名.方法名)，大部分情况是通过 __call方法 加载执行 ./program/gbuy/show/ 目录下的对应名称的文件
 */
class gbuy{
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
		
		
		
		file_put_contents('./program/gbuy/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 执行月任务
	function exe_task_m($pdo,$program_config){
		$v=date('Y-m',time());
		if($v==$program_config['task_m']){return $program_config;}
		$program_config['task_m']=$v;
		
		
		
		file_put_contents('./program/gbuy/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 执行日任务
	function exe_task_d($pdo,$program_config){
		$v=date('Y-m-d',time());
		if($v==$program_config['task_d']){return $program_config;}
		$program_config['task_d']=$v;
		
		file_put_contents('./program/gbuy/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 执行时任务
	function exe_task_h($pdo,$program_config){
		$v=date('Y-m-d H',time());
		if($v==$program_config['task_h']){return $program_config;}
		$program_config['task_h']=$v;
		file_put_contents('./program/gbuy/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 执行分钟任务
	function exe_task_minute($pdo,$program_config){
		$v=date('Y-m-d H:i',time());
		if($v==$program_config['task_minute']){return $program_config;}
		$program_config['task_minute']=$v;
		
		file_put_contents('./program/gbuy/config.php','<?php return '.var_export($program_config,true).'?>');
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
	
	
	function delete_gbuy($pdo,$id){
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
	
	function get_gbuy_money($pdo,$gb,$log){
		$gbuy=$gb['normal']-$gb['final_price'];
		if($gbuy<=0){return 0;}
		if($log['money']>=$gbuy){return 0;}
		$remain=$gbuy-$log['money'];
		
		$average=$gbuy/$gb['quantity'];
		$b=0;
		if($gb['method']==1){
			if($log['quantity']==0){$b=$gb['max_money'];}else{
				$b=self::get_gbuy_index_money($gbuy,$gb['quantity'],$log['quantity'],$gb['min_money'],$gb['max_money'],$gb['method']);
			}
		}
		if($gb['method']==2){
			$b=rand($gb['min_money']*100,$gb['max_money']*100);
			$b=$b/100;
		}
		if($gb['method']==3){
			if($log['quantity']==0){$b=$gb['min_money'];}else{
				$b=self::get_gbuy_index_money($gbuy,$gb['quantity'],$log['quantity'],$gb['min_money'],$gb['max_money'],$gb['method']);
			}
		}
		if($b>$remain){$b=$remain;}
		return $b;
	}
		
	function get_gbuy_index_money($bargin,$quantity,$log_quantity,$min,$max,$sort){
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
	
	
	function set_mall_order_out_id($pdo,$id){
		$time=time();
		$pre=date('Ymd',$time);
		$post=date('s',$time);
		$out_id=$pre.$id.$post;
		$sql="select `out_id` from ".$pdo->sys_pre."mall_order where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['out_id']!=0){return true;}
		$sql="update ".$pdo->sys_pre."mall_order set `out_id`='".$out_id."' where `id`=".$id;
		return $pdo->exec($sql);
	}
	
	function set_order_out_id($pdo,$id){
		$time=time();
		$pre=date('Ymd',$time);
		$post=date('s',$time);
		$out_id=$pre.$id.$post;
		$sql="select `out_id` from ".self::$table_pre."order where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['out_id']!=0){return true;}
		$sql="update ".self::$table_pre."order set `out_id`='".$out_id."' where `id`=".$id;
		return $pdo->exec($sql);
	}
	
	//=======================================================================================================【按商品先进先出方法，返回商品成本】
	function get_cost_price($pdo,$goods_id){
		$sql="select `price` from ".$pdo->sys_pre."mall_goods_batch where  `goods_id`='".$goods_id."' and `left`>0 order by `id` asc limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if(!$r['price']){
			$sql="select `price` from ".$pdo->sys_pre."mall_goods_batch where  `goods_id`='".$goods_id."' order by `id` desc limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
		}
		if(!$r['price']){$r['price']=0;}
		return $r['price'];	
	}	
//======================================================================================================= 返回商品单位的名称
	function get_mall_unit_name($pdo,$id){
		$sql="select `name`,`gram` from ".$pdo->sys_pre."mall_unit where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$_POST['temp_unit_gram']=$r['gram'];
		return $r['name'];	
	}
	
	
	
	function update_order_group($pdo,$id,$config,$language){
		$sql="select * from ".self::$table_pre."order where `id`=".$id;
		$order=$pdo->query($sql,2)->fetch(2);
		$sql="update ".$pdo->sys_pre."gbuy_group set `quantity`=`quantity`+1 where `id`=".$order['gr_id'];
		$pdo->exec($sql);
		$sql="select * from ".self::$table_pre."group where `id`=".$order['gr_id'];
		$gr=$pdo->query($sql,2)->fetch(2);
		
		$sql="select * from ".self::$table_pre."goods where `id`=".$order['b_id'];
		$b=$pdo->query($sql,2)->fetch(2);
		if($b['number']<=$gr['quantity']){
			
			//在商城提交订单
			$sql="select * from ".self::$table_pre."order where `gr_id`=".$order['gr_id'];
			$r=$pdo->query($sql,2);
			$time=time();
			foreach($r as $v){
				$sql="select * from ".$pdo->sys_pre."mall_goods where `id`=".$v['g_id'];
				$goods=$pdo->query($sql,2)->fetch(2);
				if($goods['option_enable']){
					$goods_cost=self::get_cost_price($pdo,$v['g_id'].'_'.$v['s_id']);
				}else{
					$goods_cost=self::get_cost_price($pdo,$v['g_id']);
				}
					
				
				$sql="select * from ".$pdo->sys_pre."mall_receiver where `id`=".$v['receiver_id'];
				$re=$pdo->query($sql,2)->fetch(2);
				
				$sql="insert into ".$pdo->sys_pre."mall_order (`add_time`,`last_time`,`shop_id`,`buyer`,`receiver_id`,`goods_money`,`actual_money`,`change_price_reason`,`pay_method`,`cashier`,`received_money`,`change`,`state`,`preferential_way`,`delivery_time`,`buyer_remark`,`express`,`preferential_code`,`weight`,`express_cost_buyer`,`sum_money`,`receiver_name`,`receiver_phone`,`receiver_area_id`,`receiver_detail`,`receiver_post_code`,`receiver_area_name`,`goods_names`,`share`,`goods_cost`,`goods_count`,`inventory_decrease`,`shop_credits`,`web_credits`,`shop_credits_money`,`web_credits_money`,`credits_remark`,`pre_sale`,`introducer`) values ('".$time."','".$time."','".$goods['shop_id']."','".$v['username']."','".$v['receiver_id']."','".$v['price']."','".$v['price']."','','','monxin','".$v['price']."','0','1','10','0','','0','','0','0','".$v['price']."','".$re['name']."','".$re['phone']."','".$re['area_id']."','".$re['detail']."','".$re['post_code']."','".get_area_name($pdo,$re['area_id'])."','".$v['g_title']."','','".$goods_cost."','1','0','0','0','0','0','','0','')";
				if($pdo->exec($sql)){
					$order_id=$pdo->lastInsertId();
					self::set_mall_order_out_id($pdo,$order_id);
					$temp_sql="select `id` from ".$pdo->sys_pre."mall_goods_snapshot where `goods_id`='".$v['g_id']."' order by `id` desc limit 0,1";
					$temp_r=$pdo->query($temp_sql,2)->fetch(2);
					$snapshot_id=(isset($temp_r['id']))?$temp_r['id']:0;;
					
					$temp=explode('/',$goods['icon']);
					@mkdir('./program/mall/order_icon/'.$temp[0]);
					@mkdir('./program/mall/order_icon/'.$temp[0].'/'.$temp[1]);
					if(!file_exists('./program/mall/order_icon/'.$goods['icon'])){copy('./program/mall/img/'.$goods['icon'],'./program/mall/order_icon/'.$goods['icon']);}
					
					
					$sql="insert into ".$pdo->sys_pre."mall_order_goods (`goods_id`,`s_id`,`order_id`,`snapshot_id`,`icon`,`title`,`quantity`,`price`,`transaction_price`,`unit`,`time`,`buyer`,`shop_id`,`recommendation`,`order_state`,`cost_price`) values ('".$v['g_id']."','".$v['s_id']."','".$order_id."','".$snapshot_id."','".$goods['icon']."','".$v['g_title']."','1','".$v['price']."','".$v['price']."','".self::get_mall_unit_name($pdo,$goods['unit'])."','".$time."','".$v['username']."','".$goods['shop_id']."','0','1','".$goods_cost."')";
					$pdo->exec($sql);
					
					$sql="update ".self::$table_pre."order set `state`=2 where `id`=".$v['id'];
					$pdo->exec($sql);
					
					$sql="select `openid` from ".$pdo->index_pre."user where `username`='".$v['username']."' limit 0,1";
					$user=$pdo->query($sql,2)->fetch(2);
					if($user['openid']!=''){
						$data=array();
						$data['first']=$config['web']['name'];
						$data['keyword1']=$order_id;
						$data['keyword2']=$v['g_title'];
						$data['keyword3']=$v['price'];
						$data['keyword4']=date('Y-m-d H:i',time());
						$data['remark']=self::$language['click_view_more'];
						push_gbuy_success($pdo,$config,$language,$user['openid'],$data);
					}
				}
			}
			$sql="update ".self::$table_pre."group set `state`=3 where `id`=".$order['gr_id'];
			if($pdo->exec($sql)){//给团长返佣
				if($gr['earn']>0){
					$sql="select `username` from ".$pdo->sys_pre."mall_shop where `id`=".$goods['shop_id'];
					$shop=$pdo->query($sql,2)->fetch(2);
					$reason=self::$language['gbuy_earn'];
					$reason=str_replace('{id}',$order['gr_id'],$reason);
					if(operator_money(self::$config,self::$language,$pdo,$shop['username'],'-'.$gr['earn'],$reason,'gbuy',true)){
						if(operator_money(self::$config,self::$language,$pdo,$gr['username'],$gr['earn'],$reason,'gbuy',true)){
							$sql="update ".self::$table_pre."group set `earn_state`=1 where `id`=".$order['gr_id'];
							$pdo->exec($sql);
						}
					}
				}
			}
		}
		
	}
	
	function close_overtime_order($pdo){
		$goods=array();
		$sql="select * from ".self::$table_pre."group where `state`=1";
		$r=$pdo->query($sql,2);
		$time=time();
		foreach($r as $v){
			if(!isset($goods[$v['g_id']])){
				$sql="select * from ".self::$table_pre."goods where `g_id`=".$v['g_id']." limit 0,1";
				$goods[$v['g_id']]=$pdo->query($sql,2)->fetch(2);
				if($goods[$v['g_id']]['id']==''){continue;}
			}
			if($goods[$v['g_id']]['hour']*3600+$v['start']<$time){
				$sql="select * from ".self::$table_pre."order where `gr_id`=".$v['id'];
				$r2=$pdo->query($sql,2);
				foreach($r2 as $v2){
					if($v2['state']==1){
						$refund=refund_recharge($pdo,'',$v2['id'],$v2['price'],'gbuy.update_order_state');
						if(!$refund){
							$recharge=operator_money(self::$config,self::$language,$pdo,$v2['username'],$v2['price'],self::$language['recharge'],'gbuy');
							if(!$refund){continue;}
						}
					}
					$sql="update ".self::$table_pre."order set `state`=3 where `id`=".$v2['id'];
					$pdo->exec($sql);
				}
				
				$sql="update ".self::$table_pre."group set `state`=2 where `id`=".$v['id'];
				$pdo->exec($sql);
			}
		}
	}	
	
	function get_gbuy_group_show($pdo,$group){
		$sql="select `b_id` from ".self::$table_pre."group where `id`=".$group;
		$gr=$pdo->query($sql,2)->fetch(2);
		if($gr['b_id']==''){return false;}
		$sql="select `number` from ".self::$table_pre."goods where `id`=".$gr['b_id'];
		$b=$pdo->query($sql,2)->fetch(2);
		
		$sql="select `username` from ".self::$table_pre."order where `gr_id`=".$group." and `state`>0 order by `id` asc";
		$r=$pdo->query($sql,2);
		$list='';
		$i=0;
		foreach($r as $v){
			$sql="select `icon` from ".$pdo->index_pre."user where `username`='".$v['username']."' limit 0,1";
			$u=$pdo->query($sql,2)->fetch(2);
			if(!is_url($u['icon'])){
				if($u['icon']==''){$u['icon']='default.png';}
				$u['icon']="./program/index/user_icon/".$u['icon'];
			}
			
			$list.="<img src=".$u['icon']." title='".$v['username']."' />";
			$i++;
		}
		if($i<$b['number']){
			for($i;$i<$b['number'];$i++){
				$list.="<img  src='./program/gbuy/img/none.png' title='".self::$language['none']."' />";
			}	
			$list.="<a href=./index.php?monxin=gbuy.detail&group=".$group." class=go_detail>".self::$language['inviting_friends']."</a>";
		}
		return $list;
	}
	
}
?>