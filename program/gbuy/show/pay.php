<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$id=intval(@$_GET['id']);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&id=".$id;
if(!isset($_SESSION['monxin']['username'])){
	exit('<script>window.location.href="./index.php?monxin=index.login&relaod="+ Math.round(Math.random()*100);</script>');
}


//==========================================================================================================================【在线支付 返回 start】
if(@$_GET['act']=='online_payment'){
	
	$success_sum=0;
	$sql="select * from ".self::$table_pre."order where id=".$id;
	$r=$pdo->query($sql,2);

	foreach($r as $v){
		//if(isset($_SESSION['monxin']['username'])){//------------------------------------------------登录用户
			if($_SESSION['monxin']['username']!=$v['username']){return false;}
			$or=$v;
			$sql="select `state`,`money` from ".$pdo->index_pre."recharge where `username`='".$_SESSION['monxin']['username']."' and `for_id`='".$v['id']."' order by `state` desc ,`id` desc  limit 0,1";
			$r2=$pdo->query($sql,2)->fetch(2);
			if($r2['state']!=4){continue;}
			
			
			$reason=str_replace('{order_id}','<a href=./index.php?monxin=gbuy.my_buy&search='.$v['out_id'].' target=_blank>'.$v['out_id'].'</a>',self::$language['deduction_order_money_template']);
			$reason=str_replace('{sum_money}',$v['price'],$reason);
			$deduction=operator_money(self::$config,self::$language,$pdo,$_SESSION['monxin']['username'],'-'.$v['price'],$reason,'mall');
			if(!$deduction){sleep(1);$deduction=operator_money(self::$config,self::$language,$pdo,$_SESSION['monxin']['username'],'-'.$v['price'],$reason,'mall');}
			if(!$deduction){sleep(2);$deduction=operator_money(self::$config,self::$language,$pdo,$_SESSION['monxin']['username'],'-'.$v['price'],$reason,'mall');}
			if(!$deduction){echo $_POST['operator_money_err_info'];}
			
			
		//}
		
		if($deduction===true){//如扣款成功，更新订单状态
			$v['state']=1;
			$sql="update ".self::$table_pre."order set `state`='".$v['state']."' where `id`=".$id;
			if($pdo->exec($sql)){
				self::update_order_group($pdo,$id,self::$config,self::$language);
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
.result_div{ display:block; margin:auto; margin-top:50px; margin-bottom:100px; width:60%; margin-left:10%; background-color:#fff; padding:50px; border-radius:10px;text-align:center;}
.result_div img{ display:block;  width:100px;margin:auto;}
.result_div .success{ display:block; width:100%; font-size:18px; line-height:100px;text-align:center;}
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

			
		if(isset($_SESSION['monxin']['username'])){
			echo "<body><div class=result_div><img src='./program/mall/img/pay_success.png' /><span class=success>".self::$language['pay_success']."</span> <div class=act_div><a href='/index.php?monxin=gbuy.my_buy&id=".$id."' target=_blank>".self::$language['view'].self::$language['orders']."</a><a href='/index.php?monxin=gbuy.detail&group=".$or['gr_id']."' target=_blank>".self::$language['share_other']."</a></div></div></body>"; exit;return false; 
		}else{
			echo "<body><div class=result_div><img src='./program/mall/img/pay_success.png' /><span class=success>".self::$language['pay_success']."</span> <div class=act_div><a href='./index.php' style=' margin-right:0px;'>".self::$language['go_home']."</a></div></div></body>"; exit;return false; 
		}	
		
	}else{
		$sql="select `id` from ".$pdo->index_pre."recharge where `for_id`='".$v['id']."' limit 0,1";
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
			echo "<div align='center' style='line-height:100px;font-size:20px; font-weight:bold;'><span class=fail>".self::$language['pay_fail']."</span> ".$operation." <a href='/index.php?monxin=gbuy.my_buy&id=".$id."' target=_blank style='display:none;'>".self::$language['view']."</a></div>"; return false; 
		}else{
			echo "<div align='center' style='line-height:100px;font-size:20px; font-weight:bold;'><span class=fail>".self::$language['pay_fail']."</span> ".$operation."</div>"; return false; 
		}	
	}
}	

//===========================================================================================================================【在线支付 返回 end】

$module['data']=array();
$sql="select * from ".self::$table_pre."order where `id`=".$id;
$order=$pdo->query($sql,2)->fetch(2);
if($order['id']==''){echo '<div class=return_false>id '.self::$language['not_exist'].'</div>';return false;}
if($order['state']!=0){echo '<div class=return_false>id '.self::$language['order_state_option'][$order['state']].'</div>';return false;}
if($order['username']!=$_SESSION['monxin']['username']){echo '<div class=return_false>'.self::$language['only_my_own_operation'].'</div>';return false;}
$module['data']['price']=$order['price'];

self::set_order_out_id($pdo,$id);
$sql="select * from ".self::$table_pre."goods where `id`=".$order['b_id'];
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']==''){exit("<script>alert('id ".self::$language['not_exist']."');window.location.href='./index.php?monxin=gbuy.list';</script>");}
if($r['state']!=1){exit("<script>alert('".self::$language['goods_state_option'][$r['state']]."');window.location.href='./index.php?monxin=gbuy.list';</script>");}
if($r['start_time']>time()){exit("<script>alert('".self::$language['gbuy_no_start']."');window.location.href='./index.php?monxin=gbuy.list';</script>");}
if($r['end_time']+$r['hour']*3600<time()){exit("<script>alert('".self::$language['gbuy_end']."');window.location.href='./index.php?monxin=gbuy.list';</script>");}



$sql="select * from ".$pdo->sys_pre."gbuy_group where `id`=".$order['gr_id'];
$gr=$pdo->query($sql,2)->fetch(2);
if($gr['quantity']>=$r['number']){
	exit("<script>alert('".$g_l['group_full']."');window.location.href='./index.php?monxin=mall.gbuy_goods&id=".$r['g_id']."&gid=".$r['id']."';</script>");
}

$sql="select `icon` from ".$pdo->sys_pre."mall_goods where `id`=".$order['g_id'];
$g=$pdo->query($sql,2)->fetch(2);


$module['data']['icon']=$g['icon'];
$module['data']['price']=$order['price'];
$module['data']['title']=$order['g_title'];


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
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/phone/'.str_replace($class."::","",$method).'.php';}
require($t_path);

echo '<div style="display:none;" id="visitor_position_append">'.self::$language['pages']['gbuy.pay']['name'].'</div>';
