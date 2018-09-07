<?php
$sql="select `openid` from ".$pdo->index_pre."user where `id`='".$_SESSION['monxin']['id']."'";
$r=$pdo->query($sql,2)->fetch(2);
$open_id=$r['openid'];
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$sql="select `id` from ".$pdo->sys_pre."weixin_account where `wid`='".self::$config['web']['wid']."' and `state`=1 limit 0,1";
$t=$pdo->query($sql,2)->fetch(2);	
if($t['id']==''){echo '<div style="line-height:100px; text-align:center;">'.self::$language['no_web_weixin'].' <a href=./index.php?monxin=index.config#web__diy_meta><b>'.self::$language['set'].'</b></a></div>';return false;}



$sql="select `url`,`name` from ".$pdo->sys_pre."weixin_diy_qr where `wid`='".self::$config['web']['wid']."' and `key`='get_reg_authcode' limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['url']==''){echo '<div style="line-height:100px; text-align:center;">'.self::$language['no_set_weixin_qr'].' <a href=./index.php?monxin=weixin.diy_qr&wid='.self::$config['web']['wid'].'><b>'.self::$language['set'].'</b></a></div>';return false;}

if(!is_file("./program/weixin/diy_qr_icon/".self::$config['web']['wid'].".png")){
	$icon_path='../../qr_icon.png';
}else{
	$icon_path='../../program/weixin/diy_qr_icon/'.self::$config['web']['wid'].'.png';
}
$html='<div>'.$r['name'].'</div><img class="qr_img" src="./plugin/qrcode/index.php?text='.$r['url'].'&logo=1&logo_path='.$icon_path.'" />';

if($_COOKIE['monxin_device']=='phone'){
	$html='<div>'.$r['name'].'<br /><a href=# class=weixin_scan_img_demo>'.self::$language['view'].self::$language['weixin_scan_img_demo'].'</a></div><img class="qr_img" src="./plugin/qrcode/index.php?text='.$r['url'].'&logo=1&logo_path=../../program/weixin/diy_qr_icon/'.self::$config['web']['wid'].'.png">';
}

$module['html']=$html;
$module['act_name']=self::$language['bound_2'];
$module['weixin_name']='';
$module['exist_div']='none';
$module['bind']='block';

$sql="select `nickname`,`headimgurl`,`state` from ".$pdo->sys_pre."weixin_user where `wid`='".self::$config['web']['wid']."' and `openid`='".$open_id."' limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['nickname']!=''){
	$module['weixin_name']='<img src='.de_safe_str($r['headimgurl']).' class=open_icon>'.$r['nickname'];
	$module['act_name']=self::$language['cancel'].self::$language['bound_2'];
	$module['exist_div']='block';
	$module['bind']='none';
}else{
	//$sql="update ".$pdo->index_pre."user set `openid`='' where `id`='".$_SESSION['monxin']['id']."'";
	//$pdo->exec($sql);
}



$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
