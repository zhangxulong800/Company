<?php
$act=@$_GET['act'];
if($act=='update_img'){
	$old_img=$_GET['old_img'];
	$new_img=$_GET['new_img'];
	
	if($old_img!=''){
		if($old_img!=$new_img){
			safe_unlink('./program/ci/img/'.str_replace('*','.',$old_img));	
		}	
	}
	if($new_img!=''){
		if($old_img!=$new_img){
			get_date_dir('./program/ci/img/');	
			safe_rename('./temp/'.safe_path($new_img),'./program/ci/img/'.safe_path($new_img));
		}	
		
	}
		
}