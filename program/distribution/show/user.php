<?php
$sql="select `id`,`state` from ".self::$table_pre."distributor where `username`='".$_SESSION['monxin']['username']."' limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']==''){
	header('location:./index.php?monxin=distribution.apply');return false;
}
if($r['state']!=1){
	echo '<div class=return_false>'.self::$language['distributor_state'][$r['state']].'</div>';return false;
}

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);	
$menu=require("./program/".$class."/menu.php");
$pages=require("./program/".$class."/pages.php");
$list='';
foreach($menu[str_replace("::",".",$method)] as $key=>$v){
	if(is_array($v)){$v=$key;}
	$t=explode(".",$pages[$v]['url']);
	if(!in_array($pages[$v]['url'],$_SESSION['monxin']['page'])){continue;}
	$v2['icon_path']="./templates/1/".$class."/".self::$config['program']['template_1']."/page_icon/".$pages[$v]['url'].".png";

	if($v=='distribution.apply'){continue;}

	$list.="<li><a href=index.php?monxin={$pages[$v]['url']}  target='".$pages[$v]['target']."'><img src='".$v2['icon_path']."' /><br><span>".self::$language['pages'][$v]['name']."</span></a></li>";
	
}
$module['list']="<ul id=icons>{$list}<div style='clear:both;'></div></ul>";

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
