<?php
$act=@$_GET['act'];
$id=intval(@$_GET['id']);

if($act=='inquiry'){
	$time=time();
	$sql="select `publish_time` from ".$pdo->index_pre."debug order by `publish_time` desc limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	$url=self::$config['server_url'].'receive.php?target=server::debug&act=get_debugs&publish_time='.@$r['publish_time'];
	$r=file_get_contents($url);
	//echo $r;
	$r=json_decode($r,true);
	if(count($r)==0){exit("{'state':'success','info':'<span class=success>".count($r).self::$language['item']."</span>'}");}
	//var_dump($r);
	foreach($r as $key=>$v){
		$path=$v['path'];
		if(!is_file($path)){continue;}
		$local_md5=md5(file_get_contents($path));
		if($local_md5!=$v['old_md5']){
			$temp=explode('/',$path);
			//var_dump($temp);
			if(@$temp[1]=='program'){
				$config=require('./program/'.$temp[2].'/config.php');
				if($config['version']!=$v['version']){continue;}	
			}elseif(@$temp[1]=='templates'){
				if(is_file('./templates/'.$temp[2].'/'.$temp[3].'/info.txt')){
					$info=get_txt_info('./templates/'.$temp[2].'/'.$temp[3].'/info.txt');
					if($info['version']!=$v['version']){continue;}
				}
			}
			//echo $local_md5.'='.$md5;
			$change=1;
		}else{
			$change=0;	
		}
		$sql="select `id` from ".$pdo->index_pre."debug where `debug_id`=".$v['id'];
		$r2=$pdo->query($sql,2)->fetch(2);
		if(@$r2['id']==''){
			$sql="insert into ".$pdo->index_pre."debug (`path`,`time`,`new_file`,`new_md5`,`old_md5`,`change`,`debug_id`,`publish_time`) values ('".$v['path']."','".$time."','".$v['new_file']."','".$v['new_md5']."','".$v['old_md5']."','".$change."','".$v['id']."','".$v['publish_time']."')";
		}else{
			$sql="update ".$pdo->index_pre."debug set `path`='".$v['path']."',`time`='".$time."',`new_file`='".$v['new_file']."',`new_md5`='".$v['new_md5']."',`old_md5`='".$v['old_md5']."',`change`='".$change."',`state`=0,`publish_time`='".$v['publish_time']."' where `id`=".$v['id'];
		}
		$pdo->exec($sql);		
	}
		
	exit("{'state':'success','info':'<span class=success>".count($r).self::$language['item']."</span>'}");
}
if($act=='batch_fix'){
	$sql="select * from ".$pdo->index_pre."debug where `state`=0 and `change`=0";
	$r=$pdo->query($sql,2);
	foreach($r as $info){
		$c=@file_get_contents($info['new_file']);
		if($info['new_md5']!=md5($c)){continue;}
		if(file_put_contents($info['path'],$c)){
			$sql="update ".$pdo->index_pre."debug set `state`=1 where `id`=".$info['id'];
			$pdo->exec($sql);
		}	
	}
	
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
}
if($act=='set_1'){
	$sql="select * from ".$pdo->index_pre."debug where `id`=".$id;
	$info=$pdo->query($sql,2)->fetch(2);
	$c=@file_get_contents($info['new_file']);
	
	if($info['new_md5']!=md5($c)){exit("{'state':'fail','info':'md5 err'}");}
	if(file_put_contents($info['path'],$c)){
		$sql="update ".$pdo->index_pre."debug set `state`=1 where `id`=".$id;
		$pdo->exec($sql);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='del'){
	$sql="delete from ".$pdo->index_pre."debug where `id`='$id'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='del_select'){
	$ids=@$_GET['ids'];
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$ids=explode("|",$ids);
	$ids=array_filter($ids);
	$success='';
	foreach($ids as $id){
		$sql="delete from ".$pdo->index_pre."debug where `id`='$id'";
		if($pdo->exec($sql)){
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
