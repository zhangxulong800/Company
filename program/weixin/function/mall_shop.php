<?php
function mall_shop($pdo,$table_pre,$language,$openid,$postObj,$id){
	//$id=62;
	if($openid==''){$openid=@$_GET['openid'];}
	$id=intval($id);
	$sql="select `username` from ".$pdo->index_pre."user where `openid`='".$openid."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['username']!=''){
		$username=$r['username'];
		$sql="select `id` from ".$pdo->sys_pre."mall_shop_buyer where `shop_id`=".$id." and `username`='".$username."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){
			$sql="select `id` from ".$pdo->sys_pre."mall_shop_buyer_group where `shop_id`=".$id." order by `discount` desc limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			$group_id=$r['id'];
			$sql="insert into ".$pdo->sys_pre."mall_shop_buyer (`username`,`time`,`shop_id`,`group_id`) value ('".$username."','0','".$id."','".$group_id."')";
			$pdo->exec($sql);				
		}
	}

	
	
	
	$sql="select `name`,`main_business` from ".$pdo->sys_pre."mall_shop where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	$r=de_safe_str($r);
	$r['main_business'].="
	
点击进入店铺 > >";
	$data[0]['title']=$r['name'];
	$data[0]['description']=$r['main_business'];
	$data[0]['url']=get_monxin_path().'index.php?monxin=mall.shop_index&shop_id='.$id;
	$data[0]['picurl']=get_monxin_path().'program/mall/ticket_logo/'.$id.'.png';
	return $data;	
}
