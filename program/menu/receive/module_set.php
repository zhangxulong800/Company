<?php
$act=@$_GET['act'];
if($act=='update_img'){
	$old_img=$_GET['old_img'];
	$new_img=$_GET['new_img'];
	
	if($old_img!=''){
		if($old_img!=$new_img){
			safe_unlink('./program/menu/bg/'.str_replace('*','.',$old_img));	
		}	
	}
	if($new_img!=''){
		if($old_img!=$new_img){
			get_date_dir('./program/menu/bg/');	
			safe_rename('./temp/'.$new_img,'./program/menu/bg/'.$new_img);
		}	
		
	}
		
}