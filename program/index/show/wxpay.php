<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".$pdo->index_pre."wxpay";

$where="";

if(@$_GET['start_time']!=''){
	$start_time=get_unixtime($_GET['start_time'],self::$config['other']['date_style']);
	$where.=" and `time`>$start_time";	
}
if(@$_GET['end_time']!=''){
	$end_time=get_unixtime($_GET['end_time'],self::$config['other']['date_style'])+86400;
	$where.=" and `time`<$end_time";	
}


if($_GET['search']!=''){$where=" and (`username` like '%".$_GET['search']."%' || `reason` like '%".$_GET['search']."%')";}
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
	$sum_sql=str_replace("_wxpay and","_wxpay where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_wxpay and","_wxpay where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$openid_name='';
	$sql="select `nickname`,`headimgurl`,`state` from ".$pdo->sys_pre."weixin_user where `wid`='".self::$config['web']['wid']."' and `openid`='".$v['openid']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['nickname']!=''){
		$openid_name='<img src='.de_safe_str($r['headimgurl']).' class=open_icon>'.$r['nickname'];
	}
	$operation='';
	if($v['receive_state']!=10){$operation.="<a href=".$v['id']." class=inquiry>".self::$language['inquiry']."</a>";}
	$operation.=" <a href=".$v['id']." class='del'>".self::$language['del']."</a>";
	
	
	$list.="<tr id='tr_".$v['id']."'>
	<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
	<td><span class=time><a href=#  title='ip:".$v['ip']."'>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</a></span></td>
	<td>".$v['username']."</td>
	<td>".$openid_name."</td>
	<td>".self::$language['wxpay_type'][$v['type']]."</td>
	<td>".$v['money']."</td>
	<td>".$v['reason']."</td>
	<td class=send_state>".self::$language['wxpay_send_state'][$v['send_state']]."</td>
	<td class=receive_state>".self::$language['wxpay_receive_state'][$v['receive_state']]."</td>
	<td><span class=operation>".$operation."  <span id=state_".$v['id']." class='operation_state'></span></span></td>
</tr>
";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}

$sql="select sum(money) as c from ".$pdo->index_pre."wxpay";
if($_GET['search']!=''){$sql.=" and (`username` like '%".$_GET['search']."%' || `reason` like '%".$_GET['search']."%')";}
if(isset($start_time)){$sql.=" and `time`>$start_time";	}
if(isset($end_time)){$sql.=" and `time`<$end_time";	}
$sql=str_replace("_wxpay and","_wxpay where",$sql);
$r=$pdo->query($sql,2)->fetch(2);
$module['sum_all']=$r['c'];
if($module['sum_all']==''){$module['sum_all']=0;}

$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);	