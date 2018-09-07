<?php
function get_account_option($r){
	$list='';
	foreach($r as $key=>$v){
		$list.='<option value="'.$key.'">'.$v.'</option>';
	}
	return $list;
}


$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$search=safe_str(@$_GET['search']);
$search=trim($search);
$current_page=intval(isset($_GET['current_page'])?$_GET['current_page']:1);
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."account where `username`='".$_SESSION['monxin']['username']."'";

$where="";
if(@$_GET['order']==''){
	$order=" order by `sequence` desc ,`id` asc";
}else{
	$_GET['order']=safe_str($_GET['order']);
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($current_page-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_account and","_account where",$sum_sql);
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_account and","_account where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$v=de_safe_str($v);
	$list.="<tr id='tr_".$v['id']."'>
	<td><div class=name>".$v['name']."</div><div class=banner_div><img src='./program/scanpay/banner/".$v['banner']."' /></div></td>
	<td>".self::$language['account_type_option'][$v['type']]."</td>
	<td>".$v['money']."</td>
	<td>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</td>
	<td><input type='text' class=sequence value='".$v['sequence']."' /></td>
	<td>".self::$language['account_state'][$v['state']]."</td>
	<td class=operation_td><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".self::$language['submit']."</a> <a href='./index.php?monxin=scanpay.pay&id=".$v['id']."' class='receive_money'>".self::$language['receive_money']."</a> <a href='./index.php?monxin=scanpay.account_pay_log&a_id=".$v['id']."' target=_blank class='receive_money'>".self::$language['log']."</a> 
	<br /><a href='./index.php?monxin=scanpay.account_edit&id=".$v['id']."' class='edit'>".self::$language['edit']."</a> <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
</tr>
";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['class_name']=self::$config['class_name'];
$module['page']=MonxinDigitPage($sum,$current_page,$page_size,'#'.$module['module_name']);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
