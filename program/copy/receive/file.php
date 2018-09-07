<?php
set_time_limit(6000000);
$id=intval(@$_GET['id']);
if($id==0){
	$sql="select * from ".self::$table_pre."file where `state`=0 limit 0,1";
}else{
	$sql="select * from ".self::$table_pre."file where `id`='".$id."' and `state`=0";
}
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']==''){exit;}


if($r['download_count']>3){
	$sql="delete from ".self::$table_pre."file where `id`=".$r['id'];
	$pdo->exec($sql);
	exit();
}
$sql="update ".self::$table_pre."file set `download_count`=`download_count`+1 where `id`=".$r['id'];
$pdo->exec($sql);


$sql_save_path=my_safe_save_file_name($r['save_path'],self::$config['upload']['upAllowSuffix']);
$r['save_path']=$sql_save_path;
function my_safe_save_file_name($path,$allow){
	$allow=explode(',',$allow);
	$a=explode('.',$path);
	$postfix=strtolower($a[count($a)-1]);
	if(!in_array($postfix,$allow)  || $postfix=='php' || $postfix=='asp' || $postfix=='aspx' || $postfix=='jsp'){
		$path=str_replace('.php','.php_forbidden',$path);
		$path=str_replace('.asp','.asp_forbidden',$path);
		$path=str_replace('.aspx','.aspx_forbidden',$path);
		$path=str_replace('.jsp','.jsp_forbidden',$path);
		$path=str_replace('.'.$postfix,'.'.$postfix.'_forbidden',$path);
	}
	return $path;
}


$c=file_get_contents($r['url']);
if(!$c){$c=file_get_contents($r['url']);}
if(!$c){$c=file_get_contents($r['url']);}
if(!$c){$c=file_get_contents($r['url']);}
if(!$c){$c=file_get_contents($r['url']);}
if(!$c){exit;}
$result=file_put_contents($r['save_path'],$c);
if(!$result){$result=file_put_contents($r['save_path'],$c);}
if(!$result){$result=file_put_contents($r['save_path'],$c);}

if($result){
	$sql="update ".self::$table_pre."file set `state`=1 where `id`=".$r['id'];
	$pdo->exec($sql);
	$sql="select * from ".self::$table_pre."field where `id`=".$r['field_id'];
	$r2=$pdo->query($sql,2)->fetch(2);
	if($r2['id']==''){exit;}
	if($r2['data_type']==0){
		if($r2['html_img_watermark']){
			$image=new image();
			$image->addMark($r['save_path']);	
		}	
	}elseif($r2['data_type']==1){
		$image=new image();
		if($r2['data_type_img_imageMark']){
			$image->addMark($r['save_path']);	
		}
		if($r2['data_type_img_thumb_save_path']!='' && is_dir($r2['data_type_img_thumb_save_path'])){
			if(is_numeric($r2['data_type_img_thumb_width']) && is_numeric($r2['data_type_img_thumb_height'])){
				$temp=str_replace($r2['data_type_img_save_path'],'',$sql_save_path);
				$temp=trim($temp,'/');
				$temp=explode('/',$temp);
				$thumb_dir=str_replace('//','/',$r2['data_type_img_thumb_save_path'].'/').$temp[0];
				@mkdir($thumb_dir);	
				$thumb_path=str_replace($r2['data_type_img_save_path'],$r2['data_type_img_thumb_save_path'],$sql_save_path);
				file_put_contents('test.txt',$thumb_path);
				$image->thumb($sql_save_path,$thumb_path,$r2['data_type_img_thumb_width'],$r2['data_type_img_thumb_height']);
			}
		}	
		
	}	
}