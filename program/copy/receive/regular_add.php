<?php
foreach($_POST as $key=>$v){
	if($key=='detail_url_prefix'){continue;}
	if($v==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'".$key."'}");}
}

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


$sql="insert into ".self::$table_pre."regular (`name`,`list_url`,`start_number`,`add_step`,`end_number`,`list_update_cycle`,`page_charset`,`detail_url_reg`,`detail_url_prefix`,`detail_update_cycle`,`save_to`,`switch`,`detail_url`,`detail_icon`,`detail_title`) values ('".$_POST['name']."','".$_POST['list_url']."','".intval($_POST['start_number'])."','".intval($_POST['add_step'])."','".intval($_POST['end_number'])."','".$_POST['list_update_cycle']."','".$_POST['page_charset']."','".$_POST['detail_url_reg']."','".$_POST['detail_url_prefix']."','".$_POST['detail_update_cycle']."','".$_POST['save_to']."','1','".intval($_POST['detail_url'])."','".intval($_POST['detail_icon'])."','".intval($_POST['detail_title'])."')";

if($pdo->exec($sql)){
	$insret_id=$pdo->lastInsertId();
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span><script>window.location.href='index.php?monxin=".self::$config['class_name'].".regular&id=".$insret_id."';</script>'}");
}else{
	exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
}

