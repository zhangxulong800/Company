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

$sql="select sum(`actual_money`) as c,`buyer` from ".self::$table_pre."order where `shop_id`=".SHOP_ID." and `pay_method`='credit' and `credit_state`=0  group by `buyer`";



$where="";
if($_GET['search']!=''){
	$sql="select sum(`actual_money`) as c,`buyer` from ".self::$table_pre."order where `shop_id`=".SHOP_ID." and `pay_method`='credit' and `credit_state`=0 and `buyer`='".$_GET['search']."'";
}

$_GET['order']=safe_str(@$_GET['order']);
if($_GET['order']==''){
	$order=" order by `id` desc";
}else{
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" sum(`actual_money`) as c,`buyer` "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_order and","_order where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
//echo $sql.'<br />';

$sql=str_replace("_orderr and","_order where",$sql);
//echo($sql);
//exit();

$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$sql="select `repayment_remark` from ".self::$table_pre."shop_buyer where `shop_id`=".SHOP_ID." and `username`='".$v['buyer']."' limit 0,1";
	$buyer=$pdo->query($sql,2)->fetch(2);
	$list.="<tr username='".$v['buyer']."'>
	  <td><span class=username>".$v['buyer']."</span></td>
	  <td ><span class=money>".$v['c']."</span> <a href=./index.php?monxin=mall.order_admin&pay_method=credit&credit_state=0&search=".$v['buyer']." target=_blank>".self::$language['view']."</a></td>
	  <td><textarea>".@$buyer['repayment_remark']."</textarea> <span class=state></span></td>
	  <td class=operation_td><a href=#  class='submit'>".self::$language['full_settlement']."</a><span class='state'></span></td>
	</tr>
";	

}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
