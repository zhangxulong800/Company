<?php

function get_like_option($a){
	$list='';
	foreach($a as $key=>$v){
		$list.='<option value="'.$key.'">'.$v.'</option>';	
	}
	return $list;	
}


if(!$this->check_wid_power($pdo,self::$table_pre)){echo self::$language['act_noPower'];return false;}
$wid=safe_str(@$_GET['wid']);
$sql="select `name` from ".self::$table_pre."account where `wid`='".$wid."'";
$r=$pdo->query($sql,2)->fetch(2);
$w_name=$r['name'];

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['visible']=@$_GET['visible'];
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select `id`,`key`,`sequence`,`state`,`like`,`author`,`time`,`use_count`,`input_type` from ".self::$table_pre."auto_answer where `wid`='".$wid."'";

$where="";

if($_GET['search']!=''){$where=" and (`key` like '%".$_GET['search']."%')";}
if(@$_GET['order']==''){
	$order=" order by `sequence` desc,`id` asc";
}else{
	$_GET['order']=safe_str($_GET['order']);
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" `id`,`key`,`sequence`,`state`,`like`,`author`,`time`,`use_count`,`input_type` "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_auto_answer and","_auto_answer where",$sum_sql);
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_auto_answer and","_auto_answer where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$v=de_safe_str($v);
	$del='';
	if($v['author']==$_SESSION['monxin']['username']){$del=" <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a>";}
	$list.="<tr id='tr_".$v['id']."'>
	<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
	<td><span class=key>".$v['key']."</span></td>
	<td><select id=like_".$v['id']." name=like_".$v['id']." monxin_value='".$v['like']."' class=like>".get_like_option(self::$language['like_state'])."</select></td>
	<td><input type='text' name='sequence_".$v['id']."' id='sequence_".$v['id']."' value='".$v['sequence']."' class='sequence' /></td>
	<td><input type='checkbox' name='data_state_".$v['id']."' id='data_state_".$v['id']."'  class='data_state' value='".$v['state']."' /></td>
	<td><span class=use_count>".$v['use_count']."</span></td>
	<td><span class=author>".$v['author']."</span></td>
	<td>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</td>
  <td class=operation_td><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".self::$language['submit']."</a> <a href='index.php?monxin=".$class.".auto_answer_edit&wid=".$wid."&id=".$v['id']."&type=".$v['input_type']."' class='edit'>".self::$language['edit']."</a>".$del." <span id=state_".$v['id']." class='state'></span></td>
</tr>
";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&wid='.$wid;
$module['class_name']=self::$config['class_name'];
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

echo ' <div id="user_position_reset" style="display:none;"><a href="index.php"><span id=user_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a><a href="index.php?monxin=index.user">'.self::$language['user_center'].'</a><a href="index.php?monxin=weixin.account_list">'.self::$language['pages']['weixin.account_list']['name'].'</a><a href="index.php?monxin=weixin.account_list&wid='.$wid.'">'.$w_name.'</a><span class=text>'.self::$language['pages']['weixin.auto_answer_list']['name'].'</span></div>';	

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);