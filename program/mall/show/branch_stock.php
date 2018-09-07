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
$head=self::get_headquarters_name($pdo);

$sql="select `id`,`name` from ".self::$table_pre."shop where `head`='".$head."' ";

$where="";
if($_GET['search']!=''){$where=" and (`name` like '%".$_GET['search']."%')";}
$_GET['order']=safe_str(@$_GET['order']);
if($_GET['order']==''){
	$order=" order by `id` desc";
}else{
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" `id`,`name` "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_shop and","_shop where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_shop and","_shop where",$sql);
//echo($sql);
//exit();

$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$v=de_safe_str($v);
		$sql="select sum(quantity) as c from ".self::$table_pre."goods_batch where `shop_id`=".$v['id'];
		$cumulative=$pdo->query($sql,2)->fetch(2);
		
		$sql="select sum(`left`) as c from ".self::$table_pre."goods_batch where `shop_id`=".$v['id'];
		$left=$pdo->query($sql,2)->fetch(2);
		
		$sql="select sum(`quantity`) as c from ".self::$table_pre."goods_quantity_log where `shop_id`=".$v['id'];
		$sold=$pdo->query($sql,2)->fetch(2);
		
		$sql="select sum(quantity) as c from ".self::$table_pre."goods_loss where `shop_id`=".$v['id']."";
		$loss=$pdo->query($sql,2)->fetch(2);
	
		$sql="select sum(quantity) as c from ".self::$table_pre."goods_deduct_stock where `shop_id`=".$v['id']."";
		$deduct_stock=$pdo->query($sql,2)->fetch(2);
		
	$list.="<tr id='tr_".$v['id']."'>
		<td><a class=icon href=./index.php?monxin=mall.shop_index&shop_id=".$v['id']." target=_blank><img src=./program/mall/shop_icon/".$v['id'].".png />".$v['name']."</a></td>
		</td>
		<td>".self::format_quantity($cumulative['c'])."</td>
		<td>".self::format_quantity($sold['c']).'/'.self::format_quantity($loss['c']).'/'.self::format_quantity($deduct_stock['c'])."</td>
		<td>".self::format_quantity($left['c'])."</td>
		<td class=operation_td><a href='./index.php?monxin=mall.branch_stock_detail&shop_id=".$v['id']."' target=_blank class='submit'>".self::$language['detail']."</a></td>
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
