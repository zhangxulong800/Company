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

$sql="select * from (select * from ".self::$table_pre."dialog where `to`='".$wid."' order by `id` desc ) tmptab";
$where="";
if(@$_GET['start_time']!=''){
	$start_time=get_unixtime($_GET['start_time'],self::$config['other']['date_style']);
	$where.=" and `time`>$start_time";	
}
if(@$_GET['end_time']!=''){
	$end_time=get_unixtime($_GET['end_time'],self::$config['other']['date_style'])+86400;
	$where.=" and `time`<$end_time";	
}

if($_GET['search']!=''){$where=" and (`to` like '%".$_GET['search']."%' || `from` like '%".$_GET['search']."%' || `content` like '%".$_GET['search']."%')";}
$group=' group by `from`';
$order=' order by `id` desc';

$sql.=$where;
$sql=str_replace("tmptab and","tmptab where",$sql);
$sql.=$group;

$sum_sql="select count(id) as c from (".$sql.") temptab2";
//echo($sum_sql);

$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
	
$sql.=$order.$limit;
//echo $sum;
//echo($sum_sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$v=de_safe_str($v);
	$sql="select `headimgurl`,`nickname`,`username` from ".self::$table_pre."user where `openid`='".$v['from']."'";
	$v2=$pdo->query($sql,2)->fetch(2);
	if($v2['headimgurl']!=''){
		$icon='<img src="'.$v2['headimgurl'].'">';	
	}else{
		$icon='<img src="./program/weixin/weixin_icon.png">';	
	}
	if($v2['username']!=''){
		$name=$v2['username'];
	}elseif($v2['nickname']!=''){
		$name=$v2['nickname'];	
	}else{
		$name=$v['from'];	
	}
	$function='weixin_receive_to_'.$v['input_type'];
	$v['content']=self::$function($v['content']);
	
	$sql="select count(id) as c from ".self::$table_pre."dialog where `from`='".$v['from']."' and `to`='".$wid."' and `read`=0";
	$r3=$pdo->query($sql,2)->fetch(2);
	if($r3['c']==0){$new='';}else{$new='<span class=new>'.$r3['c'].'</span>';}
	
	$list.="<tr id='tr_".$v['id']."'>
	<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
	<td class=user_info_td>
	<div class=icon_name><span class=icon>".$icon.'</span><span class=name>'.$name."</span></div>
	<div class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</div>
	</td>
	<td class=content_td>
<table class=content_table cellpadding='0' cellspacing='0'><tr><td class=td_1>&nbsp;</td><td class=td_2>&nbsp;</td><td class=td_3>&nbsp;</td></tr><tr><td class=td_4>&nbsp;</td><td class=td_5>".str_replace("\r\n",'<br />',$v['content'])."</td><td class=td_6>&nbsp;</td></tr><tr><td class=td_7>&nbsp;</td><td class=td_8>&nbsp;</td><td class=td_9>&nbsp;</td></tr></table>	
	</td>
	<td class=act_td>
	<a href='index.php?monxin=".$class.".dialog&wid=".$wid."&openid=".$v['from']."' class='edit'>".self::$language['dialog']."</span>".$new."<span class=b_end>&nbsp;</span></a>
	<a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['clear']."</a>
	</td>
</tr>
";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&wid='.$wid;
$module['class_name']=self::$config['class_name'];
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

echo ' <div id="user_position_reset" style="display:none;"><a href="index.php"><span id=user_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a><a href="index.php?monxin=index.user">'.self::$language['user_center'].'</a><a href="index.php?monxin=weixin.account_list">'.self::$language['pages']['weixin.account_list']['name'].'</a><a href="index.php?monxin=weixin.account_list&wid='.$wid.'">'.$w_name.'</a><span class=text>'.self::$language['pages']['weixin.dialog_list']['name'].'</span></div>';	

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);