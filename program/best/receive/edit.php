<?php
$id=intval($_GET['id']);
if($id==0){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
$time=time();
$_POST['title']=safe_str(@$_POST['title']);

$sql="update ".self::$table_pre."page set `title`='".$_POST['title']."',`username`='".$_SESSION['monxin']['username']."',`time`='$time' where `id`='".$id."'";	
//echo $sql;
if($pdo->exec($sql)){
	$_POST['paragraph_title']=safe_str(@$_POST['paragraph_title']);
	if(is_array($_POST['paragraph_title'])){
		foreach($_POST['paragraph_title'] as $k=>$v){
			$p_id=intval($_POST['paragraph_content'][$k]);
			if($p_id>0){
				$sql="update ".self::$table_pre."paragraph set `best_id`='".$id."',`title`='".$v."',`sequence`='".intval($k)."' where `id`=".$p_id."";	
			}else{
				$sql="insert into ".self::$table_pre."paragraph (`best_id`,`title`,`sequence`) values ('".$id."','".$v."','".intval($k)."')";	
			}
			
			$pdo->exec($sql);	
		}
	}
	$sql="select `id`,`content_pc`,`content_phone` from ".self::$table_pre."paragraph where `best_id`='".$id."'";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		if(!in_array($v['id'],$_POST['paragraph_content'])){
			$sql="delete from ".self::$table_pre."paragraph where `id`=".$v['id'];
			if($pdo->exec($sql)){
				$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
				$imgs=get_match_all($reg,$v['content_pc']);
				reg_attachd_img("del",self::$config['class_name'],$imgs,$pdo);	
				$imgs=get_match_all($reg,$v['content_phone']);
				reg_attachd_img("del",self::$config['class_name'],$imgs,$pdo);	
			}
				
		}
	}
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','url':'index.php?monxin=".self::$config['class_name'].".show&id=".$id."'}");
}else{
	exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
}
