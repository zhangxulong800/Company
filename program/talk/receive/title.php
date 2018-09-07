<?php
$type=intval(@$_GET['type']);
if($type==0){exit("{'state':'fail','info':'<span class=fail>".self::$language['lack_params'].':type'."</span>'}");}
$sql="select `manager` from ".self::$table_pre."type where `id`='".$type."' and `visible`=1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['manager']!=$_SESSION['monxin']['username']){exit("{'state':'fail','info':'<span class=fail>".self::$language['act_noPower']."</span>'}");}


$act=@$_GET['act'];
$id=intval(@$_GET['id']);
if($act=='update_visible'){
	
	$_GET['visible']=intval(@$_GET['visible']);
	$sql="update ".self::$table_pre."title set `visible`='".$_GET['visible']."' where `id`='$id'";	
	$pdo->exec($sql);
	self::update_type_sum($pdo,$id);
	exit();
}
if($act=='update'){
	$time=time();
	$editor=$_SESSION['monxin']['id'];
	$_GET['sequence']=intval(@$_GET['sequence']);
	$sql="update ".self::$table_pre."title set `sequence`='".$_GET['sequence']."' where `id`='$id'";
	if($pdo->exec($sql)){
		self::update_type_sum($pdo,$id);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='del'){
	$sql="delete from ".self::$table_pre."title where `id`='$id'";
	
	if($pdo->exec($sql)){
		$sql="select `id` from ".self::$table_pre."content where `title_id`=".$id;
		$r=$pdo->query($sql,2);
		foreach($r as $v){self::del_content($pdo,$v['id'],$type);}		
		self::update_type_sum($pdo,$id,-1);			
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
		$sql="delete from ".self::$table_pre."title where `id`='$id'";
		self::update_type_sum($pdo,$id,-1);
		if($pdo->exec($sql)){
			$sql="select `id` from ".self::$table_pre."content where `title_id`=".$id;
			$r=$pdo->query($sql,2);
			foreach($r as $v){self::del_content($pdo,$id,$type);}					
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
	$sql="update ".self::$table_pre."title set `visible`='".$_GET['visible']."' where `id` in ($ids)";
	$pdo->exec($sql);
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>'}");
}

if($act=='move_to'){
	$ids=@$_GET['ids'];
	$_GET['to_type']=intval(@$_GET['to_type']);
	$sql="select count(id) as c from ".self::$table_pre."type where `parent`=".$_GET['to_type'];
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>".self::$language['please_select_no_sub_type']."</span>'}");}
	
	
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['select_null']."</span>'}");}
	$ids=str_replace("|",",",$ids);
	$ids=trim($ids,",");
	$ids=explode(",",$ids);
	$ids=array_map('intval',$ids);
	$temp='';
	$sum=count($ids);
	foreach($ids as $id){
		$temp.=$id.",";	
	}
	$ids=trim($temp,",");
	$sql="select count(id) as c from ".self::$table_pre."content where `title_id` in ($ids)";
	$r=$pdo->query($sql,2)->fetch(2);
	$content_sum=$r['c']; 
	$sql="update ".self::$table_pre."title set `type`='".$_GET['to_type']."' where `id` in ($ids)";
	if($pdo->exec($sql)){
		$sql="update ".self::$table_pre."type set `title_sum`=`title_sum`-".$sum.",`content_sum`=`content_sum`-".$content_sum." where `id`=".$type;
		if($pdo->exec($sql)){
			$sql="update ".self::$table_pre."type set `title_sum`=`title_sum`+".$sum.",`content_sum`=`content_sum`+".$content_sum." where `id`='".$_GET['to_type']."'";
			$pdo->exec($sql);	
		}
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");	
	}
}

if($act=='submit_select'){
	//var_dump($_POST);	
	$time=time();
	$editor=$_SESSION['monxin']['id'];
	$success='';
	foreach($_POST as $v){
		$v['id']=intval($v['id']);
		$v['sequence']=intval($v['sequence']);
		$sql="update ".self::$table_pre."title set `sequence`='".$v['sequence']."' where `id`='".$v['id']."'";
		if($pdo->exec($sql)){$success.=$v['id']."|";}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}