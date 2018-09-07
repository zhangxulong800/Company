<?php
$id=intval(@$_GET['id']);
if($id==0){echo 'id err';return false;}
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&id=".$id;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$sql="select * from ".self::$table_pre."content where `id`=".$id;
$c=$pdo->query($sql,2)->fetch(2);
if($c['username']=='' || $c['username']!=$_SESSION['monxin']['username']){echo 'id err';return false;}
$time=time();
if($c['top_end']>$time){
	$list=self::$language['have_set_top_promotion'];
	$list=str_replace('{price}',$c['top_price_spare'],$list);
	$list=str_replace('{time}',date("Y-m-d H:i",$c['top_start']).' '.self::$language['to'].' '.date('Y-m-d H:i',$c['top_end']),$list);
	echo '<div style="padding-left:100px;padding-top:100px;">'.$list.'</div>';
	return false;	
}

$sql="select `id` from  ".self::$table_pre."user where `username`='".$_SESSION['monxin']['username']."'";
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']==''){
	$sql="insert into ".self::$table_pre."user (`username`) values ('".$_SESSION['monxin']['username']."')";
	$pdo->exec($sql);	
}

$module['info']=str_replace('{v}','<b class=type>'.self::get_type_position($pdo,$c['type']).'</b>',self::$language['top_ad_info']);
$sql="select `money` from ".$pdo->index_pre."user where `username`='".$_SESSION['monxin']['username']."'";
$r=$pdo->query($sql,2)->fetch(2);
$module['balance']=self::$language['available_balance']." : <b class=balance>".$r['money']."</b> ".self::$language['yuan']." <a href=./index.php?monxin=index.recharge target=_blank>".self::$language['recharge']."</a>";
$module['top_min_price']=self::$config['top_min_price'];
$module['list']='
<div class=day_option value=1><input type=radio id=day_1 name=promotion_duration /><m_label for=day_1>1'.self::$language['day'].'</m_label></div>
<div class=day_option value=3><input type=radio id=day_3 name=promotion_duration /><m_label for=day_3>3'.self::$language['day'].' '.self::$language['add_give'].self::$config['give_3'].self::$language['hour'].'</m_label></div>
<div class=day_option value=7><input type=radio id=day_7 name=promotion_duration /><m_label for=day_7>7'.self::$language['day'].' '.self::$language['add_give'].self::$config['give_7'].self::$language['hour'].'</m_label></div>
<div class=day_option value=15><input type=radio id=day_15 name=promotion_duration /><m_label for=day_15>15'.self::$language['day'].' '.self::$language['add_give'].self::$config['give_15'].self::$language['hour'].'</m_label></div>
<div class=day_option value=30><input type=radio id=day_30 name=promotion_duration /><m_label for=day_30>30'.self::$language['day'].' '.self::$language['add_give'].self::$config['give_30'].self::$language['hour'].'</m_label></div>

';
$module['time']=date('Y-m-d H:i',time()+60);

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
