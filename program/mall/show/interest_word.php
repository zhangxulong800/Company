<?php
if(@$_GET['act']=='synchronization'){
	$sql="select `id`,`name` from ".self::$table_pre."type where `parent`>0";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$sql="select `id` from ".self::$table_pre."interest_word where `name`='".$v['name']."' limit 0,1";
		$r2=$pdo->query($sql,2)->fetch(2);
		if($r2['id']==''){
			$group_ids=self::get_interest_group_id($pdo,$v['id']);
			$sql="insert into ".self::$table_pre."interest_word (`name`,`group_ids`,`type_id`) values ('".$v['name']."','".$group_ids.",','".$v['id']."')";	
			$pdo->exec($sql);
		}	
	}
	echo '<script>alert("'.self::$language['synchronization'].self::$language['success'].'");</script>';
}

$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select `id`,`name` from ".self::$table_pre."interest_group";
$r=$pdo->query($sql,2);
$groups=array();
foreach($r as $v){
	$v=de_safe_str($v);
	$groups[$v['id']]=$v['name'];
}

$sql="select * from ".self::$table_pre."interest_word";

if(@$_GET['group_id']!=''){
	$group=intval($_GET['group_id']);
	$sql="select * from ".self::$table_pre."interest_word where (`group_ids` like '".$group.",%' or `group_ids` like '%,".$group.",%')";
	
	echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=mall.interest_group">'.$groups[$group].'</a><span class=text>'.self::$language['pages']['mall.interest_word']['name'].'</span></div>';
}

$where="";


if($_GET['search']!=''){$where=" and (`name` like '%".$_GET['search']."%')";}
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
	$sum_sql=str_replace("_interest_word and","_interest_word where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_interest_word and","_interest_word where",$sql);


$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$temp=explode(',',$v['group_ids']);
	$group='';
	foreach($temp as $v2){
		if(!isset($groups[$v2])){continue;}
		$group.='<b>'.$groups[$v2].'</b>';	
	}
	$list.="<tr id='tr_".$v['id']."'>
		<td><input type='text' name='name_".$v['id']."' id='name_".$v['id']."' value='".$v['name']."'  class='name' /></td>
	  <td><input type='hidden' name='group_ids_".$v['id']."' id='group_ids_".$v['id']."' value='".$v['group_ids']."'  class='group_ids' /> <span class=group_ids_name>".$group."</span> <a href='./index.php?monxin=mall.interest_word_grop&w_id=".$v['id']."' class=set_groups></a></td>
	  <td>".$v['day']."</td>
	  <td>".$v['week']."</td>
	  <td>".$v['month']."</td>
	  <td>".$v['year']."</td>
	  <td><a href='index.php?monxin=mall.interest_user_list&word_id=".$v['id']."' class=link>".$v['sum']."</a></td>
	  <td class=operation_td><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".self::$language['submit']."</a> <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
	</tr>
";	

}
$module['list']=$list;
if($module['list']==''){$module['list']='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);	
