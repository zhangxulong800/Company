<?php
$act=@$_GET['act'];
if($act=='add_address'){
	$username=safe_str($_POST['username']);
	if($username==''){echo "{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}";exit;}
	$sql="select `username` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['username']==''){
		$sql="select `username` from ".$pdo->index_pre."user where `phone`='".$username."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
	}
	if($r['username']==''){echo "{'state':'fail','info':'<span class=fail>".self::$language['user'].self::$language['not_exist']."</span>'}";exit;}
	
	$username=$r['username'];
	$sql="select `id` from ".self::$table_pre."addressee where `addressee`='".$r['username']."' and `username`='".$_SESSION['monxin']['username']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){echo "{'state':'exists','info':'<span class=fail>".self::$language['already_exists']."</span>','username':'".$username."'}";exit;}
	
	$sql="insert into ".self::$table_pre."addressee (`username`,`addressee`,`last_time`) values ('".$_SESSION['monxin']['username']."','".$username."','".time()."')";
	if($pdo->exec($sql)){
		$new_id=$pdo->lastInsertId();
		echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>','username':'".$username."','new_id':'".$new_id."'}";
	}else{
		echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
	}
	exit;	
}

if($act=='del'){
	$id=intval($_POST['id']);
	$sql="select * from ".self::$table_pre."addressee where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['username']!=$_SESSION['monxin']['username']){echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']." username err</span>'}";}
	
	$sql="update ".self::$table_pre."addressee set `last_msg`='' where `id`=".$id."";
	if($pdo->exec($sql)){
		self::delete_addressee_info($pdo,$r['addressee'],$_SESSION['monxin']['username']);
		
		$sql="delete from ".self::$table_pre."addressee where `id`=".$id;
		$pdo->exec($sql);
		echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
	}else{
		$sql="delete from ".self::$table_pre."addressee where `id`=".$id;
		$pdo->exec($sql);
		echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
	}	
}


if($act=='del_log'){
	$id=intval($_POST['id']);
	$sql="select * from ".self::$table_pre."addressee where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['username']!=$_SESSION['monxin']['username']){echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']." username err</span>'}";}
	
	$sql="update ".self::$table_pre."addressee set `last_msg`='' where `id`=".$id."";
	if($pdo->exec($sql)){
		self::delete_addressee_info($pdo,$r['addressee'],$_SESSION['monxin']['username']);
		echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
	}else{
		echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
	}	
}

if($act=='set_blacklist'){
	$id=intval($_POST['id']);
	$sql="select * from ".self::$table_pre."addressee where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['username']!=$_SESSION['monxin']['username']){echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";}
	
	$sql="update ".self::$table_pre."addressee set `state`=2 where `id`=".$id."";
	if($pdo->exec($sql)){
		echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
	}else{
		echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
	}	
}

if($act=='unset_blacklist'){
	$id=intval($_POST['id']);
	$sql="select * from ".self::$table_pre."addressee where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['username']!=$_SESSION['monxin']['username']){echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";}
	
	$sql="update ".self::$table_pre."addressee set `state`=1  where `id`=".$id."";
	if($pdo->exec($sql)){
		echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
	}else{
		echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
	}	
}

if($act=='del_selected_stop'){
	$ids=safe_str($_POST['ids']);
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$ids=explode(",",$ids);
	$ids=array_filter($ids);
	$success='';
	foreach($ids as $id){
		$id=intval($id);
		$sql="select * from ".self::$table_pre."addressee where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['username']!=$_SESSION['monxin']['username']){continue;}
		$sql="update ".self::$table_pre."addressee set `last_msg`='' where `id`=".$id."";
		if($pdo->exec($sql)){$success.=$id."|";}
		self::delete_addressee_info($pdo,$r['addressee'],$_SESSION['monxin']['username']);		
	}
	$success=trim($success,"|");	
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>','ids':'".$success."'}");
}

if($act=='send'){
	$_POST=safe_str($_POST);
	$ids=$_POST['ids'];
	$msg=$_POST['msg'];
	$msg=trim($msg);
	//$msg=trim($msg,'<br>');
	$msg=trim($msg);
	$time=time();
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['please_select'].self::$language['user']."</span>'}");}
	if($msg==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
	$forbidden=self::$config['forbidden'];
	$forbidden=explode(',',$forbidden);
	foreach($forbidden as $v){
		if($v==''){continue;}
		if(strpos($msg,$v)!==false){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist_forbidden']."</span>'}");}
	}
	
	$msg_id=0;
	$sql="select `id` from ".self::$table_pre."msg where `content`='".$msg."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){
		$msg_id=$r['id'];
		$sql="update ".self::$table_pre."msg set `used`=`used`+1 where `id`=".$msg_id;
		$pdo->exec($sql);
	}else{
		$sql="insert into ".self::$table_pre."msg (`username`,`time`,`content`) values ('".$_SESSION['monxin']['username']."','".$time."','".$msg."')";
		if($pdo->exec($sql)){
			$msg_id=$pdo->lastInsertId();
		}
	}
	if($msg_id==0){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
	
	$ids=explode(",",$ids);
	$ids=array_filter($ids);
	$success='';
	$fails='';
	foreach($ids as $id){
		$id=intval($id);
		$sql="select `addressee` from ".self::$table_pre."addressee where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		
		$sql="select `state`,`id` from ".self::$table_pre."addressee where `username`='".$r['addressee']."' and `addressee`='".$_SESSION['monxin']['username']."' limit 0,1";
		$a=$pdo->query($sql,2)->fetch(2);
		if($a['state']==2){$fails.=$id.'|';continue;}
		if($r['addressee']==$_SESSION['monxin']['username']){$fails.=$id.'|';continue;}
		
		$sql="insert into ".self::$table_pre."msg_info (`state`,`sender`,`addressee`,`msg_id`,`time`) values ('1','".$_SESSION['monxin']['username']."','".$r['addressee']."','".$msg_id."','".$time."')";
		if($pdo->exec($sql)){
			if(!is_online($pdo,$r['addressee'])){
				$url='http://'.self::$config['web']['domain'].'/index.php?monxin=im.talk&with='.$_SESSION['monxin']['username'];
				$first=str_replace('{username}',$r['addressee'],self::$language['you_have_a_new_message']);
				push_new_msg_info($pdo,self::$config,self::$language,$r['addressee'],$_SESSION['monxin']['username'],$msg,$url,$first);
			}			
			if($a['id']==''){self::add_addressee($pdo,$r['addressee'],$_SESSION['monxin']['username']);}
			$last_msg=mb_substr($msg,0,10,'utf-8');
			$temp=explode('<img src=',$last_msg);
			if(isset($temp[1])){$last_msg=self::$language['image'];}
			$last_msg=strip_tags($last_msg);
			$sql="update ".self::$table_pre."addressee set `last_msg`='".$last_msg."',`last_time`='".$time."' where `id`=".$id;
			$pdo->exec($sql);
			$sql="update ".self::$table_pre."addressee set `last_msg`='".$last_msg."',`last_time`='".$time."' where `username`='".$r['addressee']."' and `addressee`='".$_SESSION['monxin']['username']."' limit 1";
			$pdo->exec($sql);
			$success.=$id.'|';
		}
			
	}
	$success=trim($success,"|");	
	$fails=trim($fails,"|");	
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>','ids':'".$success."','fails':'".$fails."'}");
}


if($act=='get_log'){
	//var_dump($_POST);
	$id=intval($_POST['id']);
	$info_id=intval($_POST['info_id']);
	
	$sql="select `addressee` from ".self::$table_pre."addressee where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	$addressee=$r['addressee'];
	$sql="select `icon` from ".$pdo->index_pre."user where `username`='".$addressee."' limit 0,1";
	$u=$pdo->query($sql,2)->fetch(2);
	if($u['icon']==''){$u['icon']='default.png';}
	if(!is_url($u['icon'])){$u['icon']="./program/index/user_icon/".$u['icon'];}
	$r=self::get_before_log($pdo,$id,$addressee,$u['icon'],$_SESSION['monxin']['icon'],$info_id);
	//if($r==''){$r='<div class=no_log>no_log</div>';}
	exit($r);
	
}

if($act=='get_new_msg'){
	$load_time=floatval($_GET['load_time']);
	$sql="select `time`,`sender`,`msg_id`,`id`,`sender` from ".self::$table_pre."msg_info where `time`>".$load_time." and `addressee`='".$_SESSION['monxin']['username']."' and `addressee_state`=1 and `ajax_show`=0 and `delete_a`!='".$_SESSION['monxin']['username']."' and  `delete_b`!='".$_SESSION['monxin']['username']."' order by `time` desc";
	$r=$pdo->query($sql,2);
	$ids='';
	$sender=array();
	foreach($r as $v){
		if(!isset($sender[$v['sender']])){
			$sql="select `addressee`,`id`,`last_time`,`last_msg` from ".self::$table_pre."addressee where `username`='".$_SESSION['monxin']['username']."' and `addressee`='".$v['sender']."' limit 0,1";
			$sender[$v['sender']]=$pdo->query($sql,2)->fetch(2);
			$sql="select `icon` from ".$pdo->index_pre."user where `username`='".$v['sender']."' limit 0,1";
			$u=$pdo->query($sql,2)->fetch(2);
			if($u['icon']==''){$u['icon']='default.png';}
			if(!is_url($u['icon'])){$u['icon']="./program/index/user_icon/".$u['icon'];}
			$sender[$v['sender']]['icon']=$u['icon'];
			$sender[$v['sender']]['msg']='';
			$sender[$v['sender']]['ids']='';
			$sender[$v['sender']]['last_time']=self::show_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$sender[$v['sender']]['last_time']);
			$sender[$v['sender']]['msg_sum']=0;
			
			
		}
		$msg_c=self::get_msg_content($pdo,$v['msg_id']);
		$sender[$v['sender']]['msg'].='<div class=time>'.self::show_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time']).'</div><div class="info you" id=info_'.$v['id'].'><a class=icon><img src="'.$sender[$v['sender']]['icon'].'" /></a><div class=c><span class=horn></span><span class=content>'.$msg_c.'</span></div></div>';
		$sender[$v['sender']]['msg_sum']++;
		$ids.=$v['id'].',';
		$sender[$v['sender']]['ids']=$v['id'].',';
	}
	$ids=trim($ids,',');
	$sql="update ".self::$table_pre."msg_info set `ajax_show`=1 where `id` in (".$ids.") and `addressee`='".$_SESSION['monxin']['username']."' ";
	$r=$pdo->exec($sql);
	
	$sender=json_encode($sender);
	exit($sender);
	
}

if($act=='update_info_stete'){
	$ids=safe_str($_POST['ids']);
	$ids=str_replace(',,',',',$ids);
	$ids=trim($ids,',');
	
	$a=explode(',',$ids);
	$ids='';
	foreach($a as $v){
		if($v==''){continue;}
		$ids.=intval($v).',';
	}
	$ids=trim($ids,',');
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
	$sql="update ".self::$table_pre."msg_info set `addressee_state`=2 where `id` in (".$ids.") and `addressee`='".$_SESSION['monxin']['username']."' ";
	//file_put_contents('t.txt',$sql);
	$r=$pdo->exec($sql);
	if($r){
		echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>','effect':'".$r."'}";
	}else{
		echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
	}	
	
}
