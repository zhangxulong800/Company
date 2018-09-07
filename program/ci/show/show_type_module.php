<?php
$attribute=format_attribute($args[1]);
$id=$attribute['id'];
if($attribute['follow_type']=='true' && intval(@$_GET['type'])!=0){
	$id=intval($_GET['type']);
	$sql="select `id` from  ".self::$table_pre."type where `parent`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){
		$sql="select `parent` from ".self::$table_pre."type where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$id=$r['parent'];	
	}
}



if($id!=0){
	$sql="select `name` from ".self::$table_pre."type where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	$r=de_safe_str($r);
	$parent='<a href="./index.php?monxin=ci.list&type='.$id.'"  target="'.$attribute['target'].'" class="parent"><span class=icon><img src=./program/ci/type_icon/'.$id.'.png /></span><span class=text>'.$r['name'].'</span></a>';	
}else{
	$parent='<a href="./index.php?monxin=ci.list&type='.$id.'"  target="'.$attribute['target'].'" class="parent"><span class=icon><img src=./program/ci/type_icon/0.png /></span><span class=text>'.self::$language['information_classification'].'</span></a>';	
}
$sql="select `id`,`name`,`url` from ".self::$table_pre."type where `parent`=".$id." and `visible`=1 order by `sequence` desc limit 0,".intval($attribute['quantity']);
$r=$pdo->query($sql,2);
$sub='';
//if(!$r){header('location:./index.php');exit;}
foreach($r as $v){
	$v=de_safe_str($v);
	if($v['url']!=''){$url=$v['url'];}else{$url='./index.php?monxin=ci.list&type='.$v['id'].'';}
	$sub.='<a href="'.$url.'" target="'.$attribute['target'].'" style="width:'.$attribute['sub_width'].'" id=type_'.$v['id'].'>'.$v['name'].'</a>';	
}

if($sub!=''){$sub='<div class="sub">'.$sub.'</div>';}
$module['list']='<div class=type_div>'.$parent.$sub.'</div>';


$module['module_width']=$attribute['width'];
$module['module_height']=$attribute['height'];
$module['module_name']=str_replace("::","_",$method.'_'.$id);
$module['module_save_name']=str_replace("::","_",$method.$args[1]);
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
