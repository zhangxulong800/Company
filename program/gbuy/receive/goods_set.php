<?php
$act=@$_GET['act'];
if($act=='set'){
	$id=intval(@$_GET['id']);
	if($id==0){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}

	$_POST=safe_str($_POST);
	foreach($_POST as $k=>$v){
		if($v==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'".$k."'}");}	
	}
	
	if(@$_POST['start_time']==''){exit("{'state':'fail','info':'<span class=fail>start_time is null</span>','id':'start_time'}");}
	if(@$_POST['end_time']==''){exit("{'state':'fail','info':'<span class=fail>end_time is null</span>','id':'end_time'}");}
	$start_time=get_unixtime($_POST['start_time'],self::$config['other']['date_style']);
	$end_time=get_unixtime($_POST['end_time'],self::$config['other']['date_style'])+86399;
	if($end_time<=$start_time){exit("{'state':'fail','info':'<span class=fail>".self::$language['the_end_time_must_be_greater_than_the_start_time']."</span>'}");}
	
	$sql="select * from ".self::$table_pre."goods where `id`=".$id;
	$old=$pdo->query($sql,2)->fetch(2);
	if($old['state']==0){$state=self::$config['goods_state'];}else{$state=$old['state'];}
	
	$o_price=self::get_goods_price($pdo,$old['g_id']);	
		
	$sql="update ".self::$table_pre."goods set `time`='".time()."',`price`='".floatval($_POST['price'])."',`number`='".intval($_POST['number'])."',`hour`='".floatval($_POST['hour'])."',`earn`='".floatval($_POST['earn'])."',`start_time`='".$start_time."',`end_time`='".$end_time."',`state`=".$state." where `id`='".$id."'";

	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

