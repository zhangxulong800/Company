<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".$pdo->index_pre."share where `user_id`=".$_SESSION['monxin']['id'];

$where="";
if($_GET['search']!=''){$where=" and (`title` like '%".$_GET['search']."%')";}
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
	$sum_sql=str_replace("_share and","_share where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
	
	
	//get sum contribution
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," sum(contribution) as c ",$sum_sql);
	$sum_sql=str_replace("_share and","_share where",$sum_sql);
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$contribution=$r['c'];
	$module['sum']='<span class=m_label>'.self::$language['contribution'].': </span><span class=value>'.$contribution.'</span>';
	//get sum visit reg 
	if($where==''){
		$sum_sql="select count(id) as c from ".$pdo->index_pre."share_visit where `user_id`=".$_SESSION['monxin']['id'];
		$r=$pdo->query($sum_sql,2)->fetch(2);
		$visit=$r['c'];
		$sum_sql="select count(id) as c from ".$pdo->index_pre."user where `introducer`='".$_SESSION['monxin']['username']."'";
		$r=$pdo->query($sum_sql,2)->fetch(2);
		$reg=$r['c'];
		$module['sum']='<span class=m_label>'.self::$language['visit'].': </span><span class=value>'.$visit.'</span> <span class=m_label>'.self::$language['reg'].': </span><span class=value>'.$reg.'</span> '.$module['sum'];
	}
	
	
	
	
	
	
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_share and","_share where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$v['title']=de_safe_str($v['title']);
	$v['url']=de_safe_str($v['url']);
	$sql="select count(id) as c from ".$pdo->index_pre."share_visit where `share_id`=".$v['id'];
	$temp=$pdo->query($sql,2)->fetch(2);
	$visit=$temp['c'];
	
	$sql="select count(id) as c from ".$pdo->index_pre."share_reg where `share_id`=".$v['id'];
	$temp=$pdo->query($sql,2)->fetch(2);
	$reg=$temp['c'];
	
	
	$list.="<tr id='tr_".$v['id']."'>
	<td><a href='./index.php?monxin=".$v['url']."' target=_blank class=title>".$v['title']."</a></td>
	<td><a href='./index.php?monxin=index.my_share_visit&id=".$v['id']."' target=_blank class=visit>".$visit."</a></td>
	<td><a href='./index.php?monxin=index.my_share_reg&id=".$v['id']."' target=_blank class=reg>".$reg."</a></td>
	<td><span  class=contribution>".$v['contribution']."</span></td>
	<td><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</span></td>
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