<?php
$attribute=format_attribute($args[1]);
$id=$attribute['id'];
$sql="select * from ".self::$table_pre."brand where `parent`='".intval($id)."' and `visible`=1 order by `sequence` desc";
//echo $sql;
$r=$pdo->query($sql,2);
$a=array();
$index=0;
$list='';
foreach($r as $v){
	$v=de_safe_str($v);
	if($v['url']==''){$v['url']="./index.php?monxin=mall.goods_list&search=".$v['name'];}	
	$list.="<a href=".$v['url']." target=_blank><img src=./program/mall/brand_icon/".$v['id'].".png /><span>".$v['name']."</span></a>";
}
if($list==''){$list='<span class=no_related_content_span>'.self::$language['no_related_content'].'</span>';}
$module['list']=$list;
$module['module_name']=str_replace("::","_",$method.'_'.$id);
$module['module_save_name']=str_replace("::","_",$method.$args[1]);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
