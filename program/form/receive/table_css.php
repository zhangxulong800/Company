<?php
$id=intval(@$_GET['id']);
if($id==0){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");}
$_POST=safe_str($_POST,0);
$sql="select * from ".self::$table_pre."table where `id`=".$id;
$r=$pdo->query($sql,2)->fetch(2);
if($_POST['css_pc_bg']!=''){
	if(file_exists('./temp/'.$_POST['css_pc_bg'])){
		get_date_dir('./program/form/img/');
		$path='./program/form/img/'.$_POST['css_pc_bg'];
		@safe_unlink('./program/form/img/'.$r['css_pc_bg']);
		if(!safe_rename('./temp/'.$_POST['css_pc_bg'],$path)){
			$_POST['css_pc_bg']=$r['css_pc_bg'];
		}
	}else{$_POST['css_pc_bg']=$r['css_pc_bg'];}	
}else{$_POST['css_pc_bg']=$r['css_pc_bg'];}

if($_POST['css_phone_bg']!=''){
	if(file_exists('./temp/'.$_POST['css_phone_bg'])){
		get_date_dir('./program/form/img/');
		$path='./program/form/img/'.$_POST['css_phone_bg'];
		@safe_unlink('./program/form/img/'.$r['css_phone_bg']);
		if(!safe_rename('./temp/'.$_POST['css_phone_bg'],$path)){
			$_POST['css_phone_bg']=$r['css_phone_bg'];
		}
	}else{$_POST['css_phone_bg']=$r['css_phone_bg'];}	
}else{$_POST['css_phone_bg']=$r['css_phone_bg'];}

$sql="update ".self::$table_pre."table set `css_width`='".$_POST['css_width']."',`css_pc_bg`='".$_POST['css_pc_bg']."',`css_pc_top`='".$_POST['css_pc_top']."',`css_phone_bg`='".$_POST['css_phone_bg']."',`css_phone_top`='".$_POST['css_phone_top']."',`css_diy`='".$_POST['css_diy']."' where `id`=".$id;
file_put_contents('t.txt',$sql);
if($pdo->exec($sql)){
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
}else{
	exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
}

