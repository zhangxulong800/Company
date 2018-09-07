<?php
$id=intval(@$_GET['id']);
if($id==0){return not_find();}
$sql="select * from ".self::$table_pre."regular where `id`=".$id;
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']==''){return not_find();}

echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=copy.regular&id='.$id.'">'.$r['name'].'</a><span class=text>'.self::$language['pages']['copy.task_list']['name'].'</span></div>';

function get_task_state_option($v){
	$list='';
	foreach($v as $key=>$v2){
		$list.='<option value="'.$key.'">'.$v2.'</option>';
	}
	return $list;	
}








$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."task where `regular_id`=".$id;

$where="";
if($_GET['search']!=''){$where=" and (`title` like '%".$_GET['search']."%' or `url` like '%".$_GET['search']."%')";}
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
	$sum_sql=str_replace("_task and","_task where",$sum_sql);
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_task and","_task where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$v=de_safe_str($v);
	$list.="<tr id='tr_".$v['id']."'>
	<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
	<td><a href='".$v['url']."' target=_blank class=title><img src='".$v['icon']."' /> ".$v['title']."</a></td>
  <td><input type='text' name='sequence_".$v['id']."' id='sequence_".$v['id']."' value='".$v['sequence']."' class='sequence' /></td>
  <td><select id='data_state_".$v['id']."' name='data_state_".$v['id']."' monxin_value='".$v['state']."' class=data_state>".get_task_state_option(self::$language['task_state'])."</select></td>
  <td><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</span></td>
  <td class=operation_td>
  <a href='#' onclick='return update(".$v['id'].")'  class='submit'>".self::$language['submit']."</a> 
  <a href='./index.php?monxin=copy.task&id=".$v['id']."' target=_blank class='submit'>".self::$language['open_copy_text'][$v['state']]."</a> 
  <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
</tr>
";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&id='.$id;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);
$module['filter']='';

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);