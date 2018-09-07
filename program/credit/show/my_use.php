<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$search=safe_str(@$_GET['search']);
$search=trim($search);
$current_page=intval(isset($_GET['current_page'])?$_GET['current_page']:1);
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."prize_log where `username`='".$_SESSION['monxin']['username']."'";

$where="";
if($search!=''){$where=" and (`p_name` like '%$search%' or `r_info` like '%$search%' or `s_info` like '%$search%')";}
if(@$_GET['order']==''){
	$order=" order by `id` desc";
}else{
	$_GET['order']=safe_str($_GET['order']);
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($current_page-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_prize_log and","_prize_log where",$sum_sql);
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_prize_log and","_prize_log where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$v=de_safe_str($v);
	if($v['state']==1){
		$act="";
		$disabled="disabled='disabled'";
	}else{
		$disabled='';
		$act="<a href='#' d_id=".$v['id']." class='submit'>".self::$language['submit']."</a>";
	}
	
	
	if($_COOKIE['monxin_device']=='pc'){
		$list.="<tr id='tr_".$v['id']."'>
	<td><div class=prize_info><img src=./program/credit/img/".$v['p_id'].".jpg /><div class=name>".$v['p_name']."</div></div></td>
	<td>".$v['money']."</td>
	<td>".self::$language['exchange_state'][$v['state']]."</td>
	<td><textarea type='text' $disabled placeholder='".self::$language['r_info_placeholder']."' name='r_info_".$v['id']."' id='r_info_".$v['id']."' class='r_info' >".$v['r_info']."</textarea></td>
	<td>".$v['s_info']."</td>
  <td class=operation_td>".$act."<span id=state_".$v['id']." class='state'></span></td>
</tr>
";	
	}else{
		$list.="<tr id='tr_".$v['id']."'>
	<td><div class=prize_info><img src=./program/credit/img/".$v['p_id'].".jpg /><div class=name>".$v['p_name']."</div></div></td>
	<td><textarea type='text' $disabled placeholder='".self::$language['r_info_placeholder']."' name='r_info_".$v['id']."' id='r_info_".$v['id']."' class='r_info' >".$v['r_info']."</textarea><br />".$act."<span id=state_".$v['id']." class='state'></span></td>
	<td>".$v['s_info']."</td>
	<td>".$v['money']."</td>
	<td>".self::$language['exchange_state'][$v['state']]."</td>
</tr>
";	
	}
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['class_name']=self::$config['class_name'];
$module['page']=MonxinDigitPage($sum,$current_page,$page_size,'#'.$module['module_name']);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
