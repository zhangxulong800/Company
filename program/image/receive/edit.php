<?php
$id=intval(@$_GET['id']);
if($id>0){
	$sql="select `content`,`src` from ".self::$table_pre."img where `id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	$time=time();
	$editor=$_SESSION['monxin']['id'];
	$_POST['type']=intval(@$_POST['type']);
	$_POST['html4_up']=safe_str(@$_POST['html4_up']);
	$_POST['title']=safe_str(@$_POST['title']);
	$_POST['link']=safe_str(@$_POST['link']);
	$_POST['content']=safe_str(@$_POST['content']);
	
	if($_POST['html4_up']!=''){
		if(file_exists('./temp/'.$_POST['html4_up'])){
			$path='./program/image/img/'.$r['src'];	
			if(copy('./temp/'.$_POST['html4_up'],$path)==false){
				exit("{'state':'fail','info':'<span class=fail>image replace failed</span>'}");
			}
			$thumb_width=(intval(@$_POST['thumb_width'])>0)?$_POST['thumb_width']:self::$config['program']['thumb_width'];
			$thumb_height=(intval(@$_POST['thumb_height'])>0)?$_POST['thumb_height']:self::$config['program']['thumb_height'];
			
			safe_unlink('./temp/'.$_POST['html4_up']);
			$image=new image();
			$image->thumb($path,'./program/image/img_thumb/'.$r['src'],$thumb_width,$thumb_height);
			if($_POST['image_mark']){
				$image->addMark($path);
			}
		}	
	}
	
	
	$sql="update ".self::$table_pre."img set `type`='".$_POST['type']."',`title`='".$_POST['title']."',`content`='".$_POST['content']."',`time`='$time',`editor`='$editor',`link`='".$_POST['link']."' where `id`='$id'";
	if($pdo->exec($sql)){
		$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
		$new_imgs=get_match_all($reg,$_POST['content']);
		//var_dump($new_imgs);
		$old_imgs=get_match_all($reg,$r['content']);
		foreach($old_imgs as $v){
			if(!in_array($v,$new_imgs)){
				$sql="select count(id) as c from ".self::$table_pre."img where `content` like '%".$v."%'";
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
		exit("{'state':'success','info':'<span class=success>&nbsp;</span><script>window.location.href=\"index.php?monxin=".self::$config['class_name'].".show&id=".$id."\";</script>'}");
		}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}	
