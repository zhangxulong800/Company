<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".$pdo->index_pre."surl";

$where="";
if($_GET['search']!=''){$where=" and (`title` like '%".$_GET['search']."%' or `diy_title` like '%".$_GET['search']."%' or `id` ='".letter_to_number($_GET['search'])."')";}
if(@$_GET['order']==''){
	$order=" order by `id` desc";
}else{
	$_GET['order']=safe_str($_GET['order']);
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_surl and","_surl where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
		
	
	
	
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_surl and","_surl where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
self::$config['web']['share_template']=str_replace('{web_name}',self::$config['web']['name'],self::$config['web']['share_template']);
foreach($r as $v){
	$v['title']=str_replace('{page_name}','<b>'.$v['title'].'</b>',self::$config['web']['share_template']);
	$list.="<tr id='tr_".$v['id']."'>
	<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
	<td>".de_safe_str($v['title'])."<br /><input type=text value='".de_safe_str($v['diy_title'])."' class=diy_title /> <i></i></td>
	
	<td><a href=./index.php?monxin=".$v['url']." target='_blank'>./index.php?monxin=".$v['url']."</a>
	<br /><a class=surl target='_blank' href=".'http://'.self::$config['web']['domain'].'/?u='.number_to_letter($v['id'],6).">".'http://'.self::$config['web']['domain'].'/?u='.number_to_letter($v['id'],6)."</a>
	</td>
  <td>".$v['click']."</td>
  <td>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</td>
  <td>".$v['username']."</td>
  <td class=operation_td><a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
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