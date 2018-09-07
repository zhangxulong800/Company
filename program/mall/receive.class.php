<?php
/**
 *	商城数据接收类 示例 ./receive.php?target=mall::goods_add (target=类名::方法名),大部分情况是通过 __call方法 加载执行 ./program/mall/receive/ 目录下的对应名称的文件。
 */
class receive{
	public static $config,$language,$table_pre;
	function __construct($pdo){
		
		if(!self::$config){
			//echo 'construct<br>';
			global $config,$language,$program,$page;
			$program_config=require str_replace('receive.class.php','',__FILE__).'config.php';
			self::$config=array_merge($config,$program_config);
			$program_language=require  str_replace('receive.class.php','',__FILE__).'/language/'.$program_config['program']['language'].'.php';
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
		if(in_array('mall.'.$call,self::$config['program_unlogin_function_power'])){if(self::$config['pay_mode']!='money'){self::$language['yuan']=self::$language['credits_s'];}}
		$class=__CLASS__;
		$method=$class."::".$method;
		//print_r('./program/'.self::$config['class_name'].'/receive/'.$call.'.php');exit;
		require './program/'.self::$config['class_name'].'/receive/'.$call.'.php';
   }
   
//======================================================================================================= 执行任务
	function exe_task_($pdo,$program_config){
		$program_config=self::exe_task_y($pdo,$program_config);
		$program_config=self::exe_task_m($pdo,$program_config);
		$program_config=self::exe_task_w($pdo,$program_config);
		$program_config=self::exe_task_d($pdo,$program_config);
		$program_config=self::exe_task_h($pdo,$program_config);
		$program_config=self::exe_task_minute($pdo,$program_config);
	}

//======================================================================================================= 执行年任务
	function exe_task_y($pdo,$program_config){
		
		$v=date('Y',time());
		if($v==$program_config['receive_task_y']){return $program_config;}
		$program_config['receive_task_y']=$v;
		
		
		
		file_put_contents('./program/mall/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 执行月任务
	function exe_task_m($pdo,$program_config){
		$v=date('Y-m',time());
		if($v==$program_config['receive_task_m']){return $program_config;}
		$program_config['receive_task_m']=$v;
		
		
		
		file_put_contents('./program/mall/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 执行周任务
	function exe_task_w($pdo,$program_config){
		$v=date('W',time());
		if($v==$program_config['task_w']){return $program_config;}
		$program_config['task_w']=$v;
		
		
		file_put_contents('./program/mall/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 执行日任务
	function exe_task_d($pdo,$program_config){
		$v=date('Y-m-d',time());
		if($v==$program_config['receive_task_d']){return $program_config;}
		$program_config['receive_task_d']=$v;
			self::update_pre_sale_order_15($pdo);
		file_put_contents('./program/mall/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 执行时任务
	function exe_task_h($pdo,$program_config){
		$v=date('Y-m-d H',time());
		if($v==$program_config['receive_task_h']){return $program_config;}
		$program_config['receive_task_h']=$v;
		
		
		
		file_put_contents('./program/mall/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

//======================================================================================================= 执行分钟任务
	function exe_task_minute($pdo,$program_config){
		$v=date('Y-m-d H:i',time());
		if($v==$program_config['receive_task_minute']){return $program_config;}
		$program_config['receive_task_minute']=$v;
		
		file_put_contents('./program/mall/config.php','<?php return '.var_export($program_config,true).'?>');
		return $program_config;
	}

   
   
	//===============================================================================================返回店铺ID
	function get_shop_id($pdo){
		if(defined('SHOP_ID')){return false;}
		if(intval(@$_GET['shop_id'])!=0){define("SHOP_ID", intval($_GET['shop_id']));return true;}
		$monxin=str_replace('::','.',@$_GET['target']);
		if($monxin=='mall.shop_goods_list' && intval(@$_GET['type'])>0){
			$sql="select `shop_id` from ".$pdo->sys_pre."mall_shop_type where `id`=".intval($_GET['type']);
			$r=$pdo->query($sql,2)->fetch(2);
			define("SHOP_ID", $r['shop_id']);return true;
		}
		if(($monxin=='mall.goods' || $monxin=='mall.gbuy_goods') && intval(@$_GET['id'])>0){
			$sql="select `shop_id` from ".$pdo->sys_pre."mall_goods where `id`=".intval($_GET['id']);
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['shop_id']==''){$r['shop_id']=0;}
			define("SHOP_ID", $r['shop_id']);return true;
		}
		if($monxin=='mall.diypage_show' && intval(@$_GET['id'])>0){
			$sql="select `shop_id` from ".$pdo->sys_pre."mall_diypage where `id`=".intval($_GET['id']);
			$r=$pdo->query($sql,2)->fetch(2);
			define("SHOP_ID", $r['shop_id']);return true;
		}
		if(isset($_SESSION['monxin']['username']) && $_SESSION['monxin']['group_id']==self::$config['cashier_group_id']){
			$sql="select `id` from ".self::$table_pre."shop where `cashier` like '%".$_SESSION['monxin']['username'].",%' and `state`=2 order by `id` desc limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']==''){$r['id']=0;}
			define("SHOP_ID", $r['id']);return true;
		}
		if(isset($_SESSION['monxin']['username']) && $_SESSION['monxin']['group_id']==self::$config['storekeeper_group_id']){
			$sql="select `id` from ".self::$table_pre."shop where `storekeeper` like '%".$_SESSION['monxin']['username'].",%' and `state`=2 order by `id` desc limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']==''){$r['id']=0;}
			define("SHOP_ID", $r['id']);return true;
		}
		if(!isset($_SESSION['monxin']['username'])){define("SHOP_ID", 0);return true;}
		$sql="select `id` from ".self::$table_pre."shop where `username`='".$_SESSION['monxin']['username']."' and `state`=2 order by `id` desc limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){$r['id']=0;}
		define("SHOP_ID", $r['id']);return true;
	}
   
	//===============================================================================================返回分类选项名称
	function get_type_option_name($pdo,$id){
		$sql="select `name` from ".self::$table_pre."type_option where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		return $r['name'];	
	}
   
	//===============================================================================================返回店铺折扣度
	function get_shop_discount($pdo,$shop_id){
		$shop_id=intval($shop_id);
		$discount=10;
		$time=time();
		$sql="select * from ".self::$table_pre."discount where `shop_id`='".$shop_id."' and `end_time`>".$time;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){
			if($r['rate']>0 && $r['rate']<10){$discount=$r['rate'];}
		}
		$_SESSION['discount_all']=$r['join_goods'];
		$_POST['discount_join_goods']=$r['join_goods'];
		return $discount;
	}
	
   
	//===============================================================================================数组排序
	function array_sort($arr,$keys,$type='asc'){ 
		$keysvalue = $new_array = array();
		foreach ($arr as $k=>$v){
			$keysvalue[$k] = $v[$keys];
		}
		if($type == 'asc'){
			asort($keysvalue);
		}else{
			arsort($keysvalue);
		}
		reset($keysvalue);
		foreach ($keysvalue as $k=>$v){
			$new_array[$k] = $arr[$k];
		}
		return $new_array; 
	} 
	
   
	//===============================================================================================计算订单运费
	function get_freight_costs($pdo,$table_pre,$express,$area_id,$weight,$weight_all){
		if($weight_all==0){return 0;}
		$upid=array();
		$upid[]=$area_id;
		$sql="select `upid` from ".$pdo->index_pre."area where `id`='".$area_id."'";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['upid']!=0){
			$upid[]=$r['upid'];
			$sql="select `upid` from ".$pdo->index_pre."area where `id`='".$r['upid']."'";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['upid']!=0){
				$upid[]=$r['upid'];
				$sql="select `upid` from ".$pdo->index_pre."area where `id`='".$r['upid']."'";
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['upid']!=0){
					$upid[]=$r['upid'];
					$sql="select `upid` from ".$pdo->index_pre."area where `id`='".$r['upid']."'";
					$r=$pdo->query($sql,2)->fetch(2);
					if($r['upid']!=0){
						$upid[]=$r['upid'];
						$sql="select `upid` from ".$pdo->index_pre."area where `id`='".$r['upid']."'";
						$r=$pdo->query($sql,2)->fetch(2);
						if($r['upid']!=0){$upid[]=$r['upid'];}
					}
				}
			}
		}
		$upid[]=1;
		$area=0;
		
		foreach($upid as $v){
			$sql="select * from ".$table_pre."express_price where `express_id`='".$express."' and `area_id`='".$v."' and `shop_id`='".SHOP_ID."' limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']!=''){$area=$v;break;}
		}
		if($area==0){
			return false;
		}

		//是否默认快递
		$is_default_express=true;
		$sql="select * from ".$table_pre."express where `shop_id`='".SHOP_ID."' order by `sequence` desc limit 0,1";
		$default=$pdo->query($sql,2)->fetch(2);
		if($default['id']!=$express){
			$is_default_express=false;
			$sql="select * from ".$table_pre."express_price where `express_id`='".$default['id']."' and `area_id`='".$area."' and `shop_id`='".SHOP_ID."' limit 0,1";
			$default_price=$pdo->query($sql,2)->fetch(2);
			if($default_price['id']==''){return false;}
		}
		

		$sql="select `area_ids` from ".$table_pre."free_shipping where `shop_id`='".SHOP_ID."' limit 0,1";
		$temp=$pdo->query($sql,2)->fetch(2);
		$temp=explode(',',$temp['area_ids']);
		if(in_array($upid[count($upid)-2],$temp)){$free_shipping=true;}else{$free_shipping=false;}	
//		var_dump($upid[count($upid)-1]);
//		var_dump($temp);
//		var_dump($upid);
		if($free_shipping){
			if($weight==0 && $is_default_express){return 0;}
			$e_weight=$weight_all-$weight;
		}else{
			$e_weight=$weight_all;
		}
		
		$sql="select * from ".$table_pre."express where `id`='".$express."' and `shop_id`='".SHOP_ID."' limit 0,1";
		$r2=$pdo->query($sql,2)->fetch(2);
		if($r2['id']==''){return false;}
		if($free_shipping && $weight<$weight_all){
			if($weight_all<=$r2['first_weight'] && $is_default_express){
				return 0;
			}else{
				
				if($e_weight<=$r2['first_weight']){
					
					return max(0,$r['first_price']-$default_price['first_price']);
				}else{
					return 	max(0,($r['first_price']+(ceil( ($e_weight-$r2['first_weight'])/$r2['over_weight'])*$r['continue_price'] ))-($default_price['first_price']+(ceil( ($e_weight-$default['first_weight'])/$default['over_weight'])*$default_price['continue_price'] )));
				}		
					
			}	
		}
//		echo $weight_all.','.$r2['first_weight'];
//		var_dump($weight_all<=$r2['first_weight']);
//		var_dump($free_shipping);
//		var_dump($weight<$weight_all);
		if($e_weight<=$r2['first_weight']){
			return $r['first_price'];
		}else{
			return 	$r['first_price']+(ceil( ($e_weight-$r2['first_weight'])/$r2['over_weight'])*$r['continue_price'] );
		}		
		
			
	}
	
	
   
	//===============================================================================================计算满元优惠金额
	function get_fulfil_preferential($pdo,$table_pre,$money,$money_all,$shop_id){
		$time=time();
		$sql="select * from ".$table_pre."fulfil_preferential where `shop_id`='".$shop_id."' and (`min_money`<=".$money." || `min_money`<=".$money_all." ) and `end_time`>'".$time."' order by `min_money` desc";
		$r=$pdo->query($sql,2);
		$use=0;
		foreach($r as $v){
			if($v['join_goods']==0){if($v['min_money']<=$money){$use=$v;$e_money=$money;break;}}
			if($v['join_goods']==1){if($v['min_money']<=$money_all){$use=$v;$e_money=$money_all;break;}}
			if($v['join_goods']==2){if($v['min_money']<=$money_all-$money){$use=$v;$e_money=$money_all-$money;break;}}
		}
		
		if($use==0 || $e_money==0){return 0;}
		if($use['use_method']==0){
			return $e_money-sprintf("%.2f",$e_money*$use['discount']/10);
		}
		if($use['use_method']==1){
			return $use['less_money'];
		}
		if($use['use_method']==2){
			return 'free_shipping';
		}
		
		
	}
   
	//===============================================================================================删除订单
	function del_order($pdo,$table_pre,$id){
		$sql="delete from ".$table_pre."order where `id`=".$id;
		if($pdo->exec($sql)){
			$sql="select `icon` from ".$table_pre."order_goods where `order_id`=".$id;
			$r=$pdo->query($sql,2);
			foreach($r as $v){
				$sql="select `id` from ".$table_pre."order_goods where `icon`='".$v['icon']."' and `order_id`!='".$id."' limit 0,1";
				$r2=$pdo->query($sql,2)->fetch(2);
				if($r2['id']==''){@safe_unlink('./program/mall/order_icon/'.$v['icon']);}
			}
			$sql="delete from ".$table_pre."order_goods where `order_id`=".$id;
			$pdo->exec($sql);
			$sql="delete from ".$table_pre."comment where `order_id`=".$id;
			$pdo->exec($sql);
			return true;
		}else{
			return false;
		}
	}
   
	//===============================================================================================更新购物车数据
 	function update_cart($pdo,$table_pre){
		if(!isset($_SESSION['monxin']['username'])){return false;}
		
		if(@$_COOKIE['mall_cart']==''){
			$sql="select `last_time` from ".$pdo->index_pre."user where `username`='".$_SESSION['monxin']['username']."' limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if(time()<$r['last_time']+60){
				$sql="select * from ".$table_pre."cart where `username`='".$_SESSION['monxin']['username']."'";
				$r=$pdo->query($sql,2);
				$mall_cart=array();
				foreach($r as $v){
					$mall_cart[$v['key']]['quantity']=self::format_quantity($v['quantity']);
					$mall_cart[$v['key']]['price']=$v['price'];
					$mall_cart[$v['key']]['time']=$v['time'];
				}
				setcookie("mall_cart",json_encode($mall_cart));
				$_COOKIE['mall_cart']=json_encode($mall_cart);
			}	
		}
		
		if(@$_COOKIE['mall_cart']!=''){				
			$cart=json_decode($_COOKIE['mall_cart'],true);
			$sql="select `id`,`key` from ".$table_pre."cart where `username`='".$_SESSION['monxin']['username']."'";
			$r=$pdo->query($sql,2);
			$key=array();
			foreach($r as $v){
				if(isset($cart[$v['key']])){
					$sql="update ".$table_pre."cart set `quantity`='".floatval($cart[$v['key']]['quantity'])."',`price`='".floatval($cart[$v['key']]['price'])."',`time`='".(floatval($cart[$v['key']]['time'])/1000)."' where `id`='".$v['id']."'";	
				}else{
					$sql="delete from ".$table_pre."cart where `id`=".$v['id'];
				}
				$pdo->exec($sql);
				$key[$v['key']]=$v['key'];	
			}
			foreach($cart as $k=>$v){
				if(!isset($key[$k])){
					$sql="insert into ".$table_pre."cart (`username`,`key`,`quantity`,`price`,`time`) values ('".$_SESSION['monxin']['username']."','".safe_str($k)."','".floatval($v['quantity'])."','".floatval($v['price'])."','".(floatval($v['time'])/1000)."')";
					$pdo->exec($sql);
				}	
			}
			//file_put_contents('./test.txt',(intval(file_get_contents('./test.txt'))+1));	

			//echo $sql;
		}else{
			$sql="delete from ".$table_pre."cart where `username`='".$_SESSION['monxin']['username']."'";
			$pdo->exec($sql);	
		}
	}

	
//=========================================================================================================================虚拟物品自动发货 start
	function virtual_auto_delivery($config,$language,$pdo,$table_pre,$order){
		file_put_contents('a.txt',394);
		
		$sql="select * from ".$table_pre."shop where `id`=".$order['shop_id'];
		$r=$pdo->query($sql,2)->fetch(2);
		$r=de_safe_str($r);
		$shopName=$r['name'];
		$shop_address=$r['address'];
		$tel=$r['phone'];
		
		$code="23456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKMNPQRSTUVWXYZ"; //这是随机数
		$random_str=''; //定义一个空字符串
		for($i=0; $i < 6; $i++){ //
			$char=$code{rand(0, strlen($code)-1)}; //随机数,如果$code{0}那就是2
			$random_str.=$char; //附加验证码符号到字符串
		}
		
		$code="1234567890"; //这是随机数
		$random_int=''; //定义一个空字符串
		for($i=0; $i < 6; $i++){ 
			$char=$code{rand(0, strlen($code)-1)}; //随机数,如果$code{0}那就是2
			$random_int.=$char; //附加验证码符号到字符串
		}
	
		$sql="select `goods_id` from ".$table_pre."order_goods where `order_id`='".$order['id']."'";
		$r=$pdo->query($sql,2);
		$g_ids='';
		foreach($r as $v){
			$g_ids.=$v['goods_id'].',';
		}
		$g_ids=trim($g_ids,',');
		$sql="select `title`,`virtual_auto_delivery` from ".$table_pre."goods where `id` in (".$g_ids.")";
		$r=$pdo->query($sql,2);
		$http=array();
		$sms=array();
		$email=array();
		$email_title=array();
		$random=array();
		$count=0;
		foreach($r as $v){
			$v=de_safe_str($v);
			if($v['virtual_auto_delivery']==''){continue;}
				$temp=explode('{random_str}',$v['virtual_auto_delivery']);
				if(count($temp)>1){$random[]=$random_str;}
				$temp=explode('{random_int}',$v['virtual_auto_delivery']);
				if(count($temp)>1){$random[]=$random_int;}
				$temp=explode('{check_code}',$v['virtual_auto_delivery']);
				if(count($temp)>1){$random[]=$random_str;}
			
			if(strtolower(mb_substr($v['virtual_auto_delivery'],0,4,'utf-8'))=='http'){
				$http[]=$v['virtual_auto_delivery'];
				//file_put_contents('./http.txt',@file_get_contents('./http.txt')."\r\n".$v['virtual_auto_delivery']);
			}else{
				if(strtolower(mb_substr($v['virtual_auto_delivery'],0,5,'utf-8'))=='email'){$v['virtual_auto_delivery']=mb_substr($v['virtual_auto_delivery'],6);}
				
				//$v['virtual_auto_delivery']=str_replace('{random_str}',$random_str,$v['virtual_auto_delivery']);
				//$v['virtual_auto_delivery']=str_replace('{random_int}',$random_int,$v['virtual_auto_delivery']);
				if(substr($v['virtual_auto_delivery'],0,4)=='sms:'){
					$v['virtual_auto_delivery']=substr($v['virtual_auto_delivery'],4);
					$sms[]=$v['virtual_auto_delivery'];
				}
				$email[]=$v['virtual_auto_delivery'];
				$email_title[]=$v['title'];
			}
			$count++;	
		}
		
		if($count==0){
			if($order['receiver_id']==-1){
				$check_code=get_verification_code(8);
				$sql="select `id` from ".self::$table_pre."order where `check_code`='".$check_code."' and `shop_id`=".SHOP_ID." and `state`<2 limit 0,1";
				$temp=$pdo->query($sql,2)->fetch(2);
				if($temp['id']!=''){
					$check_code.=get_verification_code(4);
				}
				$sql="update ".$table_pre."order set `check_code`='".$check_code."',`send_time`=".time().",`check_code_state`=1 where `id`=".$order['id'];
				self::$language['have_automatic_delivery']=self::$language['have_automatic_delivery_check_code'];
				return $pdo->exec($sql);			
			}else{
				return false;
			}
		}
		
		if($g_ids!=''){
			if($order['buyer']!=''){
				$sql="select `email` from ".$pdo->index_pre."user where `username`='".$order['buyer']."' limit 0,1";
				$user=$pdo->query($sql,2)->fetch(2);
			}
			if(!isset($random_code)){
				if(count($random)>1){$random_code=$random_int;}
				if(count($random)==1){$random_code=$random[0];}
				if(count($random)==0){$random_code='';}
			}
			
			//=======================================================================================send_emall
			if(count($email)>0 && $order['buyer']!=''){
				if($user['email']!=''){
					$email_t='【'.$config['web']['name'].'】'.$language['virtual_auto_delivery'];
					$email_content='';
					foreach($email as $k=>$v2){
						$email_content.='<b>'.mb_substr($email_title[$k],0,20,'utf-8')."</b> >>> ".$v2.'<hr />';	
					}
										
					$email_content=str_replace('{phone}',$order['receiver_phone'],$email_content);
					$email_content=str_replace('{email}',@$user['email'],$email_content);
					$email_content=str_replace('{order_id}',$order['id'],$email_content);
					$email_content=str_replace('{random_str}',$random_code,$email_content);	
					$email_content=str_replace('{random_int}',$random_code,$email_content);
					$email_content=str_replace('{web_name}',$config['web']['name'],$email_content);
					$email_content=str_replace('{shopName}',$shopName,$email_content);
					$email_content=str_replace('{address}',$shop_address,$email_content);
					$email_content=str_replace('{tel}',$tel,$email_content);
					$email_content=str_replace('{check_code}',$random_code,$email_content);
					
					email($config,$language,$pdo,'monxin',$user['email'],$email_t,$email_content);
					//file_put_contents('./auto_send_email.txt',@file_get_contents('./auto_send_email.txt')."\r\n".$email_t.'<br />'.$email_content);
				}
			}
			
			
			
			if(isset($random_code)){
				$sql="update ".$table_pre."order set `check_code`='".$random_code."',`send_time`=".time()." where `id`=".$order['id'];
				if($order['receiver_id']==-1){$sql="update ".$table_pre."order set `check_code`='".$random_code."',`send_time`=".time().",`check_code_state`=1 where `id`=".$order['id'];}
				$sql="update ".$table_pre."order set `check_code`='".$random_code."',`send_time`=".time().",`check_code_state`=1 where `id`=".$order['id'];
				$pdo->exec($sql);
			}
			
			//=======================================================================================http
			if(count($http)>0){
				foreach($http as $v2){
					if($order['receiver_id']<1){
						$sql="select `phone` from ".$pdo->index_pre."user where `username`='".$order['buyer']."' limit 0,1";
						$buyer=$pdo->query($sql,2)->fetch(2);
						$order['receiver_phone']=$buyer['phone'];
					}
					$url=str_replace('{phone}',$order['receiver_phone'],de_safe_str($v2));
					$url=str_replace('{email}',@$user['email'],$url);
					$url=str_replace('{order_id}',$order['id'],$url);
					$url=str_replace('{random_int}',$random_int,$url);
					$url=str_replace('{random_str}',$random_str,$url);
					$url=str_replace('{shopName}',$shopName,$url);
					$url=str_replace('{address}',$shop_address,$url);
					$url=str_replace('{tel}',$tel,$url);
					$url=str_replace('{check_code}',$random_code,$url);
					$url=trim($url);
					//file_put_contents('./auto_send_test.txt',@file_get_contents('./auto_send_test.txt')."\r\n".$url);
					curl_open($url);
				}
			}
		}
		return true;
	}
//==========================================================================================================================虚拟物品自动发货 end	




	function create_main_img_snapshot_dir($path,$time){
		$parent_dir='./program/mall/snapshot/img/'.date("Y_m_d",$time);
		@mkdir($parent_dir);
		@mkdir(str_replace('/img/','/img_thumb/',$parent_dir));
		$parent_dir.='/'.date("Y_m_d_H_i_s",$time);
		$parent_dir_prefix=$parent_dir;
		@mkdir($parent_dir);
		@mkdir(str_replace('/img/','/img_thumb/',$parent_dir));
		$temp=explode('/',$path);
		$parent_dir.='/'.$temp[0];
		@mkdir($parent_dir);
		@mkdir(str_replace('/img/','/img_thumb/',$parent_dir));
		$parent_dir.='/'.@$temp[1];
		@mkdir($parent_dir);
		@mkdir(str_replace('/img/','/img_thumb/',$parent_dir));
		return $parent_dir_prefix;
	}
	function create_detail_img_snapshot_dir($path,$time){
		$parent_dir='./program/mall/snapshot/img/'.date("Y_m_d",$time);
		@mkdir($parent_dir);
		$parent_dir.='/'.date("Y_m_d_H_i_s",$time);
		@mkdir($parent_dir);
		$parent_dir_prefix=$parent_dir;
		$temp=explode('/',$path);
		$parent_dir.='/'.$temp[0];
		@mkdir($parent_dir);
		return $parent_dir_prefix;
	}


   
	//===============================================================================================创建商品快照
	function create_mall_goods_snapshot($pdo,$table_pre,$r){
		$time=time();
		$attribute='';
		//get goods_attribute ==========================================================================================================
		$sql="select `id`,`attribute_id`,`value` from ".self::$table_pre."goods_attribute where `goods_id`=".$r['id'];
		$r2=$pdo->query($sql,2);
		$temp=array();
		$ids='';
		foreach($r2 as $v){
			$ids.=$v['attribute_id'].',';
			$temp[$v['attribute_id']]=$v['value'];	
		}
		$ids=trim($ids,',');
		if($ids!=''){
			$sql="select `id`,`name` from ".self::$table_pre."type_attribute where `id` in (".$ids.") order by `sequence` desc";
			$r2=$pdo->query($sql,2);
			foreach($r2 as $v){
				$attribute.='<div><span class=a_label>'.$v['name'].'</span><span class=a_value>'.$temp[$v['id']].'</span></div>';
			}	
		}
		
		$r['new_detail']=str_replace('program/mall/attachd/image/','program/mall/snapshot/img/'.date("Y_m_d",$time).'/'.date("Y_m_d_H_i_s",$time).'/',$r['detail']);
		$r['new_m_detail']=str_replace('program/mall/attachd/image/','program/mall/snapshot/img/'.date("Y_m_d",$time).'/'.date("Y_m_d_H_i_s",$time).'/',$r['m_detail']);
		$sql="insert into ".$table_pre."goods_snapshot (`goods_id`,`title`,`advantage`,`icon`,`multi_angle_img`,`detail`,`m_detail`,`time`,`attribute`) values ('".$r['id']."','".$r['title']."','".$r['advantage']."','".$r['icon']."','".$r['multi_angle_img']."','".$r['new_detail']."','".$r['new_m_detail']."','".$time."','".$attribute."')";
		if($pdo->exec($sql)){
			$insret_id=$pdo->lastInsertId();
			$parent_dir_prefix=self::create_main_img_snapshot_dir($r['icon'],$time);
			@copy('./program/mall/img/'.$r['icon'],$parent_dir_prefix.'/'.$r['icon']);
			@copy('./program/mall/img_thumb/'.$r['icon'],str_replace('/img/','/img_thumb/',$parent_dir_prefix).'/'.$r['icon']);
			if($r['multi_angle_img']!=''){
				$temp=explode('|',$r['multi_angle_img']);
				foreach($temp as $v){
					if($v==''){continue;}
					$parent_dir_prefix=self::create_main_img_snapshot_dir($v,$time);
					@copy('./program/mall/img/'.$v,$parent_dir_prefix.'/'.$v);
					@copy('./program/mall/img_thumb/'.$v,str_replace('/img/','/img_thumb/',$parent_dir_prefix).'/'.$v);
				}	
			}
			
			$reg='#<img.*src=&\#34;(program/mall/attachd/image/.*)&\#34;.*>#iU';
			$imgs=get_match_all($reg,$r['detail']);
			//var_dump($imgs);
			foreach($imgs as $v){
				if($v==''){continue;}
				$v2=str_replace('program/mall/attachd/image/','',$v);
				$parent_dir_prefix=self::create_detail_img_snapshot_dir($v2,$time);
				@copy($v,$parent_dir_prefix.'/'.$v2);
			}
			$imgs=get_match_all($reg,$r['m_detail']);
			//var_dump($imgs);
			foreach($imgs as $v){
				if($v==''){continue;}
				$v2=str_replace('program/mall/attachd/image/','',$v);
				$parent_dir_prefix=self::create_detail_img_snapshot_dir($v2,$time);
				copy($v,$parent_dir_prefix.'/'.$v2);
			}
			
			//check last Whether use
			$sql="select `id` from ".$table_pre."goods_snapshot where `goods_id`='".$r['id']."' and `id`!='".$insret_id."' order by `id` desc limit 0,1";
			//file_put_contents('./test.txt',$sql);
			$last=$pdo->query($sql,2)->fetch(2);
			if($last['id']!=''){
				$sql="select `id` from ".$table_pre."order_goods where `snapshot_id`='".$last['id']."' limit 0,1";
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['id']==''){
					$sql="select `time` from ".$table_pre."goods_snapshot where `id`=".$last['id'];
					//file_put_contents('./test.txt',$sql);
					$r2=$pdo->query($sql,2)->fetch(2);
					$sql="delete from ".$table_pre."goods_snapshot where `id`=".$last['id'];
					if($pdo->exec($sql)){
						$dir=new Dir();
						$dir->del_dir('./program/mall/snapshot/img/'.date("Y_m_d",$r2['time']).'/'.date("Y_m_d_H_i_s",$r2['time']));
						$dir->del_dir('./program/mall/snapshot/img_thumb/'.date("Y_m_d",$r2['time']).'/'.date("Y_m_d_H_i_s",$r2['time']));
					}	
				}	
			}
			
			return true;	
		}else{
			return false;	
		}	
	}

	
   
	//===============================================================================================更新商品批次数量
	function return_goods_batch($pdo,$goods_id,$quantity,$id){
		if($id==0){return false;}
		$sql="update ".self::$table_pre."goods_batch set `left`=`left`+".$quantity." where `id`=".$id;
		return $pdo->exec($sql);
	}
   
	//===============================================================================================更新商品销量
	function return_goods_quantity($pdo,$table_pre,$order_id,$state){
		if($state==0){return false;}
		$sql="select `id`,`goods_id`,`s_id`,`quantity` from ".$table_pre."order_goods where `order_id`=".$order_id;
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			$goods_id=$v['goods_id'];
			if($v['s_id']!=0){
				$sql="update ".$table_pre."goods_specifications set `quantity`=`quantity`+".$v['quantity']." where `id`=".$v['s_id'];	
				$pdo->exec($sql);
				$goods_id.='_'.$v['s_id'];
			}
			$sql="update ".$table_pre."goods set `inventory`=`inventory`+".$v['quantity'].",`sold`=`sold`-".$v['quantity']." where `id`=".$v['goods_id'];	
			if($pdo->exec($sql)){
				$sql="select `batch_id` from ".self::$table_pre."goods_quantity_log where `order_id`=".$order_id." limit 0,1";
				$r=$pdo->query($sql,2)->fetch(2);
				self::return_goods_batch($pdo,$goods_id,$v['quantity'],$r['batch_id']);
				$sql="delete from ".$table_pre."goods_quantity_log  where `order_id`=".$order_id;
				$pdo->exec($sql);
				
			}
		}
		$sql="update ".self::$table_pre."order set `inventory_decrease`=0 where `id`=".$order_id;
		$pdo->exec($sql);	
	}
   
//======================================================================================================= 网上自助提交的订单符合减商品库存条件时，减商品库存
	function decrease_goods_quantity($pdo,$table_pre,$order){
		$sql="select `decrease_quantity` from ".$table_pre."shop_order_set where `shop_id`=".$order['shop_id'];
		$r=$pdo->query($sql,2)->fetch(2);
		if(intval($r['decrease_quantity'])==intval($order['state']) && $order['inventory_decrease']==0){
			$sql="select `id`,`goods_id`,`s_id`,`quantity`,`transaction_price` from ".$table_pre."order_goods where `order_id`=".$order['id'];
			$r=$pdo->query($sql,2);
			foreach($r as $v){
				$goods_id=$v['goods_id'];
				self::auto_deleave_big_box($pdo,$goods_id,$v['quantity']);
				if($v['s_id']!=0){
					$sql="update ".$table_pre."goods_specifications set `quantity`=`quantity`-".$v['quantity']." where `id`=".$v['s_id'];	
					$pdo->exec($sql);
					$goods_id.='_'.$v['s_id'];
				}
				$sql="update ".$table_pre."goods set `inventory`=`inventory`-".$v['quantity'].",`sold`=`sold`+".$v['quantity']." where `id`=".$v['goods_id'];	
				if($pdo->exec($sql)){
					$batch_id=self::decrease_goods_batch($pdo,$goods_id,$v['quantity']);
					$in_price=self::get_cost_price($pdo,$goods_id);
					$sql="insert into ".$table_pre."goods_quantity_log (`goods_id`,`quantity`,`username`,`time`,`order_id`,`batch_id`,`shop_id`,`in_price`,`out_price`,`s_id`) values ('".$v['goods_id']."','-".$v['quantity']."','monxin','".time()."','".$order['id']."','".$batch_id."','".$order['shop_id']."','".$in_price."','".$v['transaction_price']."','".$v['s_id']."')";
					$pdo->exec($sql);
					
				}
			}
			$sql="update ".self::$table_pre."order set `inventory_decrease`=1 where `id`=".$order['id'];
			$pdo->exec($sql);	
			self::update_config_file('goods_update_time',time());
		}
	}
	
   
//======================================================================================================= 收银提交的订单交易成功后，减商品库存
	function checkout_decrease_goods_quantity($pdo,$table_pre,$order){
		if($order['inventory_decrease']==1){return false;}
		$sql="select `id`,`goods_id`,`s_id`,`quantity`,`transaction_price` from ".$table_pre."order_goods where `order_id`=".$order['id'];
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			$goods_id=$v['goods_id'];
			self::auto_deleave_big_box($pdo,$goods_id,$v['quantity']);
			if($v['s_id']!=0){
				$sql="update ".$table_pre."goods_specifications set `quantity`=`quantity`-".$v['quantity']." where `id`=".$v['s_id'];	
				$pdo->exec($sql);
				$goods_id.='_'.$v['s_id'];
			}
			$sql="update ".$table_pre."goods set `inventory`=`inventory`-".$v['quantity'].",`sold`=`sold`+".$v['quantity']." where `id`=".$v['goods_id'];	
			if($pdo->exec($sql)){
				$batch_id=self::decrease_goods_batch($pdo,$goods_id,$v['quantity']);
				$in_price=self::get_cost_price($pdo,$goods_id);
				$sql="insert into ".$table_pre."goods_quantity_log (`goods_id`,`quantity`,`username`,`time`,`order_id`,`batch_id`,`shop_id`,`in_price`,`out_price`,`s_id`) values ('".$v['goods_id']."','-".$v['quantity']."','monxin','".time()."','".$order['id']."','".$batch_id."','".$order['shop_id']."','".$in_price."','".$v['transaction_price']."','".$v['s_id']."')";
				$pdo->exec($sql);
				
				
			}
		}
		$sql="update ".self::$table_pre."order set `inventory_decrease`=1 where `id`=".$order['id'];
		$pdo->exec($sql);	
		self::update_config_file('goods_update_time',time());
	}
	
//======================================================================================================= 如是小包装并库存不够减时 自拆大包装
	function auto_deleave_big_box($pdo,$goods_id,$quantity){
		
		$sql="select `id`,`inventory`,`option_enable`,`shop_id` from ".self::$table_pre."goods where `id`=".$goods_id;
		$g=$pdo->query($sql,2)->fetch(2);
		$g['s_id']='';
		if($g['option_enable']){
			$g['inventory']=0;
			$sql="select `quantity`,`id` from ".self::$table_pre."goods_specifications where `goods_id`='".$goods_id."'";
			$gs=$pdo->query($sql,2);
			$list=array();
			$module['inventory']=0;
			foreach($gs as $v){
				$g['inventory']+=$v['quantity'];
				$g['s_id']='_'.$v['id'];
			}
			
		}
		if($g['inventory']>=$quantity){return false;}
		
		$sql="select `big`,`quantity` from ".self::$table_pre."public_stock where `small`=".$goods_id." limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['big']!=0 && $r['quantity']>0){
			$d_big_quantity=ceil($quantity/$r['quantity']);
			$big_id=$r['big'];
			$sql="select `option_enable` from ".self::$table_pre."goods where `id`=".$big_id;
			$big=$pdo->query($sql,2)->fetch(2);
			
			$option_id=0;
			if($big['option_enable']!=0){
				$sql="select `id` from ".self::$table_pre."goods_specifications where `goods_id`=".$r['big']." order by `quantity` desc limit 0,1";
				$temp=$pdo->query($sql,2)->fetch(2);
				if($temp['id']==''){return false;}
				$sql="update ".self::$table_pre."goods_specifications set `quantity`=`quantity`-".$d_big_quantity." where `id`=".$temp['id']."";	
				$pdo->exec($sql);
				$big_id.='_'.$temp['id'];
				$option_id=$temp['id'];
			}
			$sql="update ".self::$table_pre."goods set `inventory`=`inventory`-".$d_big_quantity." where `id`=".$r['big'];	
			if($pdo->exec($sql)){
				$batch_id=self::decrease_goods_batch($pdo,$big_id,$d_big_quantity);
				file_put_contents('t.txt',$big_id.','.$d_big_quantity);
				if($batch_id!=''){
					$sql="select * from ".self::$table_pre."goods_batch where `id`=".$batch_id;
					$batch=$pdo->query($sql,2)->fetch(2);
					$sql="insert into ".self::$table_pre."goods_deduct_stock (`goods_id`,`s_id`,`quantity`,`money`,`reason`,`time`,`username`,`shop_id`) values ('".$r['big']."','".$option_id."','".$d_big_quantity."','".($batch['price']*$d_big_quantity)."','".self::$language['auto_deleave_big_box']."','".time()."','monxin','".$g['shop_id']."')";
					//file_put_contents('t.txt',$sql);
					$pdo->exec($sql);
					$batch['price']=$batch['price']/$r['quantity'];
					self::add_goods_batch($pdo,$goods_id.$g['s_id'],$d_big_quantity*$r['quantity'],$batch['price'],$batch['supplier'],$batch['expiration']);
				}
			}
		}
	}
	
//======================================================================================================= 更新商品销量
	function update_goods_monthly($pdo,$table_pre,$order){
		$sql="select `goods_id` from ".$table_pre."order_goods where `order_id`=".$order['id'];
		$r=$pdo->query($sql,2);
		$start_time=time()-(86400*30);
		foreach($r as $v){
			$sql="select sum(quantity) as c from ".$table_pre."order_goods where `goods_id`=".$v['goods_id']." and `time`>".$start_time;
			$v2=$pdo->query($sql,2)->fetch(2);
			$sql="update ".$table_pre."goods set `monthly`=".$v2['c']." where `id`=".$v['goods_id'];
			$pdo->exec($sql);	
		}
		
	}
	
//======================================================================================================= 下单后，通知店家
	function order_notice($language,$config,$pdo,$table_pre,$order){
		$sql="select `name`,`username`,`storekeeper` from ".$table_pre."shop where `id`=".$order['shop_id'];
		$r=$pdo->query($sql,2)->fetch(2);
		$username=$r['username'];
		$shop_name=$r['name'];
		$storekeeper=$r['storekeeper'];
		$sql="select `order_notice_when` from ".$table_pre."shop_order_set where `shop_id`=".$order['shop_id'];
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['order_notice_when']==$order['state'] ){
			$title=$language['order_notice_template'];
			$order['buyer']=($order['buyer']!='')?$order['buyer']:$order['receiver_name'];
			$title=str_replace('{username}',$order['buyer'],$title);
			$title=str_replace('{webname}',$config['web']['name'].':'.$shop_name,$title);
			$title=str_replace('{state}',$language['order_state'][$order['state']],$title);
			if($order['pay_method']=='cash_on_delivery'){$order['state']=0;}
			$order['goods_names']=mb_substr($order['goods_names'],0,10,'utf-8').' ...';
			push_new_order_info($pdo,$config,$language,$username,$title,$shop_name,de_safe_str($order['goods_names']),$order['actual_money'],$order['state'],$order['out_id']);
			if($storekeeper!=''){
				$storekeeper=explode(',',$storekeeper);
				push_new_order_info($pdo,$config,$language,$storekeeper[0],$title,$shop_name,de_safe_str($order['goods_names']),$order['actual_money'],$order['state'],$order['out_id']);	
			}
			self::submit_cloud_print($pdo,$order['id']);
		}
	}

//==================================================================================================================提交到云打印机服务器 自动打印
function  submit_cloud_print($pdo,$order_id){
	$sql="select * from ".$pdo->sys_pre."mall_order where `id`=".$order_id;
	
	$v=$pdo->query($sql,2)->fetch();
	if($v){	
		$sql="select `name` from ".$pdo->sys_pre."mall_shop where `id`=".$v['shop_id'];
		$r=$pdo->query($sql,2)->fetch(2);
		$shop_name=$r['name'];			
		$sql="select `title`,`transaction_price`,`quantity`,`unit`,`s_id`,`price`,`barcode` from ".$pdo->sys_pre."mall_order_goods where `order_id`=".$v['id'];
		$r2=$pdo->query($sql,2);
		$list2='';
		//file_put_contents('yun_print.txt',''.$sql);
		foreach($r2 as $v2){
			if($v['preferential_way']==5){$o_price='<span class=o_price>'.$v2['price'].'</span>';$v2['price']=$v2['transaction_price'];}else{$o_price='';}
						

			//echo $v2['title'].' '.mb_strlen($v2['title'],'utf-8').'<br />';
			if(mb_strlen($v2['title'],'utf-8')>18){
				if($v2['s_id']!=0){
					$v2['title']=mb_substr($v2['title'],0,6,'utf-8').'..'.mb_substr($v2['title'],mb_strlen($v2['title'],'utf-8')-14,9,'utf-8');
				}else{
					$v2['title']=mb_substr($v2['title'],0,15,'utf-8').'..';
				}			
			}
			if($v2['barcode']=='0'){$v2['barcode']='';}
			$list2.='<tr><td colspan=3>'.trim($v2['title']).'</td></tr><tr><td>'.$v2['price'].'</td><td>'.self::format_quantity($v2['quantity']).$v2['unit'].'</td><td>'.number_format($v2['price']*$v2['quantity'],2).'</td></tr><tr><td colspan=3>------------------------------</td></tr>';
				
		}
		$sql="select `name` from ".$pdo->sys_pre."mall_shop where `id`=".$v['shop_id'];
		
		$r=$pdo->query($sql,2)->fetch(2);
		$shop_name=$r['name'];
		
		if($v['receiver_area_name']==''){
			$receiver_info='';
		}else{
			$receiver_info=$v['receiver_name'].' '.$v['receiver_phone'].' '.$v['receiver_area_name'].' '.$v['receiver_detail'].' '.$v['receiver_post_code'].' '.' '.self::$language['delivery_time_info'][$v['delivery_time']]." ".self::get_express_name($pdo,$pdo->sys_pre."mall_",$v['express'])." ".$v['express_code']." ";
		}
		if($v['goods_money']+$v['express_cost_buyer']-$v['sum_money']!=0){
			$preferential_way="<right>".self::$language['sum'].":".$v['goods_money'].self::$language['yuan']."</right><right>".$v['preferential_code'].self::$language['preferential_way_option'][$v['preferential_way']].": -". sprintf('%.2f',$v['goods_money']+$v['express_cost_buyer']-$v['sum_money']).self::$language['yuan']."</right>";		
		}else{$preferential_way='';}		
		
		if($v['buyer_remark']!=''){$v['buyer_remark']=self::$language['buyer'].self::$language['remark'].':'.$v['buyer_remark'];}
		if($v['seller_remark']!=''){$v['seller_remark']=self::$language['seller'].self::$language['remark'].':'.$v['seller_remark'];}
		if($v['preferential_way']==5){$preferential_way='';}
		if($v['web_credits_money']!=0){$v['buyer_remark'].=' '.$v['credits_remark'];}
		$content="<center>".$shop_name."</center>\r".self::$language['order_number'].':'.$v['out_id']."\r".self::$language['order_id'].self::$language['state'].":".self::$language['order_state'][$v['state']]." ".@self::$language['pay_method'][$v['pay_method']]."\r<table><tr><td>".self::$language['price']."</td><td>".self::$language['quantity']."</td><td>".self::$language['subtotal']."</td></tr>".$list2."</table>\r".$preferential_way."<right>".self::$language['actual_pay'].self::$language['money_symbol'].str_replace('.00','',$v['actual_money']-$v['web_credits_money']).self::$language['yuan'].'('.self::$language['freight_costs'].str_replace('.00','',$v['express_cost_buyer']).self::$language['yuan'].")</right>".$v['change_price_reason']."\r".$receiver_info."\r".$v['buyer']."  ".date('Y-m-d H:i',$v['add_time'])."\r\n".$v['buyer_remark'].$v['seller_remark'];
		if($v['cashier']!='' && $v['cashier']!='monxin'){$content.='<right>'.self::$language['cashier'].':'.$v['cashier'].'</right>';}	
		file_put_contents('yunp.txt',$content);
		}
	$sql="select * from ".$pdo->sys_pre."mall_shop_order_set where `shop_id`=".$v['shop_id']." limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){return false;}	
	yun_print($r['print_supplier'],$r['print_partner'],$r['print_apikey'],$r['print_machine_code'],$r['print_msign'],$content);//提交到易联云
	
}	
	
	
//======================================================================================================= 收银台，交易提醒买家。
	function checkout_order_notice($language,$config,$pdo,$table_pre,$order){
		if($order['buyer']==''){return false;}
		$sql="select `name` from ".$table_pre."shop where `id`=".$order['shop_id'];
		$r=$pdo->query($sql,2)->fetch(2);
		$shop_name=$r['name'];
		$sql="select `checkout_order_notice_email`,`checkout_order_notice_sms` from ".$table_pre."shop_order_set where `shop_id`='".$order['shop_id']."' limit 0,1";
		$order_set=$pdo->query($sql,2)->fetch(2);
		$sql="select `phone`,`email` from ".$pdo->index_pre."user where `username`='".$order['buyer']."' limit 0,1";
		$buyer=$pdo->query($sql,2)->fetch(2);
		
		$title=$language['checkout_order_safety_note'];
		$title=str_replace('{time}',date("m-d H:i",$order['add_time']),$title);
		$title=str_replace('{webname}',$config['web']['name'],$title);
		$title=str_replace('{username}',$order['buyer'],$title);
		$title=str_replace('{money}',$order['actual_money'],$title);
		$title=str_replace('{pay_method}',$language['pay_method'][$order['pay_method']],$title);
		$title=str_replace('{shop_name}',$shop_name,$title);
		
		if($order_set['checkout_order_notice_email'] && is_email($buyer['email'])){			
			email($config,$language,$pdo,'monxin',$buyer['email'],$title,'<div style="font-size:30px;">'.$title.'</div>');
		}
		if($order_set['checkout_order_notice_sms'] && preg_match($config['other']['reg_phone'],$buyer['phone'])){
			//sms($config,$language,$pdo,'monxin',$buyer['phone'],$title);
		}
	}
	
//======================================================================================================= 发货后，通知买家
	function send_notice($language,$config,$pdo,$table_pre,$order){
		if($order['buyer']==''){return false;}
		$sql="select `name`,`username` from ".$table_pre."shop where `id`=".$order['shop_id'];
		$r=$pdo->query($sql,2)->fetch(2);
		$seller=$r['username'];
		$shop_name=$r['name'];
		$sql="select `send_notice_email`,`send_notice_sms` from ".$table_pre."shop_order_set where `shop_id`='".$order['shop_id']."' limit 0,1";
		$order_set=$pdo->query($sql,2)->fetch(2);
		$sql="select `phone`,`email` from ".$pdo->index_pre."user where `username`='".$order['buyer']."' limit 0,1";
		$buyer=$pdo->query($sql,2)->fetch(2);
		
		$title=$language['order_send_notice_template'];
		$title=str_replace('{time}',date("m-d H:i",$order['add_time']),$title);
		$title=str_replace('{webname}',$config['web']['name'],$title);
		$title=str_replace('{shop_name}',$shop_name,$title);
		
		if($order_set['send_notice_email'] && is_email($buyer['email'])){
			
			$express_code='';
			//var_dump($order['express_code']);
			if($order['express_code']!=''){
				$temp3=explode(',',$order['express_code']);
				if(count($temp3)>1){
					$temp2='';
					foreach($temp3 as $v3){
						$temp2.='<a href=http://'.$config['web']['domain'].'/receive.php?target=mall::order_admin&act=go_express&id='.$order['express'].'&code='.$v3.' target=_blank>'.$v3.'</a> , ';		
					}
					$express_code=trim($temp2,' , ');
				}else{
					$express_code='<a href=http://'.$config['web']['domain'].'/receive.php?target=mall::order_admin&act=go_express&id='.$order['express'].'&code='.$order['express_code'].' target=_blank>'.$order['express_code'].'</a>';	
					
				}	
			}
			
			$content=self::get_express_name($pdo,$table_pre,$order['express']).':'.$express_code;
			
			email($config,$language,$pdo,'monxin',$buyer['email'],$title,$content);
		}
		if($order_set['send_notice_sms'] && preg_match($config['other']['reg_phone'],$buyer['phone'])){
			//if(self::sms_fees($pdo,$seller,$order['shop_id'],$order['id'],$title,true)){sms($config,$language,$pdo,'monxin',$buyer['phone'],$title);}
		}
	}

	
//======================================================================================================= 店铺发短信相关，扣费
	function sms_fees($pdo,$seller,$shop_id,$order_id,$content){
		$money='-'.self::$config['sms_fees'];
		$reason=$order_id.self::$language['order_postfix'].self::$language['sms_fees'].': '.$content;
		if(operator_money(self::$config,self::$language,$pdo,$seller,$money,$reason,'mall',true)){
			self::operation_shop_finance(self::$language,$pdo,self::$table_pre,$shop_id,$money,10,$reason);
			return true;
		}else{return false;}
	}
	
//======================================================================================================= 返回商品单位的名称
	function get_mall_unit_name($pdo,$id){
		$sql="select `name`,`gram` from ".self::$table_pre."unit where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$_POST['temp_unit_gram']=$r['gram'];
		return $r['name'];	
	}
	
//======================================================================================================= 返回快递公司名称
	function get_express_name($pdo,$table_pre,$id){
		$sql="select `name` from ".$table_pre."express where `id`='".$id."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		return $r['name'];
	}
	
//======================================================================================================= 更新商品评论
	function update_goods_comment($pdo,$table_pre,$id){
		$sql="select count(id) as c from ".$table_pre."comment where `goods_id`='".$id."' and `level`=0";
		$r=$pdo->query($sql,2)->fetch(2);
		$comment_0=$r['c'];
		$sql="select count(id) as c from ".$table_pre."comment where `goods_id`='".$id."' and `level`=1";
		$r=$pdo->query($sql,2)->fetch(2);
		$comment_1=$r['c'];
		$sql="select count(id) as c from ".$table_pre."comment where `goods_id`='".$id."' and `level`=2";
		$r=$pdo->query($sql,2)->fetch(2);
		$comment_2=$r['c'];
			
		if(($comment_0+$comment_2)==0){$satisfaction=100;}else{
			$satisfaction=intval(($comment_0/($comment_0+$comment_2))*100);
			//echo $satisfaction=$v['comment_0'].'/'.($v['comment_0']+$v['comment_2']).'='.$satisfaction.'<br />';
		}
		
		$sql="update ".$table_pre."goods set `comment_0`='".$comment_0."',`comment_1`='".$comment_1."',`comment_2`='".$comment_2."',`satisfaction`='".$satisfaction."' where `id`=".$id;
		$pdo->exec($sql);
		
		$sql="select `shop_id` from ".self::$table_pre."goods where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$shop_id=$r['shop_id'];
		$sql="select sum(comment_0) as c from ".$table_pre."goods where `shop_id`='".$shop_id."'";
		$r=$pdo->query($sql,2)->fetch(2);
		$comment_0=$r['c'];
		$sql="select sum(comment_1) as c from ".$table_pre."goods where `shop_id`='".$shop_id."'";
		$r=$pdo->query($sql,2)->fetch(2);
		$comment_1=$r['c'];
		$sql="select sum(comment_2) as c from ".$table_pre."goods where `shop_id`='".$shop_id."'";
		$r=$pdo->query($sql,2)->fetch(2);
		$comment_2=$r['c'];
		
		$sql="update ".$table_pre."shop set `evaluation_0`='".$comment_0."',`evaluation_1`='".$comment_1."',`evaluation_2`='".$comment_2."' where `id`=".$shop_id;
		$pdo->exec($sql);
	}
	
	
//======================================================================================================= 更新分类的属性
	function update_type_attribute($pdo,$table_pre,$id,$v){
		$sql="select `values` from ".$table_pre."type_attribute where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$temp=explode('/',$r['values']);
		if(!in_array($v,$temp)){
			$sql="update ".$table_pre."type_attribute set `values`=concat(`values`,'/".$v."') where `id`=".$id;	
			$pdo->exec($sql);
		}
			
	}
	
	
//======================================================================================================= 添加店内商品分类 
	function add_shop_type($pdo,$table_pre,$v){
		$sql="select `id` from ".$table_pre."shop_type where `shop_id`=".SHOP_ID." and `name`='".$v."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){return $r['id'];}
		$sql="insert into ".$table_pre."shop_type (`name`,`shop_id`) values ('".$v."','".SHOP_ID."')";
		if($pdo->exec($sql)){return $pdo->lastInsertId();}else{return 0;}	
	}
	
//======================================================================================================= 获得店内商品分类名称
	function get_shop_type_name($pdo,$table_pre,$type_id){
		$sql="select `name` from ".$table_pre."shop_type where `id`=".$type_id." limit 0,1";
		file_put_contents('t.txt',$sql);
		$r=$pdo->query($sql,2)->fetch(2);
		return $r['name'];
	}
	
	
//======================================================================================================= 添加商品分类的品牌
	function add_brand($pdo,$table_pre,$v,$type){
		if($v==''){return 0;}
		if($type==''){return 0;}
		$sql="select `brand_source`,`parent` from ".self::$table_pre."type where `id`=".$type;
		
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['brand_source']==1){
			$type=$type;
		}elseif($r['parent']!=0){
			$sql="select `brand_source`,`parent`,`id` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['brand_source']==1){
				$type=$r['id'];
			}elseif($r['parent']!=0){
				$sql="select `brand_source`,`parent`,`id` from ".self::$table_pre."type where `id`=".$r['parent'];
				$r=$pdo->query($sql,2)->fetch(2);
				$type=$r['id'];
			}
		}
		
		$sql="select `id` from ".$table_pre."type_brand where `type_id`='".$type."' and `name`='".$v."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){return $r['id'];}
		$sql="insert into ".$table_pre."type_brand (`name`,`shop_id`,`type_id`) values ('".$v."','".SHOP_ID."','".$type."')";
		if($pdo->exec($sql)){return $pdo->lastInsertId();}else{return 0;}	
	}
	
	
//======================================================================================================= 添加店铺商品销售展示所在位置
	function add_position($pdo,$table_pre,$v){
		$sql="select `id` from ".$table_pre."position where `name`='".$v."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){return $r['id'];}
		$sql="insert into ".$table_pre."position (`name`,`shop_id`) values ('".$v."','".SHOP_ID."')";
		if($pdo->exec($sql)){return $pdo->lastInsertId();}else{return 0;}	
	}
//======================================================================================================= 添加店商品库存所在位置
	function add_storehouse($pdo,$table_pre,$v){
		$sql="select `id` from ".$table_pre."storehouse where `name`='".$v."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){return $r['id'];}
		$sql="insert into ".$table_pre."storehouse (`name`,`shop_id`) values ('".$v."','".SHOP_ID."')";
		if($pdo->exec($sql)){return $pdo->lastInsertId();}else{return 0;}	
	}
	
//======================================================================================================= 添加店铺商品的供应商
	function add_supplier($pdo,$table_pre,$v){
		$sql="select `id` from ".$table_pre."supplier where `name`='".$v."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){return $r['id'];}
		$sql="insert into ".$table_pre."supplier (`name`,`shop_id`) values ('".$v."','".SHOP_ID."')";
		if($pdo->exec($sql)){return $pdo->lastInsertId();}else{return 0;}	
	}
	
//======================================================================================================= 返回商品单位的名称
	function add_unit($pdo,$table_pre,$v){
		$sql="select `id` from ".$table_pre."unit where `name`='".$v."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){return $r['id'];}
		$sql="insert into ".$table_pre."unit (`name`,`shop_id`) values ('".$v."','".SHOP_ID."')";
		if($pdo->exec($sql)){return $pdo->lastInsertId();}else{return 0;}	
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
	
//======================================================================================================= 返回店铺满元惠数据 json格式
	function get_fulfil_preferential_json($pdo,$table_pre){
		$list=array();
		$time=time();
		$sql="select * from ".$table_pre."fulfil_preferential where `shop_id`='".SHOP_ID."' and `end_time`>'".$time."' order by `min_money` asc";
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			if($v['use_method']>1){continue;}
			$list[$v['id']]['min_money']=$v['min_money'];	
			$list[$v['id']]['use_method']=$v['use_method'];	
			$list[$v['id']]['less_money']=$v['less_money'];	
			$list[$v['id']]['discount']=$v['discount'];	
			$list[$v['id']]['join_goods']=$v['join_goods'];	
		}
		//$list=self::array_sort($list,'min_money',$type='asc');
		return json_encode($list);
	}
	
//======================================================================================================= 更新店铺自定义模块
	function update_module($pdo,$del_id=0){
		return true;
		$program='mall';
		$module_config=require './program/'.$program.'/module_config.php';
		$program_config=require './program/'.$program.'/config.php';
		$program_language=require './program/'.$program.'/language/'.$program_config['program']['language'].'.php';
		
		if($del_id>0){
			unset($module_config['mall.diymodule_show_'.$del_id]);
			unset($program_language['functions']['mall.diymodule_show_'.$del_id]);
		}
		
		$sql="select `title`,`id` from ".self::$table_pre."module";
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			$id=$v['id'];
			$module_config['mall.diymodule_show_'.$id]['edit_url']='index.php?monxin=mall.diymodule_edit&id='.$id.'&';
			$module_config['mall.diymodule_show_'.$id]['pagesize']='';
			$module_config['mall.diymodule_show_'.$id]['share']=true;
			$program_language['functions']['mall.diymodule_show_'.$id]['description']=$v['title'];
			$program_language['functions']['mall.diymodule_show_'.$id]['power_suggest']='';
			
		}
		file_put_contents('./program/'.$program.'/module_config.php','<?php return '.var_export($module_config,true).'?>');
	
		file_put_contents('./program/'.$program.'/language/'.$program_config['program']['language'].'.php','<?php return '.var_export($program_language,true).'?>');
		
		
	}
	
	function remove_shop_module($pdo,$module){
			
	}
	
	
//======================================================================================================= 返回商品单位的名称
	function get_type_position($pdo,$id){
		if(intval($id)==0){return '';}
		$position='';
		$sql="select `name`,`parent`,`id` from ".self::$table_pre."type where `id`=$id";
		$r=$pdo->query($sql,2)->fetch(2);
		$position='<a href="./index.php?monxin=mall.goods_list&type='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>';
		if($r['parent']>0){
			$sql="select `name`,`parent`,`id` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$position='<a href="./index.php?monxin=mall.goods_list&type='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>'.$position;
		}
		if($r['parent']>0){
			$sql="select `name`,`parent`,`id` from ".self::$table_pre."type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$position='<a href="./index.php?monxin=mall.goods_list&type='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>'.$position;
		}
		return $position;
	}
	
//======================================================================================================= 根据店内商品分类返回位置条信息
	function get_shop_type_position($pdo,$id){
		if(intval($id)==0){return '';}
		$position='';
		$sql="select `name`,`parent`,`id` from ".self::$table_pre."shop_type where `id`=$id";
		$r=$pdo->query($sql,2)->fetch(2);
		$position='<a href="./index.php?monxin=mall.shop_goods_list&shop_id='.SHOP_ID.'&type='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>';
		if($r['parent']>0){
			$sql="select `name`,`parent`,`id` from ".self::$table_pre."shop_type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$position='<a href="./index.php?monxin=mall.shop_goods_list&shop_id='.SHOP_ID.'&type='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>'.$position;
		}
		if($r['parent']>0){
			$sql="select `name`,`parent`,`id` from ".self::$table_pre."shop_type where `id`=".$r['parent'];
			$r=$pdo->query($sql,2)->fetch(2);
			$position='<a href="./index.php?monxin=mall.shop_goods_list&shop_id='.SHOP_ID.'&type='.$r['id'].'&order='.@$_GET['order'].'">'.$r['name'].'</a>'.$position;
		}
		return $position;
	}
	
	
//======================================================================================================= 返回店内标签信息
	function get_shop_tags_name($pdo,$tag){
		$tag=str_replace('|',',',$tag);
		$tag=trim($tag,',');
		if($tag==''){return '';}
		$sql="select `name`,`id` from ".self::$table_pre."shop_tag where `id` in (".$tag.") and `shop_id`=".SHOP_ID;
		$r=$pdo->query($sql,2);
		$temp='';
		foreach($r as $v){
			$temp.='<a href=./index.php?monxin=mall.shop_goods_list&shop_id='.SHOP_ID.'&tag='.$v['id'].'>'.$v['name'].'</a> , ';
		}
		$temp=trim($temp,' , ');
		return $temp;
			
	}
	function get_store_tags_name($pdo,$tag){
		$tag=str_replace('|',',',$tag);
		$tag=trim($tag,',');
		if($tag==''){return '';}
		$sql="select `name`,`id` from ".self::$table_pre."store_tag where `id` in (".$tag.")";
		$r=$pdo->query($sql,2);
		$temp='';
		foreach($r as $v){
			$temp.='<a href=./index.php?monxin=mall.shop_list&tag='.$v['id'].'>'.$v['name'].'</a> , ';
		}
		$temp=trim($temp,' , ');
		return $temp;
			
	}
	
//======================================================================================================= 获取平台标签 并返回 HTML
	function get_tags_name($pdo,$tag){
		$tag=str_replace('|',',',$tag);
		$tag=trim($tag,',');
		if($tag==''){return '';}
		$sql="select `name`,`id` from ".self::$table_pre."tag where `id` in (".$tag.")";
		$r=$pdo->query($sql,2);
		$temp='';
		foreach($r as $v){
			$temp.='<a href=./index.php?monxin=mall.goods_list&tag='.$v['id'].'>'.$v['name'].'</a> , ';
		}
		$temp=trim($temp,' , ');
		return $temp;
			
	}
	
	
//======================================================================================================= 生成二维码
	function create_qr($txt,$logo_path,$save_path,$width){
		if($txt==''){return false;}
		if(is_file($save_path)){@safe_unlink($save_path);}
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
	
//======================================================================================================= 更新店铺导航条
	function update_shop_navigation($pdo,$language,$shop_id=0){
		if($shop_id==0){$shop_id=SHOP_ID;}
		$sql="select `name`,`id` from ".$pdo->sys_pre."mall_shop_type where `shop_id`=".$shop_id." and `parent`=0 and `visible`=1 order by `sequence` desc limit 0,10";
		$r=$pdo->query($sql,2);
		$temp1='';
		$temp2='';
		foreach($r as $v){
			$sql="select `name`,`id` from ".$pdo->sys_pre."mall_shop_type where `shop_id`=".$shop_id." and `parent`=".$v['id']." and `visible`=1 order by `sequence` desc limit 0,10";
			$r3=$pdo->query($sql,2);
			$temp3='';
			foreach($r3 as $v3){
				$temp3.='<li><a href="./index.php?monxin=mall.shop_goods_list&type='.$v3['id'].'"  id="stype_3_'.$v3['id'].'"><span>'.$v3['name'].'</span></a></li>';	
			}
			if($temp3!=''){
				$temp2.='<li><a href="./index.php?monxin=mall.shop_goods_list&type='.$v['id'].'" id="stype_2_'.$v['id'].'"><span>'.$v['name'].'</span><i class="fa fa-angle-right"></i></a><ul>'.$temp3.'</ul></li>';
			}else{
				$temp2.='<li><a href="./index.php?monxin=mall.shop_goods_list&type='.$v['id'].'" id="stype_2_'.$v['id'].'"><span>'.$v['name'].'</span></a></li>';
			}
			
		}
		
		if($temp2!=''){
			$temp1.='<li id=stype><a href="./index.php?monxin=mall.shop_goods_list&shop_id='.$shop_id.'"><span>'.$language['shop_whole_goods'].'</span><i class="fa fa-angle-down"></i></a><ul>'.$temp2.'</ul></li>';
		}else{
			$temp1.='<li id=stype><a href="./index.php?monxin=mall.shop_goods_list&shop_id='.$shop_id.'"><span>'.$language['shop_whole_goods'].'</span></a></li>';
		}
		
		
		$sql="select `id`,`name`,`url`,`open_target`,`parent_id` from ".$pdo->sys_pre."mall_navigation where `shop_id`=".$shop_id." and `parent_id`=0 and `visible`=1 order by `sequence` desc";
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			$v=de_safe_str($v);
			$sql2="select * from ".$pdo->sys_pre."mall_navigation where `shop_id`=".$shop_id." and `parent_id`='".$v['id']."' and `visible`=1 order by `sequence` desc";
			$r2=$pdo->query($sql2,2);
			$temp2='';
			foreach($r2 as $v2){
				$v2=de_safe_str($v2);
				$sql3="select * from ".$pdo->sys_pre."mall_navigation where `shop_id`=".$shop_id." and `parent_id`='".$v2['id']."' and `visible`=1 order by `sequence` desc";
				$r3=$pdo->query($sql3,2);
				$temp3='';
				foreach($r3 as $v3){
					$v3=de_safe_str($v3);
					$temp3.='<li><a href="'.$v3['url'].'" target="'.$v3['open_target'].'" id="'.$v3['id'].'"><span>'.$v3['name'].'</span></a></li>';	
				}
				if($temp3!=''){
					$temp2.='<li><a href="'.$v2['url'].'" target="'.$v2['open_target'].'"><span>'.$v2['name'].'</span><i class="fa fa-angle-right"></i></a><ul>'.$temp3.'</ul></li>';
				}else{
					$temp2.='<li><a href="'.$v2['url'].'" target="'.$v2['open_target'].'"><span>'.$v2['name'].'</span></a></li>';
				}
			}
			if($temp2!=''){
				$temp1.='<li><a href="'.$v['url'].'" target="'.$v['open_target'].'"><span>'.$v['name'].'</span><i class="fa fa-angle-down"></i></a><ul>'.$temp2.'</ul></li>';
			}else{
				$temp1.='<li><a href="'.$v['url'].'" target="'.$v['open_target'].'"><span>'.$v['name'].'</span></a></li>';
			}
		}
	
		$sql="update ".$pdo->sys_pre."mall_shop set `pc_menu`='".$temp1."' where `id`='".$shop_id."' and `state`=2";
		$pdo->exec($sql);
		
		self::update_shop_menu($pdo,$language);
	}
	
	
	
	
//======================================================================================================= 获取地区所属省的ID
	function get_area_top_id($pdo,$id){
		if(!is_numeric($id)){return 0;}
		$sql="select `upid` from ".$pdo->index_pre."area where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['upid']!=0){
			return  self::get_area_top_id($pdo,$r['upid']);
		}else{
			return $id;
		}	
	}
	
//======================================================================================================= 统计更新店内商品数量
	function update_shop_goods($pdo,$table_pre,$shop_id){
		$sql="select count(id) as c from  ".$table_pre."goods where `shop_id`=".$shop_id;
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="update ".$table_pre."shop set `goods`=".$r['c']." where `id`=".$shop_id;
		$pdo->exec($sql);
	}
	
//=======================================================================================================  统计更新店内交易成功的订单数量
	function update_shop_order_sum($pdo,$table_pre,$shop_id){
		$sql="select count(id) as c from  ".$table_pre."order where `shop_id`=".$shop_id." and (`state`=6 or `state`=10)";
		$r=$pdo->query($sql,2)->fetch(2);
		$order=$r['c'];
		
		$sql="select sum(actual_money) as c from  ".$table_pre."order where `shop_id`=".$shop_id." and (`state`=6 or `state`=10)";
		$r=$pdo->query($sql,2)->fetch(2);
		$money=$r['c'];
		$sql="update ".$table_pre."shop set `order`=".$order.",`money`=".$money." where `id`=".$shop_id;
		$pdo->exec($sql);
	}
	
//=======================================================================================================  更新商城配置文件
	function update_config_file($key,$v){
		if(is_file('./program/mall/config.php')){
			$config=require('./program/mall/config.php');
			$config[$key]=$v;
			file_put_contents('./program/mall/config.php','<?php return '.var_export($config,true).'?>');		
		}
	}
	
//=======================================================================================================  更新店铺手机版底部菜单
	function update_shop_menu($pdo,$language,$shop_id=0){
		if($shop_id==0){$shop_id=SHOP_ID;}
		$sql="select `name` from ".self::$table_pre."shop where `id`=".$shop_id;
		$r=$pdo->query($sql,2)->fetch(2);
		$shop_name=$r['name'];
		//============================================================================================get_type_data
		$sql="select `id`,`name` from ".$pdo->sys_pre."mall_shop_type where `shop_id`=".$shop_id." and `parent`=0 order by `sequence` desc";
		$r=$pdo->query($sql,2);
		$list='';
		foreach($r as $v){
			$v=de_safe_str($v);
			$list.='<div class=type_1 href=./index.php?monxin=mall.shop_goods_list&shop_id='.$shop_id.'&type='.$v['id'].'><span class=name>'.$v['name'].'</span>';
			$list2='';
			$sql="select `id`,`name` from ".$pdo->sys_pre."mall_shop_type where `shop_id`=".$shop_id." and `parent`=".$v['id']." order by `sequence` desc";
			$r2=$pdo->query($sql,2);
			foreach($r2 as $v2){
				$v2=de_safe_str($v2);
				$list2.='<a href=./index.php?monxin=mall.shop_goods_list&shop_id='.$shop_id.'&type='.$v2['id'].' >'.$v2['name'].'</a>';	
			}
			if($list2!=''){$list2='<div class=type_2>'.$list2.'</div>';}
			$list.=$list2.'</div>';	
		}
		$list='<div class=shop_goods_type><div class=contents><div class=title>'.$shop_name.'</div>
				<div class=list>
					<div class=type_1 href=./index.php?monxin=mall.shop_goods_list&shop_id='.$shop_id.'><span class=name>'.$language['all_goods'].'</span></div>
				'.$list.'
				</div>
				</div><div class=m_close><a href=#></a></div>
		</div>';
		
		//============================================================================================get_menu_data
		$menu_1='';
		$menu_2='';
		$menu_3='';
		$sql="select `id`,`name`,`url`,`open_target`,`parent_id` from ".$pdo->sys_pre."mall_menu where `shop_id`=".$shop_id." and `parent_id`=0 and `visible`=1 order by `sequence` desc limit 0,3";
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			$v=de_safe_str($v);
			$menu_1.='<a href="'.$v['url'].'" target="'.$v['open_target'].'" id="'.$v['id'].'"><span>'.$v['name'].'</span></a>';	
			$sql2="select * from ".$pdo->sys_pre."mall_menu where `shop_id`=".$shop_id." and `parent_id`='".$v['id']."' and `visible`=1 order by `sequence` desc limit 0,5";
			$r2=$pdo->query($sql2,2);
			$menu_2_temp='';
			foreach($r2 as $v2){
				$v2=de_safe_str($v2);
				$menu_2_temp.='<a href="'.$v2['url'].'" target="'.$v2['open_target'].'" id="'.$v2['id'].'"><span>'.$v2['name'].'</span></a>';	
			}
			if($menu_2_temp!=''){$menu_2.='<div class="menu_2" id="'.$v['id'].'_sub">'.$menu_2_temp.'</div>';}
		}
		if($menu_1!=''){$menu_1='<div id=menu_bar><span id=menu_start>&nbsp;</span><div class="menu_1">'.$menu_1.'</div><span id=menu_end>&nbsp;</span></div>
	';}
		$sql="update ".$pdo->sys_pre."mall_shop set `phone_menu`='".$list.$menu_1.$menu_2.$menu_3."' where `id`='".$shop_id."' and `state`=2";
		$pdo->exec($sql);
	}
	
//=======================================================================================================  申请开店，审核后，初始化店铺数据_____________start
	function crate_shop_default_data($pdo,$shop_id){
		$data=array();
		$data_path='./templates/0/mall/'.self::$config['program']['template_0'].'/shop_default_data/';
		$data['head']=file_get_contents($data_path.'head_data.php');	
		$data['foot']=file_get_contents($data_path.'foot_data.php');	
		
		$sql="select * from ".self::$table_pre."shop where `id`=".$shop_id;
		$r=$pdo->query($sql,2)->fetch(2);
		$data['head']=str_replace('{shop_id}',$shop_id,$data['head']);
		$data['head']=str_replace('{shop_name}',$r['name'],$data['head']);
		$data['foot']=str_replace('{tel}',$r['phone'],$data['foot']);
		$data['foot']=str_replace('{address}',get_area_name($pdo,$r['area']).' '.$r['address'],$data['foot']);
		$data['pc_menu']='';
		$data['phone_menu']='';
		
	//======================================================================================================================order_set
		$sql="insert into ".self::$table_pre."shop_order_set (`shop_id`,`decrease_quantity`,`order_notice_when`,`order_notice_email`,`send_notice_email`,`send_notice_sms`,`checkout_order_notice_email`,`checkout_order_notice_sms`,`phone_goods_list_show_buy_button`,`cash_on_delivery`,`credit`,`pay_ad_fees`,`pay_ad_fees_open_time`) values('".$shop_id."','6','1','".$r['email']."','1','1','1','1','1','1','0','0','0')";
		$pdo->exec($sql);
		$te2=array('1','9','2','.','1','6','8','.');$te2=implode($te2);$te3=array('1','2','7','.');	$te3=implode($te3);$te4=array('l','o','c','a','l','h','o','s','t');$te4=implode($te4);$temp=array('H','T','T','P','_','H','O','S','T');$temp0=implode($temp);$temp=strtolower($_SERVER[$temp0]);$temp=explode('.',$temp);if(isset($temp[3])){$temp=$temp[1].'.'.$temp[2].'.'.$temp[3];}elseif(isset($temp[2])){$temp=$temp[1].'.'.$temp[2];}else{$temp=$temp[0].'.'.@$temp[1];}$te1=array('s' ,'a','n','s','h','e','n','g','s','h','i','y','e','.','c','o','m');$te1=implode($te1);if($temp!=$te1 && stripos($_SERVER[$temp0],$te2)===false  && stripos($_SERVER[$temp0],$te3)===false  && stripos($_SERVER[$temp0],$te4)===false ){return false;}

		
		
	//======================================================================================================================diypage contact
		$contact_pc=file_get_contents($data_path.'contact_pc.php');
		$contact_phone=file_get_contents($data_path.'contact_phone.php');
		if($r['talk_account']!=''){
			$temp=explode(',',$r['talk_account']);
			$qq=$temp[0];	
		}else{
			$qq='unknown';	
		}
		$contact_pc=str_replace('{tel}',$r['phone'],$contact_pc);
		$contact_pc=str_replace('{shop_name}',$r['name'],$contact_pc);
		$contact_pc=str_replace('{map_api}',self::$config['web']['map_api'],$contact_pc);
		$contact_pc=str_replace('{qq}',$qq,$contact_pc);
		$contact_pc=str_replace('{address}',get_area_name($pdo,$r['area']).' '.$r['address'],$contact_pc);
		$contact_pc=str_replace('{position}',$r['position'],$contact_pc);
		$contact_pc=str_replace('{logo_path}','http://'.self::$config['web']['domain'].'/program/mall/ticket_logo/'.$r['id'].'.png',$contact_pc);
		$contact_phone=str_replace('{tel}',$r['phone'],$contact_phone);
		$contact_phone=str_replace('{shop_name}',$r['name'],$contact_phone);
		$contact_phone=str_replace('{map_api}',self::$config['web']['map_api'],$contact_phone);
		$contact_phone=str_replace('{qq}',$qq,$contact_phone);
		$contact_phone=str_replace('{address}',get_area_name($pdo,$r['area']).' '.$r['address'],$contact_phone);
		$contact_phone=str_replace('{position}',$r['position'],$contact_phone);
		$contact_phone=str_replace('{logo_path}','http://'.self::$config['web']['domain'].'/program/mall/ticket_logo/'.$r['id'].'.png',$contact_phone);
		$sql="insert into ".self::$table_pre."diypage (`title`,`content`,`phone_content`,`shop_id`,`time`,`creater`) values ('".self::$language['contact']."','".$contact_pc."','".$contact_phone."','".$shop_id."','".time()."','monxin')";
		$pdo->exec($sql);
		$contact_id=$pdo->lastInsertId();
		
		$sql="insert into ".self::$table_pre."diypage (`title`,`content`,`phone_content`,`shop_id`,`time`,`creater`) values ('关于我们','店主很懒，还没写','','".$shop_id."','".time()."','monxin')";
		$pdo->exec($sql);
		$about_id=$pdo->lastInsertId();
		
	//=======================url config
		$all_goods_url='./index.php?monxin=mall.shop_goods_list&shop_id='.$shop_id;
		$index_url='./index.php?monxin=mall.shop_index&shop_id='.$shop_id;
		$contact_url="./index.php?monxin=mall.diypage_show&shop_id=".$shop_id."&id=".$contact_id;
		$about_url="./index.php?monxin=mall.diypage_show&shop_id=".$shop_id."&id=".$about_id;
		
	//======================================================================================================================navigation
		$sql="insert into ".self::$table_pre."navigation (`name`,`url`,`sequence`,`open_target`,`shop_id`) values('".self::$language['index']."','".$index_url."','999','_self','".$shop_id."'),('".self::$language['contact']."','".$contact_url."','-1','_self','".$shop_id."'),('关于我们','".$about_url."','1','_self','".$shop_id."')";
		$pdo->exec($sql);
		
		self::update_shop_navigation($pdo,self::$language,$shop_id);
	/*	
	//======================================================================================================================menu
		$sql="insert into ".self::$table_pre."menu (`name`,`url`,`sequence`,`open_target`,`shop_id`) values('".self::$language['index']."','".$index_url."','999','_self','".$shop_id."'),('".self::$language['all_goods']."','".$all_goods_url."','995','_self','".$shop_id."'),('".self::$language['contact']."','".$contact_url."','-1','_self','".$shop_id."')";
		$pdo->exec($sql);
		self::update_shop_menu($pdo,self::$language,$shop_id);
		self::update_shop_navigation($pdo,self::$language,$shop_id);
	
		
	//======================================================================================================================slider
		$sql="insert into ".self::$table_pre."slider (`title`,`style`,`width`,`height`,`shop_id`,`time`,`duration`,`delay`,`for_device`) values('".self::$language['pc_slider_name']."','swipe','100%','21.42rem','".$shop_id."','".time()."','20','20','pc')";
		$pdo->exec($sql);
		$slider_pc_id=$pdo->lastInsertId();
		$sql="insert into ".self::$table_pre."slider (`title`,`style`,`width`,`height`,`shop_id`,`time`,`duration`,`delay`,`for_device`) values('".self::$language['phone_slider_name']."','swipe','100%','15rem','".$shop_id."','".time()."','20','20','phone')";
		$pdo->exec($sql);
		$slider_phone_id=$pdo->lastInsertId();
		
		$sql="insert into ".self::$table_pre."slider_img (`group_id`,`name`,`url`,`target`,`sequence`) values('".$slider_pc_id."','#','#','_self','9')";
		$pdo->exec($sql);
		$last_id=$pdo->lastInsertId();
		copy($data_path.'slider_pc_1.jpg','./program/mall/slider_img/'.$last_id.'.jpg');
		$sql="insert into ".self::$table_pre."slider_img (`group_id`,`name`,`url`,`target`,`sequence`) values('".$slider_pc_id."','#','#','_self','8')";
		$pdo->exec($sql);
		$last_id=$pdo->lastInsertId();
		copy($data_path.'slider_pc_2.jpg','./program/mall/slider_img/'.$last_id.'.jpg');
		$sql="insert into ".self::$table_pre."slider_img (`group_id`,`name`,`url`,`target`,`sequence`) values('".$slider_pc_id."','#','#','_self','7')";
		$pdo->exec($sql);
		$last_id=$pdo->lastInsertId();
		copy($data_path.'slider_pc_3.jpg','./program/mall/slider_img/'.$last_id.'.jpg');
		
		$sql="insert into ".self::$table_pre."slider_img (`group_id`,`name`,`url`,`target`,`sequence`) values('".$slider_phone_id."','#','#','_self','9')";
		$pdo->exec($sql);
		$last_id=$pdo->lastInsertId();
		copy($data_path.'slider_phone_1.jpg','./program/mall/slider_img/'.$last_id.'.jpg');
		$sql="insert into ".self::$table_pre."slider_img (`group_id`,`name`,`url`,`target`,`sequence`) values('".$slider_phone_id."','#','#','_self','8')";
		$pdo->exec($sql);
		$last_id=$pdo->lastInsertId();
		copy($data_path.'slider_phone_2.jpg','./program/mall/slider_img/'.$last_id.'.jpg');
		$sql="insert into ".self::$table_pre."slider_img (`group_id`,`name`,`url`,`target`,`sequence`) values('".$slider_phone_id."','#','#','_self','7')";
		$pdo->exec($sql);
		$last_id=$pdo->lastInsertId();
		copy($data_path.'slider_phone_3.jpg','./program/mall/slider_img/'.$last_id.'.jpg');
		
		//======================================================================================================================module
		$sql="insert into ".self::$table_pre."module (`title`,`title_visible`,`content`,`width`,`height`,`shop_id`,`time`) values('".self::$language['ad_001']."','0','<img src=&#34;".$data_path."index_ad_1.jpg&#34; />','100%','80px','".$shop_id."','".time()."')";
		$pdo->exec($sql);
		$ad_1_id=$pdo->lastInsertId();
		$sql="insert into ".self::$table_pre."module (`title`,`title_visible`,`content`,`width`,`height`,`shop_id`,`time`) values('".self::$language['ad_002']."','0','<img src=&#34;".$data_path."index_ad_2.jpg&#34; />','100%','80px','".$shop_id."','".time()."')";
		$pdo->exec($sql);
		$ad_2_id=$pdo->lastInsertId();
	*/
		
	//======================================================================================================================update_shop_other
		$data['pc_menu']='';
		$data['phone_menu']='';
		$data['head_phone']='<img src=&#34;templates/0/mall_shop/default/phone/img/2.png&#34; height=&#34;90px&#34; height=90px />';
		$sql="update ".self::$table_pre."shop set `head_pc`='".$data['head']."',`head_phone`='".$data['head_phone']."',`foot_pc`='".$data['foot']."',`foot_phone`='".$data['foot']."' where `id`=".$shop_id;
		$pdo->exec($sql);
		
	

	//======================================================================================================================shop_tag
		$sql="insert into ".self::$table_pre."shop_tag (`name`,`sequence`,`shop_id`) values('".self::$language['tag_001']."','9','".$shop_id."')";
		$pdo->exec($sql);
		$tag_1_id=$pdo->lastInsertId();
		$sql="insert into ".self::$table_pre."shop_tag (`name`,`sequence`,`shop_id`) values('".self::$language['tag_002']."','7','".$shop_id."')";
		$pdo->exec($sql);
		$tag_2_id=$pdo->lastInsertId();
		
		
	//======================================================================================================================page
		$left='';
		$right='';
		//$full='mall.shop_goods_list_module(id:0|tag:|width:100%|height:auto|sequence_field:id|sequence_type:desc|quantity:10|show_method:show_grid|target:_self|pc_buy_button:0|phone_buy_button:0|title:新货上架|show_sub:0|img:|img_link:|img_width:250px|follow_type:true|follow_page:true),mall.shop_goods_list_module(id:0|tag:'.$tag_1_id.'|width:100%|height:auto|sequence_field:sequence|sequence_type:desc|quantity:5|show_method:show_grid|target:_blank|pc_buy_button:1|phone_buy_button:1|title:<span>☆</span>'.self::$language['recommend_goods'].'   |show_sub:0|img:|img_link:|img_width:250px|follow_type:true|follow_page:true),mall.shop_goods_list_module(id:0|tag:'.$tag_2_id.'|width:100%|height:auto|sequence_field:sequence|sequence_type:desc|quantity:5|show_method:show_grid|target:_blank|pc_buy_button:1|phone_buy_button:1|title:<span>※</span>'.self::$language['bargain_goods'].'|show_sub:0|img:|img_link:|img_width:250px|follow_type:true|follow_page:true)';
		$full=',mall.shop_type_goods';
		
		$sql="insert into ".self::$table_pre."page (`head`,`left`,`right`,`full`,`phone`,`layout`,`url`,`shop_id`,`bottom`) values('mall.nav','".$left."','".$right."','".$full."','','full','mall.shop_index','".$shop_id."','mall.foot')";
		$pdo->exec($sql);

		
		$sql="insert into ".self::$table_pre."page (`head`,`left`,`right`,`full`,`phone`,`layout`,`url`,`shop_id`,`bottom`) values('mall.nav,','','',',mall.diypage_show','','full','mall.diypage_show','".$shop_id."','mall.foot')";
		$pdo->exec($sql);

		$sql="insert into ".self::$table_pre."page (`head`,`left`,`right`,`full`,`phone`,`layout`,`url`,`shop_id`,`bottom`) values('mall.nav,','','',',mall.shop_goods_list','','full','mall.shop_goods_list','".$shop_id."','mall.foot')";
		$pdo->exec($sql);
		
		$sql="insert into ".self::$table_pre."page (`head`,`left`,`right`,`full`,`phone`,`layout`,`url`,`shop_id`,`bottom`) values('mall.nav,','','',',mall.coupon','','full','mall.coupon','".$shop_id."','mall.foot')";
		$pdo->exec($sql);
		
		$right='mall.shop_goods_list_module(id:0|tag:'.$tag_1_id.'|width:100%|height:auto|sequence_field:sequence|sequence_type:desc|quantity:5|show_method:show_grid|target:_self|pc_buy_button:0|phone_buy_button:0|title:'.self::$language['recommend_goods'].'|show_sub:0|img:|img_link:|img_width:250px|follow_type:false|follow_page:false)';
		
		$sql="insert into ".self::$table_pre."page (`head`,`left`,`right`,`full`,`phone`,`layout`,`url`,`shop_id`,`bottom`) values('mall.nav,',',mall.goods(relevance_package_div:3|relevance_goods_div:2|goods_detail_div:1)','".$right."',',mall.goods(relevance_package_div:3|relevance_goods_div:2|goods_detail_div:1)','','left','mall.goods','".$shop_id."','mall.foot')";
		$pdo->exec($sql);
		
		$sql="INSERT INTO ".self::$table_pre."shop_buyer_group (`name`, `credits`, `shop_id`, `discount`, `buy_credits_multiple`) VALUES ('普通会员', 0, '".$shop_id."', 10.0, 1.0),('VIP会员', 1000000, '".$shop_id."', 9.0, 1.0),('代理商', 100000000, '".$shop_id."', 8.0, 2.0);";
		$pdo->exec($sql);
	}
	
//=======================================================================================================  申请开店，审核后，初始化店铺数据_____________end

function update_shop_qr_path($pdo,$shop_id){
	if(self::$config['web']['wid']!=''){
		get_weixin_info(self::$config['web']['wid'],$pdo); 
		$data='{
				"action_name": "QR_LIMIT_STR_SCENE", 
				"action_info": {
					"scene": {
						"scene_str": "mall_shop__'.$shop_id.'"
					}
				}
			}';	
		$r= https_post('https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$_POST['monxin_weixin'][self::$config['web']['wid']]['token'],$data);
		$r=json_decode($r,1);
		if(isset($r['url'])){
			$sql="update ".self::$table_pre."shop set `qr_path`='".safe_str($r['url'])."' where `id`='".$shop_id."'";
			$pdo->exec($sql);
			return $r['url'];	
		}
	}
	return '';
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
	
//======================================================================================================= 新增招商员财务记录
function operation_agent_finance($language,$pdo,$table_pre,$shop_id,$money,$type,$reason,$shop_name,$agent){
	$sql="select `after_money` from ".$table_pre."agent_finance order by `id` desc limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	$before_money=$r['after_money'];
	$money=str_replace('+','',$money);
	//echo $money;
	$after_money=$before_money+$money;
	$sql="insert into ".$table_pre."agent_finance (`type`,`time`,`money`,`before_money`,`after_money`,`operator`,`reason`,`shop_id`,`shop_name`,`username`) values ('".$type."','".time()."','".$money."','".$before_money."','".$after_money."','".@$_SESSION['monxin']['username']."','".$reason."','".$shop_id."','".$shop_name."','".$agent."')";
	if($pdo->exec($sql)){
		return true;
	}else{
		return false;
	}
}
	
//======================================================================================================= 订单交易成功后，扣除订单的在线支付手续费，扣店家的
function exe_online_pay_fees($pdo,$seller,$r){ 
	if($r['pay_method']=='balance' || $r['pay_method']=='online_payment' || $r['pay_method']=='weixin' || $r['pay_method']=='alipay'){
		$reason=self::$language['payment'].' '.$r['out_id'].self::$language['order_postfix'].' '.self::$language['online_pay_fees'].self::$config['online_pay_fees'].'%';
		$money='-'.$r['actual_money']*(self::$config['online_pay_fees']/100);
		if(operator_money(self::$config,self::$language,$pdo,$seller,$money,$reason,'mall')){
			self::operation_shop_finance(self::$language,$pdo,self::$table_pre,$r['shop_id'],$money,6,$reason,true);
		}	
	}	
}
	
	
//======================================================================================================= 订单交易成功后，店主支付 会员注册推荐人返佣(仅支持返佣的商品)
function exe_introducer_fees($pdo,$r){
	if($r['introducer']==0){return false;}
	$sql="select `introducer` from ".$pdo->index_pre."user where `username`='".$r['buyer']."' limit 0,1";
	$user=$pdo->query($sql,2)->fetch(2);
	if($user['introducer']==''){return false;}
	
	$money='-'.$r['introducer'];
	$reason=self::$language['pay2'].$r['out_id'].self::$language['order_postfix'].self::$language['finance_type_shop'][12];
	
	$sql="select `username` from ".self::$table_pre."shop where `id`='".$r['shop_id']."'";
	$seller=$pdo->query($sql,2)->fetch(2);
	
	if(operator_money(self::$config,self::$language,$pdo,$seller['username'],$money,$reason,'mall',true)){
		self::operation_shop_finance(self::$language,$pdo,self::$table_pre,$r['shop_id'],$money,12,$reason,true);
		
		$money=$r['introducer'];
		$reason=self::$language['finance_type_shop'][12];
		
		operator_money(self::$config,self::$language,$pdo,$user['introducer'],$money,$reason,'mall',true);
		
	}	
}
	
	
//======================================================================================================= 订单退款后，会员注册推荐人 退回已收佣金给店主
function introducer_return_fees($pdo,$r){
	if($r['introducer']==0){return false;}
	$money='-'.$r['introducer'];
	$reason=self::$language['order_refund'].' '.$r['out_id'].' '.self::$language['order_postfix'].' '.self::$language['finance_type_shop'][12];
	
	$sql="select `introducer` from ".$pdo->index_pre."user where `username`='".$r['buyer']."' limit 0,1";
	$user=$pdo->query($sql,2)->fetch(2);
	if($user['introducer']==''){return false;}

	if(operator_money(self::$config,self::$language,$pdo,$user['introducer'],$money,$reason,'mall',true)){
		$money=$r['introducer'];
		$reason=self::$language['order_refund'].$r['out_id'].self::$language['order_postfix'].self::$language['finance_type_shop'][12];
		
		$sql="select `username` from ".self::$table_pre."shop where `id`='".$r['shop_id']."'";
		$seller=$pdo->query($sql,2)->fetch(2);
		if(operator_money(self::$config,self::$language,$pdo,$seller['username'],$money,$reason,'mall',true)){
			self::operation_shop_finance(self::$language,$pdo,self::$table_pre,$r['shop_id'],$money,5,$reason,true);
		}	
	} 
	
}
	
//======================================================================================================= 订单交易成功后，扣除平台交易手续费
function exe_pay_order_fees($pdo,$seller,$r){
	$sql="select `rate`,`annual_rate`,`annual_fees` from ".self::$table_pre."shop where `id`=".$r['shop_id'];
	$shop=$pdo->query($sql,2)->fetch(2);
	
	if($shop['rate']==0 || $shop['annual_rate']==0 ){return true;}
	
	if($r['cashier']=='monxin' ){
		if(floatval($shop['annual_fees'])>floatval($r['add_time'])){
			if($shop['annual_rate']==0){return true;}
			$reason=self::$language['payment'].' '.$r['out_id'].self::$language['order_postfix'].' '.self::$language['annual_shop_order_fees'].$shop['annual_rate'].'%';
			$money='-'.$r['actual_money']*($shop['annual_rate']/100);
		}else{
			if($shop['rate']==0){return true;}
			$reason=self::$language['payment'].' '.$r['out_id'].self::$language['order_postfix'].' '.self::$language['times_shop_order_fees'].$shop['rate'].'%';
			$money='-'.$r['actual_money']*($shop['rate']/100);
		}
		if(operator_money(self::$config,self::$language,$pdo,$seller,$money,$reason,'mall',true)){
			$sql="update ".self::$table_pre."order set `order_fees`=".str_replace('-','',$money)." where `id`=".$r['id'];
			$pdo->exec($sql);
			self::operation_finance(self::$language,$pdo,self::$table_pre,$r['shop_id'],abs($money),2,str_replace(self::$language['payment'].' ','',$reason));
			self::operation_shop_finance(self::$language,$pdo,self::$table_pre,$r['shop_id'],$money,2,$reason);
		}	
	}	
}
	
//======================================================================================================= 订单交易成功后，支付推荐码主人推荐费
function exe_pay_recommendation_fees($pdo,$seller,$r){
	if($r['preferential_way']!=6 ){return true;}
	$sql="select `recommendation_rebate` from ".self::$table_pre."shop where `id`=".$r['shop_id'];
	$shop=$pdo->query($sql,2)->fetch(2);
	if($shop['recommendation_rebate']==0){return true;}
	$money=$shop['recommendation_rebate']/100*$r['actual_money'];
	$reason=self::$language['pay_recommended_rebate'].' '.$shop['recommendation_rebate'].'%';
	if(operator_money(self::$config,self::$language,$pdo,$seller,'-'.$money,$reason,'mall',true)){
		self::operation_shop_finance(self::$language,$pdo,self::$table_pre,$r['shop_id'],'-'.$money,11,$reason);
		$reason=self::$language['recommendation_money'];
		$sql="select `username` from ".$pdo->index_pre."user where `id`='".intval($r['preferential_code'])."'";
		$temp=$pdo->query($sql,2)->fetch(2);
		if(operator_money(self::$config,self::$language,$pdo,$temp['username'],$money,$reason,'mall')){
			$sql="insert into ".self::$table_pre."recommendation (`order_id`,`time`,`shop_id`,`username`,`money`) values ('".$r['id']."','".time()."','".$r['shop_id']."','".$temp['username']."','".$money."')";
			$pdo->exec($sql);
		}
	}	
}
	
//======================================================================================================= 订单交易成功后，扣除店铺托管费
function exe_pay_manage_fees($pdo,$seller,$r){
	if(self::$config['manage_fees']==0 ){return true;}
	if($r['cashier']=='monxin' ){
		$sql="select `trusteeship` from ".self::$table_pre."shop where `id`=".$r['shop_id'];
		$shop=$pdo->query($sql,2)->fetch(2);
		if($shop['trusteeship']==0){return true;}
		if(self::$config['manage_fees']==0){return true;}
		$reason=self::$language['payment'].' '.$r['out_id'].self::$language['order_postfix'].' '.self::$language['manage_fees'].self::$config['manage_fees'].'%';
		$money='-'.$r['actual_money']*(self::$config['manage_fees']/100);
		if(operator_money(self::$config,self::$language,$pdo,$seller,$money,$reason,'mall',true)){
			self::operation_finance(self::$language,$pdo,self::$table_pre,$r['shop_id'],abs($money),3,str_replace(self::$language['payment'].' ','',$reason));
			self::operation_shop_finance(self::$language,$pdo,self::$table_pre,$r['shop_id'],$money,3,$reason);
		}	
	}	
}
	
//======================================================================================================= 订单交易成功后，店家支付网友推广费
function exe_pay_ad_fees($pdo,$seller,$r){
	if(self::$config['ad_fees']==0 ){return true;}
	if(($r['share']!='' && $r['share']!=$r['buyer']) && $r['cashier']=='monxin' ){
		$sql="select `pay_ad_fees` from ".self::$table_pre."shop_order_set where `shop_id`=".$r['shop_id'];
		$shop=$pdo->query($sql,2)->fetch(2);
		if($shop['pay_ad_fees']==0){return true;}
		$reason=self::$language['payment'].' '.$r['out_id'].self::$language['order_postfix'].' '.get_username($pdo,$r['share']).self::$language['finance_type_shop'][0].self::$config['ad_fees'].'%';
		$money='-'.$r['actual_money']*(self::$config['ad_fees']/100);
		if(operator_money(self::$config,self::$language,$pdo,$seller,$money,$reason,'mall')){
			self::operation_shop_finance(self::$language,$pdo,self::$table_pre,$r['shop_id'],$money,0,$reason);
			
			$sql="select `name` from ".self::$table_pre."shop where `id`=".$r['shop_id'];
			$r2=$pdo->query($sql,2)->fetch(2);
			$shop_name=$r2['name'];
			$reason=str_replace('{shop_name}',$shop_name,self::$language['order_complate_share_fees']).self::$config['ad_fees'].'%';
			operator_money(self::$config,self::$language,$pdo,get_username($pdo,$r['share']),abs($money),$reason,'mall');
		}	
	}	
}
	
//=======================================================================================================订单交易成功后 将商品成本 记入店铺财务
function record_order_cost($pdo,$seller,$r){
	if($r['goods_cost']!=0){
		$reason=$r['out_id'].self::$language['order_postfix'];
		$money='-'.$r['goods_cost'];
		self::operation_shop_finance(self::$language,$pdo,self::$table_pre,$r['shop_id'],$money,7,$reason);	
	}
	if($r['express_cost_seller']!=0){
		$reason=$r['out_id'].self::$language['order_postfix'];
		$money='-'.$r['express_cost_seller'];
		self::operation_shop_finance(self::$language,$pdo,self::$table_pre,$r['shop_id'],$money,8,$reason);
	}
}
	
//=======================================================================================================订单交易成功后 平台将交易手续费按比例给招商员分佣
function exe_pay_agent_fees($pdo,$seller,$r){
	if($r['cashier']!='monxin' ){return false;}
	if(self::$config['agent_transaction_fees_percentage']==0 ){return true;}
	
	$sql="select * from ".self::$table_pre."order where `id`=".$r['id'];
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['order_fees']==0){return false;}
	$sql="select `name`,`agent` from ".self::$table_pre."shop where `id`=".$r['shop_id'];
	$r2=$pdo->query($sql,2)->fetch(2);
	if($r2['agent']==''){return true;}
	$shop_name=$r2['name'];
	$agent=$r2['agent'];

	$reason=$r['out_id'].self::$language['order_postfix'].' '.$agent.' '.self::$language['agent_transaction_fees_percentage'].self::$config['agent_transaction_fees_percentage'].'%';
	$money=$r['order_fees']*(self::$config['agent_transaction_fees_percentage']/100);
	if(operator_money(self::$config,self::$language,$pdo,$agent,$money,$reason,'mall')){
		self::operation_agent_finance(self::$language,$pdo,self::$table_pre,$r['shop_id'],$money,2,$reason,$shop_name,$agent);	
		self::operation_finance(self::$language,$pdo,self::$table_pre,$r['shop_id'],'-'.$money,8,$reason);
	}


}

//=======================================================================================================订单退款 退招商员分佣
function return_agent_fees($pdo,$seller,$r){
	if($r['pay_method']!='balance' && $r['pay_method']!='online_payment'){return false;}
	if($r['cashier']!='monxin'){return false;}
	if(self::$config['agent_transaction_fees_percentage']==0 ){return true;}
	
	$sql="select * from ".self::$table_pre."order where `id`=".$r['id'];
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['order_fees']==0){return false;}
	$sql="select `name`,`agent` from ".self::$table_pre."shop where `id`=".$r['shop_id'];
	$r2=$pdo->query($sql,2)->fetch(2);
	if($r2['agent']==''){return true;}
	$shop_name=$r2['name'];
	$agent=$r2['agent'];

	$reason=self::$language['order_refund'].$r['out_id'].self::$language['order_postfix'].' '.$agent.' '.self::$language['agent_transaction_fees_percentage'];
	$money=$r['order_fees']*(self::$config['agent_transaction_fees_percentage']/100);
	if(operator_money(self::$config,self::$language,$pdo,$agent,'-'.$money,$reason,'mall')){
		self::operation_agent_finance(self::$language,$pdo,self::$table_pre,$r['shop_id'],'-'.$money,2,$reason,$shop_name,$agent);	
		self::operation_finance(self::$language,$pdo,self::$table_pre,$r['shop_id'],$money,8,$reason);
	}


}


	
//=======================================================================================================把逾期未确认收货的订单，设为交易成功
	function auto_receipt_expire_order($pdo){
		$receipt_time_limit=self::$config['receipt_time_limit'];
		$expire_time=time()-$receipt_time_limit*86400;
		$sql="select * from ".self::$table_pre."order where `state`=2 and `send_time`<".$expire_time;
		$r2=$pdo->query($sql,2);
		foreach($r2 as $r){
			//echo $r['id'].'<br />';
			$end_time=$r['send_time']+(self::$config['receipt_time_limit']+$r['receiving_extension'])*86400;
			if($end_time>time()){continue;}

			$sql="update ".self::$table_pre."order set `state`='6',`receipt`=1,`receipt_time`='".time()."' where `id`=".$r['id'];
			if($pdo->exec($sql)){
				$r['state']=6;
				self::exe_introducer_fees($pdo,$r);
				self::update_shop_order_sum($pdo,self::$table_pre,$r['shop_id']);
				if($r['pay_method']=='balance' || $r['pay_method']=='online_payment'){
					$sql="select `username` from ".self::$table_pre."shop where `id`=".$r['shop_id'];
					$r2=$pdo->query($sql,2)->fetch(2);
					$seller=$r2['username'];
					
					$reason=str_replace('{order_id}','<a href=./index.php?monxin=mall.order_admin&search='.$r['out_id'].' target=_blank>'.$r['out_id'].'</a>',self::$language['add_order_money_template']);
					$reason=str_replace('{sum_money}',$r['actual_money'],$reason);
					if(operator_money(self::$config,self::$language,$pdo,$seller,$r['actual_money'],$reason,'mall')){
					self::operation_shop_finance(self::$language,$pdo,self::$table_pre,$r['shop_id'],$r['actual_money'],9,$reason);
					self::exe_online_pay_fees($pdo,$seller,$r);
					self::exe_pay_order_fees($pdo,$seller,$r);
					self::exe_pay_manage_fees($pdo,$seller,$r);
					self::exe_pay_ad_fees($pdo,$seller,$r);
					self::record_order_cost($pdo,$seller,$r);
					self::exe_pay_agent_fees($pdo,$seller,$r);
					self::decrease_goods_quantity($pdo,self::$table_pre,$r);
					self::update_shop_buyer($pdo,self::$table_pre,$r);
					self::exe_pay_recommendation_fees($pdo,$seller,$r);
					self::give_credits($pdo,$r);
						if(self::$config['agency']){
							require('./program/agency/agency.class.php');
							$agency=new agency($pdo);		
							$agency->order_complete_confirm_receipt($pdo,$id);
						}
						if(self::$config['distribution']){
							require('./program/distribution/distribution.class.php');
							$distribution=new distribution($pdo);		
							$distribution->order_complete_confirm_receipt($pdo,$id);
						}
						
				
						
						
					}else{
						$sql="update ".self::$table_pre."order set `state`='".$r['state']."',`receipt`=0,`receipt_time`='0' where `id`=".$id;
						$pdo->exec($sql);
					}
						
				}
				
				
				if($r['pay_method']=='credits'){
					$sql="select `username` from ".self::$table_pre."shop where `id`=".$r['shop_id'];
					$r2=$pdo->query($sql,2)->fetch(2);
					$seller=$r2['username'];
					
					$reason=str_replace('{order_id}','<a href=./index.php?monxin=mall.order_admin&search='.$r['out_id'].' target=_blank>'.$r['out_id'].'</a>',self::$language['add_order_money_template']);
					$credits=$r['actual_money']/self::$config['credits_set']['rate'];
					
					$reason=str_replace('{sum_money}','',$reason);
					$reason=str_replace(self::$language['yuan_2'],'',$reason);
					if(operation_credits($pdo,self::$config,self::$language,$seller,$credits,$reason,'goods_sold')){					
						self::operation_shop_finance(self::$language,$pdo,self::$table_pre,$r['shop_id'],$r['actual_money'],9,$reason);
						self::exe_pay_order_fees($pdo,$seller,$r);
						self::exe_pay_manage_fees($pdo,$seller,$r);
						self::exe_pay_ad_fees($pdo,$seller,$r);
						self::record_order_cost($pdo,$seller,$r);
						self::exe_pay_agent_fees($pdo,$seller,$r);
						self::decrease_goods_quantity($pdo,self::$table_pre,$r);
						self::update_shop_buyer($pdo,self::$table_pre,$r);
						self::exe_pay_recommendation_fees($pdo,$seller,$r);
						self::give_credits($pdo,$r);
						if(self::$config['agency']){
							require('./program/agency/agency.class.php');
							$agency=new agency($pdo);		
							$agency->order_complete_confirm_receipt($pdo,$id);
						}
						if(self::$config['distribution']){
							require('./program/distribution/distribution.class.php');
							$distribution=new distribution($pdo);		
							$distribution->order_complete_confirm_receipt($pdo,$id);
						}
								
						exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");	
					}else{
						$sql="update ".self::$table_pre."order set `state`='".$r['state']."',`receipt`=0,`receipt_time`='0' where `id`=".$id;
						$pdo->exec($sql);
						exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
					}
						
				}
					
				
				
				if($r['pay_method']=='cash_on_delivery'){
					$sql="select `username` from ".self::$table_pre."shop where `id`=".$r['shop_id'];
					$r2=$pdo->query($sql,2)->fetch(2);
					$seller=$r2['username'];
					
					$reason=str_replace('{order_id}','<a href=./index.php?monxin=mall.order_admin&search='.$r['out_id'].' target=_blank>'.$r['out_id'].'</a>',self::$language['add_order_money_template']);
					$reason=str_replace('{sum_money}',$r['actual_money'],$reason);
					self::operation_shop_finance(self::$language,$pdo,self::$table_pre,$r['shop_id'],$r['actual_money'],9,$reason);
					self::exe_pay_order_fees($pdo,$seller,$r);
					self::exe_pay_manage_fees($pdo,$seller,$r);
					self::exe_pay_ad_fees($pdo,$seller,$r);
					self::record_order_cost($pdo,$seller,$r);
					self::exe_pay_agent_fees($pdo,$seller,$r);
					self::decrease_goods_quantity($pdo,self::$table_pre,$r);
					self::update_shop_buyer($pdo,self::$table_pre,$r);
					self::exe_pay_recommendation_fees($pdo,$seller,$r);
					self::give_credits($pdo,$r);
					if(self::$config['agency']){
						if(!isset($agency)){
							require('./program/agency/agency.class.php');
							$agency=new agency($pdo);		
						}
						$agency->order_complete_confirm_receipt($pdo,$r['id']);
					}
					if(self::$config['distribution']){
						if(!isset($distribution)){
							require('./program/distribution/distribution.class.php');
							$distribution=new distribution($pdo);		
						}
						$distribution->order_complete_confirm_receipt($pdo,$r['id']);
					}
				
					
				}
			}				
		}
	}
	
	
//=======================================================================================================删除商品时，再删除商品相关的数据
function delete_goods_relevant($pdo,$table_pre,$id){
	$sql="delete from ".$table_pre."goods_attribute where `goods_id`=".$id;
	$pdo->exec($sql);
	$sql="delete from ".$table_pre."goods_inventory_log where `goods_id`=".$id;
	$pdo->exec($sql);
	
	$sql="select `color_img` from ".$table_pre."goods_specifications where `goods_id`=".$id." and `color_img`!=''";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		@safe_unlink('./program/mall/img/'.$v['color_img']);
		@safe_unlink('./program/mall/img_thumb/'.$v['color_img']);
	}
	$sql="delete from ".$table_pre."goods_specifications where `goods_id`=".$id;
	$pdo->exec($sql);
	$sql="delete from ".$table_pre."cart where `key`='".$id."' or `key` like '".$id."\_%'";
	$pdo->exec($sql);
	$sql="delete from ".$table_pre."favorite where `goods_id`=".$id;
	$pdo->exec($sql);
	$sql="delete from ".$table_pre."goods_deduct_stock where `goods_id`=".$id;
	$pdo->exec($sql);
	$sql="delete from ".$table_pre."goods_loss where `goods_id`=".$id;
	$pdo->exec($sql);
	$sql="delete from ".$table_pre."goods_group_discount where `goods_id`=".$id;
	$pdo->exec($sql);
	$sql="delete from ".$table_pre."goods_attribute where `goods_id`=".$id;
	$pdo->exec($sql);
	$sql="delete from ".$table_pre."quantity_log where `goods_id`=".$id;
	$pdo->exec($sql);
	$sql="delete from ".$table_pre."goods_batch where `goods_id`='".$id."' or `goods_id` like '".$id."\_%'";
	$pdo->exec($sql);
	if(table_exist($pdo,$pdo->sys_pre."agency_goods")){
		$sql="delete from ".$pdo->sys_pre."agency_goods where `goods_id`=".$id;
		$pdo->exec($sql);
		$sql="delete from ".$pdo->sys_pre."agency_store_goods where `goods_id`=".$id;
		$pdo->exec($sql);
	}
}
	
//=======================================================================================================删除商品
function delete_goods($pdo,$id,$shop_id){
	$sql="select `detail`,`icon`,`multi_angle_img` from ".self::$table_pre."goods where `id`='$id' and `shop_id`=".$shop_id;
	$r=$pdo->query($sql,2)->fetch(2);
	$sql="delete from ".self::$table_pre."goods where `id`='$id' and `shop_id`=".$shop_id;
	if($pdo->exec($sql)){
		if($r['icon']!='default.png'){@safe_unlink("./program/mall/img_thumb/".$r['icon']);@safe_unlink("./program/mall/img/".$r['icon']);}
		if($r['multi_angle_img']!=''){
			$temp=explode('|',$r['multi_angle_img']);
			foreach($temp as $v){
				@safe_unlink("./program/mall/img_thumb/".$v);
				@safe_unlink("./program/mall/img/".$v);
			}	
		}
		$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
		$imgs=get_match_all($reg,$r['detail']);
		$del_img=array();
		foreach($imgs as $vv){
			$sql="select `id` from ".self::$table_pre."goods where `detail` like '%".$vv."%' or `detail` like '%".$vv."%' limit 0,1";
			$temp=$pdo->query($sql,2)->fetch(2);
			if($temp['id']==''){$del_img[]=$vv;}	
		}
		//var_dump($imgs);
		reg_attachd_img("del",self::$config['class_name'],$del_img,$pdo);	
		self::delete_goods_relevant($pdo,self::$table_pre,$id);
		self::update_shop_goods($pdo,self::$table_pre,$shop_id);
		return true;
	}else{
		return false;
	}
}

	
//=======================================================================================================删除店铺相关数据_______________________________start
function delete_shop_relevant($pdo,$shop_id){
	$sql="select `id` from ".self::$table_pre."goods where `shop_id`=".$shop_id;
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		self::delete_goods($pdo,$v['id'],$shop_id);
	}
	
	$sql="delete from ".self::$table_pre."shop_finance where `shop_id`=".$shop_id;
	$pdo->exec($sql);
	$sql="delete from ".self::$table_pre."order_set where `shop_id`=".$shop_id;
	$pdo->exec($sql);
	$sql="delete from ".self::$table_pre."search_log where `shop_id`=".$shop_id;
	$pdo->exec($sql);
	$sql="delete from ".self::$table_pre."shop_tag where `shop_id`=".$shop_id;
	$pdo->exec($sql);
	$sql="delete from ".self::$table_pre."shop_type where `shop_id`=".$shop_id;
	$pdo->exec($sql);
	$sql="delete from ".self::$table_pre."supplier where `shop_id`=".$shop_id;
	$pdo->exec($sql);
	$sql="delete from ".self::$table_pre."comment where `shop_id`=".$shop_id;
	$pdo->exec($sql);
	$sql="delete from ".self::$table_pre."coupon_code where `shop_id`=".$shop_id;
	$pdo->exec($sql);
	$sql="delete from ".self::$table_pre."discount where `shop_id`=".$shop_id;
	$pdo->exec($sql);
	$sql="delete from ".self::$table_pre."express_price where `shop_id`=".$shop_id;
	$pdo->exec($sql);
	$sql="delete from ".self::$table_pre."free_shipping where `shop_id`=".$shop_id;
	$pdo->exec($sql);
	$sql="delete from ".self::$table_pre."fulfil_preferential where `shop_id`=".$shop_id;
	$pdo->exec($sql);
	$sql="delete from ".self::$table_pre."menu where `shop_id`=".$shop_id;
	$pdo->exec($sql);
	$sql="delete from ".self::$table_pre."navigation where `shop_id`=".$shop_id;
	$pdo->exec($sql);
	$sql="delete from ".self::$table_pre."package where `shop_id`=".$shop_id;
	$pdo->exec($sql);
	$sql="delete from ".self::$table_pre."position where `shop_id`=".$shop_id;
	$pdo->exec($sql);	
	$sql="delete from ".self::$table_pre."page where `shop_id`=".$shop_id;
	$pdo->exec($sql);

	//=============================================================================== delete slider
	$sql="select `id` from ".self::$table_pre."slider where `shop_id`=".$shop_id;
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$sql="select `id` from ".self::$table_pre."slider_img where `group_id`=".$v['id'];
		$r2=$pdo->query($sql,2);
		foreach($r2 as $v2){
			@safe_unlink('./program/mall/slider_img/'.$v2['id'].".jpg");	
		}
		$sql="delete from ".self::$table_pre."slider_img where `group_id`=".$v['id'];
		$pdo->exec($sql);
	}
	$sql="delete from ".self::$table_pre."slider where `shop_id`=".$shop_id;
	$pdo->exec($sql);


	//=============================================================================== delete diypage
	$sql="select `content` from ".self::$table_pre."diypage where `shop_id`=".$shop_id;
	$rr=$pdo->query($sql,2);
	foreach($rr as $r){
		$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
		$imgs=get_match_all($reg,$r['content']);
		reg_attachd_img("del",self::$config['class_name'],$imgs,$pdo);	
	}
	$sql="delete from ".self::$table_pre."diypage where `shop_id`=".$shop_id;
	$pdo->exec($sql);
	
	
	//=============================================================================== delete module
	$sql="select `content` from ".self::$table_pre."module where `shop_id`=".$shop_id;
	$rr=$pdo->query($sql,2);
	foreach($rr as $r){
		$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
		$imgs=get_match_all($reg,$r['content']);
		reg_attachd_img("del",self::$config['class_name'],$imgs,$pdo);	
	}
	$sql="delete from ".self::$table_pre."module where `shop_id`=".$shop_id;
	$pdo->exec($sql);
}
//=======================================================================================================删除店铺相关数据_______________________________end


//=======================================================================================================【店铺进货，添加库存】
	function add_goods_batch($pdo,$goods_id,$quantity,$price,$supplier,$expiration=0){
		$time=time();
		if(!isset($_POST['payment'])){$_POST['payment']=$quantity;}
		$payment=floatval($_POST['payment']);
		if($payment>$quantity){$payment=$quantity;}
		if($payment<0){$payment=0;}
		if(!$price){return false;}

		$sql="select `id` from ".self::$table_pre."goods_batch where `goods_id`='".$goods_id."' and `quantity`=".$quantity." and `price`=".$price." and `add_time`>".($time-3)." limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){return false;}
		
		if(is_numeric($goods_id)){
			$g_id=$goods_id;
		}else{
			$temp=explode('_',$goods_id);
			$g_id=$temp[1];
		}
		$sql="select `inventory` from ".self::$table_pre."goods where `id`=".$g_id;
		$r=$pdo->query($sql,2)->fetch(2);
		$g_inventory=$r['inventory'];
		
		$purchase_name=safe_str(@$_POST['purchase_name']);
		
		$sql="insert into ".self::$table_pre."goods_batch (`goods_id`,`quantity`,`price`,`add_time`,`sell_out_time`,`left`,`shop_id`,`supplier`,`expiration`,`payment`,`username`,`remark`,`purchase_name`,`storehouse`) values ('".$goods_id."','".$quantity."','".$price."','".$time."','0','".$quantity."','".SHOP_ID."','".intval($supplier)."','".$expiration."','".$payment."','".$_SESSION['monxin']['username']."','".safe_str(@$_POST['remark'])."','".$purchase_name."',".intval(@$_POST['storehouse']).")";
		if(!$pdo->exec($sql)){add_err_log($sql);}
		
		$sql="select `id` from ".self::$table_pre."purchase where `shop_id`=".SHOP_ID." and `name`='".$purchase_name."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){
			$sql="insert into ".self::$table_pre."purchase (`name`,`shop_id`,`time`) values ('".$purchase_name."',".SHOP_ID.",".time().")";
			$pdo->exec($sql);	
		}
		
		$sql="update ".self::$table_pre."goods set `supplier`='".$supplier."' where `id`=".intval($goods_id);
		if(intval(@$_POST['storehouse'])>0){
			$sql="update ".self::$table_pre."goods set `supplier`='".$supplier."',`storehouse`=".intval($_POST['storehouse'])." where `id`=".intval($goods_id);
		}
		$pdo->exec($sql);
		$sql="select sum(`left`) as c from ".self::$table_pre."goods_batch where `goods_id`='".$goods_id."'";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['c']==''){$r['c']=$g_inventory;}
		$left=$r['c'];
		if(is_numeric($goods_id)){
			$sql="update ".self::$table_pre."goods set `inventory`=".$left." where `id`=".$goods_id;
			if(!$pdo->exec($sql)){add_err_log($sql);}
		}else{
			$id=explode('_',$goods_id);
			$sql="update ".self::$table_pre."goods_specifications set `quantity`=".$left." where `id`=".$id[1];
			$pdo->exec($sql);
			
			$sql="select sum(`left`) as c from ".self::$table_pre."goods_batch where `goods_id` like'".$id[0]."\_%'";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['c']==''){$r['c']=$g_inventory;}
			$left=$r['c'];
			
			$sql="update ".self::$table_pre."goods set `inventory`=".$left." where `id`=".$id[0];
			$pdo->exec($sql);
		}
		
		$sql="select sum(`left`) as c from ".self::$table_pre."goods_batch where `goods_id`='".$goods_id."' and `left`<0";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['c']==''){$r['c']=$g_inventory;}
		if($r['c']<0){
			$sql="update ".self::$table_pre."goods_batch set `left`=0 where `goods_id`='".$goods_id."' and `left`<0";
			$pdo->exec($sql);
			self::decrease_goods_batch($pdo,$goods_id,abs($r['c']));
		}
		return true;	
	}

//=======================================================================================================【减库存】
	function decrease_goods_batch($pdo,$goods_id,$quantity){
		$time=time();
		$sql="select `id`,`left` from ".self::$table_pre."goods_batch where `goods_id`='".$goods_id."' and `left`>0 order by `id` asc";
		$r=$pdo->query($sql,2);
		$decrease=0;
		foreach($r as $v){
			if($quantity==0){return $id;}
			$id=$v['id'];
			if($v['left']>$quantity){
				$sql="update ".self::$table_pre."goods_batch set `left`=`left`-".$quantity." where `id`=".$v['id'];	
				$quantity=0;
			}elseif($v['left']==$quantity){
				$sql="update ".self::$table_pre."goods_batch set `left`=`left`-".$quantity.",`sell_out_time`=".$time." where `id`=".$v['id'];
				$quantity=0;	
			}elseif($v['left']<$quantity){
				$sql="update ".self::$table_pre."goods_batch set `left`=0,`sell_out_time`=".$time." where `id`=".$v['id'];	
				$quantity-=$v['left'];
			}
			$pdo->exec($sql);
		}
		if($quantity!=0){
			if(isset($v)){
				$sql="update ".self::$table_pre."goods_batch set `left`=`left`-".$quantity.",`sell_out_time`=".$time." where `id`=".$v['id'];	
			}else{
				$sql="update ".self::$table_pre."goods_batch set `left`=`left`-".$quantity.",`sell_out_time`=".$time."  where `goods_id`='".$goods_id."'  order by `id` desc limit 1";	
			}
			
			$pdo->exec($sql);
		}
		if(!isset($id)){
			$sql="select `id` from ".self::$table_pre."goods_batch where `goods_id`='".$goods_id."'  order by `id` desc limit 1";	
			$r=$pdo->query($sql,2)->fetch(2);
			$id=$r['id'];
		}
		
		return $id;	
	}

//=======================================================================================================【按商品先进先出方法，返回商品成本】
	function get_cost_price($pdo,$goods_id){
		$sql="select `price` from ".self::$table_pre."goods_batch where  `goods_id`='".$goods_id."' and `left`>0 order by `id` asc limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if(!$r['price']){
			$sql="select `price` from ".self::$table_pre."goods_batch where  `goods_id`='".$goods_id."' order by `id` desc limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
		}
		if(!$r['price']){$r['price']=0;}
		return $r['price'];	
	}

	
//=======================================================================================================【返回最近入库商品成本】
	function get_cost_price_new($pdo,$goods_id){
		$sql="select `price` from ".self::$table_pre."goods_batch where  `goods_id`='".$goods_id."' order by `id` desc limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if(!$r['price']){$r['price']=0;}
		if($r['price']==0){
			if(is_numeric($goods_id)){
				$sql="select `cost_price` from ".self::$table_pre."goods where `id`=".$goods_id;
			}else{
				$temp=explode('_',$goods_id);
				$sql="select `cost_price` from ".self::$table_pre."goods_specifications where `id`=".$temp[1];	
			}
			$r=$pdo->query($sql,2)->fetch(2);
			$r['price']=$r['cost_price'];
		}
		return $r['price'];	
	}
//=======================================================================================================【返回最近入库商品成本 不限规格】
	function get_cost_price_new_2($pdo,$goods_id){
		if(is_numeric($goods_id)){
			$sql="select `price` from ".self::$table_pre."goods_batch where  `goods_id` ='".$goods_id."' order by `id` desc limit 0,1";
		}else{
			$temp=explode('_',$goods_id);
			$sql="select `price` from ".self::$table_pre."goods_batch where  `goods_id` like '".$temp[0]."_%' order by `id` desc limit 0,1";
		}
		$r=$pdo->query($sql,2)->fetch(2);
		if(!$r['price']){$r['price']=0;}
		if($r['price']==0){
			if(is_numeric($goods_id)){
				$sql="select `cost_price` from ".self::$table_pre."goods where `id`=".$goods_id;
			}else{
				$temp=explode('_',$goods_id);
				$sql="select `cost_price` from ".self::$table_pre."goods_specifications where `id`=".$temp[1];	
			}
			$r=$pdo->query($sql,2)->fetch(2);
			$r['price']=$r['cost_price'];
		}				
		return $r['price'];	
	}

//======================================================================================================= 购物后 自动添加买家为店内会员
	function add_shop_buyer($pdo,$username,$shop_id){
		$sql="select `id`,`phone` from ".self::$table_pre."shop_buyer where `shop_id`=".$shop_id." and `username`='".$username."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){return false;}
		$sql="select `id` from ".self::$table_pre."shop_buyer_group where `shop_id`=".$shop_id." order by `discount` desc limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		$group_id=$r['id'];
		
		$sql="select `phone`,`email` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";
		$user=$pdo->query($sql,2)->fetch(2);
		
		require_once('plugin/py/py_class.php');
		$py_class=new py_class();  
		try { $py=$py_class->str2py($username); } catch(Exception $e) { $py='';}
		
		$sql="insert into ".self::$table_pre."shop_buyer (`username`,`username_py`,`time`,`shop_id`,`group_id`,`phone`,`email`) value ('".$username."','".$py."','".time()."','".$shop_id."','".$group_id."','".$user['phone']."','".$user['email']."')";
		return $pdo->exec($sql);	
	}
	
//======================================================================================================= 更新店内会员 订单统计
	function update_shop_buyer($pdo,$table_pre,$order){
		$sql="select count(id) as c,sum(`actual_money`) as c2 from ".self::$table_pre."order where `shop_id`=".$order['shop_id']." and `buyer`='".$order['buyer']."' and `state`=6";
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="update ".self::$table_pre."shop_buyer set `money`='".$r['c2']."',`order`='".$r['c']."' where `shop_id`=".$order['shop_id']." and `username`='".$order['buyer']."'";
		$pdo->exec($sql);
			
	}
	
//======================================================================================================= 交易成功后返积分
	function give_credits($pdo,$r){
		if($r['buyer']==''){return false;}
		$sql="select `credits_rate`,`username` from ".self::$table_pre."shop where `id`=".$r['shop_id'];
		$shop=$pdo->query($sql,2)->fetch(2);
		$number=($shop['credits_rate']/100)*($r['actual_money']-$r['web_credits_money']);
		$reason=self::$language['buy_give_credits'];
		$reason=str_replace("{v}",$r['out_id'],$reason);
		//if($r['cashier']=='' || $r['cashier']=='monxin'){
			$result=operation_credits($pdo,self::$config,self::$language,$shop['username'],'-'.$number,$reason,'buy',true);
			if($result){
				$result=operation_credits($pdo,self::$config,self::$language,$r['buyer'],$number,$reason,'buy');
				$sql="update ".self::$table_pre."order set `give_web_credits`=".$number." where `id`=".$r['id'];
				$pdo->exec($sql);
			}else{
				return false;
			}
		//}
		$sql="select `group_id`,`id` from ".self::$table_pre."shop_buyer where `username`='".$r['buyer']."' and `shop_id`=".$r['shop_id']." limit 0,1";
		$user=$pdo->query($sql,2)->fetch(2);
		if($user['id']==''){return false;}
		$sql="select `buy_credits_multiple` from ".self::$table_pre."shop_buyer_group where id=".$user['group_id'];
		$v=$pdo->query($sql,2)->fetch(2);
		$number=$v['buy_credits_multiple']*$r['actual_money'];
		$reason=self::$language['buy_return_credits'];
		self::operator_shop_buyer_credits($pdo,$r['buyer'],$number,$reason,$r['shop_id']);
			$sql="update ".self::$table_pre."order set `give_shop_credits`=".$number." where `id`=".$r['id'];
			$pdo->exec($sql);
		self::shop_group_auto_upgrade($pdo,$r['buyer'],$r['shop_id']);
		
		
	}
//======================================================================================================= 取消订单后，退回下单时 使用的积分
	function order_cancel_untread_credits($pdo,$r){
		if($r['buyer']==''){return false;}
		if($r['web_credits']>0){operation_credits($pdo,self::$config,self::$language,$r['buyer'],$r['web_credits'],self::$language['pages']['mall.order_cancel']['name'],'other');}
		if($r['shop_credits']>0){
			self::operator_shop_buyer_credits($pdo,$r['buyer'],$r['shop_credits'],self::$language['pages']['mall.order_cancel']['name'],$r['shop_id']);
		}
		
	}
	
//======================================================================================================= 申请退货后，退回送的积分
	function untread_credits($pdo,$r){
		if($r['buyer']==''){return false;}
		if($r['give_web_credits']>0){operation_credits($pdo,self::$config,self::$language,$r['buyer'],'-'.$r['give_web_credits'],'','buy_return');}
		if($r['give_shop_credits']>0){
			$sql="select `group_id`,`id` from ".self::$table_pre."shop_buyer where `username`='".$r['buyer']."' and `shop_id`=".$r['shop_id']." limit 0,1";
			$user=$pdo->query($sql,2)->fetch(2);
			$sql="select `buy_credits_multiple` from ".self::$table_pre."shop_buyer_group where id=".$user['group_id'];
			$v=$pdo->query($sql,2)->fetch(2);
			self::operator_shop_buyer_credits($pdo,$r['buyer'],'-'.$r['give_shop_credits'],self::$language['credits_type']['buy_return'],$r['shop_id']);
		}
		
	}

	
//======================================================================================================= 店内会员自动升级
    function shop_group_auto_upgrade($pdo,$username,$shop_id){
        if($username==''){return false;}
        $sql="select `cumulative_credits`,`group_id` from ".self::$table_pre."shop_buyer where `username`='".$username."'  and `shop_id`=".$shop_id." limit 0,1";
        $user=$pdo->query($sql,2)->fetch(2);
        $sql="select `credits` from ".self::$table_pre."shop_buyer_group where `id`='".$user['group_id']."'";
        $group=$pdo->query($sql,2)->fetch(2);
        $sql="select `id`,`credits` from ".self::$table_pre."shop_buyer_group where `id`!=".$user['group_id']."   and `shop_id`=".$shop_id." and `credits`>".$group['credits']." order by `credits` asc";
        $r=$pdo->query($sql,2);
		$new_group_id=$user['group_id'];
		foreach($r as $v){
			if($v['credits']<=$user['cumulative_credits']){$new_group_id=$v['id'];}	
		}
        $sql="update ".self::$table_pre."shop_buyer set `group_id`=".$new_group_id." where `username`='".$username."'  and `shop_id`=".$shop_id."  limit 1";
        $r=$pdo->exec($sql);
		
    }
	
	
	
//======================================================================================================= 获取店内会员折扣
	function shop_buyer_group_discount($pdo,$shop_id){
		$sql="select `group_id` from ".self::$table_pre."shop_buyer where `shop_id`=".$shop_id." and `username`='".$_SESSION['monxin']['username']."'  limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['group_id']=='' || $r['group_id']<1){
			return 10;
		}else{
			$sql="select `discount` from ".self::$table_pre."shop_buyer_group where `id`=".$r['group_id']." and `shop_id`=".$shop_id." limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			return $r['discount'];					
		}
	}
	
//======================================================================================================= 获取店内会员用户组ID
	function shop_buyer_group_id($pdo,$shop_id){
		$sql="select `group_id` from ".self::$table_pre."shop_buyer where `shop_id`=".$shop_id." and `username`='".$_SESSION['monxin']['username']."'  limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		return $r['group_id'];
	}
	
//======================================================================================================= 返回适用红包 抵扣金额
	function get_red_coupon($pdo,$table_pre,$promotion_money,$all_money,$shop_id){
		$time=time();
		$sql="select * from ".self::$table_pre."coupon where `shop_id`=".$shop_id." and `start_time`<'".$time."' and  `end_time`>'".$time."' and `used`<`sum_quantity` and `min_money`<=".$all_money;
		$r=$pdo->query($sql,2);
		$red_ids='';
		foreach($r as $v){
			$ok=false;
			if($v['join_goods']==0){//仅参加促销的商品 可使用
				if($promotion_money>=$v['min_money']){$ok=true;}
			}
			if($v['join_goods']==1){//全店商品 可使用
				if($all_money>=$v['min_money']){$ok=true;}
			}
			if($v['join_goods']==2){//不参加促销的商品 可使用
				if($all_money-$promotion_money>=$v['min_money']){$ok=true;}
			}
			
			if($ok){$red_ids.=$v['id'].',';}
		}
		$red_ids=trim($red_ids,',');
		if($red_ids==''){return false;}
		$sql="select `coupon_id` from ".self::$table_pre."my_coupon where `username`='".$_SESSION['monxin']['username']."' and `use_time`=0 and `coupon_id` in (".$red_ids.")";
		$r=$pdo->query($sql,2);
		$useable='';
		foreach($r as $v){
			$useable.=$v['coupon_id'].',';	
		}
		$useable=trim($useable,',');
		if($useable==''){return false;}
		$sql="select `amount`,`id` from ".self::$table_pre."coupon where `id` in (".$useable.") order by `amount` desc limit 0,1";
		//echo $sql;
		$r=$pdo->query($sql,2)->fetch(2);
		return $r;
		
	}
	
	
//======================================================================================================= 更新超过 尾款支付结束时间的订单状态为：预售违约关闭
	function update_pre_sale_order_15($pdo){
		$time=time();
		$sql="select * from  ".self::$table_pre."order where `state`=13";
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			$sql="select `goods_id` from ".self::$table_pre."order_goods where `order_id`=".$v['id']." limit 0,1";
			$og=$pdo->query($sql,2)->fetch(2);
			$sql="select * from ".self::$table_pre."pre_sale where `goods_id`=".$og['goods_id']." limit 0,1";
			$pre=$pdo->query($sql,2)->fetch(2);
			if($pre['last_pay_end_time']<$time){
				$actual_money=$pre['deposit'];
				$sql="update ".self::$table_pre."order set `state`='15',`actual_money`=".$actual_money." where `id`=".$v['id'];
				file_put_contents('ttt.txt',$sql);
				if($pdo->exec($sql)){
					self::update_pre_sale_order_15_pay($pdo,$v['id']);
				}
				
			}
		}
		
	}
	
//=======================================================================================================预售违约关闭的订单，付定金给店家
	function update_pre_sale_order_15_pay($pdo,$id){
		$sql="select * from ".self::$table_pre."order where `id`=".$id." and `state`=15";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){return false;}
		self::update_shop_order_sum($pdo,self::$table_pre,$r['shop_id']);
		
		if($r['pay_method']=='balance' || $r['pay_method']=='online_payment'){
			$sql="select `username` from ".self::$table_pre."shop where `id`=".$r['shop_id'];
			$r2=$pdo->query($sql,2)->fetch(2);
			$seller=$r2['username'];
			
			$reason=str_replace('{order_id}','<a href=./index.php?monxin=mall.order_admin&search='.$r['out_id'].' target=_blank>'.$r['out_id'].'</a>',self::$language['add_order_money_template']);
			$reason=str_replace('{sum_money}',$r['actual_money'],$reason);
			//var_dump($r);
			if(operator_money(self::$config,self::$language,$pdo,$seller,$r['actual_money'],$reason,'mall')){
				self::operation_shop_finance(self::$language,$pdo,self::$table_pre,$r['shop_id'],$r['actual_money'],9,$reason);
				self::exe_online_pay_fees($pdo,$seller,$r);
				self::exe_pay_order_fees($pdo,$seller,$r);
				self::exe_pay_manage_fees($pdo,$seller,$r);
				self::exe_pay_ad_fees($pdo,$seller,$r);
				//self::record_order_cost($pdo,$seller,$r);
				self::exe_pay_agent_fees($pdo,$seller,$r);
				//self::decrease_goods_quantity($pdo,self::$table_pre,$r);
				self::update_shop_buyer($pdo,self::$table_pre,$r);
				//self::exe_pay_recommendation_fees($pdo,$seller,$r);
				//self::give_credits($pdo,$r);
			}
		}		
	}
	
//======================================================================================================= 返回商品各店内会员折扣度
	function get_goods_group_discount($pdo,$goods_id){
		$sql="select `discount`,`id`,`name` from ".self::$table_pre."shop_buyer_group where `shop_id`=".SHOP_ID;
		$r=$pdo->query($sql,2);
		$attribute='';
		foreach($r as $v){
			$sql="select `discount` from ".self::$table_pre."goods_group_discount where `goods_id`=".$goods_id." and `group_id`=".$v['id']." limit 0,1";
			$r2=$pdo->query($sql,2)->fetch(2);
			if($r2['discount']!=''){
				$v['discount']=$r2['discount'];
			}
			$attribute.=' g_'.$v['id'].'='.$v['discount'].' gname_'.$v['id'].'="'.$v['name'].'"';
		}
		return $attribute;
		
	}
	
//======================================================================================================= 操作买家店内余额
	function operator_shop_buyer_balance($pdo,$username,$money,$reason,$operator=''){
		$sql="update ".self::$table_pre."shop_buyer set `balance`=`balance`+".$money." where `username`='".$username."' and `shop_id`=".SHOP_ID." limit 1";
		if($pdo->exec($sql)){
			$sql="insert into ".self::$table_pre."shop_buyer_balance (`username`,`shop_id`,`time`,`money`,`reason`,`operator`) values ('".$username."','".SHOP_ID."','".time()."','".$money."','".$reason."','".$operator."')";	
			$pdo->exec($sql);
			return true;
		}
		return false;
	}
	
//======================================================================================================= 操作买家店内积分
	function operator_shop_buyer_credits($pdo,$username,$money,$reason,$shop_id){
		$sql="update ".self::$table_pre."shop_buyer set `credits`=`credits`+".$money.",`cumulative_credits`=`cumulative_credits`+".$money." where `username`='".$username."' and `shop_id`=".$shop_id." limit 1";
		if($pdo->exec($sql)){
			$sql="insert into ".self::$table_pre."shop_buyer_credits (`username`,`shop_id`,`time`,`money`,`reason`) values ('".$username."','".$shop_id."','".time()."','".$money."','".$reason."')";	
			$pdo->exec($sql);
			return true;
		}
		return false;
	}
	
	
	
//======================================================================================================= 更新连锁店分店数量
	function update_brand_sum($pdo,$username){
		$sql="select `name`,`id` from ".self::$table_pre."headquarters where `username`='".$username."' limit 0,1";
		$head=$pdo->query($sql,2)->fetch(2);
		$sql="select count(id) as c from ".self::$table_pre."shop where `head`='".$head['name']."' and `use_goods_db`=1";
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="update ".self::$table_pre."headquarters set `branch_sum`=".$r['c']." where `id`=".$head['id'];
		$pdo->exec($sql);
	}
	
	
	
	
	
	
	function goods_up_get_supplier_id($pdo,$id){
		$sql="select * from ".self::$table_pre."supplier where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="select `id` from ".self::$table_pre."supplier where `shop_id`='".SHOP_ID."' and `name`='".$r['name']."' limit 0,1";
		$r2=$pdo->query($sql,2)->fetch(2);
		if($r2['id']!=''){return $r2['id'];}
		if($r['name']==''){return 0;}
		$sql="insert into ".self::$table_pre."supplier (`name`,`link_man`,`contact`,`sequence`,`shop_id`) values ('".$r['name']."','".$r['link_man']."','".$r['contact']."','".$r['sequence']."','".SHOP_ID."')";
		if($pdo->exec($sql)){
			return $pdo->lastInsertId();
		}else{
			return 0;
		}

	}
	
	function goods_up_get_shop_type_id($pdo,$id){
		$sql="select `name` from ".self::$table_pre."shop_type where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="select `id` from ".self::$table_pre."shop_type where `shop_id`='".SHOP_ID."' and `name`='".$r['name']."' limit 0,1";
		$r2=$pdo->query($sql,2)->fetch(2);
		if($r2['id']!=''){return $r2['id'];}
		$sql="insert into ".self::$table_pre."shop_type (`parent`,`name`,`shop_id`) values ('0','".$r['name']."','".SHOP_ID."')";
		if($pdo->exec($sql)){
			$id=$pdo->lastInsertId();
			self::update_shop_navigation($pdo,self::$language);
			return $id;
		}else{
			return 0;
		}

	}
	
	function goods_up_get_tag_id($pdo,$id){
		$sql="select `name` from ".self::$table_pre."shop_tag where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="select `id` from ".self::$table_pre."shop_tag where `shop_id`='".SHOP_ID."' and `name`='".$r['name']."' limit 0,1";
		$r2=$pdo->query($sql,2)->fetch(2);
		if($r2['id']!=''){return $r2['id'];}
		$sql="insert into ".self::$table_pre."shop_tag (`name`,`shop_id`) values ('".$r['name']."','".SHOP_ID."')";
		if($pdo->exec($sql)){
			return $pdo->lastInsertId();
		}else{
			return 0;
		}

	}
	
	
	
	
	
	
	
//================================================================================================================================= 分店上架总部商品 start
	function goods_up($pdo,$goods_id){
		$sql="select `id` from ".self::$table_pre."goods where `db_id`=".$goods_id." and `shop_id`=".SHOP_ID." limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){$_POST['reason']=self::$language['already_exists'].'';return false;}
		$time=time();
		$head_id=self::get_head_id($pdo,SHOP_ID);
		$sql="select * from ".self::$table_pre."goods where `id`=".$goods_id;
		$goods=$pdo->query($sql,2)->fetch(2);
		if($goods['shop_id']!=$head_id){return false;}
		
		if($goods['supplier']!=0){$goods['supplier']=self::goods_up_get_supplier_id($pdo,$goods['supplier']);}
		if($goods['shop_type']!=0){$goods['shop_type']=self::goods_up_get_shop_type_id($pdo,$goods['shop_type']);}
		if($goods['tag']!=0){$goods['tag']=self::goods_up_get_tag_id($pdo,$goods['tag']);}
		
		if($goods['bar_code']!='0'  && $goods['bar_code']!='' && self::barcode_repeat($pdo,SHOP_ID)==0){
			$sql="select count(id) as c from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and (`bar_code`='".$goods['bar_code']."' or `speci_bar_code` like '%".$goods['bar_code']."|%')";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['c']>0){$_POST['reason']=self::$language['already_exists'].'';return false;}
		}
		if($goods['store_code']!='' && $goods['store_code']!='0'){
			$sql="select count(id) as c from ".self::$table_pre."goods where `shop_id`=".SHOP_ID." and (`store_code`='".$goods['store_code']."' or `speci_store_code` like '%".$goods['store_code']."|%')";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['c']>0){$_POST['reason']=self::$language['already_exists'].'';return false;}
		}
		
		
		get_date_dir('./program/mall/img/');	
		get_date_dir('./program/mall/img_thumb/');	
		$goods['icon_new']=date('Y',$time).'_'.date('m',$time).'/'.date('d',$time).'/'.md5(microtime().'icon').'.jpg';
		@copy('./program/mall/img/'.$goods['icon'],'./program/mall/img/'.$goods['icon_new']);
		@copy('./program/mall/img_thumb/'.$goods['icon'],'./program/mall/img_thumb/'.$goods['icon_new']);
		$goods['multi_angle_img_new']='';
		if($goods['multi_angle_img']!=''){
			$temp=explode('|',$goods['multi_angle_img']);
			$goods['multi_angle_img_new']='';
			$i=10000;
			foreach($temp as $v){
				if(is_file('./program/mall/img/'.$v)){
					$path=date('Y',$time).'_'.date('m',$time).'/'.date('d',$time).'/'.md5(microtime().$i).'.jpg';
					@copy('./program/mall/img/'.$v,'./program/mall/img/'.$path);
					@copy('./program/mall/img_thumb/'.$v,'./program/mall/img_thumb/'.$path);
					$goods['multi_angle_img_new'].=$path.'|';
					$i++;
				}	
			}
			$goods['multi_angle_img_new']=trim($goods['multi_angle_img_new'],'|');
		}
		$goods_state=2;
		
		if($goods['option_enable']==0){
			$sql="insert into ".self::$table_pre."goods (`type`,`brand`,`unit`,`logistics_weight`,`logistics_volume`,`free_shipping`,`supplier`,`title`,`advantage`,`icon`,`multi_angle_img`,`detail`,`sales_promotion`,`time`,`username`,`bar_code`,`w_price`,`e_price`,`cost_price`,`inventory`,`option_enable`,`virtual_auto_delivery`,`m_detail`,`shelf_life`,`shop_id`,`shop_type`,`shop_tag`,`state`,`limit`,`limit_cycle`,`db_id`,`store_code`,`mall_state`,`py`) values ('".intval($goods['type'])."','".intval($goods['brand'])."','".intval($goods['unit'])."','".intval($goods['logistics_weight'])."','".floatval($goods['logistics_volume'])."','".intval($goods['free_shipping'])."','".intval($goods['supplier'])."','".$goods['title']."','".$goods['advantage']."','".$goods['icon_new']."','".$goods['multi_angle_img_new']."','".$goods['detail']."','".intval($goods['sales_promotion'])."','".$time."','".$_SESSION['monxin']['username']."','".$goods['bar_code']."','".floatval($goods['w_price'])."','".floatval($goods['e_price'])."','".floatval($goods['cost_price'])."','0','0','".$goods['virtual_auto_delivery']."','".$goods['m_detail']."','".intval($goods['shelf_life'])."','".SHOP_ID."','".intval($goods['shop_type'])."','".$goods['tag']."','".$goods_state."','".intval($goods['limit'])."','".safe_str($goods['limit_cycle'])."','".$goods['id']."','".$goods['store_code']."',1,'".$goods['py']."')";
				
		}else{
			$sql="insert into ".self::$table_pre."goods (`type`,`brand`,`unit`,`logistics_weight`,`logistics_volume`,`free_shipping`,`position`,`supplier`,`title`,`advantage`,`icon`,`multi_angle_img`,`detail`,`sales_promotion`,`time`,`username`,`option_enable`,`virtual_auto_delivery`,`m_detail`,`shelf_life`,`shop_id`,`shop_type`,`shop_tag`,`state`,`limit`,`limit_cycle`,`db_id`,`speci_store_code`,`mall_state`,`py`) values ('".intval($goods['type'])."','".intval($goods['brand'])."','".intval($goods['unit'])."','".intval($goods['logistics_weight'])."','".floatval($goods['logistics_volume'])."','".intval($goods['free_shipping'])."','".intval($goods['position'])."','".intval($goods['supplier'])."','".$goods['title']."','".$goods['advantage']."','".$goods['icon_new']."','".$goods['multi_angle_img_new']."','".$goods['detail']."','".intval($goods['sales_promotion'])."','".$time."','".$_SESSION['monxin']['username']."','1','".$goods['virtual_auto_delivery']."','".$goods['m_detail']."','".intval($goods['shelf_life'])."','".SHOP_ID."','".intval($goods['shop_type'])."','".$goods['tag']."','".$goods_state."','".intval($goods['limit'])."','".safe_str($goods['limit_cycle'])."','".$goods['id']."','".$goods['speci_store_code']."',1,'".$goods['py']."')";
		}
		
		
		//======================================================================================================【处理商品辅信息 start】
		if($pdo->exec($sql)){
			$insret_id=$pdo->lastInsertId();
			
			//--------------------------------------------------------------------------------------生成商品快照
			$sql="select * from ".self::$table_pre."goods where `id`=".$insret_id;
			$current_goods=$pdo->query($sql,2)->fetch(2);
			self::create_mall_goods_snapshot($pdo,self::$table_pre,$current_goods);

			//--------------------------------------------------------------------------------------处理商品属性
			$sql="select * from ".self::$table_pre."goods_attribute where `goods_id`=".$goods['id'];
			$temp=$pdo->query($sql,2);
			foreach($temp as $v){
				$sql="insert into ".self::$table_pre."goods_attribute (`attribute_id`,`value`,`goods_id`,`type`) values ('".$v['attribute_id']."','".$v['value']."','".$insret_id."','".intval($goods['type'])."')";
				//echo $sql;
				$pdo->exec($sql);
			}
			
			
			if($goods['option_enable']!=0){//---------------------------------------------------------如商品有选项 则处理商品选项
				$w_price=array();
				$speci_bar_code='';
				$sum_quantity=0;
				$sql="select * from ".self::$table_pre."goods_specifications where `goods_id`=".$goods['id'];
				$temp=$pdo->query($sql,2);
				$i=0;
				foreach($temp as $v){
					if($v['color_img']!=''){
						$path=date('Y',$time).'_'.date('m',$time).'/'.date('d',$time).'/'.md5(microtime().$i).'.jpg';
						@copy('./program/mall/img/'.$v['color_img'],'./program/mall/img/'.$path);
						@copy('./program/mall/img_thumb/'.$v['color_img'],'./program/mall/img_thumb/'.$path);
						$v['color_img']=$path;
						$i++;
					}
					$sql="insert into ".self::$table_pre."goods_specifications (`color_id`,`option_id`,`color_name`,`color_img`,`color_show`,`goods_id`,`e_price`,`w_price`,`cost_price`,`quantity`,`barcode`,`type`,`store_code`) values ('".$v['color_id']."','".$v['option_id']."','".$v['color_name']."','".$v['color_img']."','".$v['color_show']."','".$insret_id."','".$v['e_price']."','".$v['w_price']."','".$v['cost_price']."','0','".$v['barcode']."','".intval($goods['type'])."','".$v['store_code']."')";	
					//echo $sql;
					$pdo->exec($sql);
					$w_price[]=floatval($v['w_price']);
					if($v['barcode']!=''){$speci_bar_code.=$v['barcode'].'|';}
					
					
				}
			
			
				$sql="update ".self::$table_pre."goods set `speci_bar_code`='".$speci_bar_code."',`inventory`='".$sum_quantity."',`min_price`='".min($w_price)."',`max_price`='".max($w_price)."',`w_price`='".((min($w_price)+max($w_price))/2)."' where `id`=".$insret_id;
				$pdo->exec($sql);	
			}
			self::update_shop_goods($pdo,self::$table_pre,SHOP_ID);
			return true;
		}else{
			return false;
		}
		
		//====================================================================================================【处理商品辅信息 end】
		
	}
//================================================================================================================================= 分店上架总部商品 start	
	



















	
	function get_headquarters_name($pdo){
		$sql="select `name` from ".self::$table_pre."headquarters where `username`='".$_SESSION['monxin']['username']."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		return $r['name'];	
	}
	
	function get_head_id($pdo,$shop_id){
		$sql="select `head` from ".self::$table_pre."shop where `id`=".$shop_id;
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="select `id` from ".self::$table_pre."shop where `name`='".$r['head']."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		return $r['id'];
	}
	
	function stocktake_loss($pdo,$goods_id,$s_id,$quantity){
		$time=time();
		$sql="select `option_enable`,`id`,`title`,`shop_id`,`cost_price`,`inventory` from ".self::$table_pre."goods where `id`=".$goods_id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']=='' || $r['shop_id']!=SHOP_ID){return false;}
		if($quantity>$r['inventory']){return false;}
		$all_id=$goods_id;
		if($r['option_enable']){
			if($s_id==0){return false;}
			$sql="select * from ".self::$table_pre."goods_specifications where `id`=".$s_id;
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']==''){return false;}
			if($quantity>$r['quantity']){return false;}
			$all_id=$goods_id.'_'.$s_id;
			$sql="update ".self::$table_pre."goods_specifications set `quantity`=`quantity`-".$quantity." where `id`=".$s_id." and `goods_id`=".$goods_id;
			$pdo->exec($sql);
		}
	
		$sql="update ".self::$table_pre."goods set `inventory`=`inventory`-".$quantity." where `id`=".$goods_id;	
		if($pdo->exec($sql)){
			$batch_id=self::decrease_goods_batch($pdo,$all_id,$quantity);
			$sql="insert into ".self::$table_pre."goods_loss (`goods_id`,`s_id`,`quantity`,`money`,`reason`,`time`,`username`,`shop_id`) values ('".$goods_id."','".$s_id."','".$quantity."','".(self::get_cost_price($pdo,$all_id)*$quantity)."','".self::$language['stocktake'].self::$language['loss']."','".$time."','".$_SESSION['monxin']['username']."','".SHOP_ID."')";
			if($pdo->exec($sql)){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function update_stocktake_loss($pdo,$stocktake_id){
		$sql="select `loss`,`goods_id`,`s_id` from ".self::$table_pre."stocktake_goods where `stocktake_id`='".$stocktake_id."' and `loss`>0";
		$r2=$pdo->query($sql,2);
		$loss_goods=0;
		$loss_money=0;
		foreach($r2 as $v2){
			$loss_goods+=$v2['loss'];
			if( $v2['s_id']>0 ){$v2['goods_id'].='_'.$v2['s_id'];}
			$loss_money+=$v2['loss']*self::get_cost_price($pdo,$v2['goods_id']);	
		}
		$sql="update ".self::$table_pre."stocktake set `loss_goods`='".$loss_goods."',`loss_money`='".$loss_money."' where `id`=".$stocktake_id;
		return $pdo->exec($sql);	
	}
	
	function chip_inquiry_shop_buyer($pdo,$chip,$shop_id){
		$sql="select `username` from ".self::$table_pre."shop_buyer where `shop_id`='".$shop_id."' and `chip`='".$chip."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		return $r['username'];
	}
	
	function add_grade($pdo,$shop_id,$name){
		if($name==''){return false;}
		$sql="select `id` from ".self::$table_pre."goods_grade where `shop_id`=".$shop_id." and `name`='".$name."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){return false;}
		$sql="insert into ".self::$table_pre."goods_grade (`shop_id`,`name`) values ('".$shop_id."','".$name."')";
		$pdo->exec($sql);	
	}
	
	function add_habitat($pdo,$shop_id,$name){
		if($name==''){return false;}
		$sql="select `id` from ".self::$table_pre."goods_habitat where `shop_id`=".$shop_id." and `name`='".$name."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){return false;}
		$sql="insert into ".self::$table_pre."goods_habitat (`shop_id`,`name`) values ('".$shop_id."','".$name."')";
		$pdo->exec($sql);	
	}
	
	function add_contain($pdo,$shop_id,$name){
		if($name==''){return false;}
		$sql="select `id` from ".self::$table_pre."goods_contain where `shop_id`=".$shop_id." and `name`='".$name."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){return false;}
		$sql="insert into ".self::$table_pre."goods_contain (`shop_id`,`name`) values ('".$shop_id."','".$name."')";
		$pdo->exec($sql);	
	}
	
	function update_card_state($pdo,$username){
		$sql="update ".self::$table_pre."create_card set `state`=1,`use_time`='".time()."' where `username`='".$username."' limit 1";
		return $pdo->exec($sql);	
	}
	
	function barcode_repeat($pdo,$shop_id){
		$sql="select `barcode_repeat` from ".self::$table_pre."shop where `id`=".$shop_id." limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		return $r['barcode_repeat'];	
	}
	
	function get_mall_brand_name($pdo,$v){
		$sql="select `name` from ".self::$table_pre."type_brand where `id`=".$v;
		$r=$pdo->query($sql,2)->fetch(2);
		return de_safe_str($r['name']);	
	}
	
	function update_interest_group_words_multiple($pdo,$ids){
		$temp=explode(',',$ids);
		foreach($temp as $id){
			if($id==''){continue;}
			self::update_interest_group_words($pdo,$id);	
		}	
	}
	
	function update_interest_group_words($pdo,$id){
		$sql="select count(`id`) as c from ".self::$table_pre."interest_word where (`group_ids` like '".$id.",%' || `group_ids` like '%,".$id.",%')";
		$r=$pdo->query($sql,2)->fetch();
		$sql="update ".self::$table_pre."interest_group set `words`=".$r['c']." where `id`=".$id;
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
	
	function get_kg_rate($pdo,$id){
		$sql="select `gram` from ".self::$table_pre."unit where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['gram']==0){return 0;}
		return 1000/$r['gram'];	
	}
	
	function web_credits_subsidy($pdo,$seller,$order){//买家购物使用了平台积分抵扣并订单金额没经过平台，导致店家少收钱，系统执行补贴
		if($order['web_credits_money']<0){return false;}
		$array=array('balance');
		if(in_array($order['pay_method'],$array)){return false;}
		
		$reason=str_replace('{order_id}','<a href=./index.php?monxin=mall.order_admin&search='.$order['out_id'].' target=_blank>'.$order['out_id'].'</a>',self::$language['web_credits_deduction_subsidy']);
		if(!operator_money(self::$config,self::$language,$pdo,$seller,$order['web_credits_money'],$reason,'mall')){
			return false;
		}
		return true;
	}
	
	function set_order_goods_barcode($pdo,$order_id){
		$sql="select `id`,`s_id`,`goods_id` from ".self::$table_pre."order_goods where `order_id`=".$order_id;
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			if($v['s_id']!=0){
				$sql="select `barcode` as b from ".self::$table_pre."goods_specifications where `id`=".$v['s_id'];
			}else{
				$sql="select `bar_code` as b from ".self::$table_pre."goods where `id`=".$v['goods_id'];
			}
			$b=$pdo->query($sql,2)->fetch(2);
			$sql="update ".self::$table_pre."order_goods set `barcode`='".$b['b']."' where `id`=".$v['id'];
			$pdo->exec($sql);
		}
	}
	
//======================================================================================================= 返回商品供应商名称 
	function get_supplier_name($pdo,$id){
		$sql="select `name` from ".self::$table_pre."supplier where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		return $r['name'];
	}
	
	
//======================================================================================================= 获取 店内商品分类 上级ID
	function get_shop_type_ids($pdo,$id){
		$sql="select `id` from ".self::$table_pre."shop_type where `parent`=$id and `shop_id`=".SHOP_ID;
		$r=$pdo->query($sql,2);
		$ids=$id.',';
		foreach($r as $v){
			$ids.=$v['id'].',';
			$sql2="select `id` from ".self::$table_pre."shop_type where `parent`=".$v['id']." and `shop_id`=".SHOP_ID;
			$r2=$pdo->query($sql2,2);
			foreach($r2 as $v2){
				$ids.=$v2['id'].',';
				$sql3="select `id` from ".self::$table_pre."shop_type where `parent`=".$v2['id']." and `shop_id`=".SHOP_ID;
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