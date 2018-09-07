<?php
$axis_id=intval($_GET['axis_id']);
if($axis_id==0){echo 'axis_id err';return false;}
$sql="select `id`,`name`,`username`,`sequence` from ".self::$table_pre."group where `id`=".$axis_id;
$axis=$pdo->query($sql,2)->fetch(2);
if($axis['id']==''){exit("{'state':'fail','info':'<span class=fail>axis_id err</span>'}");}
if($axis['username']!=$_SESSION['monxin']['username']){echo 'axis_id power err';return false;}


$module['monxin_table_name']=$axis['name'].' '.self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$search=safe_str(@$_GET['search']);
$search=trim($search);
$current_page=intval(isset($_GET['current_page'])?$_GET['current_page']:1);
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."log where `g_id`=".$axis_id."";

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
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$v=de_safe_str($v);
	$list.="<tr id='tr_".$v['id']."'>
	<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
	<td class=log_detail_td>".self::get_log_html($pdo,self::$language,$v)."</td>
  <td class=operation_td><a href=./index.php?monxin=axis.content&axis_id=".$_GET['axis_id']."&id=".$v['id']." class='edit set_content'>".self::$language['edit']."</a><a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=act_state_".$v['id']." class='act_state'></span></td>
</tr>
";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&axis_id=".$axis_id;
$module['list']=$list;
$module['class_name']=self::$config['class_name'];
$module['page']=MonxinDigitPage($sum,$current_page,$page_size,'#'.$module['module_name']);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
