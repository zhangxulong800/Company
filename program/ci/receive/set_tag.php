<?php
$act=@$_GET['act'];
if($act=='submit'){
	$_GET['c_id']=intval(@$_GET['c_id']);
	$tag=safe_str($_GET['tag']);
	$tag=str_replace('t_','',$tag);
	$sql="update ".self::$table_pre."content set `tag`='".$tag."' where `id`=".$_GET['c_id'];	
	if($pdo->exec($sql)){
		$html=self::get_tags_name($pdo,$tag).' <a href=./index.php?monxin=ci.set_tag&c_id='.$_GET['c_id'].'&id='.$tag.' class=set>&nbsp;</a>';
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','html':'".$html."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}