<?php
$act=@$_GET['act'];


if($act=='email'){
	$sql="select * from ".$pdo->index_pre."email_msg where `state`=1 order by `sequence` desc,`id` asc";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit("{'quantity':'0'}");}

	$mail_info=get_mail_info($pdo,$r['addressee']);
	require("./plugin/mail/class.phpmailer.php"); 
	//var_dump(self::$config);
	$web_name=self::$config['web']['name'];
	//echo $r['email'];
	if(sendmail($web_name,$r['addressee'],$r['title'],$r['content'],$mail_info)){
	//if(1){
		$sql="update ".$pdo->index_pre."email_msg set `state`=2 where `id`='".$r['id']."'";
	}else{
		$sql="update ".$pdo->index_pre."email_msg set `state`=3 where `id`='".$r['id']."'";
	}
	$pdo->exec($sql);
	
	$sql="select count(id) as c from ".$pdo->index_pre."email_msg where `state`=1";
	$r=$pdo->query($sql,2)->fetch(2);
	ob_clean(); 
	ob_end_flush(); 
	exit("{'quantity':'".$r['c']."'}");
}


