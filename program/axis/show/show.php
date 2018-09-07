<?php
$id=intval($_GET['id']);
if($id==0){echo 'id err';return false;}
$sql="select * from ".self::$table_pre."group where `id`=".$id;
$axis=$pdo->query($sql,2)->fetch(2);
if($axis['id']==''){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
if($axis['state']==0){header('location:./index.php');exit;}
$module['style']=$axis['style'];
$module['axis_name']=$axis['name'];
$module['monxin_table_name']=$axis['name'].' '.self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['count_url']="receive.php?target=".$method."&id=".$id;
$search=safe_str(@$_GET['search']);
$search=trim($search);
$current_page=intval(isset($_GET['current_page'])?$_GET['current_page']:1);
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."log where `g_id`=".$id."";

$where="";
if($search!=''){$where=" and (`content` like '%$search%')";}
if($axis['sequence']){
	$order=" order by `date` asc";
}else{
	$order=" order by `date` desc";
}
$limit=" limit ".($current_page-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_log and","_log where",$sum_sql);
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_log and","_log where",$sql);
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$v=de_safe_str($v);
	$list.=self::get_log_html($pdo,self::$language,$v);	
}
if($sum==0){$list='<div style="text-align:center;">'.self::$language['no_related_content'].'</div>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&id=".$id;
$module['list']=$list;
$module['class_name']=self::$config['class_name'];
$module['page']=MonxinDigitPage($sum,$current_page,$page_size,'#'.$module['module_name']);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
echo '<div id="visitor_position_reset" style="display:none;"><span id=current_position_text>'.self::$language['current_position'].'</span><a href="./index.php"><span id=visitor_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a>'.$axis['name'].'</div>';