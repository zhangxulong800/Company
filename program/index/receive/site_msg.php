<?php
$time=time();
$_POST['addressee']=safe_str(@$_POST['addressee']);
$_POST['title']=safe_str(@$_POST['title']);
$_POST['content']=safe_str(@$_POST['content']);
//var_dump($_POST);
if($_POST['addressee']!='' && $_POST['title']!='' && $_POST['content']!=''){
	$sender=$_SESSION['monxin']['username'];
	$_POST['addressee']=explode(',',$_POST['addressee']);
	$_POST['addressee']=array_unique($_POST['addressee']);
	
	foreach($_POST['addressee'] as $addressee){
		if($addressee==''){continue;}
		$addressee=trim($addressee,',');
		$userid=get_user_id($pdo,$addressee);
		if($userid==NULL){
			$info="{'state':'fail','info':'<span class=fail>".self::$language['username_err'].':'.$addressee."</span>'}";	
			exit($info);
		}	
	}
	
	foreach($_POST['addressee'] as $addressee){
		if($addressee!=''){
			
			$sql="insert into ".$pdo->index_pre."site_msg (`sender`,`addressee`,`title`,`content`,`sender_state`,`addressee_state`,`time`) values ('$sender','$addressee','".$_POST['title']."','".$_POST['content']."','1','1','$time')";	
			$pdo->exec($sql);
		}
	}
		$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
		$imgs=get_match_all($reg,$_POST['content']);
		reg_attachd_img("add",self::$config['class_name'],$imgs,$pdo);
		exit("{'state':'success','info':'<span class=success>&nbsp;</span><script>window.location.href='index.php?monxin=".self::$config['class_name'].".site_msg_sender';</script>'}");

}	
