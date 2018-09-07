<?php
$act=@$_GET['act'];
$v=@$_GET['v'];
$v=str_replace('|||','&',$v);

$config=require('./program/ci/config.php');
switch($act){
	case 'info_verify':
		$v=($v=='true')?true:false;
		break;
	case 'visitor_add':
		$v=($v=='true')?true:false;
		break;
	case 'day_add_max':
		$v=(is_numeric($v))?intval($v):1;
		$v=($v<1)?1:$v;
		break;
	case 'day_reflash_max':
		$v=(is_numeric($v))?intval($v):0;
		$v=($v<1)?0:$v;
		break;
	case 'reflash_price':
		$v=(is_numeric($v))?floatval($v):1;
		$v=($v<0)?1:$v;
		break;
	case 'top_min_price':
		$v=(is_numeric($v))?floatval($v):1;
		$v=($v<0)?1:$v;
		break;
	case 'give_3':
		$v=(is_numeric($v))?intval($v):0;
		$v=($v<0)?0:$v;
		break;
	case 'give_7':
		$v=(is_numeric($v))?intval($v):0;
		$v=($v<0)?0:$v;
		break;
	case 'give_15':
		$v=(is_numeric($v))?intval($v):0;
		$v=($v<0)?0:$v;
		break;
	case 'give_30':
		$v=(is_numeric($v))?intval($v):0;
		$v=($v<0)?0:$v;
		break;
			
}
if(isset($config[$act])){
	$config[$act]=$v;
	if(file_put_contents('./program/ci/config.php','<?php return '.var_export($config,true).'?>')){
		echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
	}else{
		echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
	}	
}