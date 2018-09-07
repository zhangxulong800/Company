<?php
$id=intval(@$_GET['id']);
if($id==0){return not_find();}
$sql="select * from ".self::$table_pre."goods_snapshot where `id`=".$id;
$module['data']=$pdo->query($sql,2)->fetch(2);
if($module['data']['id']==''){return not_find();}
$module['data']=de_safe_str($module['data']);
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['class_name']=self::$config['class_name'];
$module['data']['thumb_list']='<a href="#"><img src="./program/mall/snapshot/img_thumb/'.date('Y_m_d',$module['data']['time']).'/'.date('Y_m_d_H_i_s',$module['data']['time']).'/'.$module['data']['icon'].'" /></a>';
$module['data_phone']['thumb_list']='<div><img u="image" src="./program/mall/snapshot/img_thumb/'.date('Y_m_d',$module['data']['time']).'/'.date('Y_m_d_H_i_s',$module['data']['time']).'/'.$module['data']['icon'].'" /><img  u="thumb"  src="./program/mall/img/'.$module['data']['icon'].'" /></div>';
$temp=explode('|',$module['data']['multi_angle_img']);

$module['data']['img_list']='<li><a href="#"><img src="./program/mall/snapshot/img/'.date('Y_m_d',$module['data']['time']).'/'.date('Y_m_d_H_i_s',$module['data']['time']).'/'.$module['data']['icon'].'" /></a></li>';


foreach($temp as $v){
	if($v==''){continue;}
	$module['data']['thumb_list'].='<a href="#"><img src="./program/mall/snapshot/img_thumb/'.date('Y_m_d',$module['data']['time']).'/'.date('Y_m_d_H_i_s',$module['data']['time']).'/'.$v.'" /></a>';
	$module['data_phone']['thumb_list'].='<div><img u="image" src="./program/mall/snapshot/img/'.date('Y_m_d',$module['data']['time']).'/'.date('Y_m_d_H_i_s',$module['data']['time']).'/'.$v.'" /><img u="thumb" src="./program/mall/snapshot/img_thumb/'.date('Y_m_d',$module['data']['time']).'/'.date('Y_m_d_H_i_s',$module['data']['time']).'/'.$v.'" /></div>';
	$module['data']['img_list'].='<li><a href="#"><img src="./program/mall/snapshot/img/'.date('Y_m_d',$module['data']['time']).'/'.date('Y_m_d_H_i_s',$module['data']['time']).'/'.$v.'" /></a></li>';

}

//var_dump($module['data']['img_list']);

$sql="select `time` from ".self::$table_pre."goods_snapshot where `goods_id`='".$module['data']['goods_id']."' and `time`>".$module['data']['time']." order by `id` desc limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['time']!=''){$end_time=$r['time'];}else{$end_time=time();}
$module['time_limit']=date('Y-m-d H:i',$module['data']['time']).' - '.date('Y-m-d H:i',$end_time);


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
echo '<div id="visitor_position_reset" style="display:none;"><span id=current_position_text>'.self::$language['current_position'].'</span><a href="./index.php"><span id=visitor_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a>'.self::$language['pages']['mall.goods_snapshot']['name'].'</div>';
		