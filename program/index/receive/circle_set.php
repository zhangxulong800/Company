<?php
$act=@$_GET['act'];

$id=intval(@$_GET['id']);

if($act=='add' || $act=='update'){
	foreach($_GET as $key=>$v){
		if($v==''){exit("{'state':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");}
	}
	
	$name=safe_str(@$_GET['name']);
	
	require('plugin/py/py_class.php');
	$py_class=new py_class(); 
	try { $py=$py_class->str2py($name); } catch(Exception $e) { $py='';}
	
	
	$center=safe_str(@$_GET['center']);
	$range=intval(@$_GET['range']);
	$sequence=intval(@$_GET['sequence']);
	$visible=intval(@$_GET['visible']);
	
	$parent_id=intval(@$_GET['parent_id']);
	
	$ids=@$_GET['ids'];
	$area=@$_GET['area'];
	$area=explode('|',$area);
	if(!isset($area[1])){
		$level=3;
	}else{
		$level=$area[1];
	}
	$area=intval($area[0]);
	
	$level_name=array();
	$level_name[1]='';
	$level_name[2]='';
	$level_name[3]='';
	$sql="select `name`,`upid` from ".$pdo->index_pre."area where `id`=".$area;
	
	$r=$pdo->query($sql,2)->fetch(2);
	$level_name[$level]=$r['name'];
	if($r['upid']!=0){
		$sql="select `name`,`upid` from ".$pdo->index_pre."area where `id`=".$r['upid'];
		$r=$pdo->query($sql,2)->fetch(2);
		$level_name[$level-1]=$r['name'];
		if($r['upid']!=0){
			$sql="select `name`,`upid` from ".$pdo->index_pre."area where `id`=".$r['upid'];
			$r=$pdo->query($sql,2)->fetch(2);
			$level_name[$level-2]=$r['name'];	
		}
	}		
}

if($act=='add'){
	
	$sql="insert into ".$pdo->index_pre."circle (`name`,`sequence`,`parent_id`,`center`,`range`,`area_id`,`visible`,`province`,`city`,`county`,`py`) values ('$name','$sequence','$parent_id','$center','$range','$area','$visible','".$level_name[1]."','".$level_name[2]."','".$level_name[3]."','".$py."')";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','id':'".$pdo->lastInsertId()."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='update'){
	$sql="update ".$pdo->index_pre."circle set `parent_id`='$parent_id',`name`='$name',`sequence`='$sequence',`center`='$center',`range`='$range',`area_id`='$area',`visible`='$visible',`province`='".$level_name[1]."',`city`='".$level_name[2]."',`county`='".$level_name[3]."',`py`='".$py."' where `id`='$id'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
	}
}
if($act=='update_visible'){
	$visible=intval(@$_GET['visible']);
	$sql="update ".$pdo->index_pre."circle set `visible`='$visible' where `id`='$id'";	
	$pdo->exec($sql);
	exit();
}
if($act=='del'){
	if(!is_numeric($id)){exit();}
	$sql="select count(id) as c from ".$pdo->index_pre."circle where `parent_id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['have_sub']."'}");}
	$sql="delete from ".$pdo->index_pre."circle where `id`='$id'";
	if($pdo->exec($sql)){
		@safe_unlink('./program/index/circle_icon/'.$id.'.png');
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}

}
