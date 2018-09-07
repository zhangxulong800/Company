<?php
$id=intval(@$_GET['id']);

if($id>0){
	$sql="select `content` from ".self::$table_pre."module where `id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	$time=time();
	$editor=$_SESSION['monxin']['id'];
	$_POST['width']=safe_str(@$_POST['width']);
	$_POST['height']=safe_str(@$_POST['height']);
	$_POST['title']=safe_str(@$_POST['title']);
	$_POST['title_visible']=intval(@$_POST['title_visible']);
	$_POST['content']=safe_str(@$_POST['content']);
	
	$sql="update ".self::$table_pre."module set `width`='".$_POST['width']."',`height`='".$_POST['height']."',`title`='".$_POST['title']."',`title_visible`='".$_POST['title_visible']."',`content`='".$_POST['content']."',`time`='$time' where `id`='$id' and `shop_id`=".SHOP_ID;
	if($pdo->exec($sql)){
		
		
		$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
		
		$new_imgs=get_match_all($reg,$_POST['content']);
		
		$old_imgs=get_match_all($reg,$r['content']);
		foreach($old_imgs as $v){
			if(!in_array($v,$new_imgs)){
				$sql="select count(id) as c from ".self::$table_pre."module where `content` like '%".$v."%'";
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
		$this->update_module($pdo);
		exit("{'state':'success','info':'<span class=success>&nbsp;</span><script>window.location.href=\"index.php?monxin=".self::$config['class_name'].".diymodule_admin\";</script>'}");
		}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}	
