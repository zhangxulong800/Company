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
$username=$_SESSION['monxin']['username'];
$where="";
for($i=1;$i<self::$config['level']+1;$i++){
	$where.=" (`u_".$i."`='".$username."' && `r_".$i."`>0) ||";
}
$where=trim($where,'||');
$sql="select * from ".self::$table_pre."order where ".$where;
//echo $sql;
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
	$sum_sql=str_replace("_order and","_order where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
	
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," sum(order_money) as c ",$sum_sql);
	$sum_sql=str_replace("_order and","_order where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	if($r['c']==''){$r['c']=0;}
	$sum_all=$r['c'];
	
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_order and","_order where",$sql);
//echo($sql);
//exit();

$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	
	$sql="select `name` from ".$pdo->sys_pre."mall_shop where `id`=".$v['shop_id'];
	$shop=$pdo->query($sql,2)->fetch(2);
	$fy='';
	
	if($v['r_1']>0){$fy.='1 '.$v['u_1'].': '.$v['r_1'].'<br />';}
	if($v['r_2']>0){$fy.='2 '.$v['u_2'].': '.$v['r_2'].'<br />';}
	if($v['r_3']>0){$fy.='3 '.$v['u_3'].': '.$v['r_3'].'<br />';}
	if($v['r_4']>0){$fy.='4 '.$v['u_4'].': '.$v['r_4'].'<br />';}
	if($v['r_5']>0){$fy.='5 '.$v['u_5'].': '.$v['r_5'].'<br />';}
	if($v['r_6']>0){$fy.='6 '.$v['u_6'].': '.$v['r_6'].'<br />';}
	if($v['r_7']>0){$fy.='7 '.$v['u_7'].': '.$v['r_7'].'<br />';}
	if($v['r_8']>0){$fy.='8 '.$v['u_8'].': '.$v['r_8'].'<br />';}
	if($v['r_9']>0){$fy.='9 '.$v['u_9'].': '.$v['r_9'].'<br />';}
	
	$list.="<tr id='tr_".$v['id']."'>
		<td>".$v['out_id']."</td>
		<td>".$v['buyer']."</td>
		<td >".$v['order_money']."</td>
		<td >".$fy."</td>
		<td><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['add_time'])."</span></td>
		<td><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['success_time'])."</span></td>
		<td class=order_state_".$v['order_state'].">".self::$language['order_state'][$v['order_state']]."</td>

	</tr>
";	

}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

$list='';
foreach(self::$language['order_state'] as $k=>$v){
	$list.='<option value='.$k.'>'.$v.'</option>';	
}

$module['filter']="<select name='state_filter' id='state_filter'><option value='-1'>".self::$language['visible_state']."</option><option value='' selected>".self::$language['all'].self::$language['state']."</option>{$list}</select>";

$module['sum_html']='<div class=sum_div>'.self::$language['sum'].self::$language['order_money'].':<b>'.$sum_all.'</b> </div>';

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
