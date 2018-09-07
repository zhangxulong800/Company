<?php
$time=time();
$today=get_date($time,'Y-m-d',self::$config['other']['timeoffset']);
$sql="select `id` from ".$pdo->index_pre."withdraw where `username`='".$_SESSION['monxin']['username']."' and `time`>".$today." limit ".self::$config['withdraw_set']['max_time'].",1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']!=''){echo '<div style="text-align:center;line-height:100px;">'.self::$language['config_language']['withdraw_set']['max_time'].':'.self::$config['withdraw_set']['max_time'].'</div>';return false;}

$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$sql="select `money`,`real_name`,`openid` from ".$pdo->index_pre."user where `id`='".$_SESSION['monxin']['id']."'";
$r=$pdo->query($sql,2)->fetch(2);
$module['user_money']=$r['money'];
$module['real_name']=$r['real_name'];

if($module['real_name']==''){header('location:./index.php?monxin=index.edit_user&field=real_name');exit;}

$module['weixin_name']='';
$module['withdraw_method_1']='';
$sql="select `nickname`,`headimgurl`,`state` from ".$pdo->sys_pre."weixin_user where `wid`='".self::$config['web']['wid']."' and `openid`='".$r['openid']."' limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['nickname']!=''){
	$module['weixin_name']='<img src='.de_safe_str($r['headimgurl']).' class=open_icon>'.$r['nickname'];
	$module['withdraw_method_1']='<input type="radio" name=radio  class=radio value=1 />'.self::$language['openid'];
}

self::$language['billing_info_template_old']=self::$language['billing_info_template'];
$sql="select `billing_info` from ".$pdo->index_pre."withdraw where `username`='".$_SESSION['monxin']['username']."' order by `id` desc limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['billing_info']!=''){self::$language['billing_info_template']=str_replace($module['real_name'],'',$r['billing_info']);}

$module['withdraw_set']=self::$config['withdraw_set'];


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);

