<?php
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);





$sql="select `id`,`introducer`,`buyer`,`add_time`,`state`,`out_id` from ".self::$table_pre."order where `introducer`>0";
if($_GET['search']!=''){
	$sql="select `username` from ".$pdo->index_pre."user where `introducer`='".$_GET['search']."'";
	$r=$pdo->query($sql,2);
	$users='';
	foreach($r as $v){
		$users.=" or `buyer`='".$v['username']."'";	
	}
	$users=trim($users,' or ');
	if($users!=''){$sql="select `id`,`introducer`,`buyer`,`add_time`,`state`,`out_id` from ".self::$table_pre."order where `introducer`>0 and (".$users.")";}
	
	
}
$where='';
$_GET['order']=safe_str(@$_GET['order']);
if($_GET['order']==''){
	$order=" order by `id` desc";
}else{
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" `id`,`introducer`,`buyer`,`add_time`,`state`,`out_id` "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_order and","_order where",$sum_sql);
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
//echo $sql.'<br />';

$sql=str_replace("_order and","_order where",$sql);
//echo($sql);
//exit();

$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$sql="select `introducer` from ".$pdo->index_pre."user where `username`='".$v['buyer']."' limit 0,1";
	$introducer=$pdo->query($sql,2)->fetch(2);
	
	if($v['state']>5){$v['state']='<span class=settled>'.self::$language['settled'].'</span>';}else{$v['state']=self::$language['order_state'][$v['state']];}
	$list.="<tr id='tr_".$v['id']."'>
	  <td ><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['add_time'])."</span></td>
	  <td><span class=username>".$v['buyer']."</span><span class=order_remark><a href=./index.php?monxin=mall.m_order_admin&id=".$v['id']." target=_blank>".$v['out_id'].'</a> '.self::$language['order_postfix']."</span></td>
	  <td ><span class=money>".self::$language['money_symbol'].$v['introducer']."</span></td>
	  <td>".$introducer['introducer']."</td>
	  <td ><span class=state>".$v['state']."</span></td>
	</tr>
";	

}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
