<?php
foreach($_GET as $key=>$v){
	if($v==''){exit("{'state':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");}
}
$act=@$_GET['act'];

if($act=='copy_sub'){
	function get_xzqh_org($pdo,$upid,$url){
		$temp=explode('/',$url);
		$base_url=str_replace($temp[count($temp)-1],'',$url);
		$str=file_get_contents($url);
		$str=mb_convert_encoding($str,'utf-8','gbk');
		$body=get_match_single("#</font>.*<table.*>(.*)</table>#iUs",$str);
		//var_dump($body);
		$r=get_match_all("#<tr>.*<td.*>.*</td>.*<td.*>(.*)</td>.*</tr>#iUs",$body);
		//var_dump($r);
		//$r=get_match_all("#<tr.*>(.*)</tr>#iUs",$body);
		$result=array();
		foreach($r as $v){
			$detail_url=get_match_single('#<a href="(.*)>.*</a>#iU',$v);
			if($detail_url){
				/*
				$sub_url=$base_url.$detail_url;
				$sub_str=file_get_contents($sub_url);
				$sub_str=mb_convert_encoding($sub_url,'utf-8','gbk');
				$sub_body=get_match_single("#keating编辑制作转载请注明来自www.xzqh.org</font></p>.*<table.*>(.*)</table>#iUs",$sub_str);
				$sub_r=get_match_all("#<tr>.*<td.*>.*</td>.*<td.*>(.*)</td>.*</tr>#iUs",$sub_body);
				*/
			}
			$v=strip_tags($v);
			$v=trim($v);
			if($v=='名称' || $v=='区' || $v=='县名'){continue;}
			$result[]=$v;
		}
		unset($result[count($result)-1]);
		return $result;
	}
	$url=$_GET['url'];
	$upid=intval($_GET['upid']);
	$sql="select `level` from ".$pdo->index_pre."area where `id`=".$upid;
	$r=$pdo->query($sql,2)->fetch(2);
	$level=$r['level']+1;
	
	$r=get_xzqh_org($pdo,$upid,$url);
	//var_dump($r);exit();
	$sum=0;
	foreach($r as $v){
		$v=safe_str($v);
		$sql="select `id` from ".$pdo->index_pre."area where `upid`=".$upid." and `name`='".$v."' limit 0,1";
		$rr=$pdo->query($sql,2)->fetch(2);
		if($rr['id']==''){
			$sql="insert into ".$pdo->index_pre."area (`name`,`sequence`,`upid`,`level`) values ('".$v."','0','".$upid."','".$level."')";
			if($pdo->exec($sql)){$sum++;}
		}
	}	
	
	exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['success']." ".$sum."'}");
	
}

if($act=='add'){
	$upid=intval(@$_GET['upid']);
	$sequence=intval(@$_GET['sequence']);
	$name=safe_str(@$_GET['name']);
	
	if($upid==0){
		$level=1;	
	}else{
		$sql="select `level` from ".$pdo->index_pre."area where `id`=".$upid;
		$r=$pdo->query($sql,2)->fetch(2);
		$level=$r['level'];	
		$level++;
	}
	
	$sql="insert into ".$pdo->index_pre."area (`name`,`sequence`,`upid`,`level`) values ('".$_GET['name']."','".$_GET['sequence']."','".$upid."','".$level."')";
	//file_put_contents('./test.sql',$sql);
	if($pdo->exec($sql)){
		$new_id=$pdo->lastInsertId();
		update_area_address($pdo,$new_id);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','id':'".$new_id."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='update'){
	$_GET['id']=intval(@$_GET['id']);
	$_GET['sequence']=intval(@$_GET['sequence']);
	$_GET['name']=safe_str(@$_GET['name']);
	$sql="update ".$pdo->index_pre."area set `name`='".$_GET['name']."',`sequence`='".$_GET['sequence']."' where `id`='".$_GET['id']."'";
	if($_GET['center']!=''){
		$temp=explode(',',$_GET['center']);
		$sql="update ".$pdo->index_pre."area set `name`='".$_GET['name']."',`sequence`='".$_GET['sequence']."',`longitude`='".floatval($temp[0])."',`latitude`='".floatval($temp[1])."' where `id`='".$_GET['id']."'";
	}
	if($pdo->exec($sql)){
		update_area_address($pdo,$_GET['id']);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
	}
}
if($act=='del'){
	$id=intval(@$_GET['id']);
	if($id<1){exit();}
	$sql="select count(id) as c from ".$pdo->index_pre."area where `upid`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['have_sub']."'}");}
	$sql="delete from ".$pdo->index_pre."area where `id`='$id'";
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
		$id=intval($id);
		$sql="select count(id) as c from ".$pdo->index_pre."area where `upid`='$id'";
		$r=$pdo->query($sql,2)->fetch(2);		
		if($r['c']==0){
			$sql="delete from ".$pdo->index_pre."area where `id`='$id'";
			if($pdo->exec($sql)){$success.=$id."|";}
		}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}

if($act=='submit_select'){
	$success='';
	foreach($_POST as $v){
		$v['id']=intval($v['id']);
		$v['sequence']=intval($v['sequence']);
		$v['name']=safe_str($v['name']);
		$sql="update ".$pdo->index_pre."area set `name`='".$v['name']."',`sequence`='".$v['sequence']."' where `id`='".$v['id']."'";
		if($v['center']!=''){
			$temp=explode(',',$v['center']);
			$sql="update ".$pdo->index_pre."area set `name`='".$v['name']."',`sequence`='".$v['sequence']."',`longitude`='".floatval($temp[0])."',`latitude`='".floatval($temp[1])."' where `id`='".$v['id']."'";
		}
		if($pdo->exec($sql)){$success.=$v['id']."|";update_area_address($pdo,$v['id']);}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}

