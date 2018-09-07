<?php
$id=intval(@$_GET['id']);
$act=@$_GET['act'];
$id=intval(@$_GET['id']);
if($act=='bg'){
	if(@$_POST['bg']==''  || !is_file('./temp/'.$_POST['bg'])){exit("{'state':'fail','info':'<span class=fail>is null</span>'}");}
	@safe_unlink('./program/mall/express_bg/'.$id.'.png');
	if(safe_rename('./temp/'.$_POST['bg'],'./program/mall/express_bg/'.$id.'.png')){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>is null</span>'}");
	}	
}

if($act=='update'){
	//var_dump($_POST);
	$sql="select * from ".self::$table_pre."express_layout where `e_id`=".$id." limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	$field='';
	//var_dump($r);
	foreach($r as $k=>$v){
		if($k=='id' || $k=='e_id'){continue;}
		$field.="`".$k."`='".$_POST[$k]."',";
	}
	$field=trim($field,',');
	
	$sql="update ".self::$table_pre."express_layout set ".$field." where `e_id`=".$id." limit 1";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
		
}