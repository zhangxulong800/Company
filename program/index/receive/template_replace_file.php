<?php
$input_name='replace_file';
$name=@$_FILES[$input_name]['name'];
$path=@$_POST['path'];
$path=trim($path,'/');
$path=trim($path,'.');
$new_postfix=strtolower(get_file_postfix($name));
$old_postfix=strtolower(get_file_postfix($path));

if($new_postfix!=$old_postfix){
	
	header('location:index.php?monxin=index.template_replace_file&path='.$path.'&state=fail&info='.urlencode(self::$language['type'].self::$language['inconsistent']));exit;
	exit;	
}

if(is_uploaded_file($_FILES[$input_name]['tmp_name'])){
	if(move_uploaded_file($_FILES[$input_name]['tmp_name'],'./templates/'.$path)){
		if($old_postfix=='php'){
			require('./lib/FilterTemplate.class.php');
			$info=FilterTemplate::filter_code('./templates/'.$path);
			if($info!=''){
			$info=self::$language['illegal_code_is_detected_has_been_cleared'];
			header('location:index.php?monxin=index.template_replace_file&path='.$path.'&state=success&info='.urlencode($info));exit;	
			exit;
			}
		}
		
		header('location:index.php?monxin=index.template_replace_file&path='.$path.'&state=success');exit;	
		exit;		
	}else{
		header('location:index.php?monxin=index.template_replace_file&path='.$path.'&state=fail&info='.urlencode(self::$language['upload_failed']));exit;	
		exit;	
	}
	
}else{
	header('location:index.php?monxin=index.template_replace_file&path='.$path.'&state=fail&info='.urlencode(self::$language['is_null']));exit;	
	exit;	
}



