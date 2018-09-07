<?php
self::update_expire_order($pdo,self::$table_pre,self::$config['pay_time_limit']);

//var_dump($_SESSION['monxin_mall_order_id']);
$id=intval(@$_GET['id']);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&id=".$id;
$ids=array();
$for_id=$id;
if($id==0){
	if(!isset($_SESSION['monxin_mall_order_id'])){echo 'order_id err';return false;}
	$ids=explode('|',trim(@$_SESSION['monxin_mall_order_id'],'|'));
	$id=intval($ids[0]);
	$for_id=trim($_SESSION['monxin_mall_order_id'],'|');
}
if($id==0){echo 'id err';return false;}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);


$sql="select `id`,`actual_money`,`receiver_id`,`buyer`,`state`,`add_time`,`web_credits_money`,`shop_credits_money`,`out_id`,`pre_sale`,`pay_method` from ".self::$table_pre."order where `id`=".$id;
$module['data']=$pdo->query($sql,2)->fetch(2);
if($module['data']['id']==0){echo 'id err';return false;}
$module['data']['id']='<a href="./index.php?monxin=mall.my_order&id='.$module['data']['id'].'" target=_blank >'.$module['data']['out_id'].'</a>,';
$module['data']['actual_money']-=$module['data']['web_credits_money'];
$order=$module['data'];
if($order['pay_method']=='credits'){self::$config['pay_mode']='credits';}else{self::$config['pay_mode']='money';}
if($order['pay_method']=='credits'){
	self::$language['yuan']=self::$language['credits'];
}else{
	self::$language['yuan']=self::$language['yuan_2'];
}


if($module['data']['pre_sale']==1){
	if($module['data']['state']!=11 && $module['data']['state']!=13 ){	echo "<div align='center' style='line-height:100px;'><span class=fail>".self::$language['state'].':'.self::$language['order_state'][$module['data']['state']]." ".self::$language['inoperable']."</div>";return false;	
	}
	$sql="select * from ".self::$table_pre."order_pre_sale where `order_id`=".$id." limit 0,1";
	$pre=$pdo->query($sql,2)->fetch(2);
	$sql="select * from ".self::$table_pre."order where `id`=".$id;
	$v=$pdo->query($sql,2)->fetch(2);
	self::end_pre_sale_order($pdo,$v,$pre);
	
	if($module['data']['state']==11){$module['data']['actual_money']=$pre['deposit'];}
	if($module['data']['state']==13){
		$module['data']['actual_money']-=$pre['deposit'];
		
	}
	
}
$module['data']['actual_money']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$module['data']['actual_money']);


//$module['data']['actual_money']-=$module['data']['shop_credits_money'];

if(count($ids)>1){
	$sql="select `id`,`actual_money`,`web_credits_money`,`shop_credits_money`,`out_id` from ".self::$table_pre."order where `id` in (".implode(',',$ids).")";
	//echo $sql;
	$r=$pdo->query($sql,2);
	$module['data']['actual_money']=0;
	$module['data']['id']='';
	foreach($r as $v){
		$v['actual_money']-=$v['web_credits_money'];
		$v['actual_money']=money_to_credits(self::$config['credits_set']['rate'],self::$config['pay_mode'],$v['actual_money']);

		//$v['actual_money']-=$v['shop_credits_money'];
		$module['data']['actual_money']+=$v['actual_money'];
		$module['data']['id'].='<a href="./index.php?monxin=mall.my_order&id='.$v['id'].'" target=_blank >'.$v['out_id'].'</a>,';
	}
	$module['data']['id']=trim($module['data']['id'],',');
}

if(isset($_SESSION['monxin']['username'])){
	if($_SESSION['monxin']['username']!=$module['data']['buyer']){echo self::$language['act_noPower'];return false;}	
}else{
	if($module['data']['buyer']!=''){echo self::$language['act_noPower'];return false;}	
}

if($module['data']['state']!=0 && $module['data']['state']!=11 &&  $module['data']['state']!=13){
	if(!isset($_GET['id'])){echo "<div align='center' style='line-height:100px;'><span class=success>".self::$language['success']." <a href=./index.php?monxin=mall.my_order>".self::$language['view']."</a></div>";return false;	}
	if($module['data']['state']==1){echo "<div align='center' style='line-height:100px;'><span class=success>".self::$language['has'].self::$language['payment']." <a href=./index.php?monxin=mall.my_order>".self::$language['view']."</a></div>";return false;}
	
	echo "<div align='center' style='line-height:100px;'><span class=fail>".self::$language['state'].':'.self::$language['order_state'][$module['data']['state']]." ".self::$language['inoperable']."</div>";return false;	
}





//==================================================================================================================================【在线支付 返回 start】
if(@$_GET['act']=='online_payment'){
	//var_dump($_GET);exit();
	
	$sql="select * from ".self::$table_pre."order where id=".$id;
	if(count($ids)>1){
		$sql="select * from ".self::$table_pre."order where `id` in (".implode(',',$ids).")";
	}
	$r=$pdo->query($sql,2);
	$success_sum=0;
	$automatic_delivery=0;
	foreach($r as $v){
		if($v['pre_sale']==1){
			$sql="select * from ".self::$table_pre."order_pre_sale where `order_id`=".$v['id']." limit 0,1";
			$pre=$pdo->query($sql,2)->fetch(2);
			if($v['state']==11){
				$v['actual_money']=$pre['deposit'];
			}else{
				$v['actual_money']-=$pre['deposit'];
			}
			
		}else{
			$v['actual_money']-=$v['web_credits_money'];
		}
		
		//$v['actual_money']-=$v['shop_credits_money'];
		$v['actual_money']=sprintf("%.2f",$v['actual_money']);
		$id=$v['id'];
		$deduction=false;
		if(isset($_SESSION['monxin']['username'])){//------------------------------------------------登录用户
			if($_SESSION['monxin']['username']!=$v['buyer']){return false;}
			$sql="select `state`,`money` from ".$pdo->index_pre."recharge where `username`='".$_SESSION['monxin']['username']."' and `for_id`='".$for_id."' order by `state` desc ,`id` desc  limit 0,1";
			$r2=$pdo->query($sql,2)->fetch(2);
			if($r2['state']!=4){continue;}
			
			
			$reason=str_replace('{order_id}','<a href=./index.php?monxin=mall.my_order&search='.$v['out_id'].' target=_blank>'.$v['out_id'].'</a>',self::$language['deduction_order_money_template']);
			$reason=str_replace('{sum_money}',$v['actual_money'],$reason);
				if($v['pre_sale']==1){
					$reason=$v['out_id'].self::$language['order_postfix'].self::$language['order_step_1'].":".$v['actual_money'];
				}
			$deduction=operator_money(self::$config,self::$language,$pdo,$_SESSION['monxin']['username'],'-'.$v['actual_money'],$reason,'mall');
			if(!$deduction){sleep(1);$deduction=operator_money(self::$config,self::$language,$pdo,$_SESSION['monxin']['username'],'-'.$v['actual_money'],$reason,'mall');}
			if(!$deduction){sleep(2);$deduction=operator_money(self::$config,self::$language,$pdo,$_SESSION['monxin']['username'],'-'.$v['actual_money'],$reason,'mall');}
			//if(!$deduction){sleep(3);$deduction=operator_money(self::$config,self::$language,$pdo,$_SESSION['monxin']['username'],'-'.$v['actual_money'],$reason,'mall');}
			//if(!$deduction){sleep(4);$deduction=operator_money(self::$config,self::$language,$pdo,$_SESSION['monxin']['username'],'-'.$v['actual_money'],$reason,'mall');}
			if(!$deduction){echo $_POST['operator_money_err_info'];}
			
			
		}else{//-------------------------------------------------------------------------------------游客用户
			$start_time=time()-84600;
			$sql="select `state`,`money` from ".$pdo->index_pre."recharge where `for_id`='".$for_id."' and `time`>".$start_time." order by `state` desc ,`id` desc  limit 0,1";
			//echo $sql;
			$r2=$pdo->query($sql,2)->fetch(2);
			if($r2['state']==4 && $r2['money']>=$v['actual_money']){
				$deduction=true;
			}else{
				$deduction=false;
			}	
		}
		
		if($deduction===true){//如扣款成功，更新订单状态
			if($v['state']==0){$v['state']=1;}
			if($v['state']==11){$v['state']=12;}
			if($v['state']==13){$v['state']=14;}
			$sql="update ".self::$table_pre."order set `state`='".$v['state']."',`pay_method`='online_payment' where `id`=".$id;
			if($pdo->exec($sql)){
				$sql="update ".self::$table_pre."order_goods set `order_state`='".$v['state']."' where `order_id`=".$id;
				$pdo->exec($sql);
				self::add_shop_buyer($pdo,$v['buyer'],$v['shop_id']);
				$v['pay_method']='online_payment';
				self::decrease_goods_quantity($pdo,self::$table_pre,$v);
				self::order_notice(self::$language,self::$config,$pdo,self::$table_pre,$v);	
				if(self::virtual_auto_delivery(self::$config,self::$language,$pdo,self::$table_pre,$v)){
					$sql="update ".self::$table_pre."order set `state`='2' where `id`=".$id;
					$pdo->exec($sql);
					$sql="update ".self::$table_pre."order_goods set `order_state`='2' where `order_id`=".$id;
					$pdo->exec($sql);
					$v['state']=2;
					self::decrease_goods_quantity($pdo,self::$table_pre,$v);
					$automatic_delivery++;
				}
				if(self::$config['agency']){
					if(!isset($agency)){
						require('./program/agency/agency.class.php');
						$agency=new agency($pdo);		
					}
					$agency->order_complete_pay($pdo,$id);
				}
				if(self::$config['distribution']){
					if(!isset($distribution)){
						require('./program/distribution/distribution.class.php');
						$distribution=new distribution($pdo);		
					}
					$distribution->order_complete_pay($pdo,$id);
				}
				
				$sql="select `username`,`name` from ".self::$table_pre."shop where `id`=".$v['shop_id'];
				$r=$pdo->query($sql,2)->fetch(2);
				$msg=self::$language['im_order_state_1'];
				$msg=str_replace('{shopname}',$r['name'],$msg);
				$msg.='<a href=http://'.self::$config['web']['domain'].'/index.php?monxin=mall.order_admin&search='.$v['out_id'].' target=_blank>http://'.self::$config['web']['domain'].'/index.php?monxin=mall.order_admin&search='.$v['out_id'].'</a>';
				send_im_msg(self::$config,self::$language,$pdo,$v['buyer'],$r['username'],$msg);
				$success_sum++;
			}
		}		
	}
	$css='<style>
body{ background:rgba(247,247,247,1); text-align:center;}
.result_div{ display:inline-block; margin:auto; margin-top:50px; margin-bottom:100px; width:60%; background-color:#fff; padding:50px; border-radius:10px;}
.result_div img{  width:100px;}
.result_div .success{ display:block; font-size:18px; line-height:100px;}
.result_div .act_div{}
.result_div .act_div a{ display:inline-block; vertical-align:top; width:200px; color:#FFF; border-radius:5px; text-decoration:none; line-height:30px;}
.result_div .act_div a:hover{ opacity:0.8;}
.result_div .act_div a:nth-child(odd){background:rgba(0,132,233,1); margin-right:50px;}
.result_div .act_div a:nth-child(even){background:rgba(28,180,103,1); margin-left:50px;}
</style>';
	if($_COOKIE['monxin_device']=='phone'){
		$css='<style>
body{ background:rgba(247,247,247,1); text-align:center;}
.result_div{ display:inline-block; margin:auto; margin-top:50px; margin-bottom:100px; width:60%; background-color:#fff; padding:50px; border-radius:10px;}
.result_div img{  width:100px;}
.result_div .success{ display:block; font-size:18px; line-height:100px;}
.result_div .act_div{ text-align:center;}
.result_div .act_div a{ display:block; margin:auto; width:200px; color:#FFF; border-radius:5px; text-decoration:none; line-height:30px; margin-bottom:20px;}
.result_div .act_div a:hover{ opacity:0.8;}
.result_div .act_div a:nth-child(odd){background:rgba(0,132,233,1); }
.result_div .act_div a:nth-child(even){background:rgba(28,180,103,1); }
</style>';
	
	}

	echo $css;
	if($success_sum>0){
		echo '<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />';
		if($automatic_delivery>0){
			if(isset($_SESSION['monxin']['username'])){
				echo "<body><div class=result_div><img src='./program/mall/img/pay_success.png' /><span class=success>".self::$language['pay_success'].",".self::$language['have_automatic_delivery']."</span> <div class=act_div><a href='/index.php?monxin=mall.my_order&id=".$id."' target=_blank>".self::$language['view']."</a></div></div></body>"; exit;return false; 
			}else{
				echo "<body><div class=result_div><img src='./program/mall/img/pay_success.png' /><span class=success>".self::$language['pay_success'].",".self::$language['have_automatic_delivery']."</span> </div></body>"; exit;return false; 
			}				
		}
			
		if(isset($_SESSION['monxin']['username'])){
			echo "<body><div class=result_div><img src='./program/mall/img/pay_success.png' /><span class=success>".self::$language['pay_success']."</span> <div class=act_div><a href='./index.php'>".self::$language['go_home']."</a><a href='/index.php?monxin=mall.my_order&id=".$id."' target=_blank>".self::$language['view']."</a></div></div></body>"; exit;return false; 
		}else{
			echo "<body><div class=result_div><img src='./program/mall/img/pay_success.png' /><span class=success>".self::$language['pay_success']."</span> <div class=act_div><a href='./index.php' style=' margin-right:0px;'>".self::$language['go_home']."</a></div></div></body>"; exit;return false; 
		}	
		
	}else{
		$sql="select `id` from ".$pdo->index_pre."recharge where `for_id`='".$for_id."' limit 0,1";
		$v=$pdo->query($sql,2)->fetch(2);
		$operation=' <a href='.$v['id'].' class=inquiries_pay_state>'.self::$language['inquiry'].'</a> <span id=state_'.$v['id'].'></span>';	
		echo '<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />';
		echo "<script>
		location.reload();
		function inquiries_pay_state(v){
			if(v.state=='success'){
				location.reload();
			}else{
				alert('".self::$language['fail']."');
			}	
}</script>";
		if(isset($_SESSION['monxin']['username'])){
			echo "<div align='center' style='line-height:100px;font-size:20px; font-weight:bold;'><span class=fail>".self::$language['pay_fail']."</span> ".$operation." <a href='/index.php?monxin=mall.my_order&id=".$id."' target=_blank style='display:none;'>".self::$language['view']."</a></div>"; return false; 
		}else{
			echo "<div align='center' style='line-height:100px;font-size:20px; font-weight:bold;'><span class=fail>".self::$language['pay_fail']."</span> ".$operation."</div>"; return false; 
		}	
	}
}	

//==================================================================================================================================【在线支付 返回 end】
	
	
	


$module['pay_time_limit']=self::get_pay_time_limit(self::$language,self::$config['pay_time_limit'],$module['data']['add_time']);

$module['address']=self::get_receiver_address($pdo,self::$table_pre,$module['data']['receiver_id']);
//self::$config['pay_method_sequence']=sort(self::$config['pay_method_sequence']);
arsort(self::$config['pay_method_sequence']);
$module['pay_method_option']='';
foreach(self::$config['pay_method_sequence'] as $k=>$v){
	$sub='';
	if($k=='cash' || $k=='credit' || $k=='online_payment'){continue;}
	if(!self::$config['pay_method'][$k]){continue;}
	switch($k){
		case 'balance':
			if(self::$config['pay_mode']!='money'){continue;}
			if(!isset($_SESSION['monxin']['username'])){continue;}
			$sql="select `money` from ".$pdo->index_pre."user where `id`='".$_SESSION['monxin']['id']."'";
			$r=$pdo->query($sql,2)->fetch(2);
			$module['user_money']=$r['money']==''?0:$r['money'];
			
			$module['user_money']=sprintf("%.2f",$module['user_money']);
			$order['actual_money']=sprintf("%.2f",$order['actual_money']);
			if($module['user_money']<floatval($order['actual_money'])){
				$module['balance_act']='<div class=recharge_div><span class=m_label>'.self::$language['insufficient_balance'].'</span> <a href=./index.php?monxin=index.recharge&money='.$order['actual_money'].' target="_blank">'.self::$language['click'].self::$language['recharge'].'</a></div>';
			}else{
				$balance_pay_check='';
				switch(self::$config['web']['balance_pay_check']){
					case 'code':
						$balance_pay_check='<div class=line><span class="m_label">'.self::$language['authcode'].':</span><span class=value id="authcode_box"><input type="text" name="authcode" id="authcode" size="8" style="vertical-align:middle;" /> <span id=authcode_state></span> <a href=# class=get_verification_code>'.self::$language['get_verification_code'].'</a> <span class=state></span></span></div>';
						break;
					case 'password':
						$balance_pay_check='<div class=line><span class="m_label">'.self::$language['transaction_password'].':</span><span class=value id="authcode_box"><input type="password" name="authcode" id="authcode" size="12" style="vertical-align:middle;" /> <span id=authcode_state></span></div>';
						break;
							
				}
				$module['balance_act']='
				 <div class=line><span class=m_label>'.self::$language['need_to_pay'].':</span><span class=value>'.$order['actual_money'].'<span class=unit>'.self::$language['yuan_2'].'</span></span></div>
				'.$balance_pay_check.'
				<div class=line><span class="m_label">&nbsp;</span><span class=value><a href="#" class=submit>'. self::$language['confirm_pay'].'</a> <span class=state></span></span></div>
				';	
			}
			$module['pay_method_option'].='<a href="'.$k.'" id="'.$k.'">'.self::$language['pay_method'][$k].'</a><div></div>';
				
			break;
		case 'credits':
			if(self::$config['pay_mode']!='credits'){continue;}
			if(!isset($_SESSION['monxin']['username'])){continue;}
			$sql="select `credits` from ".$pdo->index_pre."user where `id`='".$_SESSION['monxin']['id']."'";
			$r=$pdo->query($sql,2)->fetch(2);
			$module['user_credits']=$r['credits']==''?0:$r['credits'];
			
			$module['user_credits']=sprintf("%.2f",$module['user_credits']);
			$module['data']['actual_money']=sprintf("%.2f",$module['data']['actual_money']);
			if($module['user_credits']<floatval($module['data']['actual_money'])){
				$module['credits_act']='<div class=recharge_div><span class=m_label>'.self::$language['insufficient_credits'].'</span> <a href=./index.php?monxin=index.recharge_credits&money='.$module['data']['actual_money'].' target="_blank">'.self::$language['click'].self::$language['recharge'].'</a></div>';
			}else{
				$balance_pay_check='';
				switch(self::$config['web']['balance_pay_check']){
					case 'code':
						$balance_pay_check='<div class=line><span class="m_label">'.self::$language['authcode'].':</span><span class=value id="authcode_box"><input type="text" name="authcode" id="authcode" size="8" style="vertical-align:middle;" /> <span id=authcode_state></span> <a href=# class=get_verification_code>'.self::$language['get_verification_code'].'</a> <span class=state></span></span></div>';
						break;
					case 'password':
						$balance_pay_check='<div class=line><span class="m_label">'.self::$language['transaction_password'].':</span><span class=value id="authcode_box"><input type="password" name="authcode" id="authcode" size="12" style="vertical-align:middle;" /> <span id=authcode_state></span></div>';
						break;
							
				}
				
				
				$module['credits_act']='
				 <div class=line><span class=m_label>'.self::$language['need_to_pay'].':</span><span class=value>'.$module['data']['actual_money'].'<span class=unit>'.self::$language['yuan'].'</span></span></div>
				'.$balance_pay_check.'
				<div class=line><span class="m_label">&nbsp;</span><span class=value><a href="#" class=submit>'. self::$language['confirm_pay'].'</a> <span class=state></span></span></div>
				';	
			}
			$module['pay_method_option'].='<a href="'.$k.'" id="'.$k.'">'.self::$language['pay_method'][$k].'</a><div></div>';
				
			break;
		default :
			$module['pay_method_option'].='<a href="'.$k.'" id="'.$k.'">'.self::$language['pay_method'][$k].'</a><div></div>';
			break;
			
	}
	
}


$dir="./payment/";
$r=scandir($dir);
$online='';

foreach($r as $v){
	if(is_dir($dir.$v) && $v!='.' && $v!='..'){
		$config=require($dir.$v.'/config.php');
		if(!isset($config['for'])){$config['for']='pc';}
		if($config['state']=='opening' && $config['for']==$_COOKIE['monxin_device']){
			$online.="<a href=# payment=".$v." class='payment'><img src='".$dir.$v."/icon.png' alt='".$config['provider_name']."' title='".$config['provider_name']."'>".$config['provider_name']."</a>";
		}
	}
}



$module['online']=$online;		



$module['bank_transfer']=str_replace("\r\n","<br/>",file_get_contents('./payment/offline.php'));
$module['pay_info']=file_get_contents('./payment/pay_info.php');
$module['cash_on_delivery']=str_replace("\r\n","<br/>",file_get_contents('./program/mall/cash_on_delivery.txt'));


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);

echo '<div style="display:none;" id="visitor_position_append">'.self::$language['pages']['mall.pay']['name'].'</div>';
require "./plugin/html4Upfile/createHtml4.class.php";
