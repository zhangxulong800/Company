<?php
$act=@$_GET['act'];
$id=intval(@$_GET['id']);
if($act=='update'){
	if(self::update_content($pdo,$id,$_GET['comment'])){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span><a href=".self::get_content_link($pdo,$id)." class=view>".self::$language['view']."</a>'}");	
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='del'){
	$sql="select `title_id`,`username` from ".self::$table_pre."content where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['username']!=$_SESSION['monxin']['username']){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");}
	$sql="select `type` from ".self::$table_pre."title where `id`='".$r['title_id']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	$type=$r['type'];
	if(self::del_content($pdo,$id,$type)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

