<?php
foreach($_GET as $key=>$v){
	if($v==''){exit("{'state':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");}
}
$act=@$_GET['act'];
if($act=='add'){
	$time=time();
	$_GET['name']=safe_str($_GET['name']);
	$_GET['username']=safe_str($_GET['username']);
	$sql="select `id`,`group` from ".$pdo->index_pre."user where `username`='".$_GET['username']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>".$_GET['username'].self::$language['not_exist']."</span>'}");}
	if($r['group']!=self::$config['reg_set']['default_group_id']){
		$sql="select `name` from ".$pdo->index_pre."group where `id`=".self::$config['reg_set']['default_group_id'];
		$r=$pdo->query($sql,2)->fetch(2);
		exit("{'state':'fail','info':'<span class=fail>".$_GET['username'].self::$language['is_not'].$r['name']."</span>'}");
	}
	
	
	$sql="select `id` from ".self::$table_pre."headquarters where `username`='".$_GET['username']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".$_GET['username'].self::$language['already_exists']."</span>'}");}
	
	$sql="insert into ".self::$table_pre."headquarters (`name`,`username`,`time`) values ('".$_GET['name']."','".$_GET['username']."','".$time."')";
	if($pdo->exec($sql)){
		$sql="select `id` from ".self::$table_pre."shop where `username`='".$_GET['username']."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){
			$sql="select `dir` from ".self::$table_pre."template where `state`=1 and `for_shop`='*' order by `sequence` desc limit 0,1";
			$r3=$pdo->query($sql,2)->fetch(2);
			$template=$r3['dir'];
			
			$sql="insert into ".self::$table_pre."shop (`username`,`reg_username`,`name`,`state`,`reg_time`,`last_time`,`template`,`is_head`) values ('".$_GET['username']."','".$_GET['username']."','".$_GET['name']."','2','".$time."','".$time."','".$template."',1)";
		}else{
			$sql="update ".self::$table_pre."shop set `name`='".$_GET['name']."',`last_time`=".$time." where `id`=".$r['id'];
		}
		if($pdo->exec($sql)){
			if($r['id']==''){$new_id=$pdo->lastInsertId();}
			$sql="update ".$pdo->index_pre."user set `group`='".self::$config['headquarters_group_id']."' where `username`='".$_GET['username']."'";
			$pdo->exec($sql);
			
			if($r['id']==''){
				$sql="INSERT INTO  ".self::$table_pre."page (`head` ,`left` ,`right` ,`full` ,`phone` ,`layout` ,`id` ,`url` ,`shop_id` ,`bottom`) VALUES (NULL , NULL , NULL ,  'mall.goods(relevance_package_div:3|relevance_goods_div:2|goods_detail_div:1)', NULL ,  'full', NULL ,  'mall.goods',  '".$new_id."', NULL);";
				if($pdo->exec($sql)){
					exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
				}else{
					exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
				}
			}
			
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}else{
			$sql="delete from ".self::$table_pre."headquarters where `username`='".$_GET['username']."'";
			$pdo->exec($sql);
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
		
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}


if($act=='update'){
	$_GET['name']=safe_str($_GET['name']);
	$_GET['id']=intval(@$_GET['id']);
	$sql="update ".self::$table_pre."headquarters set `name`='".$_GET['name']."' where `id`='".$_GET['id']."'";
	//echo $sql;
	if($pdo->exec($sql)){
		$sql="select `username` from ".self::$table_pre."headquarters  where `id`='".$_GET['id']."'";
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="update ".self::$table_pre."shop set `name`='".$_GET['name']."' where `username`='".$r['username']."' limit 1";
		$pdo->exec($sql);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
	}
}
if($act=='del'){
	$id=intval(@$_GET['id']);
	if($id<1){exit();}
	$sql="delete from ".self::$table_pre."headquarters where `id`='$id'";
	if($pdo->exec($sql)){
		//$sql="delete from ".self::$table_pre."shop where ";
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}

}

