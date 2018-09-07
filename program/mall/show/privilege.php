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

$sql="select `shop_id`,`credits`,`group_id`,`balance` from ".self::$table_pre."shop_buyer where `username`='".$_SESSION['monxin']['username']."'";


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
	$sum_sql=str_replace(" `shop_id`,`credits`,`group_id`,`balance` "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_shop_buyer and","_shop_buyer where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_shop_buyer and","_shop_buyer where",$sql);
//echo($sql);
//exit();

$r=$pdo->query($sql,2);
$list='';
foreach($r as $v2){
	$sql="select `id`,`name`,`main_business`,`state` from ".self::$table_pre."shop where `id`=".$v2['shop_id'];
	$v=$pdo->query($sql,2)->fetch(2);
	if($v['state']!=2){continue;}
	$sql="select `name`,`discount` from ".self::$table_pre."shop_buyer_group where `id`=".$v2['group_id'];
	$group=$pdo->query($sql,2)->fetch(2);
	if($group['discount']!=''){$group['discount']=$group['discount'].self::$language['discount'];}
	$balance_act='';
	if($v2['balance']>0){$balance_act=' <a href=./index.php?monxin=mall.money_transfer&shop_id='.$v2['shop_id'].' class=transfer>'.self::$language['transfer'].'</a>';}
	
	$list.="<tr id='tr_".$v['id']."'>
	  <td><div class=info>
	  	<div class=icon><a href=./index.php?monxin=mall.shop_index&shop_id=".$v['id']." target=_blank><img src=./program/mall/shop_icon/".$v['id'].".png /></a></div><div class=other>
			<a href=./index.php?monxin=mall.shop_index&shop_id=".$v['id']." target=_blank class=name>".$v['name']."</a>
			<div class=main_business>".$v['main_business']."</div>
		</div>
	  </div></td>
	  <td>".$group['name']."</td>
	  <td>".$group['discount']."</td>
	  <td>".$v2['credits']."</td>
	  <td><span class=balance>".$v2['balance'].'</span>'.$balance_act."</td>
	  
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
