<?php
$id=intval(@$_GET['id']);
if($id==0){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
$act=@$_GET['act'];
if($act=='count'){
	$sql="update ".self::$table_pre."title set `visit`=`visit`+1 where `id`=".$id;
	$pdo->exec($sql);	
}


$sql="select `type` from ".self::$table_pre."title where `id`=".$id;
$r=$pdo->query($sql,2)->fetch(2);
$type=$r['type'];

$sql="select `content_power` from ".self::$table_pre."type where `id`='".$r['type']."' and `visible`=1";
$r=$pdo->query($sql,2)->fetch(2);
$power=explode('|',$r['content_power']);
if(!isset($_SESSION['monxin']['username'])){exit("{'state':'fail','info':'<a href=index.php?monxin=index.login>".self::$language['please_login']."</a>'}");}
if(!in_array($_SESSION['monxin']['group_id'],$power)){exit("{'state':'fail','info':'<span class=fail>".self::$language['act_noPower']."</span>'}");}

if($act=='submit_content'){
	if($_POST['content']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['content'].self::$language['is_null']."</span>'}");}
	if(strtolower($_POST['authcode'])!=strtolower($_SESSION["authCode"])){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['authcode_err']."</span>'}");			
	}
	if(self::add_content($pdo,$_POST['content'],$id,$type,0,intval($_POST['email']))){
		$_SESSION["authCode"]=rand(-9999999999,9999999999999999);
		$sql="select count(id) as c from ".self::$table_pre."content  where `title_id`='".$id."' and `for`=0 and `visible`=1";
		$r=$pdo->query($sql,2)->fetch(2);
		$module_config=require './program/talk/module_config.php';
		$end_page=ceil((intval($r['c'])+1)/$module_config['talk.content']['pagesize']);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']." <a href=./index.php?monxin=talk.content&id=".$id."&current_page=".$end_page."&scroll=content_".$_POST['insret_id']." class=view>".self::$language['view']."</a></span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
	
	exit;
}

if($act=='submit_comment'){
	if($_POST['comment_input']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['content'].self::$language['is_null']."</span>'}");}
	if(strtolower($_POST['comment_auth'])!=strtolower($_SESSION["comment_auth"])){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['authcode_err']."</span>'}");			
	}
	if(self::add_content($pdo,$_POST['comment_input'],$id,$type,intval($_POST['for_id']))){
		$_SESSION["comment_auth"]=rand(-9999999999,9999999999999999);		
		$html="<div class=comment_div id=content_".$_POST['insret_id'].">".'<span class=username>'.$_SESSION['monxin']['username'].'</span><span class=time>'.get_time(self::$config['other']['date_style']." H:i",self::$config['other']['timeoffset'],self::$language,time()).'</span><div class=comemnt><div class=v>'.$_POST['comment_input']."</div> <div class=buttons2><a href=# onclick=\"return del(".$_POST['insret_id'].")\"  class=del>".self::$language['del']."</a> <span id=state_".$_POST['insret_id']." class=state></span></div></div></div>";
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']." <a href=\'javascript:window.location.reload();\' class=refresh>".self::$language['refresh']."</a></span>','html':'".$html."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
	
	exit;
}
if($act=='del'){
	$cid=intval(@$_GET['cid']);
	if($cid==0){exit("{'state':'fail','info':'<span class=fail>cid err</span>'}");}
	if(self::del_content($pdo,$cid,$type)){
		$sql="select `id` from ".self::$table_pre."content where `for`=".$id;
		$r=$pdo->query($sql,2);
		foreach($r as $v){self::del_content($pdo,$v['id'],$type);}
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='hide'){
	$cid=intval(@$_GET['cid']);
	if($cid==0){exit("{'state':'fail','info':'<span class=fail>cid err</span>'}");}
	$sql="update ".self::$table_pre."content set `visible`=0  where `id`=".$cid;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='show'){
	$cid=intval(@$_GET['cid']);
	if($cid==0){exit("{'state':'fail','info':'<span class=fail>cid err</span>'}");}
	$sql="update ".self::$table_pre."content set `visible`=1  where `id`=".$cid;
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
