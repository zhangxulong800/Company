<?php
$_POST['id']=intval(@$_POST['id']);
$goods_id=intval(@$_GET['goods_id']);
//$_POST['discount']=floatval(@$_POST['discount']);
if($_POST['discount']>10){$_POST['discount']=10;}
if($_POST['discount']<0){$_POST['discount']=0;}
if(!is_numeric($_POST['discount'])){$_POST['discount']=0;}
$act=$_GET['act'];
if($act=='update'){
	$sql="select `id` from ".self::$table_pre."goods_group_discount where `goods_id`=".$goods_id." and `group_id`=".$_POST['id']." limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){
		if($_POST['discount']!=0){
			$sql="update ".self::$table_pre."goods_group_discount set `discount`=".$_POST['discount']." where `goods_id`=".$goods_id." and `group_id`=".$_POST['id']." limit 1";
		}else{
			$sql="delete from ".self::$table_pre."goods_group_discount where `goods_id`=".$goods_id." and `group_id`=".$_POST['id']." limit 1";
		}
	}else{
		if($_POST['discount']==0){exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");}
		$sql="insert into ".self::$table_pre."goods_group_discount (`goods_id`,`group_id`,`discount`) values ('".$goods_id."','".$_POST['id']."','".$_POST['discount']."')";
	}
	//file_put_contents('t.txt',$sql);
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

