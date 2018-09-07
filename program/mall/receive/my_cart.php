<?php
$act=@$_GET['act'];
if($act=='move_to_favorites'){
	$goods_id=@$_GET['goods_id'];
	$goods_id=str_replace('tr_','',$goods_id);
	$goods_id=explode('_',$goods_id);
	$goods_id=intval($goods_id[0]);
	if($goods_id==0){exit("{'state':'fail','info':'<span class=fail>goods id err</span>'}");}
	$sql="select `id` from ".self::$table_pre."favorite where `goods_id`='".$goods_id."' and `username`='".$_SESSION['monxin']['username']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	$time=time();
	if($r['id']!=''){
		$sql="update ".self::$table_pre."favorite set `time`='".$time."' where `goods_id`='".$goods_id."' and `username`='".$_SESSION['monxin']['username']."'";	
	}else{
		$sql="insert into ".self::$table_pre."favorite (`goods_id`,`username`,`time`) values ('".$goods_id."','".$_SESSION['monxin']['username']."','".$time."')";	
	}
	//echo $sql;
	if($pdo->exec($sql)){
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
	
}

if($act=='selected_move_to_favorites'){
	if(!isset($_SESSION['monxin']['username'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['please_login']."</span>'}");}
	$ids=@$_POST['ids'];
	if($ids==0){exit("{'state':'fail','info':'<span class=fail>goods id err</span>'}");}
	$ids=explode('|',$ids);
	foreach($ids as $goods_id){
		$goods_id=explode('_',$goods_id);
		$goods_id=intval($goods_id[0]);
		if($goods_id==0){continue;}
		$sql="select `id` from ".self::$table_pre."favorite where `goods_id`='".$goods_id."' and `username`='".$_SESSION['monxin']['username']."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		$time=time();
		if($r['id']!=''){
			$sql="update ".self::$table_pre."favorite set `time`='".$time."' where `goods_id`='".$goods_id."' and `username`='".$_SESSION['monxin']['username']."'";	
		}else{
			$sql="insert into ".self::$table_pre."favorite (`goods_id`,`username`,`time`) values ('".$goods_id."','".$_SESSION['monxin']['username']."','".$time."')";	
		}
		$pdo->exec($sql);
	}
	
	//echo $sql;
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	
}

