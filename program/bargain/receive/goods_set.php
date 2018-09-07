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
	$t=$o_price-floatval($_POST['final_price']);
	$quantity=$t/((floatval($_POST['min_money'])+floatval($_POST['max_money']))/2);
		
	$sql="update ".self::$table_pre."goods set `time`='".time()."',`final_price`='".floatval($_POST['final_price'])."',`min_money`='".floatval($_POST['min_money'])."',`max_money`='".floatval($_POST['max_money'])."',`type`='".intval($_POST['type'])."',`hour`='".floatval($_POST['hour'])."',`invitation`='".$_POST['invitation']."',`start_time`='".$start_time."',`end_time`='".$end_time."',`state`=".$state.",`new`='".intval($_POST['new'])."',`method`='".intval($_POST['method'])."',`quantity`=".$quantity." where `id`='".$id."'";

	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

