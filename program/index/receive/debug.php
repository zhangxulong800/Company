<?php
$act=@$_GET['act'];
if($act=='program_set'){
	$program=@$_GET['program'];
	$site_id=@$_GET['site_id'];
	$site_key=@$_GET['site_key'];
	if($program=='' || $program=='index'){exit();}
	if($site_id==self::$config['web']['site_id'] && $site_key==self::$config['web']['site_key']){
		$config=require('./program/'.$program.'/config.php');
		$config['program']['state']=@$_GET['state'];
		file_put_contents('./program/'.$program.'/config.php','<?php return '.var_export($config,true).'?>');	
	}
	exit();
}
if($act=='template_set'){
	$program=@$_GET['program'];
	$template=@$_GET['template'];
	$site_id=@$_GET['site_id'];
	$site_key=@$_GET['site_key'];
	if($site_id==self::$config['web']['site_id'] && $site_key==self::$config['web']['site_key'] && $program!='' && $template!=''){
		$config=require('./program/'.$program.'/config.php');
		$config['program']['template_1']=$template;
		file_put_contents('./program/'.$program.'/config.php','<?php return '.var_export($config,true).'?>');	
	}
	exit();
}







$id=intval(@$_GET['id']);
if($id==0){echo (self::$language['need_params'].' id');	return false;}

if($act=='inform'){
	$path=@$_GET['path'];	
	$md5=@$_GET['md5'];	
	$version=@$_GET['version'];	
	if($md5==''){exit("{'state':'fail','info':'md5 is null'}");}
	if(!is_file($path)){exit("{'state':'fail','info':'".self::$language['not_exist_file']."'}");}
	$local_md5=md5(file_get_contents($path));
	if($local_md5!=$md5){
		$temp=explode('/',$path);
		//var_dump($temp);
		if(@$temp[1]=='program'){
			$config=require('./program/'.$temp[2].'/config.php');
			if($config['version']!=$version){exit("{'state':'fail','info':'version ".$config['version']."'}");}	
		}elseif(@$temp[1]=='templates'){
			if(is_file('./templates/'.$temp[2].'/'.$temp[3].'/info.txt')){
				$info=get_txt_info('./templates/'.$temp[2].'/'.$temp[3].'/info.txt');
				if($info['version']!=$version){exit("{'state':'fail','info':'version ".$info['version']."'}");}
			}
		}
		//echo $local_md5.'='.$md5;
		$change=1;
	}else{
		$change=0;	
	}
	
	
	$url=self::$config['server_url'].'receive.php?target=server::debug&act=get_info&id='.$id;
	//echo $url;
	$info=file_get_contents($url);
	//echo $info;
	$info=json_decode($info,true);
	//var_dump($info);
	if(@$info['state']==='fail'){exit("{'state':'fail','info':'".$info['info']."'}");}
	
	$time=time();
	$sql="select `id` from ".$pdo->index_pre."debug where `debug_id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if(@$r['id']==''){
		$sql="insert into ".$pdo->index_pre."debug (`path`,`time`,`new_file`,`new_md5`,`old_md5`,`change`,`debug_id`,`publish_time`) values ('".$info['path']."','".$time."','".$info['new_file']."','".$info['new_md5']."','".$info['old_md5']."','".$change."','".$id."','".$info['publish_time']."')";
		if(!$pdo->exec($sql)){exit("{'state':'fail','info':'insert err'}");}
		$local_id=$pdo->lastInsertId();
	}else{
		$sql="update ".$pdo->index_pre."debug set `path`='".$info['path']."',`time`='".$time."',`new_file`='".$info['new_file']."',`new_md5`='".$info['new_md5']."',`old_md5`='".$info['old_md5']."',`change`='".$change."',`state`=0,`publish_time`='".$info['publish_time']."' where `id`=".$r['id'];
		if(!$pdo->exec($sql)){exit("{'state':'fail','info':'update sql err'}");}
		$local_id=$r['id'];	
	}
	
	if($change){exit("{'state':'fail','info':'change'}");}
	if(self::$config['web']['auto_debug']){
		$c=@file_get_contents($info['new_file']);
		if($info['new_md5']!=md5($c)){exit("{'state':'fail','info':'md5 err'}");}
		if(file_put_contents($info['path'],$c)){
			$sql="update ".$pdo->index_pre."debug set `state`=1 where `id`=".$local_id;
			$pdo->exec($sql);
			exit("{'state':'success','info':'success'}");
		}else{
			exit("{'state':'fail','info':'write file faild'}");
		}
		
	}else{
		exit("{'state':'fail','info':'auto_debug=false'}");
	}
	
}

