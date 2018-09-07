<?php
$module['user_list']='';
if(!isset($_POST['data'])){
	
	$_GET['id']=intval(@$_GET['id']);
	if($this->check_user_power($pdo,$_GET['id'])){
	$sql="select `username`,`real_name`,`group` from ".$pdo->index_pre."user where `id`='".$_GET['id']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	$module['user_list']=$r['username'].'('.$r['real_name'].')';
	$module['group']=$r['group'];
	$module['ids']=$_GET['id'];
	}
}else{
	
	$_POST['data']=explode(',',$_POST['data']);
	$ids='';
	foreach($_POST['data'] as $v){
		if(is_numeric($v)){
			if($this->check_user_power($pdo,$v)){$ids.=$v.',';}
		}	
	}
	$ids=trim($ids,',');
	$sql="select `id`,`username`,`real_name`,`group` from ".$pdo->index_pre."user where `id` in ($ids)";
	
	$r=$pdo->query($sql,2);
	$module['user_list']='';
	$module['ids']='';
	foreach($r as $v){
		$module['group']=$v['group'];
		$module['user_list'].=$v['username'].'('.$v['real_name'].')<br/>';
		$module['ids'].=$v['id'].',';
			
	}
	
}



$module['parent_select']=index::get_group_select($pdo,'-1',$_SESSION['monxin']['group_id']);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['back_url']=@$_SERVER['HTTP_REFERER'].'&re='.time();

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
