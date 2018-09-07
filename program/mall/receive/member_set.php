<?php
$act=@$_GET['act'];
function get_user_group($pdo,$v){
	$sql="select `group` from ".$pdo->index_pre."user where `username`='".$v."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	return $r['group'];		
}

if($act=='update'){	
	$_POST=safe_str($_POST);
	
	if(SHOP_ID==0){exit("{'state':'fail','info':'<span class=fail>".self::$language['forbidden_modify']."</span>'}");}
	$sql="select `cashier`,`storekeeper` from ".self::$table_pre."shop where `id`=".SHOP_ID;
	$old=$pdo->query($sql,2)->fetch(2);
	$old_cashier=explode(',',$old['cashier']);
	$old_storekeeper=explode(',',$old['storekeeper']);
	
	$cashier_a=explode(',',$_POST['cashier']);
	$cashier_a=array_filter($cashier_a);
	$cashier_a=array_unique($cashier_a);
	$storekeeper_a=explode(',',@$_POST['storekeeper']);
	$storekeeper_a=array_filter($storekeeper_a);
	$storekeeper_a=array_unique($storekeeper_a);
		
	$_POST['cashier']='';
	foreach($cashier_a as $v){
		if($v==''){continue;}
		if(in_array($v,$storekeeper_a)){exit("{'state':'fail','info':'<span class=fail>".$v." ".str_replace('{v}',self::$language['storekeeper'],self::$language['and_repeat'])."</span>','key':'cashier'}");}
		if($v==$_SESSION['monxin']['username']){exit("{'state':'fail','info':'<span class=fail>".self::$language['can_not_be'].self::$language['shop_master']."</span>','key':'cashier'}");}
		if(!check_username($pdo,$v)){exit("{'state':'fail','info':'<span class=fail>".$v." ".self::$language['is_not_a_valid'].self::$language['username']."</span>','key':'cashier'}");}
		$sql="select `id` from ".self::$table_pre."shop where (`storekeeper` like '%".$v.",%' || `cashier` like '%".$v.",%')  and `state`!=1 and `id`!=".SHOP_ID;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".$v.' '.self::$language['exist']."</span>','key':'cashier'}");}
		if(get_user_group($pdo,$v)!=self::$config['buyer_group_id'] && get_user_group($pdo,$v)!=self::$config['cashier_group_id']){
			$sql="select `name` from ".$pdo->index_pre."group where `id`=".self::$config['buyer_group_id'];
			$r=$pdo->query($sql,2)->fetch(2);
			exit("{'state':'fail','info':'<span class=fail>".$v.' '.self::$language['group_is_not'].$r['name']."</span>','key':'cashier'}");
		}
		$_POST['cashier'].=$v.',';
	}
	
	$_POST['storekeeper']='';
	foreach($storekeeper_a as $v){
		if($v==''){continue;}
		if(in_array($v,$cashier_a)){exit("{'state':'fail','info':'<span class=fail>".$v." ".str_replace('{v}',self::$language['cashier'],self::$language['and_repeat'])."</span>','key':'cashier'}");}
		if($v==$_SESSION['monxin']['username']){exit("{'state':'fail','info':'<span class=fail>".self::$language['can_not_be'].self::$language['shop_master']."</span>','key':'storekeeper'}");}
		if(!check_username($pdo,$v)){exit("{'state':'fail','info':'<span class=fail>".$v." ".self::$language['is_not_a_valid'].self::$language['username']."</span>','key':'storekeeper'}");}
		$sql="select `id` from ".self::$table_pre."shop where (`storekeeper` like '%".$v.",%' || `cashier` like '%".$v.",%') and `state`!=1 and `id`!=".SHOP_ID;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".$v.' '.self::$language['exist']."</span>','key':'storekeeper'}");}
		if(get_user_group($pdo,$v)!=self::$config['buyer_group_id'] && get_user_group($pdo,$v)!=self::$config['storekeeper_group_id']){
			$sql="select `name` from ".$pdo->index_pre."group where `id`=".self::$config['buyer_group_id'];
			$r=$pdo->query($sql,2)->fetch(2);
			exit("{'state':'fail','info':'<span class=fail>".$v.' '.self::$language['group_is_not'].$r['name']."</span>','key':'storekeeper'}");
		}
		$_POST['storekeeper'].=$v.',';
	}
	
		
	$time=time();
	$sql="update ".self::$table_pre."shop set `cashier`='".$_POST['cashier']."',`storekeeper`='".$_POST['storekeeper']."',`last_time`=".$time;
	
	$sql.=" where `id`=".SHOP_ID;
	file_put_contents('t.txt',$sql);
	
	if($pdo->exec($sql)){
		
		$cashier_a=explode(',',$_POST['cashier']);
		foreach($cashier_a as $v){
			if($v==''){continue;}
			$sql="update ".$pdo->index_pre."user set `group`='".self::$config['cashier_group_id']."' where `username`='".$v."'";
			$pdo->exec($sql);	
		}
		$storekeeper_a=explode(',',$_POST['storekeeper']);
		foreach($storekeeper_a as $v){
			if($v==''){continue;}
			$sql="update ".$pdo->index_pre."user set `group`='".self::$config['storekeeper_group_id']."' where `username`='".$v."'";
			$pdo->exec($sql);	
		}
		
		$temp=explode(',',$old['cashier']);
		foreach($temp as $v){
			if($v==''){continue;}
			if(!in_array($v,$cashier_a)){
				$sql="update ".$pdo->index_pre."user set `group`='".self::$config['buyer_group_id']."' where `username`='".$v."'";
				$pdo->exec($sql);	
			}
		}
		
		$temp=explode(',',$old['storekeeper']);
		foreach($temp as $v){
			if($v==''){continue;}
			if(!in_array($v,$storekeeper_a)){
				$sql="update ".$pdo->index_pre."user set `group`='".self::$config['buyer_group_id']."' where `username`='".$v."'";
				$pdo->exec($sql);	
			}
		}
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
		
}