<?php
if(isset($_GET['import_shop_buyer_credits'])){//临时功能 导入店内会员积分
	if(!is_file('./import_shop_buyer_credits.csv')){return false;}
	$data=file_get_contents('./import_shop_buyer_credits.csv');
	$data=iconv(self::$config['other']['export_csv_charset'].'//IGNORE',"UTF-8",$data);
	if($data==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>'}");}
	$user=explode("\r\n",$data);
	$reason='系统导入';
	//
	foreach($user as $v){
		$v=explode(',',$v);
		self::operator_shop_buyer_credits($pdo,$v[0],$v[1],$reason,SHOP_ID);	
		echo $v[0].'='.$v[1].'<br />';
	}
}

if(isset($_GET['set_py'])){
	require('plugin/py/py_class.php');
	$py_class=new py_class();  
	$sql="select `username`,`id` from ".self::$table_pre."shop_buyer where `username_py` is NULL";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		echo $v['username'];
		try { $py=$py_class->str2py($v['username']); } catch(Exception $e) { $py='';}
		$sql="update ".self::$table_pre."shop_buyer set `username_py`='".$py."' where `id`=".$v['id'];
		$pdo->exec($sql);
	}
}


if(isset($_GET['synchronization']) && $_GET['group_id']!=''){
	$sql="select `username`,`reg_time` from ".$pdo->index_pre."user";
	$r=$pdo->query($sql,2);
	$time=time();
	foreach($r as $v){
		$sql="select `id` from ".self::$table_pre."shop_buyer where `shop_id`=".SHOP_ID." and `username`='".$v['username']."' limit 0,1";
		$r2=$pdo->query($sql,2)->fetch(2);
		if($r2['id']==''){
			$sql="insert into ".self::$table_pre."shop_buyer (`shop_id`,`username`,`group_id`,`time`) values ('".SHOP_ID."','".$v['username']."','".intval($_GET['group_id'])."','".$v['reg_time']."')";
			$pdo->exec($sql);
		}
	}
}

$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."shop_buyer where `shop_id`=".SHOP_ID;



$where="";
if($_GET['search']!=''){$where=" and (`username` like '%".$_GET['search']."%' || `phone` like '%".$_GET['search']."%' ||  `email` like '%".$_GET['search']."%')";}
if(isset($_GET['group_id']) && $_GET['group_id']!=''){
	$_GET['group_id']=intval($_GET['group_id']);
	$where.=" and `group_id`=".$_GET['group_id'];	
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
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_shop_buyer and","_shop_buyer where",$sum_sql);
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
//echo $sql.'<br />';

$sql=str_replace("_shop_buyer and","_shop_buyer where",$sql);
//echo($sql);
//exit();

$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	if(!isset($v['phone'])){
		$sql="ALTER TABLE  `monxin_mall_shop_buyer` ADD  `phone` VARCHAR( 20 ) NULL COMMENT  '手机号',
ADD  `email` VARCHAR( 100 ) NULL COMMENT  '邮箱'";
		$pdo->exec($sql);
	}
	
	$sql="select `phone`,`email` from ".$pdo->index_pre."user where `username`='".$v['username']."' limit 0,1";
	$user=$pdo->query($sql,2)->fetch(2);
	
	$sql="update ".self::$table_pre."shop_buyer set `phone`='".$user['phone']."',`email`='".$user['email']."' where `id`=".$v['id'];
	$pdo->exec($sql);
	
	$list.="<tr id='tr_".$v['id']."'>
	  <td><span class=username talk='".$v['username']."'>".$v['username']."</span><div>".$user['phone']."</div><div>".$user['email']."</div></td>
	  <td ><span class=money>".$v['money']."</span></td>
	  <td ><span class=order>".$v['order']."</span></td>
	  <td ><span class=balance>".$v['balance']."</span></td>
	  <td ><span class=creditss>".$v['credits']."</span></td>
	  <td ><span class=cumulative_credits>".$v['cumulative_credits']."</span></td>
	  <td ><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</span></td>
	  <td ><select class=group_id monxin_value=".$v['group_id']." id=group_id_".$v['id'].">".self::get_shop_buyer_group_option($pdo,SHOP_ID)."</select></td>
	  <td><input type='text' name='chip_".$v['id']."' id='chip_".$v['id']."' value='".$v['chip']."'  class='chip' /></td>
	  <td class=operation_td><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".self::$language['submit']."</a> <a href='./index.php?monxin=mall.user_recharge&id=".$v['id']."' class='rehcarge'>".self::$language['recharge']."</a> <a href='./index.php?monxin=mall.credits&id=".$v['id']."' class='credits'>".self::$language['credits']."</a> <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
	</tr>
";	

}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);


$list="<option value='-1'>".self::$language['level']."</option>";
$list.="<option value='' selected>".self::$language['all'].self::$language['level']."</option>";
$list.=self::get_shop_buyer_group_option($pdo,SHOP_ID);
$list="<select name='group_id_filter' id='group_id_filter'>".$list."</select>";

$module['filter']=$list;


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);

require "./plugin/html5Upfile/createHtml5.class.php";
$html5Upfile=new createHtml5();
$html5Upfile->echo_input(self::$language,"import_file",'100%','','./temp/','true','false','csv|txt',1024*10,'0');
//echo_input(语言数组,"house_model",'控件宽度(百分比或像素)','multiple','保存到文件夹','文件夹是否附加日期','是否原名保存','允许文件类型','文件最大值','文件最小值');
