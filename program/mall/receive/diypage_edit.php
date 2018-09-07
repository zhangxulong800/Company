<?php

$id=intval(@$_GET['id']);
$type=@$_GET['type'];
$type=($type=='phone')?'phone':'pc';
if($id>0){
	$sql="select `content` from ".self::$table_pre."diypage where `id`='$id' and `shop_id`=".SHOP_ID;
	$r=$pdo->query($sql,2)->fetch(2);
	$time=time();
	$_POST['title']=safe_str(@$_POST['title']);
	$_POST['content']=safe_str(@$_POST['content']);
	if($type=='phone'){
		$sql="update ".self::$table_pre."diypage set `phone_content`='".$_POST['content']."',`time`='$time' where `id`='$id' and `shop_id`=".SHOP_ID;
	}else{
		$sql="update ".self::$table_pre."diypage set `title`='".$_POST['title']."',`content`='".$_POST['content']."',`time`='$time' where `id`='$id' and `shop_id`=".SHOP_ID;
	}
	if($pdo->exec($sql)){
		$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
		$new_imgs=get_match_all($reg,$_POST['content']);
		//var_dump($new_imgs);
		$old_imgs=get_match_all($reg,$r['content']);
		foreach($old_imgs as $v){
			if(!in_array($v,$new_imgs)){
				$sql="select count(id) as c from ".self::$table_pre."diypage where `content` like '%".$v."%' or `phone_content` like '%".$v."%'";
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
		if(count($imgs)>0){reg_attachd_img("add",self::$config['class_name'],$imgs,$pdo,$_POST['image_mark']);}
		//exit("{'state':'success','info':'<span class=success>&nbsp;</span>'}");
		if($type=='phone'){
			exit("{'state':'success','info':'<span class=success>&nbsp;</span>'}");
		}else{
			exit("{'state':'success','info':'<span class=success>&nbsp;</span><script>window.location.href='index.php?monxin=".self::$config['class_name'].".diypage_show&id=".$id."';</script>'}");
		}
		}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}	
