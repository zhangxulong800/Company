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
$_GET['state']=@$_GET['state'];
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."user where `wid`='".$wid."'";

$where="";

if($_GET['search']!=''){$where=" and (`openid` like '%".$_GET['search']."%' or `nickname` like '%".$_GET['search']."%' or `sex` like '%".$_GET['search']."%' or `area` like '%".$_GET['search']."%' or `username` like '%".$_GET['search']."%')";}
if(@$_GET['order']==''){
	$order=" order by `subscribe_time` desc";
}else{
	$_GET['order']=safe_str($_GET['order']);
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_user and","_user where",$sum_sql);
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_user and","_user where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
require './program/weixin/receive.class.php';




foreach($r as $v){
	$v=de_safe_str($v);
	if($v['nickname']==''){$g=receive::weixin_get_user_info($pdo,self::$table_pre,$wid,$v['openid']);}
	$del='';
	$del=" <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a>";
	if($v['headimgurl']!=''){
		$icon='<img src="'.$v['headimgurl'].'">';	
	}else{
		$icon='<img src="./program/weixin/weixin_icon.png">';	
	}
	$location='';
	if($v['longitude']!=''){		
		$location='<a href=http://www.monxin.com/t_map.php?latitude='.$v['latitude'].'&longitude='.$v['longitude'].' target=_blank>'.self::$language['have'].'</a>';
	}
	$v['subscribe']=($v['subscribe'])?self::$language['yes']:self::$language['no'];
	$list.="<tr id='tr_".$v['id']."'>
	<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
	<td><span class=icon_span>".$icon."</span></td>
	<td><span class=nickname>&nbsp;".$v['nickname']."</span><br /><span class=openid>".$v['openid']."</span></td>
	<td>".$location."</td>
	<td><span class=sex>&nbsp;".$v['sex']."</span></td>
	<td><span class=area>&nbsp;".$v['area']."</span></td>
	<td><span class=subscribe>".$v['subscribe']."</span></td>
	<td><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['subscribe_time'])."</span></td>
	<td><input type='checkbox' name='data_state_".$v['id']."' id='data_state_".$v['id']."'  class='data_state' value=".$v['state']." /></td>
	<td>&nbsp;<a href='index.php?monxin=index.admin_edit_user&username=".$v['username']."' target=_blank class=username>".$v['username']."</a></td>
	<td><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</span></td>
  <td class=operation_td><a href='index.php?monxin=".$class.".dialog&wid=".$wid."&openid=".$v['openid']."' class='edit'>".self::$language['dialog']."</a>".$del." <span id=state_".$v['id']." class='state'></span></td>
</tr>
";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&wid='.$wid;
$module['class_name']=self::$config['class_name'];
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

echo ' <div id="user_position_reset" style="display:none;"><a href="index.php"><span id=user_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a><a href="index.php?monxin=index.user">'.self::$language['user_center'].'</a><a href="index.php?monxin=weixin.account_list">'.self::$language['pages']['weixin.account_list']['name'].'</a><a href="index.php?monxin=weixin.account_list&wid='.$wid.'">'.$w_name.'</a><span class=text>'.self::$language['pages']['weixin.user_list']['name'].'</span></div>';	

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);