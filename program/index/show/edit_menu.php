<?php
$name_count=0;
$last_width=100;
$program=safe_str(@$_GET['program']);
$module['groups']=index::get_groups($pdo,0,"index.php?monxin=index.edit_menu&program=".$program."&id=");
$id=intval(@$_GET['id']);
if($id==0){
	$sql="select `id` from ".$pdo->index_pre."group where `parent`=0 order by `sequence` desc limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	header("location:index.php?monxin=index.edit_menu&id=".$r['id']);	
}
$sql="select `url` from ".$pdo->index_pre."group_menu where `group_id`='$id' and `visible`=1";
$r=$pdo->query($sql,2);
$menus='';
foreach($r as $v){
	$menus.=$v['url']."|";	
}
$menus=trim($menus,"|");
$menus=explode("|",$menus);


$sql="select `name` from ".$pdo->index_pre."program  order by `id` asc";
if($program!=''){$sql="select `name` from ".$pdo->index_pre."program  where `name`='$program'";}
//echo $sql;
$stmt=$pdo->query($sql,2);

$module['list2']='';
foreach($stmt as $v){
	$module['list']='';
	$menu=require("program/".$v['name']."/menu.php");
	$config=require("program/".$v['name']."/config.php");
	//var_dump($menu);
	//echo $config['program']['language'].',';
	$language=require("program/".$v['name']."/language/".$config['program']['language'].".php");
	foreach($menu as $key=>$v2){
		//echo $key;
		if(in_array($key,$menus)){$checked="checked";}else{$checked='';}
		//$v['icon_path']="program/".$v['name']."/page_icon/".$key.".png";
		$v['icon_path']='./templates/1/'.$v['name'].'/'.$config['program']['template_1'].'/page_icon/'.$key.'.png';
		$module['list'].="<li><a href=index.php?monxin={$key} target=_blank><img src={$v['icon_path']}><br/><span>".$language['pages'][$key]['name']."</span></a><div><input class='checkbox' type='checkbox' id='$key' name='$key' $checked /><div><div class=power_suggest>".self::$language['suggest'].":".$language['pages'][$key]['power_suggest']."</div></li>";
		
	}
$module['list2'].=" <fieldset><legend>".$language['program_name']."</legend><ul class=icons>{$module['list']}<div style='clear:both;'></div></ul></fieldset>";
}
$module['list']=$module['list2'];
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&id=".$id;
$module['act']='edit';
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['program_option']=index::get_program_option($pdo);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);	