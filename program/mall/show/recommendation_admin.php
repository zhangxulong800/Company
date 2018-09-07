<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."recommendation";

$where="";

if($_GET['search']!=''){$where=" and (`username` ='".$_GET['search']."')";}
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
	$sum_sql=str_replace("_recommendation and","_recommendation where",$sum_sql);
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_recommendation and","_recommendation where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';


foreach($r as $v){
	$sql="select `buyer`,`actual_money` from ".self::$table_pre."order where `id`=".$v['order_id'];
	$order=$pdo->query($sql,2)->fetch(2);
	$sql="select `title`,`quantity`,`goods_id` from ".self::$table_pre."order_goods where `order_id`=".$v['order_id'];
	$goods=$pdo->query($sql,2)->fetch(2);
	
	$sql="select `name` from ".self::$table_pre."shop where `id`=".$v['shop_id'];
	$shop=$pdo->query($sql,2)->fetch(2);
	
	
	$list.="<tr id='tr_".$v['id']."'>
	<td>".de_safe_str($shop['name'])."</td>
	<td>".$order['buyer']."</td>
	<td><a href='./index.php?monxin=mall.order_admin&id=".$v['order_id']."' target=_blank>".$v['order_id']."</a></td>
	<td><a href='./index.php?monxin=mall.goods&id=".$goods['goods_id']."' target=_blank>".$goods['title']." * ".self::format_quantity($goods['quantity'])."  ".self::$language['sum'].$order['actual_money'].self::$language['yuan']."</a></td>
	<td>".$v['username']."</td>
	<td>".$v['money']."</td>
	<td><span class=time><a href=#  >".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</a></span></td>
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