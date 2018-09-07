<?php
$id=intval(@$_GET['id']);
if($id==0){exit('group id err');}
if($_GET['act']=='update'){
	$list=str_replace('__','.',$_POST['user_sum']);
	//$list=safe_str($list);
	$r=explode(',',$list);
	$sequence=999;
	$success=0;
	$e_ids=array();
	foreach($r as $v){
		if($v==''){continue;}
		$sql="select `id` from ".$pdo->index_pre."group_quick_button where `url`='".$v."' and `group_id`=".$id;
		$e=$pdo->query($sql,2)->fetch(2);
		if($e['id']!=''){
			$sql="update ".$pdo->index_pre."group_quick_button set `sequence`=".$sequence." where `id`=".$e['id'];
			$e_ids[]=$e['id'];
			if($pdo->exec($sql)){$success++;}
		}else{
			$sql="insert into ".$pdo->index_pre."group_quick_button (`url`,`group_id`,`sequence`) values ('".$v."',".$id.",".$sequence.")";
			if($pdo->exec($sql)){$success++;}
			$new_id=$pdo->lastInsertId();
			
			$e_ids[]=$new_id;
			
		}
		
		$sequence--;
	}
	
	$sql="select `id` from ".$pdo->index_pre."group_quick_button where `group_id`=".$id."";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		if(!in_array($v['id'],$e_ids)){
			$sql="delete from ".$pdo->index_pre."group_quick_button where `id`=".$v['id'];
			$pdo->exec($sql);
		}
	}
	
	if($success){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");	
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['executed']."</span>'}");
	}
}
