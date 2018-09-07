<?php
$id=intval(@$_GET['id']);
$_POST['content']=safe_str(@$_POST['content'],0);
$_POST['is_full']=intval(@$_POST['is_full']);
$_GET['device']=safe_str(@$_GET['device']);

if($id>0){
	$sql="select `content_".$_GET['device']."` from ".self::$table_pre."paragraph where `id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	$time=time();
	$sql="update ".self::$table_pre."paragraph set `content_".$_GET['device']."`='".$_POST['content']."',`is_full`='".$_POST['is_full']."' where `id`='$id'";
	if($pdo->exec($sql)){
		$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
		$new_imgs=get_match_all($reg,$_POST['content']);
		//var_dump($new_imgs);
		$old_imgs=get_match_all($reg,$r['content_'.$_GET['device']]);
		foreach($old_imgs as $v){
			if(!in_array($v,$new_imgs)){
				$sql="select count(id) as c from ".self::$table_pre."paragraph where `content_".$_GET['device']."` like '%".$v."%'";
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
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','id':'".$id."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}else{
	$sql="insert into ".self::$table_pre."paragraph (`content_".$_GET['device']."`,`is_full`) values ('".$_POST['content']."','".$_POST['is_full']."')";
	if($pdo->exec($sql)){
		$insret_id=$pdo->lastInsertId();
		$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
		$imgs=get_match_all($reg,$_POST['content']);
		if(count($imgs)>0){reg_attachd_img("add",self::$config['class_name'],$imgs,$pdo,0);}
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','id':'".$insret_id."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

