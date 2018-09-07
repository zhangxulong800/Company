<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

	$sql="select `id`,`name`,`py` from ".$pdo->index_pre."circle where `parent_id`=0 and `visible`=1 order by `sequence` desc,`id` asc";
	$r=$pdo->query($sql,2);
	$module['parent']='<a href=./index.php?circle=0  circle=0>'.self::$language['unlimited'].'</a>';
	$module['sub']='';
	foreach($r as $v){
		$sub='';
		$sql="select `id`,`name`,`py` from ".$pdo->index_pre."circle where `parent_id`='".$v['id']."' and `visible`=1 order by `sequence` desc,`id` asc";
		$r2=$pdo->query($sql,2);
		foreach($r2 as $v2){
			$sub.='<a href=./index.php?circle='.$v2['id'].' circle='.$v2['id'].' py="'.$v2['py'].'"><span>'.de_safe_str($v2['name']).'</span></a>';	
		}
		$module['sub'].="<div class=sub_c id=sub_c_".$v['id'].">".$sub."</div>";
		$module['parent'].='<a href=./index.php?circle='.$v['id'].'  circle='.$v['id'].' py="'.$v['py'].'"><span>'.de_safe_str($v['name']).'</span></a>';
	}
	$module['circle_list']="<div class=circle_parent>".$module['parent']."</div><div class=circle_sub>".$module['sub']."</div></div>";

	if($_COOKIE['circle']>0){
		$sql="select `name` from ".$pdo->index_pre."circle where `id`=".intval($_COOKIE['circle']);
		$r=$pdo->query($sql,2)->fetch(2);
		$circle_name=de_safe_str($r['name']);
	}else{
		$circle_name=self::$language['unlimited'];
	}
	$module['circle_name']=$circle_name;

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
