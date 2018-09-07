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
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."account";

$where="";
if($search!=''){$where=" and (`username` like '%$search%' or `name` like '%$search%' or `wid` like '%$search%' or `account` like '%$search%')";}
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
	$list.="<tr id='tr_".$v['id']."'>
	<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
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
  <td><input type='text' name='username_".$v['id']."' id='username_".$v['id']."' value='".$v['username']."' old='".$v['username']."'  class='username' /></td>
  <td>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</td>
  <td><input type='text' name='sequence_".$v['id']."' id='sequence_".$v['id']."' value='".$v['sequence']."' class='sequence' /></td>  
  <td><select name='data_state_".$v['id']."' id='data_state_".$v['id']."' class='data_state' monxin_value='".$v['state']."'>".get_account_option(self::$language['account_state'])."</select></td>  
 <td class=operation_td><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".self::$language['submit']."</a> <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
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
