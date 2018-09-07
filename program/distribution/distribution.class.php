<?php
/**
 *	商城数据显示类 示例 ./index.php?monxin=distribution.goods_add (monxin=类名.方法名)，大部分情况是通过 __call方法 加载执行 ./program/distribution/show/ 目录下的对应名称的文件
 */
class distribution{
	public static $config,$language,$table_pre,$module_config,$one_task;
	function __construct($pdo){
		if(!self::$config){
			//echo 'construct<br>';
			global $config,$language,$page;
			$program=__CLASS__;
			if(is_file('./program/'.$program.'/config.php')){
				$program_config=require './program/'.$program.'/config.php';
				$program_language=require './program/'.$program.'/language/'.$program_config['program']['language'].'.php';
				self::$module_config=require './program/'.$program.'/module_config.php';
			}else{
				$program_config=require '../../program/'.$program.'/config.php';
				$program_language=require '../../program/'.$program.'/language/'.$program_config['program']['language'].'.php';
				self::$module_config=require '../../program/'.$program.'/module_config.php';
			}
			self::$config=array_merge($config,$program_config);
			self::$language=array_merge($language,$program_language);
			self::$table_pre=$pdo->sys_pre.self::$config['class_name']."_";
			
			self::$one_task=false;
			if($_COOKIE['monxin_device']=='phone'){self::$one_task=true;}
			self::exe_task_($pdo,$program_config);
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
		
		
		
		file_put_contents('./program/distribution/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 执行月任务
	function exe_task_m($pdo,$program_config){
		$v=date('Y-m',time());
		if($v==$program_config['task_m']){return $program_config;}
		$program_config['task_m']=$v;
		
		
		
		file_put_contents('./program/distribution/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 执行日任务
	function exe_task_d($pdo,$program_config){
		$v=date('Y-m-d',time());
		if($v==$program_config['task_d']){return $program_config;}
		$program_config['task_d']=$v;
		
		file_put_contents('./program/distribution/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 执行时任务
	function exe_task_h($pdo,$program_config){
		$v=date('Y-m-d H',time());
		if($v==$program_config['task_h']){return $program_config;}
		$program_config['task_h']=$v;
		file_put_contents('./program/distribution/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 执行分钟任务
	function exe_task_minute($pdo,$program_config){
		$v=date('Y-m-d H:i',time());
		if($v==$program_config['task_minute']){return $program_config;}
		$program_config['task_minute']=$v;
		
		file_put_contents('./program/distribution/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 获取 店铺首页 Title
	function index_head_data($pdo){
		$sql="select `username` from ".self::$table_pre."distributor where `id`=".@intval($_GET['id']);
		$r=$pdo->query($sql,2)->fetch(2);
		$v['title']=@$r['username'];	
		$v['keywords']=@$r['username'];	
		$v['description']=@$r['username'];	
		return $v;
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
	
	function is_distributor($pdo,$username){
		$sql="select `id`,`state` from ".self::$table_pre."distributor where `username`='".$username."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch();
		if($r['id']=='' || $r['state']!=1){return false;}else{return true;}
	}
	
	function get_sub_name_stop($pdo,$username,$level){
		$sql="select `username`,`phone` from ".self::$table_pre."distributor where `superior`='".$username."' and `state`=1";
		$r=$pdo->query($sql,2);
		$list='';
		foreach($r as $v){
			if(self::$config['level']>($level-1)){
				$sub2='';
				if(self::$config['level']>($level-1)){
					$sub2=self::get_sub_name($pdo,$v['username'],$level+1);
				}
				if($sub2!=''){$sub2='<ul class=level_'.$level.'>'.$sub2.'</ul>';}
				$list.='<li><div>'.$v['username'].' '.$v['phone'].'</div>'.$sub2.'</li>';
			}
			
		}
		//if($list!=''){$list='<ul class=level_'.$level.'>'.$list.'</ul>';}
		return $list;
	}
	
	function get_sub_name($pdo,$username,$level){
		if(!isset($_POST['sum'])){$_POST['sum']=0;}
		$sql="select `username`,`real_name`,`phone`,`icon` from ".$pdo->index_pre."user where `introducer`='".$username."'";
		$r=$pdo->query($sql,2);
		$list='';
		foreach($r as $v){
			if(self::$config['level']>($level-1)){
				$sub2='';
				if(self::$config['level']>($level-1)){
					$sub2=self::get_sub_name($pdo,$v['username'],$level+1);
				}
				if($sub2!=''){$sub2='<ul class=level_'.($level+1).'>'.$sub2.'</ul>';}
				if(!is_url($v['icon'])){
					if($v['icon']!=''){$v['icon']=" src=./program/index/user_icon/".$v['icon'];}
				}else{$v['icon']="src=".$v['icon'];}
				
				$list.='<li><div><img '.$v['icon'].' />'.$v['username'].' '.$v['real_name'].' '.$v['phone'].'</div>'.$sub2.'</li>';
			}
			$_POST['sum']++;
		}
		//if($list!=''){$list='<ul class=level_'.$level.'>'.$list.'</ul>';}
		return $list;
	}
	
	function get_superior($pdo,$buyer,$money){
		$u=array();
		$u[]=0;
		$m=array();
		$m[]=0;
		$sql="select `introducer` from ".$pdo->index_pre."user where `username`='".$buyer."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['introducer']!=''){
			$u[]=$r['introducer'];
			if(self::is_distributor($pdo,$r['introducer'])){$m[]=$money*self::$config['level_1']/100;}else{$m[]=0;}
			$sql="select `introducer` from ".$pdo->index_pre."user where `username`='".$r['introducer']."' limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['introducer']!=''){
				$u[]=$r['introducer'];
				if(self::is_distributor($pdo,$r['introducer'])){$m[]=$money*self::$config['level_2']/100;}else{$m[]=0;}
				$sql="select `introducer` from ".$pdo->index_pre."user where `username`='".$r['introducer']."' limit 0,1";
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['introducer']!=''){
					$u[]=$r['introducer'];
					if(self::is_distributor($pdo,$r['introducer'])){$m[]=$money*self::$config['level_3']/100;}else{$m[]=0;}
					$sql="select `introducer` from ".$pdo->index_pre."user where `username`='".$r['introducer']."' limit 0,1";
					$r=$pdo->query($sql,2)->fetch(2);
					if($r['introducer']!=''){
						$u[]=$r['introducer'];
						if(self::is_distributor($pdo,$r['introducer'])){$m[]=$money*self::$config['level_4']/100;}else{$m[]=0;}
						$sql="select `introducer` from ".$pdo->index_pre."user where `username`='".$r['introducer']."' limit 0,1";
						$r=$pdo->query($sql,2)->fetch(2);
						if($r['introducer']!=''){
							$u[]=$r['introducer'];
							if(self::is_distributor($pdo,$r['introducer'])){$m[]=$money*self::$config['level_5']/100;}else{$m[]=0;}
							$sql="select `introducer` from ".$pdo->index_pre."user where `username`='".$r['introducer']."' limit 0,1";
							$r=$pdo->query($sql,2)->fetch(2);
							if($r['introducer']!=''){
								$u[]=$r['introducer'];
								if(self::is_distributor($pdo,$r['introducer'])){$m[]=$money*self::$config['level_6']/100;}else{$m[]=0;}
								$sql="select `introducer` from ".$pdo->index_pre."user where `username`='".$r['introducer']."' limit 0,1";
								$r=$pdo->query($sql,2)->fetch(2);
								if($r['introducer']!=''){
									$u[]=$r['introducer'];
									if(self::is_distributor($pdo,$r['introducer'])){$m[]=$money*self::$config['level_7']/100;}else{$m[]=0;}
									$sql="select `introducer` from ".$pdo->index_pre."user where `username`='".$r['introducer']."' limit 0,1";
									$r=$pdo->query($sql,2)->fetch(2);
									if($r['introducer']!=''){
										$u[]=$r['introducer'];
										if(self::is_distributor($pdo,$r['introducer'])){$m[]=$money*self::$config['level_8']/100;}else{$m[]=0;}

										$sql="select `introducer` from ".$pdo->index_pre."user where `username`='".$r['introducer']."' limit 0,1";
										$r=$pdo->query($sql,2)->fetch(2);
										if($r['introducer']!=''){
											$u[]=$r['introducer'];
												if(self::is_distributor($pdo,$r['introducer'])){$m[]=$money*self::$config['level_9']/100;}else{$m[]=0;}
															
										}
														
									}
												
								}
										
							}
							
						}
						
					}
					
				}
				
			}
				
		}
		
		$r=array();
		$r['u']=$u;
		$r['r']=$m;
		for($i=0;$i<10;$i++){
			if(!isset($r['u'][$i])){$r['u'][$i]='';}
			if(!isset($r['r'][$i])){$r['r'][$i]=0;}
		}
		return $r;
	}
	
	
//======================================================================================================= 商城订单已付款，分销记录订单
	function order_complete_pay($pdo,$order_id){
		$sql="select * from ".$pdo->sys_pre."mall_order where `id`=".$order_id;
		$order=$pdo->query($sql,2)->fetch(2);
		if($order['buyer']==''){return false;}
		if(self::$config['all_order']==0){
			if($order['pay_method']=='cash_on_delivery'){return false;}
			if($order['cashier']!='monxin'){return false;}
		}
		
		$sql="select `id` from ".self::$table_pre."order where `order_id`=".$order_id." limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){return false;}
		$time=time();
		if($order['buyer']==''){return false;}
		$u=self::get_superior($pdo,$order['buyer'],$order['actual_money']);
		$sql="select `id` from ".self::$table_pre."distributor where `username`='".$u['u'][1]."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){$distributor_id=$r['id'];}else{$distributor_id=0;}
		$shop_rate=$order['actual_money']*self::$config['shop_rate']/100;
		
		$sum_u=0;
		foreach($u['r'] as $k=>$vv){
			$sum_u+=$vv;
		}
		$surplus=$shop_rate-$sum_u;
		
		$sql="insert into ".self::$table_pre."order (`shop_id`,`order_id`,`out_id`,`buyer`,`add_time`,`order_money`,`order_state`,`distributor_id`,`u_1`,`u_2`,`u_3`,`u_4`,`u_5`,`u_6`,`u_7`,`u_8`,`u_9`,`r_1`,`r_2`,`r_3`,`r_4`,`r_5`,`r_6`,`r_7`,`r_8`,`r_9`,`shop_rate`,`surplus`) values ('".$order['shop_id']."','".$order['id']."','".$order['out_id']."','".$order['buyer']."','".$order['add_time']."','".$order['actual_money']."','0','".$distributor_id."','".$u['u'][1]."','".$u['u'][2]."','".$u['u'][3]."','".$u['u'][4]."','".$u['u'][5]."','".$u['u'][6]."','".$u['u'][7]."','".$u['u'][8]."','".$u['u'][9]."','".$u['r'][1]."','".$u['r'][2]."','".$u['r'][3]."','".$u['r'][4]."','".$u['r'][5]."','".$u['r'][6]."','".$u['r'][7]."','".$u['r'][8]."','".$u['r'][9]."','".$shop_rate."','".$surplus."')";
		if($pdo->exec($sql)){
			return true;
		}else{return false;}
	}
	
	function add_sum_money($pdo,$username,$money){
		$sql="update ".self::$table_pre."distributor set `sum_money`=`sum_money`+".$money." where `username`='".$username."' limit 1";
		$pdo->exec($sql);
	}
	function add_earn($pdo,$username,$money){
		$sql="update ".self::$table_pre."distributor set `earn`=`earn`+".$money." where `username`='".$username."' limit 1";
		$pdo->exec($sql);
	}
	function refund_sum_money($pdo,$username,$money){
		$sql="update ".self::$table_pre."distributor set `sum_money`=`sum_money`-".$money." where `username`='".$username."' limit 1";
		$pdo->exec($sql);
	}
	function refund_earn($pdo,$username,$money){
		$sql="update ".self::$table_pre."distributor set `earn`=`earn`-".$money." where `username`='".$username."' limit 1";
		$pdo->exec($sql);
	}

//======================================================================================================= 商城订单已确认收货，分销执行返佣
	function order_complete_confirm_receipt($pdo,$order_id){
		$sql="select * from ".$pdo->sys_pre."mall_order where `id`=".$order_id;
		$order=$pdo->query($sql,2)->fetch(2);
		
		$sql="select `name` from ".$pdo->sys_pre."mall_shop where `id`=".$order['shop_id'];
		$r=$pdo->query($sql,2)->fetch(2);
		$shop_name=$r['name'];
		
		$sql="select * from ".self::$table_pre."order where `order_id`=".$order_id." limit 0,1";
		
		$o=$pdo->query($sql,2)->fetch(2);
		if($o['id']==''){return false;}
		if($o['order_state']>0){return false;}
		if($o['shop_rate']>0){
			$sql="select `username` from ".$pdo->sys_pre."mall_shop where `id`=".$order['shop_id'];
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['username']==''){return false;}
			$seller=$r['username'];
			$cause=str_replace('{order_id}',$order['out_id'],self::$language['shop_rate_reason']);
			if(operator_money(self::$config,self::$language,$pdo,$seller,'-'.$o['shop_rate'],$cause,'distribution',1)===true){
				self::operation_shop_finance(self::$language,$pdo,$pdo->sys_pre."mall_",$order['shop_id'],'-'.$o['shop_rate'],5,$cause);
				
				if($o['r_1']>0){
					$cause=str_replace('{order_id}',$order['out_id'],self::$language['rate_reason']);
					$cause=str_replace('{level}',1,$cause);
					$r=operator_money(self::$config,self::$language,$pdo,$o['u_1'],$o['r_1'],$cause,'distribution');
					if($r){self::add_sum_money($pdo,$o['u_1'],$o['order_money']);self::add_earn($pdo,$o['u_1'],$o['r_1']);}
				}
				if($o['r_2']>0){
					$cause=str_replace('{order_id}',$order['out_id'],self::$language['rate_reason']);
					$cause=str_replace('{level}',2,$cause);
					$r=operator_money(self::$config,self::$language,$pdo,$o['u_2'],$o['r_2'],$cause,'distribution');
					if($r){self::add_sum_money($pdo,$o['u_2'],$o['order_money']);self::add_earn($pdo,$o['u_2'],$o['r_2']);}
				}
				if($o['r_3']>0){
					$cause=str_replace('{order_id}',$order['out_id'],self::$language['rate_reason']);
					$cause=str_replace('{level}',3,$cause);
					$r=operator_money(self::$config,self::$language,$pdo,$o['u_3'],$o['r_3'],$cause,'distribution');
					if($r){self::add_sum_money($pdo,$o['u_3'],$o['order_money']);self::add_earn($pdo,$o['u_3'],$o['r_3']);}
				}
				if($o['r_4']>0){
					$cause=str_replace('{order_id}',$order['out_id'],self::$language['rate_reason']);
					$cause=str_replace('{level}',4,$cause);
					$r=operator_money(self::$config,self::$language,$pdo,$o['u_4'],$o['r_4'],$cause,'distribution');
					if($r){self::add_sum_money($pdo,$o['u_4'],$o['order_money']);self::add_earn($pdo,$o['u_4'],$o['r_4']);}
				}
				if($o['r_5']>0){
					$cause=str_replace('{order_id}',$order['out_id'],self::$language['rate_reason']);
					$cause=str_replace('{level}',5,$cause);
					$r=operator_money(self::$config,self::$language,$pdo,$o['u_5'],$o['r_5'],$cause,'distribution');
					if($r){self::add_sum_money($pdo,$o['u_5'],$o['order_money']);self::add_earn($pdo,$o['u_5'],$o['r_5']);}
				}
				if($o['r_6']>0){
					$cause=str_replace('{order_id}',$order['out_id'],self::$language['rate_reason']);
					$cause=str_replace('{level}',6,$cause);
					$r=operator_money(self::$config,self::$language,$pdo,$o['u_6'],$o['r_6'],$cause,'distribution');
					if($r){self::add_sum_money($pdo,$o['u_6'],$o['order_money']);self::add_earn($pdo,$o['u_6'],$o['r_6']);}
				}
				if($o['r_7']>0){
					$cause=str_replace('{order_id}',$order['out_id'],self::$language['rate_reason']);
					$cause=str_replace('{level}',7,$cause);
					$r=operator_money(self::$config,self::$language,$pdo,$o['u_7'],$o['r_7'],$cause,'distribution');
					if($r){self::add_sum_money($pdo,$o['u_7'],$o['order_money']);self::add_earn($pdo,$o['u_7'],$o['r_7']);}
				}
				if($o['r_8']>0){
					$cause=str_replace('{order_id}',$order['out_id'],self::$language['rate_reason']);
					$cause=str_replace('{level}',8,$cause);
					$r=operator_money(self::$config,self::$language,$pdo,$o['u_8'],$o['r_8'],$cause,'distribution');
					if($r){self::add_sum_money($pdo,$o['u_8'],$o['order_money']);self::add_earn($pdo,$o['u_8'],$o['r_8']);}
				}
				if($o['r_9']>0){
					$cause=str_replace('{order_id}',$order['out_id'],self::$language['rate_reason']);
					$cause=str_replace('{level}',9,$cause);
					$r=operator_money(self::$config,self::$language,$pdo,$o['u_9'],$o['r_9'],$cause,'distribution');
					if($r){self::add_sum_money($pdo,$o['u_9'],$o['order_money']);self::add_earn($pdo,$o['u_9'],$o['r_9']);}
				}
				
				if($o['surplus']>0){
					$cause=str_replace('{order_id}',$order['out_id'],self::$language['surplus_reason']);
					self::operation_mall_finance($pdo,$o['surplus'],$shop_name,$order['shop_id'],$cause);
				}
				
			}
		}
		$sql="update ".self::$table_pre."order  set `order_state`=1,`success_time`=".time()." where `order_id`=".$order_id." limit 1";
		$pdo->exec($sql);
		//write_err_log('./program/distribution/err.log',$cause.$seller.'-'.$supplier_pay.' fail');	
	}
	
	//======================================================================================================= 新增商城财务记录
	function operation_mall_finance($pdo,$money,$shop_name,$shop_id,$reason){
		$sql="select `after_money` from ".$pdo->sys_pre."mall_finance order by `id` desc limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		$before_money=$r['after_money'];
		$money=str_replace('+','',$money);
		//echo $money;
		$after_money=$before_money+$money;
		$sql="insert into ".$pdo->sys_pre."mall_finance (`type`,`time`,`money`,`before_money`,`after_money`,`operator`,`reason`,`shop_id`,`shop_name`) values ('9','".time()."','".$money."','".$before_money."','".$after_money."','','".$reason."','".$shop_id."','".$shop_name."')";
		if($pdo->exec($sql)){
			return true;
		}else{
			return false;
		}
	}
		
		
	
	
	//======================================================================================================= 退货退款退佣金
	function order_refund($pdo,$order_id){
		file_put_contents('t.txt','339');
		$sql="select * from ".$pdo->sys_pre."mall_order where `id`=".$order_id;
		$order=$pdo->query($sql,2)->fetch(2);
		$sql="select `username` from ".$pdo->sys_pre."mall_shop where `id`=".$order['shop_id'];
		$r=$pdo->query($sql,2)->fetch(2);
		$seller=$r['username'];
		$sql="select * from ".self::$table_pre."order where `order_id`=".$order_id." limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['order_state']!=1 || $r['id']=='' || ($order['state']!=6 && $order['state']!=10 )){return false;}
		file_put_contents('t.txt','348');
		$o=$r;
		if($o['shop_rate']>0){
			$cause=str_replace('{order_id}',$order['out_id'],self::$language['refund_shop_rate_reason']);
			if(operator_money(self::$config,self::$language,$pdo,$seller,$o['shop_rate'],$cause,'distribution',1)===true){
				self::operation_shop_finance(self::$language,$pdo,$pdo->sys_pre."mall_",$order['shop_id'],$o['shop_rate'],5,$cause);
			}
		}
		for($i=1;$i<10;$i++){
			if($o['r_'.$i]>0){
				$cause=str_replace('{order_id}',$order['out_id'],self::$language['refund_rate_reason']);
				$cause=str_replace('{level}',$i,$cause);
				if(operator_money(self::$config,self::$language,$pdo,$o['u_'.$i],'-'.$o['r_'.$i],$cause,'distribution',1)===true){
					self::refund_sum_money($pdo,$o['u_'.$i],$o['order_money']);self::refund_earn($pdo,$o['u_'.$i],$o['r_'.$i]);

				}
			}
		}
		return true;
		
	}
		
	function order_cancel($pdo,$order_id){
		$sql="update ".self::$table_pre."order set `order_state`=3 where `order_id`=".$order_id;
		return $pdo->exec($sql);
	}
	
			
	//======================================================================================================= 新增商城财务记录
	function operation_finance($language,$pdo,$table_pre,$shop_id,$money,$type,$reason){
		$sql="select `name` from ".$table_pre."shop where `id`=".$shop_id;
		$r=$pdo->query($sql,2)->fetch(2);
		$shop_name=$r['name'];
		$sql="select `after_money` from ".$table_pre."finance order by `id` desc limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		$before_money=$r['after_money'];
		$money=str_replace('+','',$money);
		//echo $money;
		$after_money=$before_money+$money;
		$sql="insert into ".$table_pre."finance (`type`,`time`,`money`,`before_money`,`after_money`,`operator`,`reason`,`shop_id`,`shop_name`) values ('".$type."','".time()."','".$money."','".$before_money."','".$after_money."','".@$_SESSION['monxin']['username']."','".$reason."','".$shop_id."','".$shop_name."')";
		if($pdo->exec($sql)){
			return true;
		}else{
			return false;
		}
	}
		
	//======================================================================================================= 新增店铺财务记录
	function operation_shop_finance($language,$pdo,$table_pre,$shop_id,$money,$type,$reason){
		$sql="select `after_money` from ".$table_pre."shop_finance where `shop_id`=".$shop_id." order by `id` desc limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		$before_money=$r['after_money'];
		$money=str_replace('+','',$money);
		//echo $money;
		$after_money=$before_money+$money;
		$sql="insert into ".$table_pre."shop_finance (`type`,`time`,`money`,`before_money`,`after_money`,`operator`,`reason`,`shop_id`) values ('".$type."','".time()."','".$money."','".$before_money."','".$after_money."','".@$_SESSION['monxin']['username']."','".$reason."','".$shop_id."')";
		if($pdo->exec($sql)){
			return true;
		}else{
			return false;
		}
	}
		
	

	
}
?>