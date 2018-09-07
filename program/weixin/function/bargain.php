<?php
function bargain($pdo,$table_pre,$language,$openid,$postObj,$id){
	$config=require('./config.php');
	if($openid==''){$openid=@$_GET['openid'];}
	$id=intval($id);
	$sql="select * from ".$pdo->sys_pre."bargain_log where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);	
	$sql="select `username` from ".$pdo->index_pre."user where `openid`='".safe_str($openid)."' limit 0,1";
	$r2=$pdo->query($sql,2)->fetch(2);	
	set_user_introducer($pdo,$r['username'],$r2['username']);	
	
	$sqo="select * from ".$pdo->sys_pre."bargain_goods where `id`=".$r['b_id'];
	$b=$pdo->query($sql,2)->fetch(2);
	
	
	$r=de_safe_str($r);
	$data[0]['title']="欢迎关注，点击这里继续帮朋友完成砍价";
	$data[0]['description']='帮好友砍价后，您还可以自己创建参加砍价活动';
	$data[0]['url']=get_monxin_path().'index.php?monxin=bargain.detail&id=9&l='.$id."&bargain=1";
	$data[0]['picurl']=get_monxin_path().'./templates/0/bargain/default/phone/img/weixin.png';
	return $data;	
}
