<?php
function function_close($pdo,$table_pre,$language,$openid){
	if($openid==''){$openid=@$_GET['openid'];}
	$data[0]['title']=$language['function_close'];
	$data[0]['description']='';
	$data[0]['url']='';
	$data[0]['picurl']=get_monxin_path().'program/weixin/img/cry.png';
	return $data;	
}
