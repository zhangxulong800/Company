<?php
$type=@$_GET['type'];
$type=($type=='phone')?'phone':'pc';

$sql="select `id`,`foot_pc`,`foot_phone` from ".self::$table_pre."shop where `username`='".$_SESSION['monxin']['username']."' and `state`=2 order by `id` desc limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>no shop</span>'}");}


$old=$r['foot_'.$type];
$_POST['content']=safe_str(@$_POST['content']);
//echo $_POST['content'];
$sql="update ".self::$table_pre."shop set `foot_".$type."`='".$_POST['content']."' where `username`='".$_SESSION['monxin']['username']."' and `state`=2";

if($pdo->exec($sql)){
	$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
	$new_imgs=get_match_all($reg,$_POST['content']);
	//var_dump($new_imgs);
	$old_imgs=get_match_all($reg,$old);
	foreach($old_imgs as $v){
		if(!in_array($v,$new_imgs)){
				$path=$v;
				safe_unlink($path);
				reg_attachd_img("del",self::$config['class_name'],$path,$pdo);
		}	
	}
	$imgs=array();
	foreach($new_imgs as $v){
		if(!in_array($v,$old_imgs)){$imgs[]=$v;}	
	}
	//var_dump($imgs);
	if(count($imgs)>0){reg_attachd_img("add",self::$config['class_name'],$imgs,$pdo);}
	//exit("{'state':'success','info':'<span class=success>&nbsp;</span>'}");

	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
	exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
}
