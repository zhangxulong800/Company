<?php
$act=@$_GET['act'];
$id=intval(@$_GET['id']);
if($act=='del'){
	$sql="select `id`,`content` from ".self::$table_pre."msg where `id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	$sql="delete from ".self::$table_pre."msg where `id`='$id'";
	if($pdo->exec($sql)){
		$reg='#&\#34;(program/'.self::$config['class_name'].'/attachd/.*|\./program/'.self::$config['class_name'].'/img/.*)&\#34;#iU';
		$files=get_match_all($reg,$r['content']);
		foreach($files as $v){
			if($v!=''){@safe_unlink($v);}		
		}
		$sql="delete from ".self::$table_pre."msg_info where `msg_id`=".$id;
		$pdo->exec($sql);
		
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
		$sql="select `id`,`content` from ".self::$table_pre."msg where `id`='$id'";
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="delete from ".self::$table_pre."msg where `id`='$id'";
		if($pdo->exec($sql)){
			$reg='#&\#34;(program/'.self::$config['class_name'].'/attachd/.*|\./program/'.self::$config['class_name'].'/img/.*)&\#34;#iU';
			$files=get_match_all($reg,$r['content']);
			foreach($files as $v){
				if($v!=''){@safe_unlink($v);}		
			}
			$sql="delete from ".self::$table_pre."msg_info where `msg_id`=".$id;
			$pdo->exec($sql);
			
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
