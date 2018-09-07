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

$sql="select * from ".self::$table_pre."distributor";


$where="";
if(isset($_GET['state'])){
	if($_GET['state']!=''){$where.=" and `state` ='".intval($_GET['state'])."'";}	
}


if($_GET['search']!=''){$where=" and (`username` like '%".$_GET['search']."%' or `phone` like '%".$_GET['search']."%')";}
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
	$sum_sql=str_replace("_distributor and","_distributor where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_distributor and","_distributor where",$sql);
//echo($sql);
//exit();

$state_option='<option value=0>'.self::$language['distributor_state'][0].'</option><option value=1>'.self::$language['distributor_state'][1].'</option><option value=2>'.self::$language['distributor_state'][2].'</option>';
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$sql="select * from ".$pdo->index_pre."user where `username`='".$v['username']."' limit 0,1";
	$user=$pdo->query($sql,2)->fetch(2);
	if($user['id']==''){continue;}
	if(!is_url($user['icon'])){$user['icon']="./program/index/user_icon/".$user['icon'];}
	
	$list.="<tr id='tr_".$v['id']."'>
	  <td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
	  <td><img class=icon src=".$user['icon']." /><span class=username>".$user['username']."</span></td>
	  <td><div>".$user['real_name']."</div><div>".$user['phone']."</div></td>
	  <td><a href='./index.php?monxin=distribution.show_sub&username=".de_safe_str($v['superior'])."'  iframe=1>".$v['superior']."</a><input type=text class=superior value='".$v['superior']."' /><a class=show_eidt></a></td>
	  <td><a href='./index.php?monxin=distribution.order_admin&search=".$user['username']."' target=_blank >".$v['sum_money']."<br />".$v['earn']."</a></td>
	  <td><a href='./index.php?monxin=distribution.show_sub&username=".de_safe_str($user['username'])."' iframe=1>".$v['subordinate']."</a></td>
  <td><select  name='data_state_".$v['id']."' id='data_state_".$v['id']."' monxin_value='".$v['state']."' class='data_state' >".$state_option."</select></td>
	<td><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</span></td>
	  <td class=operation_td><a href=# onclick='return update(".$v['id'].")' >".self::$language['submit']."</a><a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
	</tr>
";	

}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

$list='';
foreach(self::$language['distributor_state'] as $k=>$v){
	$list.='<option value='.$k.'>'.$v.'</option>';	
}

$module['filter']="<select name='state_filter' id='state_filter'><option value='-1'>".self::$language['visible_state']."</option><option value='' selected>".self::$language['all'].self::$language['state']."</option>{$list}</select>";

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
