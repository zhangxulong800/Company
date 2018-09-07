<?php
$id=intval(@$_GET['id']);
if($id==0){exit("{'state':'fail','info':'id err'}");}
$act=@$_GET['act'];
$_POST=safe_str($_POST);
//var_dump($_POST);


if($act=='update'){
	$temp=explode('__',str_replace('tr_','',$_POST['tr_id']));
	$table=$temp[0];
	$field=$temp[1];
	if($table=='' || $field==''){exit("{'state':'fail','info':'tr_id err'}");}
	$sql="select count(id) as c from ".self::$table_pre."field where `regular_id`='".$id."' and `table`='".$table."' and `field`='".$field."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']==0){
		$sql="insert into ".self::$table_pre."field (`regular_id`,`table`,`field`,`default_value`,`auto_update`,`replace_to`,`data_source_type`,`data_source_2`,`data_source_3`,`data_source_4`,`extract_reg`,`data_type`,`data_type_file_save_path`,`data_type_img_save_path`,`data_type_img_imageMark`,`data_type_img_thumb_save_path`,`data_type_img_thumb_width`,`data_type_img_thumb_height`,`allow_html`,`html_img_save_path`,`html_img_watermark`) values ('".$id."','".$table."','".$field."','".$_POST['default_value']."','".intval($_POST['auto_update'])."','".$_POST['replace_to']."','".$_POST['data_source_type']."','".$_POST['data_source_2']."','".$_POST['data_source_3']."','".$_POST['data_source_4']."','".$_POST['extract_reg']."','".intval($_POST['data_type'])."','".$_POST['data_type_file_save_path']."','".$_POST['data_type_img_save_path']."','".intval($_POST['data_type_img_imageMark'])."','".$_POST['data_type_img_thumb_save_path']."','".intval($_POST['data_type_img_thumb_width'])."','".intval($_POST['data_type_img_thumb_height'])."','".intval($_POST['allow_html'])."','".$_POST['html_img_save_path']."','".intval($_POST['html_img_watermark'])."')";
	}else{
		$sql="update ".self::$table_pre."field set `default_value`='".$_POST['default_value']."',`auto_update`='".intval($_POST['auto_update'])."',`replace_to`='".$_POST['replace_to']."',`data_source_type`='".intval($_POST['data_source_type'])."',`data_source_2`='".$_POST['data_source_2']."',`data_source_3`='".$_POST['data_source_3']."',`data_source_4`='".$_POST['data_source_4']."',`extract_reg`='".$_POST['extract_reg']."',`data_type`='".intval($_POST['data_type'])."',`data_type_file_save_path`='".$_POST['data_type_file_save_path']."',`data_type_img_save_path`='".$_POST['data_type_img_save_path']."',`data_type_img_imageMark`='".intval($_POST['data_type_img_imageMark'])."',`data_type_img_thumb_save_path`='".$_POST['data_type_img_thumb_save_path']."',`data_type_img_thumb_width`='".intval($_POST['data_type_img_thumb_width'])."',`data_type_img_thumb_height`='".($_POST['data_type_img_thumb_height'])."',`allow_html`='".intval($_POST['allow_html'])."',`html_img_save_path`='".$_POST['html_img_save_path']."',`html_img_watermark`='".intval($_POST['html_img_watermark'])."' where `regular_id`='".$id."' and `table`='".$table."' and `field`='".$field."'";
	}
	
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
	}	
}


