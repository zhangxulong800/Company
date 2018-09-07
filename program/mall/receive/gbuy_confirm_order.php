<?php
$act=@$_GET['act'];
$g_l=require('./program/gbuy/language/chinese_simplified.php');
if(!isset($_SESSION['monxin']['username'])){
	exit('<script>window.location.href="./index.php?monxin=index.login&relaod="+ Math.round(Math.random()*100);</script>');
}


if($act=='submit'){
	$g_id=intval($_GET['id']);
	$s_id=intval($_GET['s_id']);
	$group=intval($_GET['group']);
	//var_dump($group);
	
	$sql="select * from ".$pdo->sys_pre."gbuy_goods where `g_id`=".$g_id." limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail'].' id '.self::$language['not_exist']."</span>'}");}
	if($r['state']!=1){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail'].' '.$g_l['goods_state_option'][$r['state']]."</span>'}");}
	if($r['start_time']>time()){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail'].' '.$g_l['gbuy_no_start']."</span>'}");}
	if($r['end_time']+$r['hour']*3600<time()){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." ".$g_l['gbuy_end']."</span>'}");}
	
	if($group==0){
		$sql="insert into ".$pdo->sys_pre."gbuy_group (`b_id`,`g_id`,`username`,`price`,`quantity`,`start`,`earn`) values ('".$r['id']."','".$r['g_id']."','".$_SESSION['monxin']['username']."','".$r['price']."',0,'".time()."','".$r['earn']."')";
		$pdo->exec($sql);
		$group=$pdo->lastInsertId();
		
	}else{
		$sql="select * from ".$pdo->sys_pre."gbuy_group where `id`=".$group;
		$gr=$pdo->query($sql,2)->fetch(2);
		if($gr['quantity']>=$r['number']){
			exit("{'state':'fail','info':'<span class=fail>".self::$language['group_full']."</span>'}");
		}
	}
	
	$sql="select * from ".$pdo->sys_pre."mall_goods where `id`=".$r['g_id'];
	$g=$pdo->query($sql,2)->fetch(2);
	if($g['id']==''){echo '<div class=return_false>goods '.self::$language['not_exist'].'</div>';return false;}
	if($g['option_enable']==1){
		$sql="select * from ".$pdo->sys_pre."mall_goods_specifications where `id`=".$_GET['s_id'];
		$v4=$pdo->query($sql,2)->fetch(2);
		$g['title']=$g['title'].' '.$v4['color_name'].' '.self::get_type_option_name($pdo,$v4['option_id']);
		
	}
		
	$sql="insert into ".$pdo->sys_pre."gbuy_order (`b_id`,`g_id`,`gr_id`,`username`,`price`,`time`,`receiver_id`,`s_id`,`g_title`) values ('".$r['id']."','".$r['g_id']."','".$group."','".$_SESSION['monxin']['username']."','".$r['price']."','".time()."','".intval($_GET['receiver'])."','".intval($_GET['s_id'])."','".$g['title']."')";
	if($pdo->exec($sql)){
		
		$order_id=$pdo->lastInsertId();
		self::set_order_out_id($pdo,$order_id);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','order_id':'".$order_id."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
	
}

//==================================================================================================================================【查询收货人信息】
if($act=='get_receiver'){
	$id=intval(@$_GET['id']);
	if($id==0){exit('id err');}
	$sql="select * from ".self::$table_pre."receiver where `id`='".$id."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit('id err');}
	$power=false;
	if($r['username']==''){
		if($_SESSION['receiver_id']==$r['id']){$power=true;}
	}else{
		if(@$_SESSION['monxin']['username']==$r['username']){$power=true;}
	}
	$r=de_safe_str($r);
	$top_id=self::get_area_top_id($pdo,$r['area_id']);
	$ids=get_area_parent_ids($pdo,$r['area_id']);
	if($r['post_code']!=''){$r['post_code']='('.$r['post_code'].')';}
	if($r['tag']!=''){$r['tag']='<span class=tag ><span>'.$r['tag'].'</span></span>';}
	echo '<div class=receiver_head><span class=name>'.$r['name'].'</span>'.$r['tag'].'</div>
                        <div class=phone>'.$r['phone'].'</div>
                        <div class=area_id>'.get_area_name($pdo,$r['area_id']).'</div>
                        <div class=detail>'.$r['detail'].$r['post_code'].'</div>
						<div class=edit>'.self::$language['edit'].'</div>
						<div class=top_id>'.$top_id.'</div>
						<div class=ids>'.$ids.'</div>
						';
	exit;	
}

