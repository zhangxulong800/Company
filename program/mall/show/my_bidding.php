<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select `gid`,`shop_id`,sum(money) as s_money,count(id) as click from ".self::$table_pre."bidding where `shop_id`=".SHOP_ID." group by `gid` order by `id` desc";
$where='';
$order='';

$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" `gid`,`shop_id`,sum(money) as s_money,count(id) as click "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_bidding and","_bidding where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_bidding and","_bidding where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';


foreach($r as $v){
	$v=de_safe_str($v);
	$sql="select `title` from ".self::$table_pre."goods where `id`=".$v['gid'];
	$r2=$pdo->query($sql,2)->fetch(2);
	$goods_name=$r2['title'];
	
	$list.="<tr >
	<td><a href=./index.php?monxin=mall.goods&id=".$v['gid']." target=_blank class=goods_name>".$goods_name."</a></td>
	<td>".$v['click']."</td>
	<td><a href=./index.php?monxin=mall.my_bidding_detail&gid=".$v['gid']." target=_blank>".$v['s_money']."</a></td>
</tr>
";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;

$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

$module['hot_search']=self::$config['hot_search'];
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);