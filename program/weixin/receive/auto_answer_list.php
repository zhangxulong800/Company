<?php
if(!$this->check_wid_power($pdo,self::$table_pre)){exit("{'state':'fail','info':'<span class=fail>".self::$language['act_noPower']."</span>'}");}
$wid=safe_str(@$_GET['wid']);

$act=@$_GET['act'];
$id=intval(@$_GET['id']);
if($act=='update'){
	$_GET['state']=intval(@$_GET['state']);
	$_GET['like']=intval(@$_GET['like']);
	$_GET['sequence']=intval(@$_GET['sequence']);
	$sql="update ".self::$table_pre."auto_answer set `state`='".$_GET['state']."',`like`='".$_GET['like']."',`sequence`='".$_GET['sequence']."' where `id`='$id' and `wid`='".$wid."'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='del'){
	$sql="select `image`,`voice`,`video`,`input_type` from ".self::$table_pre."auto_answer where `id`='$id' and `wid`='".$wid."'";
	$r=$pdo->query($sql,2)->fetch(2);
	$sql="delete from ".self::$table_pre."auto_answer where `id`='$id' and `wid`='".$wid."'";
	if($pdo->exec($sql)){
		$this->del_auto_answer_files($pdo,self::$table_pre,$r,$id);
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
		$sql="select `image`,`voice`,`video`,`input_type`,`author` from ".self::$table_pre."auto_answer where `id`='$id' and `wid`='".$wid."'";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['author']=='monxin'){continue;}		
		$sql="delete from ".self::$table_pre."auto_answer where `id`='$id' and `wid`='".$wid."'";
		if($pdo->exec($sql)){
			$this->del_auto_answer_files($pdo,self::$table_pre,$r,$id);			
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
if($act=='submit_select'){
	//var_dump($_POST);	
	$success='';
	foreach($_POST as $v){
		$v['id']=intval($v['id']);
		$v['state']=intval($v['state']);
		$v['like']=intval($v['like']);
		$v['sequence']=intval($v['sequence']);
		$sql="update ".self::$table_pre."auto_answer set `state`='".$v['state']."',`like`='".$v['like']."',`sequence`='".$v['sequence']."' where `id`='".$v['id']."' and `wid`='".$wid."'";
		if($pdo->exec($sql)){$success.=$v['id']."|";}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}