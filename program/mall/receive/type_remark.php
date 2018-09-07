<?php
$id=intval(@$_GET['id']);
if($id>0){
	$sql="select * from ".self::$table_pre."type where `id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	$time=time();
	$_POST['content']=safe_str(@$_POST['content']);
	
	$sql="update ".self::$table_pre."type set `remark`='".$_POST['content']."' where `id`='$id'";
	if($pdo->exec($sql)){
		$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
		$new_imgs=get_match_all($reg,$_POST['content']);
		//var_dump($new_imgs);
		$old_imgs=get_match_all($reg,$r['remark']);
		foreach($old_imgs as $v){
			if(!in_array($v,$new_imgs)){
				$sql="select count(id) as c from ".self::$table_pre."type where `remark` like '%".$v."%'";
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['c']==0){
					$path=$v;
					safe_unlink($path);
					reg_attachd_img("del",self::$config['class_name'],$path,$pdo);
				}
			}	
		}
		$imgs=array();
		foreach($new_imgs as $v){
			if(!in_array($v,$old_imgs)){$imgs[]=$v;}	
		}
		if(count($imgs)>0){reg_attachd_img("add",self::$config['class_name'],$imgs,$pdo,0);}
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}	
