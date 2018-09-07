<?php
$act=@$_GET['act'];
if($act=='get_position_name'){
	$v=get_gps_position($_POST['v'],self::$config['web']['map_secret']);
	exit($v);
}
if($act=='add'){
	$_POST=safe_str($_POST);
	foreach($_POST as $k=>$v){
		if($v=='' && $k!='tag' && $k!='post_code' && $k!='area_id'){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'".$k."'}");}	
	}
	if(!isset($_SESSION['monxin']['username']) && strtolower(@$_POST['authcode'])!=strtolower($_SESSION["authCode"])){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['authcode_err']."</span>','id':'authcode'}");
	}
	
	$_POST['area_id']=intval($_POST['area_id']);
	//if($_POST['area_id']==0){exit("{'state':'fail','info':'<span class=fail>".self::$language['please_select']."</span>','id':'area_id'}");}
	$sql="select `id` from ".$pdo->index_pre."area where `id`='".$_POST['area_id']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	//if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>area_id err</span>','id':'area_id'}");}
		
	if(!preg_match(self::$config['other']['reg_phone'],$_POST['phone'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['phone'].self::$language['pattern_err']."</span>','id':'phone'}");}
	
	if(@$_POST['post_code']!=''){
		if(!preg_match('/^[0-9]{6}$/',$_POST['post_code'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['pattern_err']."</span>','id':'post_code'}");}
	}
	if(!isset($_SESSION['monxin']['username'])){$username='';}else{$username=$_SESSION['monxin']['username'];}
	$sql="insert into ".self::$table_pre."receiver (`username`,`time`,`area_id`,`detail`,`post_code`,`name`,`phone`,`tag`) values ('".$username."','".time()."','".intval($_POST['area_id'])."','".$_POST['detail']."','".intval($_POST['post_code'])."','".$_POST['name']."','".$_POST['phone']."','".$_POST['tag']."')";
	
	if($pdo->exec($sql)){
		$insret_id=$pdo->lastInsertId();
		$_SESSION['receiver_id']=$insret_id;
		setcookie("receiver_id",$insret_id);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

