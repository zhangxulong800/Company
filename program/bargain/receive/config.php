<?php
$act=@$_GET['act'];
$v=@$_GET['v'];
$v=str_replace('|||','&',$v);
$config=require('./program/bargain/config.php');
switch($act){
	case 'rebate_1':
		$v=intval($v);
		break;
	case 'no_sub':
		$v=($v=='true')?true:false;
		break;
	case 'bargain_remark':
		//$v=rn_to_br($v);
		break;
		
			
}
if(isset($config[$act])){
	$config[$act]=$v;
	if(file_put_contents('./program/bargain/config.php','<?php return '.var_export($config,true).'?>')){
		echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
	}else{
		echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
	}	
}