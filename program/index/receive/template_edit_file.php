<?php
$_POST['content']=@$_POST['content'];
if($_POST['content']==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['content'].self::$language['is_null']."','key':'content'}");}
$_POST['content']=str_replace('<\/textarea>','</textarea>',$_POST['content']);

$path=@$_POST['save_path'];
$path=trim($path,'/');
$path=trim($path,'.');
$path=str_replace('templates/','',$path);

$temp=explode('.',$path);
$postfix=$temp[count($temp)-1];
if($postfix=='php' || $postfix=='txt' || $postfix=='js' || $postfix=='css'){
	if(is_dir('./templates/'.$path)){header('location:index.php?monxin=index.template_edit_file&path='.$path.'&state=fail&info='.urlencode(self::$language['illegal'].self::$language['file_name']));exit;}
	//echo $_POST['content'];
	if(file_put_contents('./templates/'.$path,$_POST['content'])){
		$info='';
		if($postfix=='php'){
			require('./lib/FilterTemplate.class.php');
			$info=FilterTemplate::filter_code('./templates/'.$path);
		}
		if($info!=''){$info=self::$language['illegal_code_is_detected_has_been_cleared'];}
		
		header('location:index.php?monxin=index.template_edit_file&path='.$path.'&state=success&info='.urlencode($info));exit;
		}else{
		header('location:index.php?monxin=index.template_edit_file&path='.$path.'&state=fail&info='.urlencode(self::$language['save']));exit;
	}

}else{
	$path=@$_POST['old_path'];
	header('location:index.php?monxin=index.template_edit_file&path='.$path.'&state=fail&info='.urlencode(self::$language['illegal'].self::$language['file_name']));exit;
}
