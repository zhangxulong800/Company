<?php
function del_relevant_file($pdo,$table_pre,$id){
	$sql="select `id` from ".$table_pre."slider_img where `group_id`=".$id;
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		@safe_unlink('./program/mall/slider_img/'.$v['id'].".jpg");	
	}
	$sql="delete from ".$table_pre."slider_img where `group_id`=".$id;
	$pdo->exec($sql);
}

$id=intval(@$_GET['id']);
$act=@$_GET['act'];
if($act=='add'){
	$time=time();
	$editor=$_SESSION['monxin']['id'];
	$_GET['duration']=(intval(@$_GET['duration'])==0)?20:$_GET['duration'];
	$_GET['duration']=intval($_GET['duration']);
	$_GET['delay']=(intval(@$_GET['delay'])==0)?20:$_GET['delay'];
	$_GET['delay']=intval($_GET['delay']);
	$_GET['width']=safe_str(@$_GET['width']);
	$_GET['height']=safe_str(@$_GET['height']);
	$_GET['width']=add_px($_GET['width']);
	$_GET['height']=add_px($_GET['height']);
	$_GET['title']=safe_str(@$_GET['title']);
	$_GET['style']=safe_str(@$_GET['style']);
	$sql="insert into ".self::$table_pre."slider (`title`,`style`,`width`,`height`,`duration`,`delay`,`shop_id`,`time`) values ('".$_GET['title']."','".$_GET['style']."','".$_GET['width']."','".$_GET['height']."','".$_GET['duration']."','".$_GET['delay']."','".SHOP_ID."','".$time."')";
	//echo $sql;
	if($pdo->exec($sql)){
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','id':'".$pdo->lastInsertId()."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}


if($act=='update'){
	$time=time();
	$editor=$_SESSION['monxin']['id'];
	$_GET['duration']=(intval(@$_GET['duration'])==0)?20:$_GET['duration'];
	$_GET['duration']=intval($_GET['duration']);
	$_GET['delay']=(intval(@$_GET['delay'])==0)?20:$_GET['delay'];
	$_GET['delay']=intval($_GET['delay']);
	$_GET['width']=safe_str(@$_GET['width']);
	$_GET['height']=safe_str(@$_GET['height']);
	$_GET['width']=add_px($_GET['width']);
	$_GET['height']=add_px($_GET['height']);
	$_GET['title']=safe_str(@$_GET['title']);
	$_GET['style']=safe_str(@$_GET['style']);
	$sql="update ".self::$table_pre."slider set `width`='".$_GET['width']."',`height`='".$_GET['height']."',`duration`='".$_GET['duration']."',`delay`='".$_GET['delay']."',`title`='".$_GET['title']."',`style`='".$_GET['style']."',`time`='$time' where `id`='".$_GET['id']."' and `shop_id`=".SHOP_ID;
	if($pdo->exec($sql)){
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='del'){
	$sql="select `for_device` from ".self::$table_pre."slider where `id`='$id' and `shop_id`=".SHOP_ID;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['for_device']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['can_not_be_deleted']."</span>'}");}
	$sql="delete from ".self::$table_pre."slider where `id`='$id' and `shop_id`=".SHOP_ID;
	if($pdo->exec($sql)){
		del_relevant_file($pdo,self::$table_pre,$id);
		
		$fields=array('left','right','full','head','bottom');
		foreach($fields as $field){
			$sql="select `$field`,`id` from ".self::$table_pre."page where `$field` like '%mall.slider_show_".$id."%'";
			$r=$pdo->query($sql,2);
			foreach($r as $v){
				$new_field=str_replace("mall.slider_show_".$id.",","",$v[$field]);
				$new_field=str_replace("mall.slider_show_".$id."","",$new_field);
				$sql2="update ".self::$table_pre."page set `$field`='$new_field' where `id`='".$v['id']."'";
				$pdo->exec($sql2);	
			}
		}
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='del_select_STOP'){
	$ids=safe_str(@$_GET['ids']);
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$ids=explode("|",$ids);
	$ids=array_filter($ids);
	$success='';
	foreach($ids as $id){
		$id=intval($id);
		$sql="delete from ".self::$table_pre."slider where `id`='$id' and `shop_id`=".SHOP_ID;
		if($pdo->exec($sql)){
			del_relevant_file($pdo,self::$table_pre,$id);
			
			$fields=array('left','right','full','head','bottom');
			foreach($fields as $field){
				$sql="select `$field`,`id` from ".self::$table_pre."page where `$field` like '%mall.slider_show_".$id."%'";
				$r=$pdo->query($sql,2);
				foreach($r as $v){
					$new_field=str_replace("mall.slider_show_".$id.",","",$v[$field]);
					$new_field=str_replace("mall.slider_show_".$id."","",$new_field);
					$sql2="update ".self::$table_pre."page set `$field`='$new_field' where `id`='".$v['id']."'";
					$pdo->exec($sql2);	
				}
			}
		
			
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");	
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload(); class=refresh>".self::$language['refresh']."</a>','ids':'".$success."'}");
}

if($act=='submit_select'){
	//var_dump($_POST);	
	$time=time();
	$editor=$_SESSION['monxin']['id'];
	$success='';
	foreach($_POST as $v){
		$v['id']=intval($v['id']);
		$v['duration']=(intval($v['duration'])==0)?20:$v['duration'];
		$v['delay']=(intval($v['delay'])==0)?20:$v['delay'];
		$v['duration']=intval($v['duration']);	
		$v['delay']=intval($v['delay']);	
		$v['width']=safe_str($v['width']);
		$v['height']=safe_str($v['height']);
		$v['width']=add_px($v['width']);
		$v['height']=add_px($v['height']);
		$v['title']=safe_str($v['title']);
		$v['style']=safe_str($v['style']);
		$sql="update ".self::$table_pre."slider set `width`='".$v['width']."',`height`='".$v['height']."',`duration`='".$v['duration']."',`delay`='".$v['delay']."',`title`='".$v['title']."',`style`='".$v['style']."',`time`='$time' where `id`='".$v['id']."' and `shop_id`=".SHOP_ID;
		if($pdo->exec($sql)){$success.=$v['id']."|";}
	}
	$success=trim($success,"|");	
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload(); class=refresh>".self::$language['refresh']."</a>','ids':'".$success."'}");
}

