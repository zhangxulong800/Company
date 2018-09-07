<?php
$act=@$_GET['act'];

//================================================================================================================================	
if($act=='yun_print'){
	$id=intval(@$_GET['id']);
	if($id<1){exit();}
	$r=self::submit_cloud_print($pdo,$id);
	if($r!==false){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
	

}
