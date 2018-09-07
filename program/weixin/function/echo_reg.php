<?php
function echo_reg($pdo,$table_pre,$language,$openid){
	if($openid==''){$openid=@$_GET['openid'];}
	$data[0]['title']=$language['welcome'].$language['reg_user'];
	$data[0]['description']=$language['click'].$language['reg_user'];
	$data[0]['url']=get_monxin_path().'index.php?monxin=index.reg_user&openid='.$openid;
	$data[0]['picurl']=get_monxin_path().'logo.png';
	return $data;	
}
