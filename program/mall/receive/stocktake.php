<?php
$act=@$_GET['act'];
if($act=='add'){
	$_GET['name']=safe_str($_GET['name']);
	$sql="select `id`,`state` from ".self::$table_pre."stocktake where `shop_id`='".SHOP_ID."' order by `id` desc limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if(isset($r['id']) && $r['state']==0){exit("{'state':'fail','info':'<span class=fail>".self::$language['stocktake_not_finished']."</span>'}");}
	$sql="insert into ".self::$table_pre."stocktake (`name`,`username`,`shop_id`,`time`) values ('".$_GET['name']."','".$_SESSION['monxin']['username']."','".SHOP_ID."','".time()."')";
	if($pdo->exec($sql)){
		$stocktake_id=$pdo->lastInsertId();
		$sql="select `id`,`title`,`option_enable`,`shop_type`,`position` from ".self::$table_pre."goods where `shop_id`='".SHOP_ID."' and `inventory`>0";
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			$v['s_id']=0;
			if($v['option_enable']){
				$sql="select `id`,`color_name`,`option_id` from ".self::$table_pre."goods_specifications where `goods_id`='".$v['id']."' and `quantity`>0";
				$t=$pdo->query($sql,2);
				foreach($t as $vv){
					$v['title'].='<b class=option>'.self::get_type_option_name($pdo,$vv['option_id'])." ".$vv['color_name'].'</b>';
					$sql="insert into ".self::$table_pre."stocktake_goods (`goods_id`,`s_id`,`shop_id`,`title`,`stocktake_id`,`username`,`shop_type`,`position`) values ('".$v['id']."','".$vv['id']."','".SHOP_ID."','".$v['title']."','".$stocktake_id."','".$_SESSION['monxin']['username']."','".$v['shop_type']."','".$v['position']."')";
					$pdo->exec($sql);	
				}	
			}else{
				$sql="insert into ".self::$table_pre."stocktake_goods (`goods_id`,`s_id`,`shop_id`,`title`,`stocktake_id`,`username`,`shop_type`,`position`) values ('".$v['id']."','0','".SHOP_ID."','".$v['title']."','".$stocktake_id."','".$_SESSION['monxin']['username']."','".$v['shop_type']."','".$v['position']."')";
				$pdo->exec($sql);	
			}
		}
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='del'){
	$id=intval(@$_GET['id']);
	if($id<1){exit();}
	$sql="delete from ".self::$table_pre."stocktake where `id`='$id' and `shop_id`=".SHOP_ID;
	if($pdo->exec($sql)){
		$sql="delete from ".self::$table_pre."stocktake_goods where `stocktake_id`=".$id;
		$pdo->exec($sql);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}

}

