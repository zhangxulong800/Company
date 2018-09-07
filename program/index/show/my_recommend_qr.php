<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$sql="select `wx_qr` from ".$pdo->index_pre."user where `id`=".$_SESSION['monxin']['id'];
$r=$pdo->query($sql,2)->fetch(2);
if(($r['wx_qr']==''  && self::$config['web']['wid']!='') || self::$config['web']['wid']!='gh_7eca8f5d4da0' ){
	get_weixin_info(self::$config['web']['wid'],$pdo); 
	$data='{
			"action_name": "QR_LIMIT_STR_SCENE", 
			"action_info": {
				"scene": {
					"scene_str": "new_user__'.$_SESSION['monxin']['id'].'"
				}
			}
		}';	
	$r= https_post('https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$_POST['monxin_weixin'][self::$config['web']['wid']]['token'],$data);
	$r=json_decode($r,1);
	if(isset($r['url'])){
		$sql="update ".$pdo->index_pre."user set `wx_qr`='".safe_str($r['url'])."' where `id`='".$_SESSION['monxin']['id']."'";
		$pdo->exec($sql);
		$r['wx_qr']=safe_str($r['url']);
	}	
}
$r['wx_qr']=de_safe_str(@$r['wx_qr']);


	$url='index.reg_user&&group_id='.self::$config['reg_set']['default_group_id'];
	$user_id=$_SESSION['monxin']['id'];
	$sql="select * from ".$pdo->index_pre."surl where `url`='".$url."' and `user_id`=".$user_id." limit 0,1";
	$share=$pdo->query($sql,2)->fetch(2);	
	if($share['id']==''){
		$title=self::$language['pages']['index.reg_user']['name'];
		$sql="insert into ".$pdo->index_pre."surl (`url`,`user_id`,`title`,`time`,`username`) values ('".$url."','".$user_id."','".$title."','".time()."','".$_SESSION['monxin']['username']."')";
		if($pdo->exec($sql)){
			$new_id=$pdo->lastInsertId();
			$sql="select * from ".$pdo->index_pre."surl where `id`=".$new_id;
			$share=$pdo->query($sql,2)->fetch(2);	
		}	

	}
	$share_url='http://'.self::$config['web']['domain'].'/?u='.number_to_letter($share['id'],6);



$module['icon']=$_SESSION['monxin']['icon'];
$module['share']=$_SESSION['monxin']['id'];
$module['reg_url']=$share_url;
if($r['wx_qr']==''){
	$module['qr_text']=$share_url.'|||monxin_device=phone';
}else{
	$module['qr_text']=str_replace('&','|||',$r['wx_qr']);
}

$module['recommend_word']= self::$config['web']['recommend_word'];
$module['user_icon']=$_SESSION['monxin']['icon'];
$module['nickname']=$_SESSION['monxin']['nickname'];







$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
