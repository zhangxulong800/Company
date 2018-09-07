<?php
$axis_id=intval(@$_GET['axis_id']);
if($axis_id==0){exit("{'state':'fail','info':'<span class=fail>axis_id err</span>'}");}

$sql="select `username` from ".self::$table_pre."group where `id`=".$axis_id;
$group=$pdo->query($sql,2)->fetch(2);
if($group['username']!=$_SESSION['monxin']['username']){exit("{'state':'fail','info':'<span class=fail>".self::$language['unauthorized_operation']."</span>'}");}

$time=time();
if($_POST['date']!=''){
	$_POST['date']=get_unixtime($_POST['date'],self::$config['other']['date_style']);
}else{
	$_POST['date']=$time;	
}

if($_POST['icon']!=''){
	if(file_exists('./temp/'.$_POST['icon'])){
		get_date_dir('./program/axis/img/');
		$path='./program/axis/img/'.$_POST['icon'];
		if(copy('./temp/'.$_POST['icon'],$path)){
			safe_unlink('./temp/'.$_POST['icon']);
			$image=new image();
			$image->thumb($path,$path,128,128);
		}else{
			$_POST['icon']='';
		}
	}	
}


$_POST=safe_str($_POST);
if($_POST['content']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['content'].self::$language['is_null']."</span>'}");}

$id=intval(@$_GET['id']);
if($id>0){
	$sql="select * from ".self::$table_pre."log where `id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	$old=$r;
	if($r['g_id']!=$axis_id){exit("{'state':'fail','info':'<span class=fail>".self::$language['unauthorized_operation']."</span>'}");}
	if($_POST['icon']==''){$_POST['icon']=$r['icon'];}
	
	
	$sql="update ".self::$table_pre."log set `content`='".$_POST['content']."',`date`='".$_POST['date']."',`date_name`='".$_POST['date_name']."',`icon`='".$_POST['icon']."',`bold`='".intval($_POST['bold'])."' where `id`='$id'";
	if($pdo->exec($sql)){
		if($_POST['icon']!=$r['icon']){
			safe_unlink('./program/axis/img/'.$old['icon']);	
		}
		
		$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
		$new_imgs=get_match_all($reg,$_POST['content']);
		//var_dump($new_imgs);
		$old_imgs=get_match_all($reg,$r['content']);
		foreach($old_imgs as $v){
			if(!in_array($v,$new_imgs)){
				$sql="select count(id) as c from ".self::$table_pre."log where `content` like '%".$v."%'";
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
		if(count($imgs)>0){reg_attachd_img("add",self::$config['class_name'],$imgs,$pdo,0);}
		
		$sql="select * from ".self::$table_pre."log where `id`=".$id;
		$v=$pdo->query($sql,2)->fetch(2);
		$v=de_safe_str($v);
		$r=array();
		$r['state']='success';
		$r['info']='<span class=success>'.self::$language['success'].'</span>';
		$r['id']=$v['id'];
		$r['fun']='update';
		$r['html']=self::get_log_html($pdo,self::$language,$v);
		exit(str_replace('""','"',json_encode($r)));
		
		
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}else{
	$sql="insert into ".self::$table_pre."log (`content`,`date`,`date_name`,`icon`,`bold`,`g_id`) values ('".$_POST['content']."','".$_POST['date']."','".$_POST['date_name']."','".$_POST['icon']."','".intval($_POST['bold'])."','".$axis_id."')";
	if($pdo->exec($sql)){
		$insret_id=$pdo->lastInsertId();
		$sql="select * from ".self::$table_pre."log where `id`=".$insret_id;
		$v=$pdo->query($sql,2)->fetch(2);
		$v=de_safe_str($v);
		$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
		$imgs=get_match_all($reg,$_POST['content']);
		if(count($imgs)>0){reg_attachd_img("add",self::$config['class_name'],$imgs,$pdo,0);}
		$r=array();
		$r['state']='success';
		$r['info']='<span class=success>'.self::$language['success'].'</span>';
		$r['id']=$insret_id;
		$r['fun']='new';
		$r['html']=self::get_log_html($pdo,self::$language,$v);
		exit(str_replace('""','"',json_encode($r)));
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

