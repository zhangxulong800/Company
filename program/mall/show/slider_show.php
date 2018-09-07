<?php
if(isset($_GET['monxin']) && $_GET['monxin']=='mall.slider_show'){$id=intval($_GET['id']);}else{$id=intval($args[1]);}
if($id>0){
	$sql="select * from ".self::$table_pre."slider where `id`='$id'";
	//echo $sql;
	$module=$pdo->query($sql,2)->fetch(2);
		
	$module['width_int']=intval($module['width']);
	$module['height_int']=intval($module['height']);
	
	$module['imgs']='';
	$module['thumbs']='';
	$module['module_name']=str_replace("::","_",$method).'_'.$id;
	
	$sql="select * from ".self::$table_pre."slider_img where `group_id`=$id order by `sequence` desc,`id` asc";
	$r=$pdo->query($sql,2);
	$i=1;
	foreach($r as $v){
		$module['imgs'].="<div  class='swiper-slide'><a href='".$v['url']."' target='".$v['target']."' ><img src='./program/mall/slider_img/".$v['id'].".jpg' alt='".$v['name']."' title='".$v['name']."' /></a></div>";
		$module['thumbs'].="<a href='#' title='".$v['name']."'>$i</a>";
		$i++;
	}
	
	$t_path='./templates/0/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/style/'.$module['style'].'/show.php';
	if(!is_file($t_path)){$t_path='./templates/0/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/style/'.$module['style'].'/show.php';}
	require($t_path);	
	
	
}else{
	echo (self::$language['need_params']);
}
