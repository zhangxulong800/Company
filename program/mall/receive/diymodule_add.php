<?php

$time=time();
$_POST['width']=safe_str(@$_POST['width']);
$_POST['height']=safe_str(@$_POST['height']);
$_POST['title']=safe_str(@$_POST['title']);
$_POST['title_visible']=intval(@$_POST['title_visible']);
$_POST['content']=safe_str(@$_POST['content']);
if($_POST['title']!='' && $_POST['content']!=''){
	$sql="insert into ".self::$table_pre."module (`title`,`width`,`height`,`content`,`shop_id`,`time`,`title_visible`) values ('".$_POST['title']."','".$_POST['width']."','".$_POST['height']."','".$_POST['content']."','".SHOP_ID."','$time','".$_POST['title_visible']."')";	
	//echo $sql;
	if($pdo->exec($sql)){
		$insret_id=$pdo->lastInsertId();
		$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
		$imgs=get_match_all($reg,$_POST['content']);
		reg_attachd_img("add",self::$config['class_name'],$imgs,$pdo,$_POST['image_mark']);
		$this->update_module($pdo);
		
		exit("{'state':'success','info':'<span class=success>&nbsp;</span><script>window.location.href=\"index.php?monxin=".self::$config['class_name'].".diymodule_admin\";</script>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}

}	
