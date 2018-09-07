<?php
$act=@$_GET['act'];
if($act=='icon'){
	if(@$_POST['shelf_label']==''  || !is_file('./temp/'.$_POST['shelf_label'])){exit("{'state':'fail','info':'<span class=fail>is null</span>'}");}
	if($_GET['composing']==''){$_GET['composing']='4_2';}
	$path='./program/mall/shelf_label/'.SHOP_ID.'_'.$_GET['composing'].'.png';
	if(is_file($path)){@safe_unlink($path);}
	if(safe_rename('./temp/'.$_POST['shelf_label'],$path)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>is null</span>'}");
	}	
}
