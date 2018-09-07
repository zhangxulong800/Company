<?php
$act=@$_GET['act'];

if($act=='truncate'){
	$tables=$_POST['tables'];
	$tables=explode(',',$tables);
	$sql='';
	foreach($tables as $v){
		if($v==''){continue;}
		$sql.="TRUNCATE `".$v."`;";
	}
	$pdo->exec($sql);
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	
}
