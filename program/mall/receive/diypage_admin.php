<?php
$act=@$_GET['act'];

$id=intval(@$_GET['id']);
if($act=='update_visible'){
	$_GET['visible']=intval(@$_GET['visible']);
	$sql="update ".self::$table_pre."diypage set `visible`='".$_GET['visible']."' where `id`='$id' and `shop_id`=".SHOP_ID;	
	$pdo->exec($sql);
	exit();
}
if($act=='update'){
	$time=time();
	$_GET['title']=safe_str(@$_GET['title']);
	$sql="update ".self::$table_pre."diypage set `title`='".$_GET['title']."',`time`='$time' where `id`='$id' and `shop_id`=".SHOP_ID;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='del'){
	$sql="select `content`,`creater` from ".self::$table_pre."diypage where `id`='$id' and `shop_id`=".SHOP_ID;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['creater']=='monxin'){exit("{'state':'fail','info':'<span class=fail>".self::$language['can_not_be_deleted']."</span>'}");}

	$sql="delete from ".self::$table_pre."diypage where `id`='$id' and `shop_id`=".SHOP_ID;
	if($pdo->exec($sql)){
		$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
		$imgs=get_match_all($reg,$r['content']);
		//var_dump($imgs);
		reg_attachd_img("del",self::$config['class_name'],$imgs,$pdo);	
					
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='del_select_STOP'){
	$ids=@$_GET['ids'];
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$ids=explode("|",$ids);
	$ids=array_filter($ids);
	$success='';
	foreach($ids as $id){
		$id=intval($id);
		$sql="select `content` from ".self::$table_pre."diypage where `id`='$id' and `shop_id`=".SHOP_ID;
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="delete from ".self::$table_pre."diypage where `id`='$id' and `shop_id`=".SHOP_ID;
		if($pdo->exec($sql)){
			$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
			$imgs=get_match_all($reg,$r['content']);
			reg_attachd_img("del",self::$config['class_name'],$imgs,$pdo);				
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
if($act=='operation_visible'){
	$ids=@$_GET['ids'];
	$_GET['visible']=intval(@$_GET['visible']);
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$ids=str_replace("|",",",$ids);
	$ids=trim($ids,",");
	$ids=explode(",",$ids);
	$ids=array_map('intval',$ids);
	$temp='';
	foreach($ids as $id){
		$temp.=$id.",";	
	}
	$ids=trim($temp,","); 
	$sql="update ".self::$table_pre."diypage set `visible`='".$_GET['visible']."' where `id` in ($ids) and `shop_id`=".SHOP_ID;
	$pdo->exec($sql);
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>'}");
}

if($act=='submit_select'){
	//var_dump($_POST);	
	$time=time();
	$editor=$_SESSION['monxin']['id'];
	$success='';
	foreach($_POST as $v){
		$v['id']=intval($v['id']);
		$v['title']=safe_str($v['title']);
		$sql="update ".self::$table_pre."diypage set `title`='".$v['title']."',`time`='$time' where `id`='".$v['id']."' and `shop_id`=".SHOP_ID;
		if($pdo->exec($sql)){$success.=$v['id']."|";}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}