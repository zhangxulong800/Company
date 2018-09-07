<?php
$_GET['id']=intval(@$_GET['id']);
if($_GET['id']==0){$_GET['id']=$_SESSION['monxin']['id'];}
if($this->check_user_power($pdo,$_GET['id']) || $_SESSION['monxin']['id']==$_GET['id']){



$sql="select `username`,`real_name` from ".$pdo->index_pre."user where `id`='".$_GET['id']."'";
$module=$pdo->query($sql,2)->fetch(2);

$sql="select `ip`,`time`,`position` from ".$pdo->index_pre."user_login where `userid`='".$_GET['id']."' order by `time` desc";

$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql;
	$sum_sql=str_replace(" `ip`,`time`,`position` "," count(id) as c ",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$limit;

$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
  $list.='<tr><td>'.get_time(self::$config['other']['date_style'].' H:i',self::$config['other']['timeoffset']." H:i",self::$language,$v['time']).'</td><td>'.$v['position'].' '.$v['ip'].'</td></tr>';
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}
$module['list']=$list;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);


if($_GET['id']!=$_SESSION['monxin']['id']){$module['username_display']='block';}else{$module['username_display']='none';}

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
}
