<?php
$act=@$_GET['act'];
if($act=='update'){
	foreach($_POST as $k=>$v){
		$v=safe_str($v,0);
		if($v['type']!='diy'){$v['type']=intval($v['type']);}
		$sql="update ".self::$table_pre."foot_six_grid set `type`='".$v['type']."',`content`='".$v['content']."',`max`='".intval($v['max'])."' where `id`=".intval($k);
		$pdo->exec($sql);
		
	}	
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");	
}

if($act=='target'){
	$config=require('./program/diypage/config.php');
	$config['foot_six_grid_target']=$_GET['foot_six_grid_target'];
	if(file_put_contents('./program/diypage/config.php','<?php return '.var_export($config,true).'?>')){
		echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
	}else{
		echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
	}	
}