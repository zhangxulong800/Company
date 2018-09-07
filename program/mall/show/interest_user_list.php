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

if(isset($_GET['group_id'])){
	$type='group';$id=intval($_GET['group_id']);
	$sql="select `name` from ".self::$table_pre."interest_group where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	$name=$r['name'];
	echo '<div  style="display:none;" id="user_position_reset"><a href=./index.php?monxin=index.user>'.self::$language['user_center'].'</a><a href=./index.php?monxin=mall.master>'.self::$language['pages']['mall.master']['name'].'</a><a href=./index.php?monxin=mall.interest_index>'.self::$language['pages']['mall.interest_index']['name'].'</a><a href=./index.php?monxin=mall.interest_group>'.self::$language['pages']['mall.interest_group']['name'].'</a><a href="./index.php?monxin=mall.interest_'.$type.'">'.$name.'</a><span class=text>'.self::$language['pages']['mall.interest_user_list']['name'].'</span></div>';
	
}else{
	$type='word';$id=intval($_GET['word_id']);
	$sql="select `name` from ".self::$table_pre."interest_word where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	$name=$r['name'];
	echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=mall.interest_'.$type.'">'.$name.'</a><span class=text>'.self::$language['pages']['mall.interest_user_list']['name'].'</span></div>';
	
}

	
	
$sql="select * from ".self::$table_pre."interest_".$type."_user and `".$type."_id`=".$id;

$where="";
$_GET['order']=safe_str(@$_GET['order']);
if($_GET['order']==''){
	$order=" order by `id` desc";
}else{
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_interest_".$type."_user and","_interest_".$type."_user where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_interest_".$type."_user and","_interest_".$type."_user where",$sql);

$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$list.="<tr id='tr_".$v['id']."'>
		<td>".$v['username']."</td>
		<td>".$v['frequency']."</td>
		<td><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['last_time'])."</span></td>
	</tr>
";	

}
$module['list']=$list;
if($module['list']==''){$module['list']='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);





$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);	
