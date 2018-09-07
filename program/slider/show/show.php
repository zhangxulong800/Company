<?php
if(isset($_GET['monxin']) && $_GET['monxin']=='slider.show'){$id=intval($_GET['id']);}else{$id=intval($temp[1]);}

//$id=$temp[1];
if($id>0){
	$sql="select * from ".self::$table_pre."group where `id`='$id'";
	//echo $sql;
	$module=$pdo->query($sql,2)->fetch(2);
	if($module['id']==''){return  false;}	
	$module['width_int']=intval($module['width']);
	$module['height_int']=intval($module['height']);
	if($module['width']=='100%' && $module['style']=='width_full' && $_COOKIE['monxin_device']=='pc'){
		$module['height']=1366*intval($module['height'])/100;
		$module['height'].='px';
	}
	
	$module['imgs']='';
	$module['thumbs']='';
	$module['module_name']=str_replace("::","_",$method).'_'.$id;
	
	$sql="update ".self::$table_pre."group set `visit`=`visit`+1 where `id`=".$module['id'];
	$pdo->exec($sql);
	
	$sql="select * from ".self::$table_pre."img where `group_id`=$id order by `sequence` desc,`id` asc";
	$r=$pdo->query($sql,2);
	$i=1;
	foreach($r as $v){
		if(strlen($v['name'])>2){$v['name']="<div class=up_text>".$v['name']."</div>";}else{$v['name']='';}
		$module['imgs'].="<div  class='swiper-slide' id='slider_img_".$v['id']."'><a href='".$v['url']."' target='".$v['target']."' class=img_bg><img src='./program/slider/img/".$v['id'].".jpg' alt='".$v['name']."' title='".$v['name']."' /></a>".$v['name']."</div>";
		$module['thumbs'].="<a href='#' title='".$v['name']."'>$i</a>";
		$i++;
	}
	
	
	
	$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/style/'.$module['style'].'/'.str_replace($class."::","",$method).'.php';
	if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/phone/style/'.$module['style'].'/'.str_replace($class."::","",$method).'.php';}
	require($t_path);
}else{
	echo (self::$language['need_params']);
}
