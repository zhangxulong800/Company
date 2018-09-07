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


$sql="select * from ".self::$table_pre."goods";
$where='';
if($_GET['search']!=''){$where=" and (`g_title` like '%".$_GET['search']."%' or `username` like '%".$_GET['search']."%')";}

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
	$sum_sql=str_replace("_goods and","_goods where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_goods and","_goods where",$sql);

$state_option="<option value=0>".self::$language['goods_state_option'][0]."</option><option value=1>".self::$language['goods_state_option'][1]."</option><option value=2>".self::$language['goods_state_option'][2]."</option>";

//echo $sql;
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$sql="select `id`,`icon`,`title` from ".$pdo->sys_pre."mall_goods where `id`=".$v['g_id']."";
	$g=$pdo->query($sql,2)->fetch(2);
	if($g['id']==''){self::delete_bargain($pdo,$v['id']);}
	$sql="update ".self::$table_pre."goods set `g_title`='".$g['title']."' where `id`=".$v['id'];
	$pdo->exec($sql);
		if($v['sequence']==0){$v['sequence']='';}
		$list.="<tr id='tr_".$v['id']."'>
			<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
			<td><a href='./index.php?monxin=bargain.detail&id=".$v['id']."' target=_blank class='icon'><img src='./program/mall/img_thumb/".$g['icon']."'></a></td>
			<td><div class=title><a href='./index.php?monxin=bargain.detail&id=".$v['id']."' target=_blank>".$g['title']."</a></div></td>
			
			<td>".$v['view']."</td>
			<td>".$v['sum_sold']."</td>
			<td>".$v['sum_money']."</td>
			<td>".get_date($v['start_time'],self::$config['other']['date_style'],self::$config['other']['timeoffset'])."</td>
			<td>".get_date($v['end_time'],self::$config['other']['date_style'],self::$config['other']['timeoffset'])."</td>
			<td>".$v['username']."</td>
			<td><select  name='data_state_".$v['id']."' id='data_state_".$v['id']."' monxin_value='".$v['state']."' class='data_state'  d_id=".$v['id'].">".$state_option."</select>
			<input type=text class=sequence value='".$v['sequence']."' d_id=".$v['id']." placeholder=".self::$language['sequence']." />
			</td>
			<td><a href=./index.php?monxin=bargain.goods_view&id=".$v['id']." class=goods_view>".self::$language['view']."</a> <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
		</tr>";
	
}
if($list==''){$list='<tr><td colspan=10><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		

$module['list']=$list;

$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
