<?php
function not_found_content($account,$pdo,$language,$key,$openid){
	if($openid==''){$openid=@$_GET['openid'];}
	$data[0]['title']='《'.$key.'》'.$language['system_did_not_find_relevant_content'];
	$data[0]['description']='';
	$data[0]['url']='';
	$data[0]['picurl']=get_monxin_path().'program/weixin/img/cry.png';
	return $data;	
}
