<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$id=intval(@$_GET['id']);
$search=safe_str(@$_GET['search']);
$search=trim($search);
$current_page=intval(isset($_GET['current_page'])?$_GET['current_page']:1);
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."table";

$where="";
if($search!=''){$where=" and (`name` like '%$search%' or `description` like '%$search%')";}
if($id!=0){$where=" and `id`=".$id;}
$limit=" limit ".($current_page-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_table and","_table where",$sum_sql);
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$limit;
$sql=str_replace("_table and","_table where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$list.="<tr id='tr_".$v['id']."'>
	<td><input type=text id=description_".$v['id']." placeholder=".self::$language['name']." class=description value='".$v['description']."' /><br /><input type=text id=name_".$v['id']." placeholder=".self::$language['table_name']."  class=name value='".$v['name']."' /></td>
	<td><input type=checkbox id=write_state_".$v['id']." class=write_state value='".$v['write_state']."' /></td>
	<td><input type=checkbox id=read_state_".$v['id']." class=read_state value='".$v['read_state']."' /></td>
	<td><input type=checkbox id=default_publish_".$v['id']." class=default_publish value='".$v['default_publish']."' /></td>
	<td><input type=checkbox id=authcode_".$v['id']." class=authcode value='".$v['authcode']."' /></td>
	<td>
	<div class=inform_div>
	<div class=wx_if_div><span class=m_label>".self::$language['weixin_inform']."</span><input type=checkbox id=weixin_inform_".$v['id']." class=weixin_inform value='".$v['weixin_inform']."' /></div>
	<div><span class=m_label>".self::$language['email_inform']."</span><input type=checkbox id=email_inform_".$v['id']." class=email_inform value='".$v['email_inform']."' /></div>
	<div>".self::$language['receiver_username'].":<input type=text id=inform_user_".$v['id']." class=inform_user value='".$v['inform_user']."' /></div>
	<div class=pay_money_div>".self::$language['pay_money'].":<br /><input type=text id=pay_money_".$v['id']." class=pay_money value='".$v['pay_money']."' /></div>
	</td>
	</div>
  	<td class=operation_td><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".self::$language['submit']."</a> <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span><br /><a href='index.php?monxin=".$class.".table_edit&id=".$v['id']."' class='edit_none'>".self::$language['field'].self::$language['admin']."</a><br /><a href='index.php?monxin=".$class.".data_admin&table_id=".$v['id']."' class='edit_none'>".self::$language['data'].self::$language['admin']."</a><br /><a href='index.php?monxin=".$class.".data_show_list&table_id=".$v['id']."' class='edit_none'>".self::$language['data'].self::$language['view']."</a><br /><a href='index.php?monxin=".$class.".power&power=add&id=".$v['id']."' class='edit_none'>".self::$language['add'].self::$language['power']."</a><br /><a href='index.php?monxin=".$class.".power&power=edit&id=".$v['id']."' class='edit_none'>".self::$language['edit'].self::$language['power']."</a><br /><a href='index.php?monxin=".$class.".power&power=read&id=".$v['id']."' class='edit_none'>".self::$language['read'].self::$language['power']."</a><br /><a href='index.php?monxin=".$class.".table_css&power=read&id=".$v['id']."' class='edit_none'>".self::$language['pages']['form.table_css']['name']."</a> <a d_id=".$v['id']." href=# class='url_qr'>".self::$language['url_qr']."</a></td>
</tr>
";	
}
if($id!=0){
	echo ' <div id="user_position_reset" style="display:none;"><a href="index.php"><span id=user_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a><a href="index.php?monxin=index.user">'.self::$language['user_center'].'</a><a href="index.php?monxin=form.table_admin">'.self::$language['program_name'].'</a><span class=text>'.$v['description'].'</span></div>';	
}

if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['class_name']=self::$config['class_name'];
$module['page']=MonxinDigitPage($sum,$current_page,$page_size,'#'.$module['module_name']);

$module['url_qr_pre']="http://".self::$config['web']['domain'].'/index.php?monxin=form.data_add|||table_id=';
$module['url_pre']="http://".self::$config['web']['domain'].'/index.php?monxin=form.data_add&table_id=';


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
