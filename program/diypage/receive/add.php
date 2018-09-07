<?php
$time=time();
$_POST['type']=intval(@$_POST['type']);
$_POST['title']=safe_str(@$_POST['title']);
$_POST['content']=safe_str(@$_POST['content'],0);
if($_POST['type']>0 && $_POST['title']!='' && $_POST['content']!=''){
	$sql="insert into ".self::$table_pre."page (`type`,`title`,`content`,`editor`,`time`) values ('".$_POST['type']."','".$_POST['title']."','".$_POST['content']."','".$_SESSION['monxin']['id']."','$time')";	
	//echo $sql;
	if($pdo->exec($sql)){
		$insret_id=$pdo->lastInsertId();
		$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
		
		$imgs=get_match_all($reg,$_POST['content']);
		reg_attachd_img("add",self::$config['class_name'],$imgs,$pdo,$_POST['image_mark']);
		exit("{'state':'success','info':'<span class=success>&nbsp;</span><script>window.location.href=\"index.php?monxin=".self::$config['class_name'].".show&id=".$insret_id."\";</script>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}

}	
