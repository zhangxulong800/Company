<?php
$pk_id=intval($_GET['pk_id']);
if($pk_id==0){exit("{'state':'fail','info':'<span class=fail>pk_id err</span>'}");}
$sql="select `id`,`name`,`username` from ".self::$table_pre."pk where `id`=".$pk_id;
$pk=$pdo->query($sql,2)->fetch(2);
if($pk['id']==''){exit("{'state':'fail','info':'<span class=fail>pk_id err</span>'}");}
if($pk['username']!=$_SESSION['monxin']['username']){exit("{'state':'fail','info':'<span class=fail>pk_id power err</span>'}");}
foreach($_GET as $key=>$v){
	if($v==''){exit("{'state':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");}
}
$act=@$_GET['act'];
if($act=='add'){
	$_GET['parent']=intval(@$_GET['parent']);
	if($_GET['parent']>0){
		$sql="select count(id) as c from ".self::$table_pre."item where `id`='".$_GET['parent']."' and `pk_id`=".$pk_id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['c']==0){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['parent_not_exist']."'}");}
	}
	$_GET['sequence']=intval(@$_GET['sequence']);
	$_GET['state']=intval(@$_GET['state']);
	$_GET['name']=safe_str(@$_GET['name']);
	$sql="insert into ".self::$table_pre."item (`parent`,`name`,`sequence`,`state`,`pk_id`,`username`) values ('".$_GET['parent']."','".$_GET['name']."','".$_GET['sequence']."','".$_GET['state']."','".$pk_id."','".$_SESSION['monxin']['username']."')";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','id':'".$pdo->lastInsertId()."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='update'){
	$_GET['id']=intval(@$_GET['id']);
	$_GET['parent']=intval(@$_GET['parent']);
	$_GET['sequence']=intval(@$_GET['sequence']);
	$_GET['state']=intval(@$_GET['state']);
	$_GET['name']=safe_str(@$_GET['name']);
	$sql="update ".self::$table_pre."item set `parent`='".$_GET['parent']."',`name`='".$_GET['name']."',`sequence`='".$_GET['sequence']."',`state`='".$_GET['state']."' where `id`='".$_GET['id']."' and `pk_id`=".$pk_id;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
	}
}
if($act=='update_state'){
	$_GET['id']=intval(@$_GET['id']);
	$_GET['state']=intval(@$_GET['state']);
	$sql="update ".self::$table_pre."item set `state`='".$_GET['state']."' where `id`='".$_GET['id']."' and `pk_id`=".$pk_id;
	$pdo->exec($sql);
	exit();
}
if($act=='del'){
	$id=intval(@$_GET['id']);
	if($id<1){exit();}
	$sql="select count(id) as c from ".self::$table_pre."item where `parent`='$id' and `pk_id`=".$pk_id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['have_sub']."'}");}
	
	$sql="delete from ".self::$table_pre."item where `id`='$id' and `pk_id`=".$pk_id;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
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
		$sql="select count(id) as c from ".self::$table_pre."item where `parent`='$id' and `pk_id`=".$pk_id;
		$r=$pdo->query($sql,2)->fetch(2);		
		if($r['c']==0){
			$sql="delete from ".self::$table_pre."item where `id`='$id' and `pk_id`=".$pk_id;
			if($pdo->exec($sql)){$success.=$id."|";}
		}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
if($act=='operation_state'){
	$ids=@$_GET['ids'];
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
	$_GET['state']=intval(@$_GET['state']);
	$sql="update ".self::$table_pre."item set `state`='".$_GET['state']."' where `id` in ($ids) and `pk_id`=".$pk_id;;
	$pdo->exec($sql);
	
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>'}");
}

if($act=='submit_select'){
	$success='';
	foreach($_POST as $v){
		$v['id']=intval($v['id']);
		$v['parent']=intval($v['parent']);
		$v['sequence']=intval($v['sequence']);
		$v['name']=safe_str($v['name']);
		$sql="update ".self::$table_pre."item set `parent`='".$v['parent']."',`name`='".$v['name']."',`sequence`='".$v['sequence']."' where `id`='".$v['id']."' and `pk_id`=".$pk_id;
		if($pdo->exec($sql)){$success.=$v['id']."|";}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}

