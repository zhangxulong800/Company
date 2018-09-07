<?php
echo 123;exit;
if(!isset($_GET['id'])){
	$sql="select `id` from ".self::$table_pre."account where `is_web`=1 and `state`=1 order by `sequence` desc limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){header('location:./index.php?monxin=scanpay.pay&id='.$r['id']."&success_fun=".@$_GET['success_fun']);exit;}	
}
$id=intval(@$_GET['id']);
if($id==0){echo 'id err'; return false;}
$sql="select * from ".self::$table_pre."account where `id`='".$id."'";
$module['data']=$pdo->query($sql,2)->fetch(2);
if($module['data']['state']!=1){echo '<div style="line-height:100px; text-align:center">'.self::$language['state'].':'.self::$language['account_state'][$module['data']['state']].'</div>';return false;}
$p_id=intval(@$_GET['p_id']);
if($p_id>0){
	$act='';
	$sql="select * from ".self::$table_pre."pay where `id`=".$p_id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['settlement']==1){header('location:./index.php?monxin=scanpay.pay&id='.$id);exit;}
	if($r['state']==3){
		if($r['success_fun']==''){
			if($module['data']['is_web']){
				$sql="select `username`,`name`,`type` from ".self::$table_pre."account where `id`=".$r['a_id'];
				$account=$pdo->query($sql,2)->fetch(2);
				$reason=self::$language['pages']['scanpay.pay']['name'].':'.$account['name'].'('.self::$language['account_type_option'][$account['type']].')<br />'.$r['reason'];
				$reason=de_safe_str($reason);
				if(operator_money(self::$config,self::$language,$pdo,$account['username'],$r['money'],$reason,'scanpay')){	
					$sql="update ".self::$table_pre."pay set `settlement`=1 where `id`=".$p_id;
					$pdo->exec($sql);
				}	
			}
		}else{
			$success_fun=explode('|',de_safe_str($r['success_fun']));
			switch($success_fun[0]){
				case 'update_recharge':
					if($module['data']['is_web']){
						$success_fun[1]=intval($success_fun[1]);
						$sql="select `money` from ".$pdo->index_pre."recharge where `id`=".$success_fun[1];
						$re=$pdo->query($sql,2)->fetch(2);
						if($re['money']==$r['money']){
							update_recharge($pdo,self::$config,self::$language,$success_fun[1]);
							$sql="update ".self::$table_pre."pay set `settlement`=1 where `id`=".$p_id;
							$pdo->exec($sql);
						}
						$act='<div><a href="./index.php?monxin=index.recharge_log">'.self::$language['view'].'</a></div>';
						
					}
					break;
				case 'parent.scanpay_submit_checkout':
					echo '<script> $(document).ready(function(){parent.scanpay_submit_checkout('.$p_id.');});</script>';return false;
					break;
				default:
								
			}
			
			
		}
	}
	if($r['state']==4){
		$sql="select * from ".self::$table_pre."account where `id`='".$id."'";
		$act='<div><a href="./scanpay_type/'.$module['data']['type'].'/inquiry.php?id='.$id.'&p_id='.$p_id.'">'.self::$language['inquiry'].'</a></div>';
	}
	echo '<div style="line-height:100px; text-align:center;">'.self::$language['pay_state'][$r['state']].$act.'</div>';
	if(isset($_GET['state'])){echo '<script>alert("'.self::$language['pay_state'][$_GET['state']].'");</script>';}
	return false;
}

if(!self::check_pay_power($pdo,$module['data'])){echo '<div style="line-height:100px; text-align:center">'.self::$language['unauthorized_operation'].'</div>';return false;}

$module['data']=de_safe_str($module['data']);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&id=".$id;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['class_name']=self::$config['class_name'];
$module['web_language']=self::$config['web']['language'];

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
if(@$_GET['iframe']=='1'){
	echo '<style>
	.page-header{display:none;}
		.page-content{ background-color:#FFF;}
	.page-footer{ display:none;}
	.fixed_right_div{ display:none; }
	.container{width:100% !important;}

	</style>';
}


