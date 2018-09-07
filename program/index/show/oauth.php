<?php

$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$oauth=@$_GET['oauth'];
if($oauth==''){
	$dir="./oauth/";
	$r=scandir($dir);
	$online=array();
	$max=0;
	
	$txt_array=array();
	foreach($r as $v){
		if(is_dir($dir.$v) && $v!='.' && $v!='..'){
			$config=require($dir.$v.'/config.php');
			$max=max($max,$config['sequence']);
			$online[$config['sequence']]="<a href='./index.php?monxin=index.oauth&oauth=".$v."'><img src='".$dir.$v."/icon.png' alt='".$config['name']."' />".$config['name']."</a>";
			if($config['state']=='opening'){$txt_array[$config['sequence']]='<a href=./oauth/'.$v.'/?backurl={backurl} class='.$v.' target=_blank><img src=./oauth/'.$v.'/icon.png /></a>';}
			
		}
	}
	$temp='';
	$txt='';
	for($i=0;$i<=$max;$i++){
		if(isset($online[$i])){$temp.=$online[$i];}
		if(isset($txt_array[$i])){$txt.=$txt_array[$i];}
	}
	$online=$temp;
	file_put_contents('./oauth/oauth.txt',$txt);
	
	
}else{
	$config=require('./oauth/'.$oauth.'/config.php');
	$online="<div align='center'><img src='./oauth/".$oauth."/icon.png' alt='".$config['name']."' title='".$config['name']."'> <a href='./index.php?monxin=index.oauth'>".self::$language['return']."</a></div><iframe src='./oauth/".$oauth."/config_panel.php' width='100%' height='800' scrolling='no'  frameborder='no'></iframe>";	
}
$module['online']=$online;		

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);