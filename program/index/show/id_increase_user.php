<?php
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['random']=get_verification_code(6);

$sql="select `url`,`name` from ".$pdo->sys_pre."weixin_diy_qr where `wid`='".self::$config['web']['wid']."' and `key`='get_reg_authcode' limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
$module['weixin_code']='';
if($r['url']!=''){
	$module['weixin_code']='<div>'.$r['name'].'</div><img class="qr_img" src="./plugin/qrcode/index.php?text='.$r['url'].'&logo=1&logo_path=../../program/weixin/diy_qr_icon/'.self::$config['web']['wid'].'.png">';
}

$module['data']['gender'][0]=get_select_txt($pdo,4);
$module['data']['gender'][1]=get_select_txt($pdo,5);

$module['minzu_html']='';
foreach(self::$language['minzu_array'] as $k=>$v){
	$module['minzu_html'].='<span k="'.$k.'">'.$v.'</span>';
}


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);

