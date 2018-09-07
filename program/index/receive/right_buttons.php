<?php
$type=@$_GET['type'];
$type=($type=='phone')?'phone':'pc';
$old=@file_get_contents('./program/index/right_buttons_'.$type.'_data.txt');
$_POST['content']=str_replace('<\/textarea>','</textarea>',$_POST['content']);
$_POST['content']=safe_str(@$_POST['content'],0);

if(file_put_contents('./program/index/right_buttons_'.$type.'_data.txt',$_POST['content'])){
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
