<?php
$id=intval(@$_GET['id']);
if($id==0){exit("{'state':'fail','info':'id err'}");}

foreach($_POST as $key=>$v){
	if($key=='detail_url_prefix'){continue;}
	if($v==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'".$key."'}");}
}
//var_dump($_POST);

$_POST=safe_str($_POST);
if(!is_numeric($_POST['list_update_cycle'])){$_POST['list_update_cycle']=0;}
if(!is_numeric($_POST['detail_update_cycle'])){$_POST['detail_update_cycle']=0;}

$_POST['save_to']=str_ireplace($pdo->sys_pre,'',$_POST['save_to']);
$temp=explode(',',$_POST['save_to']);
foreach($temp as $v){
	if($v!=''){
		$sql="select count(id) as c from ".$pdo->sys_pre.$v."";	
		$r=$pdo->query($sql,2);
		//var_dump($r);
		if($r===false){
			exit("{'state':'fail','info':'<span class=fail>".$v.self::$language['not_exist']."</span>','id':'save_to'}");
		}
	}
}

$sql="update ".self::$table_pre."regular set `name`='".$_POST['name']."',`list_url`='".$_POST['list_url']."',`start_number`='".intval($_POST['start_number'])."',`add_step`='".intval($_POST['add_step'])."',`end_number`='".intval($_POST['end_number'])."',`list_update_cycle`='".$_POST['list_update_cycle']."',`page_charset`='".$_POST['page_charset']."',`detail_url_reg`='".$_POST['detail_url_reg']."',`detail_url_prefix`='".$_POST['detail_url_prefix']."',`detail_update_cycle`='".$_POST['detail_update_cycle']."',`save_to`='".$_POST['save_to']."',`detail_url`='".intval($_POST['detail_url'])."',`detail_icon`='".intval($_POST['detail_icon'])."',`detail_title`='".intval($_POST['detail_title'])."',`copy_interval`='".intval($_POST['copy_interval'])."' where `id`=".$id;
//echo $sql;
if($pdo->exec($sql)){
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
}else{
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
}

