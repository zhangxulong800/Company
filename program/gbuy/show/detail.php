<?php
self::close_overtime_order($pdo);
$group=intval(@$_GET['group']);
$order_id=intval(@$_GET['order_id']);

$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$sql="select * from ".self::$table_pre."group where `id`=".$group;
$gr=$pdo->query($sql,2)->fetch(2);
if($gr['id']==''){echo '<script>alert("'.self::$language['not_exist'].'");window.location.href="./index.php?monxin=gbuy.list";</script>';}
$module['data']=$gr;
$sql="select `id`,`icon`,`title` from ".$pdo->sys_pre."mall_goods where `id`=".$gr['g_id']."";
$goods=$pdo->query($sql,2)->fetch(2);
$sql="select `hour`,`number` from ".self::$table_pre."goods where `id`=".$gr['b_id'];
$b=$pdo->query($sql,2)->fetch(2);
$module['goods_info']="<div class=goods>
	<div class=g_left><img src='./program/mall/img_thumb/".$goods['icon']."' /></div><div class=g_right>
		<a class=g_title href=./index.php?monxin=mall.gbuy_goods&id=".$gr['g_id']."&gid=".$gr['b_id']."&group=".$group.">".$goods['title']."</a>
		<div class=price>".self::$language['money_symbol'].$gr['price']."</div>
	</div>";

$module['count_down']=(($gr['start']+($b['hour']*3600))-time());
$module['state_notice']='';
$module['act']='<a href=./index.php?monxin=gbuy.list>'.self::$language['view_gbuy_list'].'</a>';
$join=false;
if($gr['state']==1){
	
	if(isset($_SESSION['monxin']['username'])){
		$sql="select `id`,`state` from ".self::$table_pre."order where `gr_id`=".$gr['id']." and `username`='".$_SESSION['monxin']['username']."' limit 0,1";
		$o=$pdo->query($sql,2)->fetch(2);
		
		if($o['id']!=''){
			if($o['state']==0){header("location:./index.php?monxin=gbuy.pay&id=".$o['id']);exit;}
			$module['state_notice']=self::$language['still_poor'];		
			$module['state_notice']='<div class=count_down></div>'.str_replace('{n}','<b>'.($b['number']-$gr['quantity']).'</b>',$module['state_notice']);
			$module['act']="<a class=inviting_friends>".self::$language['inviting_friends']."</a>";
		}
	}
	if($module['state_notice']==''){
		$module['state_notice']=self::$language['still_poor_2'];
		$module['state_notice']=str_replace('{n}','<b>'.($b['number']-$gr['quantity']).'</b>',$module['state_notice']);
		$module['state_notice']=str_replace('{time}','<i class=count_down></i>',$module['state_notice']);
		$module['act']="<a class=join_gbuy href='./index.php?monxin=mall.gbuy_goods&id=".$gr['g_id']."&gid=".$gr['b_id']."&group=".$gr['id']."'>".self::$language['join_gbuy']."</a>";
		
	}
	
}else{
	$module['state_notice']=self::$language['group_state_option'][$gr['state']];
}
if($gr['state']==3){$module['state_notice']=self::$language['gbuy_end'];}

$module['group_list']=self::get_gbuy_group_show($pdo,$gr['id']);

$module['qr_data']=self::$config['web']['protocol'].'://'.self::$config['web']['domain'].'/index.php?monxin=gbuy.detail|||group='.$gr['id'];

$module['invitation']=self::$language['invitation_default'];
$module['invitation']=str_replace('{v}',$gr['price'],$module['invitation']);


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
