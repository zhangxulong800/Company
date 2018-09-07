<?php
function agency_store($pdo,$table_pre,$language,$openid,$postObj,$id){
	$config=require('./config.php');
	if($openid==''){$openid=@$_GET['openid'];}
	$id=intval($id);
	$sql="select * from ".$pdo->sys_pre."agency_store where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);	
	$sql="select `username` from ".$pdo->index_pre."user where `openid`='".safe_str($openid)."' limit 0,1";
	$r2=$pdo->query($sql,2)->fetch(2);	
	set_user_introducer($pdo,$r['username'],$r2['username']);	
	auto_create_store($pdo,$r2['username']);
	$r=de_safe_str($r);
	$data[0]['title']=$config['web']['name']." ".$r['name']."的店";
	$data[0]['description']='点击进入';
	$data[0]['url']=get_monxin_path().'index.php?monxin=agency.shop&store_id='.$id;
	$data[0]['picurl']=get_monxin_path().'program/agency/shop_icon/'.$r['icon'];
	$data[0]['picurl']=get_monxin_path().'logo.png';
	return $data;	
}
