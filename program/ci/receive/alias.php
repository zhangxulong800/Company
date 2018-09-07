<?php
$id=intval(@$_GET['id']);
if($id>0){
	$_POST=safe_str($_POST);
	$sql="update ".self::$table_pre."type set `title_label`='".$_POST['title_label']."',`title_placeholder`='".$_POST['title_placeholder']."',`content_label`='".$_POST['content_label']."',`content_placeholder`='".$_POST['content_placeholder']."',`icon_label`='".$_POST['icon_label']."' where `id`='$id'";
	//echo $sql;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}	
