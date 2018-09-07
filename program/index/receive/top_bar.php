<?php
$module['module_name']="index_top_bar";
$module['data']='';
$module['nickname']='';
$json=array();
$json['msg']=0;


if(!isset($_SESSION['monxin']['id'])){ 
	$module['data'].="<a id=login href='index.php?monxin=index.login'>".self::$language['login']."</a><a href='index.php?monxin=index.reg_user&group_id=".self::$config['reg_set']['default_group_id']."' id=reg_user>".self::$language['reg_user']."</a>"; 
}else{
	$module['data'].='<span id=hello>'.self::$language['user_welcome'].'</span>';
	$module['data'].="<a href='index.php?monxin=index.user' id=icon_a><img id=icon_img src='".$_SESSION['monxin']['icon']."' border=0></a>";
	$module['data'].="<a id=nickname href='index.php?monxin=index.user'>".$_SESSION['monxin']['nickname']."<span>/".$_SESSION['monxin']['group'].'</span></a>';
	$module['icon']="<a href='index.php?monxin=index.user' id=iocn_a><img id=icon_img src='".$_SESSION['monxin']['icon']."' border=0></a>";
	$module['nickname']="<a id=nickname href='index.php?monxin=index.user'>".$_SESSION['monxin']['nickname'].'</a>';
	$module['group']=$_SESSION['monxin']['group'];
	
	$module['msg']='';
	$sql="select count(id) as c from ".$pdo->index_pre."site_msg where `addressee_state`=1 and `addressee`='".$_SESSION['monxin']['username']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']>0){
		$module['msg']="<a id=msg_show href='index.php?monxin=index.site_msg_addressee' class='fadeIn animated infinite'>".$r['c']."</a>";
		$json['msg']=$r['c'];
	}
	$module['data'].=$module['msg'];
	
	$module['data'].=" <a id=unlogin href='receive.php?target=index::user&act=unlogin&callback=unlogin&backurl=index.php?monxin=index.login'  class='ajax'>".self::$language['unlogin']."</a>"; 
	$module['unlogin']=" <a id=unlogin href='receive.php?target=index::user&act=unlogin&callback=unlogin&backurl=index.php?monxin=index.login'  class='ajax'>".self::$language['unlogin']."</a>"; 
	
	$json['nickname']=$_SESSION['monxin']['nickname'];
	$json['group']=$_SESSION['monxin']['group'];
	$json['icon']="".$_SESSION['monxin']['icon'];

	
}
$module['top_welcome_info']=@self::$config['web']['top_welcome_info'];
//$module['data'].="<a href=# id='print_a' target='_blank'>".self::$language['print']."</a>"; 
//$module['print_a']="<a href=# id='print_a' target='_blank'>".self::$language['print']."</a>"; 
$$module['data']=str_replace("\r\n","",$module['data']);
$module['data']='"'.$module['data'].'"';	

$module['json']=json_encode($json);

if(self::$config['web']['circle']){
	$module['circle']='<span class=circle_position></span>';
	$sql="select `id`,`name` from ".$pdo->index_pre."circle where `parent_id`=0 and `visible`=1 order by `sequence` desc,`id` asc";
	$r=$pdo->query($sql,2);
	$module['parent']='<a href=./index.php?circle=0  circle=0>'.self::$language['unlimited'].'</a>';
	$module['sub']='';
	foreach($r as $v){
		$sub='';
		$sql="select `id`,`name` from ".$pdo->index_pre."circle where `parent_id`='".$v['id']."' and `visible`=1 order by `sequence` desc,`id` asc";
		$r2=$pdo->query($sql,2);
		foreach($r2 as $v2){
			$sub.='<a href=./index.php?circle='.$v2['id'].' circle='.$v2['id'].'><span>'.de_safe_str($v2['name']).'</span></a>';	
		}
		$module['sub'].="<div class=sub_c id=sub_c_".$v['id'].">".$sub."</div>";
		$module['parent'].='<a href=./index.php?circle='.$v['id'].'  circle='.$v['id'].'><span>'.de_safe_str($v['name']).'</span></a>';
	}
	$module['circle_list']="<div class=circle_list_for_position><div class=circle_head><div class=c_head_name><a class=\'parent_name current\' d=parent>".self::$language['unlimited']."</a><a class=sub_name d=sub>".self::$language['select_please']."</a></div><div class=head_close><a>×</a></div></div><div class=circle_parent>".$module['parent']."</div><div class=circle_sub>".$module['sub']."</div></div>";
	$module['welcome_opacity']=0;
	
}else{
	$module['circle']='';
	$module['circle_list']='';
	$module['welcome_opacity']=1;
	
}



$m_require_login=0;	
$t_path='./templates/'.$m_require_login.'/index/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/index/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);