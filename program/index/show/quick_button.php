<?php
$id=intval(@$_GET['id']);
if($id==0){
	$sql="select `id` from ".$pdo->index_pre."group order by `deep` asc , `parent` asc limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	$id=$r['id'];
}

$sql="select `page_power` from ".$pdo->index_pre."group where `id`=".$id;
$g=$pdo->query($sql,2)->fetch(2);
$power=explode(',',$g['page_power']);

$language=array();
$path='./program/';
$r=scandir($path);
foreach($r as $v){
	if($v!='.' && $v!='..' && is_dir($path.$v)){
		if(!is_file($path.$v.'/config.php')){continue;}
		$config=require($path.$v.'/config.php');
		$l=require($path.$v.'/language/'.$config['program']['language'].'.php');
		$language[$v]=$l;
	} 	
}

//var_dump($language);
$module['list']='';
$path='./program/';
$r=scandir($path);
foreach($r as $v){
	if($v!='.' && $v!='..' && is_dir($path.$v)){
		if(!is_file($path.$v.'/admin_map.php')){continue;}
		$map=require($path.$v.'/admin_map.php');
		
		foreach($map as $k2=>$v2){
			if(!in_array($k2,$power)){continue;}
			$temp=explode('.',$k2);
			$module['list'].='<div m_name="'.str_replace('.','__',$k2).'" class=b_1><img src="./templates/1/'.$temp[0].'/default/page_icon/'.$k2.'.png" />'.$language[$temp[0]]['pages'][$k2]['name'].'</div>';
			
			if(is_array($v2)){
				
				foreach($v2 as $k3=>$v3){
					
					if(is_array($v3)){
						if(!in_array($k3,$power)){continue;}
						$temp=explode('.',$k3);
						$module['list'].='<div m_name="'.str_replace('.','__',$k3).'" class=b_2><img src="./templates/1/'.$temp[0].'/default/page_icon/'.$k3.'.png" />'.$language[$temp[0]]['pages'][$k3]['name'].'</div>';
					}else{
						if(!in_array($v3,$power)){continue;}
						$temp=explode('.',$v3);
						$module['list'].='<div m_name="'.str_replace('.','__',$v3).'" class=b_2><img src="./templates/1/'.$temp[0].'/default/page_icon/'.$v3.'.png" />'.$language[$temp[0]]['pages'][$v3]['name'].'</div>';
					}
				}
				$module['list'].='<li class=li_2></li>';
				
			}
			
		}	
		$module['list'].='<li class=li_1></li>';
	} 	
}


//var_dump($language);

$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&id=".$id;


$sql="select * from ".$pdo->index_pre."group_quick_button where `group_id`=".$id." order by `sequence` desc";
$r=$pdo->query($sql,2);
$module['existing']='';

foreach($r as $v){
	$module['existing'].=$v['url'].',';
		
}


$module['groups']=index::get_groups($pdo,0,"index.php?monxin=index.quick_button&id=");
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);