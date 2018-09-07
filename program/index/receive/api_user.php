<?php
foreach($_GET as $key=>$v){
	if($v==''){exit("{'state':'fail','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>','id':'".$key."'}");}
}
$act=@$_GET['act'];


if($act=='state'){
	$state=intval(@$_POST['state']);
	$id=intval(@$_POST['id']);
	$sql="update ".$pdo->sys_pre."api_user set `state`='".$state."' where `id`=".$id;
	file_put_contents('t.txt',$sql);
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='pass'){
	$api=safe_str(@$_POST['api']);
	$id=intval(@$_POST['id']);
	$sql="select * from ".$pdo->sys_pre."api_user where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);	
	$sql="update ".$pdo->sys_pre."api_user set `api_power`='".$r['api_power'].",".$api."',`application`='".str_replace(','.$api,'',$r['application'])."' where `id`=".$r['id'];
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='unpass'){
	$api=safe_str(@$_POST['api']);
	$id=intval(@$_POST['id']);
	$sql="select * from ".$pdo->sys_pre."api_user where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>".$username.' '.self::$language['not_exist']."</span>'}");}
	
	$sql="update ".$pdo->sys_pre."api_user set `api_power`='".str_replace(','.$api,'',$r['api_power'])."' where `id`=".$r['id'];
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
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
		$sql="delete from ".$pdo->sys_pre."api_user where `id`='$id'";
		if($pdo->exec($sql)){$success.=$id."|";}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}

if($act=='submit_select'){
	$success='';
	$ids=str_replace('|',',',$_POST['ids']);
	$target=$_POST['target'];
	$ids=trim($ids,',');
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
	
	if($target==1 || $target==0){
		$sql="update ".$pdo->sys_pre."api_user set `state`=".$target." where `id` in (".$ids.")";
		if($pdo->exec($sql)){
			exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
	}else{
		$ids=explode(',',$ids);
		foreach($ids as $id){
			if($id==''){continue;}
			$sql="select * from ".$pdo->sys_pre."api_user where `id`=".$id;
			$r=$pdo->query($sql,2)->fetch(2);	
			$sql="update ".$pdo->sys_pre."api_user set `api_power`='".$r['api_power'].",".$r['application']."',`application`='' where `id`=".$r['id'];
			$pdo->exec($sql);
			exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
		}
	}
	
}

