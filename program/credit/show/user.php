<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select `id`,`username`,`credits` from ".$pdo->index_pre."user";

$where="";
if($_GET['search']!=''){$where=" and (`username` like '%".$_GET['search']."%')";}
if(@$_GET['order']==''){
	$order=" order by `id` desc";
}else{
	$_GET['order']=safe_str($_GET['order']);
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" `id`,`username`,`credits` "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_user and","_user where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
	
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" `id`,`username`,`credits` "," sum(money) as c ",$sum_sql);
	$sum_sql=str_replace("_user and","_user where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	if($r['c']==''){$r['c']=0;}
	$module['sum']=number_format($r['c']);
	
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_user and","_user where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$v['username']=de_safe_str($v['username']);
	$list.="<tr id='tr_".$v['id']."'>
	<td>".$v['username']."</td>
	<td><a target=_blank href=index.php?monxin=credit.admin&search=".$v['username']." class=credit>".$v['credits']."</a></td>
	<td class=operation_td><a href='#' class=increase  d_id=".$v['id'].">".self::$language['increase']."</a> <a href='#' class=decrease d_id=".$v['id'].">".self::$language['decrease']."</a> </td>
</td>
</tr>
";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;

$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);	