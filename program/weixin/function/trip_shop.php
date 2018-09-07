<?php
function trip_shop($pdo,$table_pre,$language,$openid,$postObj,$id){
	//$id=62;
	if($openid==''){$openid=@$_GET['openid'];}
	$id=intval($id);
	$sql="select `username` from ".$pdo->index_pre."user where `openid`='".$openid."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['username']!=''){
	}

	
	
	
	$sql="select `name`,`main_business` from ".$pdo->sys_pre."trip_shop where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	$r=de_safe_str($r);
	$r['main_business'].="
	
点击进入 ".$r['name']." > >";
	$data[0]['title']=$r['name'];
	$data[0]['description']=$r['main_business'];
	$data[0]['url']=get_monxin_path().'index.php?monxin=trip.shop_index&shop_id='.$id;
	$data[0]['picurl']=get_monxin_path().'program/trip/ticket_logo/'.$id.'.png';
	return $data;	
}
