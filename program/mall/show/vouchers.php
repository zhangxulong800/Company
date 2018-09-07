<?php

$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$sql="select * from ".self::$table_pre."vouchers where `shop_id`=".SHOP_ID." order by `id` desc";

$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
$sum_sql=str_replace(" * "," count(id) as c ",$sql);
$r=$pdo->query($sum_sql,2)->fetch(2);
$sum=$r['c'];


$sql.=$limit;
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$list.="<tr id='tr_".$v['id']."'>
		<td><span class=name>".$v['name']."</span></td>
		<td><span class=number>".$v['number']."</span></td>
		<td><span class=amount>".$v['amount']."</span></td>
		<td><span class=min_money>".$v['min_money']."</span></td>
	  	<td>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['start_time'])." - ".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['end_time'])."</td>
		<td><span class=join_goods>".self::$language['join_goods_front'][$v['join_goods']]."</span></td>
		<td><span class=sum_quantity>".$v['sum_quantity']."</span></td>
		<td><span class=use_quantity>".$v['use_quantity']."</span></td>
	  <td class=operation_td><a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
	</tr>
";	

}
$module['list']=$list;
if($module['list']==''){$module['list']='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);


		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
