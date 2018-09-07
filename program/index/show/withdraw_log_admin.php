<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".$pdo->index_pre."withdraw";

$where="";
$_GET['state']=intval(@$_GET['state']);
if($_GET['state']!=0){$where=" and `state`='".$_GET['state']."'";}

if(@$_GET['start_time']!=''){
	$start_time=get_unixtime($_GET['start_time'],self::$config['other']['date_style']);
	$where.=" and `time`>$start_time";	
}
if(@$_GET['end_time']!=''){
	$end_time=get_unixtime($_GET['end_time'],self::$config['other']['date_style'])+86400;
	$where.=" and `time`<$end_time";	
}


if($_GET['search']!=''){$where=" and (`username` like '%".$_GET['search']."%')";}
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
	$sum_sql=str_replace("_withdraw and","_withdraw where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_withdraw and","_withdraw where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$v=de_safe_str($v);
	$pay_time='';
	$sql="select `real_name` from ".$pdo->index_pre."user where `username`='".$v['username']."' limit 0,1";
	$rr=$pdo->query($sql,2)->fetch(2);
	
	if($v['method']==0){$v['method']=self::$language['other'];$act_name=self::$language['deduction_balance_0'];}else{$v['method']=self::$language['openid'];$act_name=self::$language['deduction_balance_1'];}
	
	if($v['state']!=3){$operation="<a href=".$v['id']." class='refuse'>".self::$language['refuse']."</a> <a href=".$v['id']." class='paid'>".$act_name."</a>";}else{$operation="";$pay_time=get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['pay_time']);}
	if($pay_time==self::$language['none']){$pay_time='';}
	if($v['state']==2){$reason='<a href="#" title="'.$v['reason'].'" class="reason">'.self::$language['reason'].'</a>';$operation=" <a href=".$v['id']." class='del'>".self::$language['del']."</a>";}else{$reason='';}
	if($v['state']==1){$input='<input type="text" style="display:none;" id="reason_'.$v['id'].'" name="reason_'.$v['id'].'" value="'.self::$language['reason'].':" class="reason_input" />';}else{$input='';}
	
	$list.="<tr id='tr_".$v['id']."'>
	<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
	<td><a class='username' href='./index.php?monxin=index.admin_users&search=".$v['username']."' target=_blank>".$v['username']."</a></td>
	<td><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</span></td>
	<td><span class=money>".$v['money']." <i>".self::$language['withdraw_deduction_state'][$v['deduction']]."</i></span></td>
	<td><span class=rate>".trim(rtrim($v['rate'],'0'),'.')."% ".self::$language['money_symbol'].($v['money']*$v['rate']/100)."</span></td>
	<td><span class=method>".$v['method']."</span></td>
	<td><span class=real_name>".$rr['real_name']."</span></td>
	<td><span class=billing_info>".$v['billing_info']."</span></td>
	<td><span class=state>".self::$language['withdraw_state'][$v['state']]." $reason $pay_time</span> </td>
	<td class=operation_td>&nbsp; $input".$operation."  <span id=state_".$v['id']." class='operation_state'></span></td>
</tr>
";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}

$sql="select sum(money) as c from ".$pdo->index_pre."withdraw where `state`=1";
if(@$_GET['method']!=''){$sql.=" and `method`='".$_GET['method']."'";}
if($_GET['search']!=''){$sql.=" and (`username` like '%".$_GET['search']."%')";}
if(isset($start_time)){$sql.=" and `time`>$start_time";	}
if(isset($end_time)){$sql.=" and `time`<$end_time";	}
$r=$pdo->query($sql,2)->fetch(2);
$module['state_1']=$r['c'];
if($module['state_1']==''){$module['state_1']=0;}


$sql="select sum(money) as c from ".$pdo->index_pre."withdraw where `state`=2";
if(@$_GET['method']!=''){$sql.=" and `method`='".$_GET['method']."'";}
if($_GET['search']!=''){$sql.=" and (`username` like '%".$_GET['search']."%')";}
if(isset($start_time)){$sql.=" and `time`>$start_time";	}
if(isset($end_time)){$sql.=" and `time`<$end_time";	}
$r=$pdo->query($sql,2)->fetch(2);
$module['state_2']=$r['c'];
if($module['state_2']==''){$module['state_2']=0;}


$sql="select sum(money) as c from ".$pdo->index_pre."withdraw where `state`=3";
if(@$_GET['method']!=''){$sql.=" and `method`='".$_GET['method']."'";}
if($_GET['search']!=''){$sql.=" and (`username` like '%".$_GET['search']."%')";}
if(isset($start_time)){$sql.=" and `time`>$start_time";	}
if(isset($end_time)){$sql.=" and `time`<$end_time";	}
$r=$pdo->query($sql,2)->fetch(2);
$module['state_3']=$r['c'];
if($module['state_3']==''){$module['state_3']=0;}





$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['filter']="<select id='state' name='state'><option value='-1'>".self::$language['state']."</option><option value='' selected>".self::$language['all']."</option><option value='1'>".self::$language['withdraw_state'][1]."</option><option value='2'>".self::$language['withdraw_state'][2]."</option><option value='3'>".self::$language['withdraw_state'][3]."</option></select>";
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);	