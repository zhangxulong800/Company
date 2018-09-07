<?php
function get_account_option($r){
	$list='';
	foreach($r as $key=>$v){
		$list.='<option value="'.$key.'">'.$v.'</option>';
	}
	return $list;
}


$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$search=safe_str(@$_GET['search']);
$search=trim($search);
$current_page=intval(isset($_GET['current_page'])?$_GET['current_page']:1);
if($current_page<1){$current_page=1;}
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."account where `username`='".$_SESSION['monxin']['username']."' or `manager` like '%,".$_SESSION['monxin']['username'].",%'";
$wid=safe_str(@$_GET['wid']);
if($wid!=''){
	$sql="select `name` from ".self::$table_pre."account where `wid`='".$wid."'";
	$r=$pdo->query($sql,2)->fetch(2);
	$w_name=$r['name'];
	echo ' <div id="user_position_reset" style="display:none;"><a href="index.php"><span id=user_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a><a href="index.php?monxin=index.user">'.self::$language['user_center'].'</a><a href="index.php?monxin=weixin.account_list">'.self::$language['pages']['weixin.account_list']['name'].'</a><span class=text>'.$w_name.'</span></div>';	
	$sql="select * from ".self::$table_pre."account where (`username`='".$_SESSION['monxin']['username']."'  or `manager` like '%,".$_SESSION['monxin']['username'].",%') and `wid`='".$wid."'";
}

$where="";
if($search!=''){$where=" and (`username` like '%$search%' or `wid` like '%$search%' or `account` like '%$search%')";}
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
	$sum_sql=str_replace("_account and","_account where",$sum_sql);
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_account and","_account where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$v=de_safe_str($v);
	$menu="";
	if($v['AppId']!='' && $v['AppSecret']!=''){
		$menu="<a href='index.php?monxin=".$class.".menu_list&wid=".$v['wid']."' class='menu_a'>".self::$language['menu']."</a>";	
	}
	$act='';
	if($v['username']==$_SESSION['monxin']['username']){
		$act="<a href='index.php?monxin=".$class.".account_edit&id=".$v['id']."' class='edit'>".self::$language['edit']."</a><a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a>";	
	}
	$list.="<tr id='tr_".$v['id']."'>
	<td>
		<a href='./program/weixin/qr_code/".$v['qr_code']."' class=qr_code_div target=_blank><img src='./program/weixin/qr_code/".$v['qr_code']."' class=qr_code_img></a>
	</td>
	<td>
		<div class=info_div align=left>
			<div><span class=m_label>".self::$language['weixin_name']."</span><span class=name>".$v['name']."</span></div>
			<div><span class=m_label>".self::$language['weixin_account']."</span><span class=account>".$v['account']."</span></div>
			<div><span class=m_label>".self::$language['weixin_id']."</span><span class=wid>".$v['wid']."</span></div>
			<div><span class=m_label>".self::$language['area']."</span><span class=area><span class=load_js_span  src='area_js.php?callback=set_area&input_id=area&id=".$v['area']."&output=text2' id='area_".$v['area']."'></span></div>
			
		</div>
	</td>
  <td>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</td>
 <td class=operation_td>".$menu."<a href='index.php?monxin=".$class.".auto_answer_list&wid=".$v['wid']."' class='auto_answer_a'>".self::$language['auto_answer']."</a><a href='index.php?monxin=".$class.".user_list&wid=".$v['wid']."' class='user_a'>".self::$language['user']."</a><a href='index.php?monxin=".$class.".dialog_list&wid=".$v['wid']."' class='dialog_a'>".self::$language['dialog']."</a><a href='index.php?monxin=".$class.".diy_qr&wid=".$v['wid']."' class='diy_qr'>".self::$language['diy_qr']."</a><a href='index.php?monxin=".$class.".mass&wid=".$v['wid']."' class='mass'>".self::$language['pages']['weixin.mass']['name']."</a><br /><a href=# class=reset_token d_id=".$v['id'].">".self::$language['reset_token']."</a>".$act." <span id=state_".$v['id']." class='state'></span></td>
</tr>
";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['class_name']=self::$config['class_name'];
$module['page']=MonxinDigitPage($sum,$current_page,$page_size,'#'.$module['module_name']);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
