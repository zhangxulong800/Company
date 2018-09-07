<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."agent_finance where `username`='".$_SESSION['monxin']['username']."'";

$where="";
if(@$_GET['start_time']!=''){
	$start_time=get_unixtime($_GET['start_time'],self::$config['other']['date_style']);
	$where.=" and `time`>$start_time";	
}
if(@$_GET['end_time']!=''){
	$end_time=get_unixtime($_GET['end_time'],self::$config['other']['date_style'])+86400;
	$where.=" and `time`<$end_time";	
}

if(@$_GET['type']!=''){
	$type=intval($_GET['type']);
	$where.=" and `type`=".$type;
}

if(@$_GET['shop_id']!=''){
	$where.=" and `shop_id`=".intval($_GET['shop_id']);
}


if($_GET['search']!=''){$where.=" and (`money` like '%".$_GET['search']."%' || `reason` like '%".$_GET['search']."%' || `shop_name` like '%".$_GET['search']."%')";}
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
	$sum_sql=str_replace("_agent_finance and","_agent_finance where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
	
	$income=$sql.' and `money`>0'.str_replace(' and `money`<0','',$where);
	$income=str_replace(" * "," sum(money) as c ",$income);
	$income=str_replace("_agent_finance and","_agent_finance where",$income);
	$r=$pdo->query($income,2)->fetch(2);
	$income=$r['c'];
	
	$expenditure=$sql.' and `money`<0'.str_replace(' and `money`>0','',$where);
	$expenditure=str_replace(" * "," sum(money) as c ",$expenditure);
	$expenditure=str_replace("_agent_finance and","_agent_finance where",$expenditure);
	$r=$pdo->query($expenditure,2)->fetch(2);
	$expenditure=$r['c'];
	
	$module['income']=$income;
	$module['expenditure']=str_replace('-','',$expenditure);
	if($module['income']==''){$module['income']=0;}
	if($module['expenditure']==''){$module['expenditure']=0;}
	$module['profit']=sprintf("%.2f",$income+$expenditure);
	
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_agent_finance and","_agent_finance where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$operation="<a href=".$v['id']." class='del'>".self::$language['del']."</a>";
	$v['money']=($v['money']<0)?$v['money']:'+'.$v['money'];
	if($v['money']<0){$f_method=self::$language['finance_method'][0];}else{$f_method=self::$language['finance_method'][1];}
	
	$list.="<tr id='tr_".$v['id']."'>
	<td><span class=method>".$f_method."</span></td>
	<td><span class=type>".self::$language['finance_type_agent'][$v['type']]."</span></td>
	<td><span class=before_money>".$v['before_money']."</span></td>
	<td><span class=money>".$v['money']."</span></td>
	<td><span class=after_money>".$v['after_money']."</span></td>
	<td><span class=reason>".$v['reason']."</span></td>
	<td><a href='./index.php?monxin=mall.finance&shop_id=".$v['shop_id']."' class=shop_name>".$v['shop_name']."</a></td>
	<td><span class=time><a href=#  >".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</a></span></td>
</tr>
";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}

if(@$_GET['shop_id']!=''){
	echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=mall.agent_finance">'.self::$language['pages']['mall.agent_finance']['name'].'</a><span class=text>'.$v['shop_name'].'</span></div>';
}



$sql="select sum(money) as c from ".$pdo->index_pre."money_log where `username`='".$_SESSION['monxin']['username']."' and `money`>0";
if($_GET['search']!=''){$sql.=" and (`username` like '%".$_GET['search']."%' || `money` like '%".$_GET['search']."%' || `reason` like '%".$_GET['search']."%' || `operator` like '%".$_GET['search']."%')";}
if(isset($start_time)){$sql.=" and `time`>$start_time";	}
if(isset($end_time)){$sql.=" and `time`<$end_time";	}
$sql=str_replace("_money_log and","_money_log where",$sql);
$r=$pdo->query($sql,2)->fetch(2);
$module['add']=$r['c']==''?0:$r['c'];


$sql="select sum(money) as c from ".$pdo->index_pre."money_log where `username`='".$_SESSION['monxin']['username']."' and `money`<0";
if($_GET['search']!=''){$sql.=" and (`username` like '%".$_GET['search']."%' || `money` like '%".$_GET['search']."%' || `reason` like '%".$_GET['search']."%' || `operator` like '%".$_GET['search']."%')";}
if(isset($start_time)){$sql.=" and `time`>$start_time";	}
if(isset($end_time)){$sql.=" and `time`<$end_time";	}
$sql=str_replace("_money_log and","_money_log where",$sql);
$r=$pdo->query($sql,2)->fetch(2);
$module['deduction']=$r['c']==''?'-0':$r['c'];

	
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);


function get_agent_finance_method($pdo,$language){
	$list="<option value='-1'>".$language['method']."</option>";
	$list.="<option value='' selected>".$language['all'].$language['method']."</option>";
	foreach($language['finance_method'] as $k=>$v){
		$list.='<option value="'.$k.'">'.$v.'</option>';	
	}
	$list='<select id=method name=method>'.$list.'</select>';
	return $list;
}

function get_agent_finance_type($pdo,$language){
	$list="<option value='-1'>".$language['type']."</option>";
	$list.="<option value='' selected>".$language['all'].$language['type']."</option>";
	foreach($language['finance_type_agent'] as $k=>$v){
		$list.='<option value="'.$k.'">'.$v.'</option>';	
	}
	$list='<select id=type name=type>'.$list.'</select>';
	return $list;
}
function get_agent_finance_method_option($pdo,$language){
	$list="<option value=''>".$language['please_select']."</option>";
	foreach($language['finance_method'] as $k=>$v){
		$list.='<option value="'.$k.'">'.$v.'</option>';	
	}
	$list='<select class=add_method>'.$list.'</select>';
	return $list;
}

function get_agent_finance_type_option($pdo,$language){
	$list="<option value=''>".$language['please_select']."</option>";
	foreach($language['finance_type_agent'] as $k=>$v){
		$list.='<option value="'.$k.'">'.$v.'</option>';
	}
	$list='<select class=add_type>'.$list.'</select>';
	return $list;
}



$module['filter']=get_agent_finance_type($pdo,self::$language);

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);