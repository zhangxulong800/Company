<?php
$act=@$_GET['act'];
if($act=='exchange'){
	$id=intval($_POST['id']);
	if($id==0){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
	if(!isset($_SESSION['monxin']['id'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['please_login']."</span>'}");}
	$sql="select `credits`,`id` from ".$pdo->index_pre."user where `id`=".$_SESSION['monxin']['id'];
	$user=$pdo->query($sql,2)->fetch(2);
	if($user['id']==''){exit("{'state':'fail','info':'<span class=fail>user err</span>'}");}
	$sql="select * from ".self::$table_pre."prize where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>prize id err</span>'}");}
	if($r['state']==0){exit("{'state':'fail','info':'<span class=fail>state err</span>'}");}
	if($r['quantity']<1){exit("{'state':'fail','info':'<span class=fail>".self::$language['no_prize']."</span>'}");}
	if($r['money']>$user['credits']){exit("{'state':'fail','info':'<span class=fail>".self::$language['credit'].self::$language['insufficient']."</span>'}");}
	$reason=self::$language['exchange'].$r['name'];
	if(operation_credits($pdo,self::$config,self::$language,$_SESSION['monxin']['username'],'-'.$r['money'],$reason,'other')){
		$sql="insert into ".self::$table_pre."prize_log (`p_id`,`p_name`,`money`,`username`,`time`) values ('".$r['id']."','".$r['name']."','".$r['money']."','".$_SESSION['monxin']['username']."','".time()."')";		
		if($pdo->exec($sql)){
			$sql="update ".self::$table_pre."prize set `quantity`=`quantity`-1,`use`=`use`+1 where `id`=".$r['id'];
			$pdo->exec($sql);
			
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");	
		}
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
	
}
