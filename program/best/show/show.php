<?php
$id=intval(@$_GET['id']);
$p_id=intval(@$_GET['p_id']);
if($id==0){	return  not_find();	}
$sql="select * from ".self::$table_pre."page where `id`=".$id;
$best=$pdo->query($sql,2)->fetch(2);
$best=de_safe_str($best);
if($best['id']==''){return not_find();}
if($best['visible']==0){return not_find();}
$module['data']['title']=de_safe_str($best['title']);	
$module['data']['time']=get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$best['time']);	

if($best['show_type']==1){//===================================================================================分段显示

	$sql="select `id`,`title`,`content_".$_COOKIE['monxin_device']."`,`is_full` from ".self::$table_pre."paragraph where `best_id`='".$best['id']."' order by `sequence` asc limit 0,20";
	$r=$pdo->query($sql,2);
	$module['data']['content']='';
	$module['data']['paragraph']='';
	foreach($r as $v){
		$v=de_safe_str($v);
		if($p_id==0){$p_id=$v['id'];}
		$url='./index.php?monxin=best.show&id='.$best['id'].'&p_id='.$v['id'];
		if( substr($v['content_'.$_COOKIE['monxin_device']],0,4)=='http' || substr($v['content_'.$_COOKIE['monxin_device']],0,11)=='./index.php'){$url=$v['content_'.$_COOKIE['monxin_device']]." target=_blank";}
		$module['data']['paragraph'].='<a href='.$url.' p_id='.$v['id'].'>'.$v['title'].'</a><span class=sep>|</span>';
	}
	$module['data']['paragraph']=substr($module['data']['paragraph'],0,strlen($module['data']['paragraph'])-24);
	
	//$module['data']['paragraph']=trim($module['data']['paragraph'],'<span class=sep>|</span>');
	
	$sql="select `id`,`content_pc`,`content_phone`,`is_full` from ".self::$table_pre."paragraph where `id`=".$p_id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){return not_find();}
	if($r['is_full']){$module['data']['is_full']='';}else{$module['data']['is_full']=' container';}
	$module['data']['content']=de_safe_str($r['content_'.$_COOKIE['monxin_device']]);
	
	if($_COOKIE['monxin_device']=='phone'){
		if($r['content_'.$_COOKIE['monxin_device']]==''){
			$module['data']['content']=de_safe_str($r['content_pc']);
		}
	}	
		
}else{//===============================================================================================================显示全部
	$sql="select `id`,`title`,`content_pc`,`content_phone`,`is_full` from ".self::$table_pre."paragraph where `best_id`='".$best['id']."' order by `sequence` asc limit 0,20";
	$r=$pdo->query($sql,2);
	$module['data']['content']='';
	$module['data']['paragraph']='';
	foreach($r as $v){
		$v=de_safe_str($v);
		if($p_id==0){$p_id=$v['id'];}
		$url='#p_'.$v['id'];
		
		$content=de_safe_str($v['content_pc']);
		if($_COOKIE['monxin_device']=='phone'){
			if($v['content_'.$_COOKIE['monxin_device']]!=''){
				$content=de_safe_str($v['content_phone']);
			}
		}	
		
		if( substr($content,0,4)=='http' || substr($content,0,11)=='./index.php'){$url=$content." target=_blank";}
		$module['data']['paragraph'].='<a href='.$url.' p_id='.$v['id'].'>'.$v['title'].'</a><span class=sep>|</span>';
		if($url!='#p_'.$v['id']){ continue;}
		
		
		$module['data']['content'].='<div class=paragraph id=p_'.$v['id'].'><div class=p_title>'.$v['title'].'</div><div class=p_content>'.$content.'</div></div>';
		
	}
	$module['data']['paragraph']=substr($module['data']['paragraph'],0,strlen($module['data']['paragraph'])-24);
	
}


	
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['count_url']="receive.php?target=".$method."&id=".$id;
$module['module_save_name']=str_replace("::","_",$method.$args[1]);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'_'.$best['show_type'].'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'_'.$best['show_type'].'.php';}
require($t_path);
