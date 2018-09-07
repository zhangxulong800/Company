<?php
$act=@$_GET['act'];
$id=intval(@$_GET['id']);
if($act=='set_state'){
	$state=intval(@$_GET['state']);
	if($state!=1 && $state!=2  && $state!=3){exit("{'state':'fail','info':'<span class=fail>state err</span>'}");}
	$sql="select `state` from ".self::$table_pre."content where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	$old_state=$r['state'];
	switch($state){
		case 1:
			if($old_state!=2){exit("{'state':'fail','info':'<span class=fail>state err</span>'}");}
			break;	
		case 2:
			if($old_state!=1){exit("{'state':'fail','info':'<span class=fail>state err</span>'}");}
			break;	
		case 3:
			break;	
	}
	
	$sql="update ".self::$table_pre."content set `state`='".$state."' where `id`='$id' and `username`='".$_SESSION['monxin']['username']."'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span> <a href=javascript:window.location.reload()>".self::$language['refresh'].self::$language['webpage']."</a>','html':'<span class=s_".$state.">".self::$language['info_state'][$state]."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='del_select'){
	$ids=@$_GET['ids'];
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$ids=explode("|",$ids);
	$ids=array_filter($ids);
	$success='';
	foreach($ids as $id){
		$id=intval($id);
		$sql="update ".self::$table_pre."content set `state`=3 where `id`='$id' and `username`='".$_SESSION['monxin']['username']."'";
		if($pdo->exec($sql)){
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
