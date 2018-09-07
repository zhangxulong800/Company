<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['username']=safe_str(@$_GET['username']);
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select `id`,`name`,`type` from ".self::$table_pre."account where `username`='".$_SESSION['monxin']['username']."'";
$r=$pdo->query($sql,2);
$account=array();
$account_type=array();
$account_option='';
$a_ids='';
foreach($r as $v){
	$v['name']=de_safe_str($v['name']).'('.self::$language['account_type_option'][$v['type']].')';	
	$account_option.='<option value="'.$v['id'].'">'.$v['name'].'</option>';
	$account[$v['id']]=$v['name'];	
	$account_type[$v['id']]=$v['type'];	
	$a_ids.=$v['id'].',';
}
$a_ids=trim($a_ids,',');
if($a_ids==''){header('location:./index.php?monxin=scanpay.account_add');exit;}

$sql="select * from ".self::$table_pre."pay where `a_id` in (".$a_ids.")";

$where="";
if(intval(@$_GET['a_id'])>0){$where.=" and `a_id`='".intval($_GET['a_id'])."'";}
if(intval(@$_GET['state'])>0){$where.=" and `state`='".intval($_GET['state'])."'";}
if(intval(@$_GET['settlement'])>0){$where.=" and `settlement`='".intval($_GET['settlement'])."'";}

if(@$_GET['start_time']!=''){
	$start_time=get_unixtime($_GET['start_time'],self::$config['other']['date_style']);
	$where.=" and `time`>$start_time";	
}
if(@$_GET['end_time']!=''){
	$end_time=get_unixtime($_GET['end_time'],self::$config['other']['date_style'])+86400;
	$where.=" and `time`<$end_time";	
}


if($_GET['search']!=''){$where=" and (`barcode` like '%".$_GET['search']."%' || `out_id` like '%".$_GET['search']."%' || `reason` like '%".$_GET['search']."%' || `payer` like '%".$_GET['search']."%' || `operator` like '%".$_GET['search']."%')";}
if($_GET['username']!=''){$where=" and `username`='".$_GET['username']."'";}
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
	$sum_sql=str_replace("_pay and","_pay where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_pay and","_pay where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$inquiry='';
	if($v['state']==4){$inquiry='<a href="./scanpay_type/'.$account_type[$v['a_id']].'/inquiry.php?id='.$v['a_id'].'&p_id='.$v['id'].'" target=_blank>'.self::$language['inquiry'].'</a>';}
	$list.="<tr id='tr_".$v['id']."'>
	<td><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</span></td>
	<td >".$v['money']."</td>
	<td >".self::$language['pay_state'][$v['state']]." ".$inquiry." ".$v['fail_reason']."</td>
	<td ><div>".$account[$v['a_id']]."</div>".$v['payer'].' '.$v['reason']."</td>
	<td >".$v['barcode']."</td>
	<td >".$v['out_id']."</td>
	<td >".self::$language['settlement_state'][$v['settlement']]."</td>
	<td >".$v['operator']."</td>
</tr>
";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}



$module['filter']="";
$account_option="<option value='-1'>".self::$language['account_name']."</option><option value='' selected>".self::$language['all'].self::$language['account_name']."</option>".$account_option;
$module['filter'].="<select name='a_id' id='a_id'>".$account_option."</select>";

$option="<option value='-1'>".self::$language['pay_money'].self::$language['state']."</option><option value='' selected>".self::$language['all'].self::$language['pay_money'].self::$language['state']."</option>";
foreach(self::$language['pay_state'] as $k=>$v){
	$option.="<option value=".$k.">".$v."</option>";	
}
$module['filter'].="<select name='state' id='state'>".$option."</select>";

$option="<option value='-1'>".self::$language['settlement']."</option><option value='' selected>".self::$language['all'].self::$language['settlement']."</option>";
foreach(self::$language['settlement_state'] as $k=>$v){
	$option.="<option value=".$k.">".$v."</option>";	
}
$module['filter'].="<select name='settlement' id='settlement'>".$option."</select>";

$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

$sql="select  sum(`money`) as c from ".self::$table_pre."pay where `a_id` in (".$a_ids.") ".$where;
$sql=str_replace("_pay and","_pay where",$sql);
$r=$pdo->query($sql,2)->fetch(2);
if($r['c']==''){$r['c']=0;}
$module['sum_money']=$r['c'];
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);