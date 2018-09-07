<?php
if(isset($_SESSION['monxin']['id'])){header("location:index.php?monxin=index.user");}
$backurl=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'./index.php?monxin=index.user';
//echo $_SERVER['HTTP_REFERER'];
$backurl=str_replace('&','|||',$backurl);
$backurl=isset($_GET['backurl'])?'http://'.$_GET['backurl']:$backurl;
$module['backurl']=$backurl;
$module['backurl_2']=str_replace('|||','&',$backurl);
//echo $backurl;
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&oauth=".@$_GET['oauth']."&backurl=".$backurl;

if(@$_SESSION['monxin']['login_count']>3){$module['authCodeStyle']=' var authCodeStyle="block";';}else{$module['authCodeStyle']='var authCodeStyle="none";';}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$module['oauth']='';
$oauth_txt=@file_get_contents('./oauth/oauth.txt');
if($oauth_txt!=''){
	$module['oauth']='<div class=oauth_div>
			<a href=# class=oauth_switch>'.self::$language['other_login_method'].'</a>
			<div class=icons>'.str_replace('{backurl}',$backurl,$oauth_txt).'</div>
		  </div>';
}

$module['have_web_account']=str_replace('{web_name}',self::$config['web']['name'],self::$language['have_web_account']);

$module['default_group_id']=self::$config['reg_set']['default_group_id'];

if($_COOKIE['monxin_device']=='pc'){
	$module['phone_country_select']='<select class=phone_country id=phone_country name=phone_country monxin_value='.self::$config['reg_set']['phone_country'].'>'.get_phone_country_opton(self::$language['phone_country']).'</select>';
}else{
	$module['phone_country_select']='<select class=phone_country id=phone_country name=phone_country monxin_value='.self::$config['reg_set']['phone_country'].'>'.get_phone_country_opton(self::$language['phone_country']).'</select>';
}


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
echo '<div style="display:none;" id="visitor_position_append"><append>'.self::$language['login'].'</append></div>';
