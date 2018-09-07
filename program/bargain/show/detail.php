<?php
$id=intval(@$_GET['id']);
if($id==0){echo 'id err';return false;}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&id=".$id."&l=".@$_GET['l'];

$sql="select * from ".self::$table_pre."goods where `id`=".$id." limit 0,1";

$module['data']=$pdo->query($sql,2)->fetch(2);
$gb=$module['data'];
if($module['data']['id']==''){echo 'id err';return false;}
$bargin=$module['data'];
if($bargin['state']!=1){exit("<script>alert('".self::$language['goods_state_option'][$bargin['state']]."');window.location.href='./index.php?monxin=bargain.list';</script>");}
if($bargin['start_time']>time()){exit("<script>alert('".self::$language['bargain_no_start']."');window.location.href='./index.php?monxin=bargain.list';</script>");}
if($bargin['end_time']+$bargin['hour']*3600<time()){exit("<script>alert('".self::$language['bargain_end']."');window.location.href='./index.php?monxin=bargain.list';</script>");}

$sql="update ".self::$table_pre."goods set `view`=`view`+1 where `id`=".$id;
$pdo->exec($sql);

$sql="select * from ".$pdo->sys_pre."mall_goods where `id`=".$bargin['g_id'];
$g=$pdo->query($sql,2)->fetch(2);
if($g['id']==''){header('location:./index.php');exit;}
$module['data']['g_icon']='./program/mall/img_thumb/'.$g['icon'];
$module['normal']=self::get_goods_price($pdo,$g['id']);
$gb['normal']=$module['normal'];


$module['bargain_money']=0;
$module['bargain_times']=0;
$module['bargain_err']='';
if(!isset($_GET['l'])){
	if(isset($_SESSION['monxin']['username'])){
		$sql="select * from ".self::$table_pre."log where `b_id`=".$id." and `username`='".$_SESSION['monxin']['username']."' and `state`=1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){
			$sql="insert into ".self::$table_pre."log (`b_id`,`g_id`,`username`,`start`) values ('".$id."','".$gb['g_id']."','".$_SESSION['monxin']['username']."','".time()."')";
			if($pdo->exec($sql)){
				$insret_id=$pdo->lastInsertId();
				
				header('location:./index.php?monxin=bargain.detail&id='.$id.'&l='.$insret_id);exit;
				
			}else{
				
			}
		}else{
			header('location:./index.php?monxin=bargain.detail&id='.$id.'&l='.$r['id']);exit;
		}
		
		
	}else{
		echo '<script>window.location.href="./index.php?monxin=index.login";</script>';exit;
	}
	
	
}else{
	$l=intval($_GET['l']);
	$sql="select * from ".self::$table_pre."log where `id`=".$l;
	$log=$pdo->query($sql,2)->fetch(2);
	if($log['id']==''){header('location:./index.php?monxin=bargain.detail&id='.$id);exit;}
	$module['buy_url']='./index.php?monxin=mall.confirm_order&goods_src=goods_id&id='.$module['data']['g_id'].'&quantity=1&bargain_log='.$log['id'];
	
	
	if($g['option_enable']){
		$sql="select `id` from ".$pdo->sys_pre."mall_goods_specifications where `goods_id`=".$g['id']." order by `w_price` asc limit 0,1";
		$gs=$pdo->query($sql,2)->fetch(2);
		$module['buy_url']='./index.php?monxin=mall.confirm_order&goods_src=goods_id&id='.$module['data']['g_id'].'&s_id='.$gs['id'].'&quantity=1&bargain_log='.$log['id'];
		
	}
		
	
	$module['act_button']="<div class=execute_bargain_div><a class=execute_bargain>".self::$language['execute_bargain']."</a></div>";
	
	if(isset($_SESSION['monxin']['username'])){
		if(($log['wx_qr']==''  && self::$config['web']['wid']!='') || self::$config['web']['wid']!='gh_7eca8f5d4da0' ){
			get_weixin_info(self::$config['web']['wid'],$pdo); 
			$data='{
					"action_name": "QR_LIMIT_STR_SCENE", 
					"action_info": {
						"scene": {
							"scene_str": "bargain__'.$log['id'].'"
						}
					}
				}';	
			$r= https_post('https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.@$_POST['monxin_weixin'][self::$config['web']['wid']]['token'],$data);
			$r=json_decode($r,1);
			if(isset($r['url'])){
				$sql="update ".self::$table_pre."log set `wx_qr`='".safe_str($r['url'])."' where `id`=".$log['id']."";
				$pdo->exec($sql);
				$log['wx_qr']=safe_str($r['url']);
			}	
		}				
						
		
		
		if($_SESSION['monxin']['username']==$log['username']){
			$module['act_button']="<div class=share_a_div><a class=share_a>".self::$language['share_text']."</a></div>
        <div class=buy_a_div><a class=buy_a>".self::$language['buy']."</a></div>";
		
			if($log['quantity']==0){
				$bargain_money=self::get_bargain_money($pdo,$gb,$log);	
				if($bargain_money>0){
					$sql="insert into ".self::$table_pre."detail (`l_id`,`b_id`,`g_id`,`username`,`time`,`money`,`ip`,`l_username`) values ('".$log['id']."','".$gb['id']."','".$gb['g_id']."','".$_SESSION['monxin']['username']."','".time()."','".$bargain_money."','".get_ip()."','".$log['username']."')";
					if($pdo->exec($sql)){
						$sql="update ".self::$table_pre."log set `quantity`=`quantity`+1,`money`=`money`+".$bargain_money." where `id`=".$log['id'];
						$pdo->exec($sql);
						$module['bargain_money']=$bargain_money;
						$log['money']=$module['bargain_money'];
					}
					
				}
			}
		}else{
			if(isset($_GET['bargain'])){
				if($gb['new']==1){
					$sql="select `id` from ".self::$table_pre."detail where `username`='".$_SESSION['monxin']['username']."' and `l_username`!='".$_SESSION['monxin']['username']."' limit 0,1";
					$r=$pdo->query($sql,2)->fetch(2);
					if($r['id']!=''){
						$module['bargain_times']=1;
						$module['bargain_err']=self::$language['just_new_user_bargain'];
					}
				}else{
					$start_time=time()-86400;
					$sql="select count(`id`) as c from ".self::$table_pre."detail where `username`='".$_SESSION['monxin']['username']."' and `l_username`!='".$_SESSION['monxin']['username']."' and `time`>".$start_time;
					$r=$pdo->query($sql,2)->fetch(2);
					if($r['c']>self::$config['bargain_limit']){
						$module['bargain_times']=$r['c'];
						$module['bargain_err']=self::$language['day_bargain_overrun'];
						$module['bargain_err']=str_replace("{times}",$r['c'],$module['bargain_err']);
					}
					
				}
				
				
				if($module['bargain_times']==0){
					
					$bargain_money=self::get_bargain_money($pdo,$gb,$log);	
					if($bargain_money>0){
						$sql="insert into ".self::$table_pre."detail (`l_id`,`b_id`,`g_id`,`username`,`time`,`money`,`ip`,`l_username`) values ('".$log['id']."','".$gb['id']."','".$gb['g_id']."','".$_SESSION['monxin']['username']."','".time()."','".$bargain_money."','".get_ip()."','".$log['username']."')";
						if($pdo->exec($sql)){
							$sql="update ".self::$table_pre."log set `quantity`=`quantity`+1,`money`=`money`+".$bargain_money." where `id`=".$log['id'];
							$pdo->exec($sql);
							$module['bargain_money']=$bargain_money;
							$log['money']=$module['bargain_money'];
						}
						
					}else{
						$bargain=$gb['normal']-$gb['final_price'];
						if($log['money']>=$bargain){
							$sql="update ".self::$table_pre."log set `state`=3 where `id`=".$log['id']." and `state`=1";
							$pdo->exec($sql);
						}
						
					}
						
					
				}
				
				
			}
		}
	}
	
	
	$module['log_qr']=$log['wx_qr'];
	$module['username']=$log['username'];
	
	$sql="select `icon` from ".$pdo->index_pre."user where `username`='".$log['username']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if(!is_url($r['icon'])){
		if($r['icon']==''){$r['icon']='default.png';}
		$r['icon']="./program/index/user_icon/".$r['icon'];
	}
	$module['u_icon']=$r['icon'];
	if($gb['type']==1){$notice=self::$language['notice_1'];}else{$notice=self::$language['notice_0'];}
	
	$a=$log['money'];
	$b=$module['normal']-$gb['final_price']-$a;
	$module['now_price']=$module['normal']-$log['money'];
	
	$notice=str_replace("{a}","<span class=bargained>".$a."</span>",$notice);
	$notice=str_replace("{b}","<span>".$b."</span>",$notice);
	
	$module['notice']=$notice;
	
	$module['count_down']=($log['start']+$gb['hour']*3600)-time();
	//echo date("Y-m-d",($log['start']+$gb['hour']*3600));
	//echo $module['count_down'];
	//砍价超时
	if($module['count_down']<=0){
		$sql="update ".self::$table_pre."log set `state`=2 where `id`=".$l." and `state`=1";
		$pdo->exec($sql);
	}
	
}


$module['data']=de_safe_str($module['data']);
//$module['data']['type']=self::$language['bargain_type_option'][$module['data']['type']];


$module['data']['goods_price']=self::get_goods_price($pdo,$module['data']['g_id']);

foreach($module['data'] as $k=>$v){
	if($k=='type'){continue;}
	if($v=='0'){$module['data'][$k]='';}
}

	$module['data']['start_time']=get_date($module['data']['start_time'],self::$config['other']['date_style'],self::$config['other']['timeoffset']);
	$module['data']['end_time']=get_date($module['data']['end_time'],self::$config['other']['date_style'],self::$config['other']['timeoffset']);


$module['qr_data']=self::$config['web']['protocol'].'://'.self::$config['web']['domain'].'/index.php?monxin=bargain.detail|||id='.$id;


$sql="select * from ".self::$table_pre."detail where `l_id`=".$log['id']." order by `id` desc";
$r=$pdo->query($sql,2);
$module['log_detail']='';	
foreach($r as $v){
	$sql="select `icon` from ".$pdo->index_pre."user where `username`='".$v['username']."' limit 0,1";
	$u=$pdo->query($sql,2)->fetch(2);
	if(!is_url($u['icon'])){
		if($u['icon']==''){$u['icon']='default.png';}
		$u['icon']="./program/index/user_icon/".$u['icon'];
	}
	
	$module['log_detail'].="<div><span class=b_userinfo><img src='".$u['icon']."' /><span class=buser>".$v['username']."</span></span><span class=bmoney>".self::$language['help_bargain'].self::$language['money_symbol'].$v['money']."</span><span class=btime>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</span></div>";
}
if($log['state']==2){$module['act_button']='';$module['notice']=self::$language['log_state_option'][2];}
if($log['state']==3){$module['act_button']="<div class=buy_a_div><a class=buy_a>".self::$language['buy']."</a></div>";$module['notice']=self::$language['bargain_completed'];}
$module['log_state']=$log['state'];


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);