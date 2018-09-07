<?php
$time=time();
$_POST['title']=safe_str(@$_POST['title']);
$sql="insert into ".self::$table_pre."page (`title`,`username`,`time`) values ('".$_POST['title']."','".$_SESSION['monxin']['username']."','$time')";	
//echo $sql;
if($pdo->exec($sql)){
	$insret_id=$pdo->lastInsertId();
	$_POST['paragraph_title']=safe_str(@$_POST['paragraph_title']);
	if(is_array($_POST['paragraph_title'])){
		foreach($_POST['paragraph_title'] as $k=>$v){
			$p_id=intval($_POST['paragraph_content'][$k]);
			if($p_id>0){
				$sql="update ".self::$table_pre."paragraph set `best_id`='".$insret_id."',`title`='".$v."',`sequence`='".intval($k)."' where `id`=".$p_id." and `best_id`=0";	
			}else{
				$sql="insert into ".self::$table_pre."paragraph (`best_id`,`title`,`sequence`) values ('".$insret_id."','".$v."','".intval($k)."')";	
			}
			
			$pdo->exec($sql);
		}
	}
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','url':'index.php?monxin=".self::$config['class_name'].".show&id=".$insret_id."'}");
}else{
	exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
}
