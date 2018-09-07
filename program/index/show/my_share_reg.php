<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$id=intval($_GET['id']);
if($id==0){echo 'id err ';return false;}
$sql="select * from ".$pdo->index_pre."share where `id`=".$id;
$r=$pdo->query($sql,2)->fetch(2);
$module['time']=get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$r['time']);
$module['username']=$r['username'];
$module['share_content']="<a href='./index.php?monxin=".$r['url']."' target=_blank>".$r['title']."</a>";
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select `username`,`reg_time`,`id` from ".$pdo->index_pre."user where `introducer`='".$_SESSION['monxin']['username']."'";

$where="";
$order=" order by `id` desc";
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" `username`,`reg_time`,`id` "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_user and","_user where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];

	
	
	
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_user and","_user where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	
	$list.="<tr id='tr_".$v['id']."'>
	<td>".$v['username']."</td>
	<td><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['reg_time'])."</span></td>
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