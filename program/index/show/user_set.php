<?php
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);



$sql="select * from ".$pdo->index_pre."user_set_item order by `sequence` desc,`id` asc";
$r=$pdo->query($sql,2);
$list='';
$module['user_set_color']='';
foreach($r as $v){
	
	$sql2="select `item_value` from ".$pdo->index_pre."user_set where `user_id`='".$_SESSION['monxin']['id']."' and `item_variable`='".$v['variable']."'";
	$r2=$pdo->query($sql2,2)->fetch(2);
	if($r2['item_value']==''){$value=$v['default_value'];}else{$value=$r2['item_value'];}
	if($v['variable']=='user_set_color'){$module['user_set_color']=$r2['item_value'];continue;}
	if($v['variable']=='user_set_circle'){$module['circle']=$r2['item_value'];continue;}
	
	$option='';
	$temp=explode('|',$v['options']);
	
	foreach($temp as $v2){
		$v3=explode('=',$v2);
		if(!isset($v3[1])){continue;}
		if($v3[0]==$value){$selected='selected';}else{$selected='';}
		
		$option.='<option value="'.$v3[0].'" '.$selected.'>'.$v3[1].'</option>';	
	}
	$options='<select id="'.$v['variable'].'" name="'.$v['variable'].'" >'.$option.'</select><span id="'.$v['variable'].'_state"></span>';
	
	$list.="<p><span class='name'>".$v['name'].":</span><span class='options'>".$options."</span></p>";
}
$module['list']=$list;	

$sql="select `id`,`name` from ".$pdo->index_pre."color order by `sequence` desc";
$r=$pdo->query($sql,2);
$module['color_option']='';
foreach($r as $v){
	$module['color_option'].='<option value="'.$v['id'].'">'.$v['name'].'</option>';
}

$module['circle_option']='<option value="0">'.self::$language['unlimited'].'</option>'.get_circle_option($pdo);

	
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);	
