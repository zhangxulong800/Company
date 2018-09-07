<?php
$act=@$_GET['act'];
if($act=='edit'){
	$id=intval(@$_GET['id']);
	if($id==0){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}

	$_POST=safe_str($_POST);
	foreach($_POST as $k=>$v){
		if($v=='' && $k!='tag' && $k!='post_code' && $k!='area_id'){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'".$k."'}");}	
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
	
	$sql="select * from ".self::$table_pre."receiver where `id`='".$id."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
	$power=false;
	if(isset($_SESSION['monxin']['username'])){
		if($_SESSION['monxin']['username']==$r['username']){$power=true;}
	}else{
		if($r['id']==$_SESSION['receiver_id']){$power=true;}
	}
	if(!$power){exit("{'state':'fail','info':'<span class=fail>no power</span>'}");}
		
	$sql="update ".self::$table_pre."receiver set `time`='".time()."',`area_id`='".intval($_POST['area_id'])."',`detail`='".$_POST['detail']."',`post_code`='".intval($_POST['post_code'])."',`name`='".$_POST['name']."',`phone`='".$_POST['phone']."',`tag`='".$_POST['tag']."' where `id`='".$id."'";
	
	if($pdo->exec($sql)){
		$_SESSION['receiver_id']=$id;
		setcookie("receiver_id",$id);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

