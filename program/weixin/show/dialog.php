<?php
if(!$this->check_wid_power($pdo,self::$table_pre)){exit("{'state':'fail','info':'<span class=fail>".self::$language['act_noPower']."</span>'}");}
$wid=safe_str(@$_GET['wid']);
$sql="select `name` from ".self::$table_pre."account where `wid`='".$wid."'";
$r=$pdo->query($sql,2)->fetch(2);
$w_name=$r['name'];

$openid=safe_str(@$_GET['openid']);
if($openid==''){echo 'openid is null';return false;}

function get_weixin_user_info($pdo,$table_pre,$openid){
	if(isset($_SESSION['weixin_user_info'][$openid])){return $_SESSION['weixin_user_info'][$openid];}
	if($openid==$_GET['wid']){
		$sql="select `name` from ".$table_pre."account where `wid`='".$openid."'";
		$r=$pdo->query($sql,2)->fetch(2);
		$_SESSION['weixin_user_info'][$openid]='<img src="./program/weixin/weixin_icon.png"><span class=name>'.$r['name'].'</span>';
		return $_SESSION['weixin_user_info'][$openid];
	}
	$sql="select `headimgurl`,`nickname`,`username` from ".$table_pre."user where `openid`='".$openid."'";
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
		$name=$openid;	
	}
	//echo $name;
	$_SESSION['weixin_user_info'][$openid]='<span class=icon>'.$icon.'</span><span class=name>'.$name.'</span>';
	return $_SESSION['weixin_user_info'][$openid];
	
}

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);

$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."dialog where (`to`='".$wid."' or `from`='".$wid."') and (`to`='".$openid."' or `from`='".$openid."')";

$where="";
if(@$_GET['start_time']!=''){
	$start_time=get_unixtime($_GET['start_time'],self::$config['other']['date_style']);
	$where.=" and `time`>$start_time";	
}
if(@$_GET['end_time']!=''){
	$end_time=get_unixtime($_GET['end_time'],self::$config['other']['date_style'])+86400;
	$where.=" and `time`<$end_time";	
}

if($_GET['search']!=''){$where=" and `content` like '%".$_GET['search']."%'";}

$order=' order by `id` desc';
$sql.=$where;
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_dialog and","_dialog where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$order.$limit;
$sql=str_replace("_dialog and","_dialog where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	
	$v=de_safe_str($v);
	$time='<span class=time>'.get_time(self::$config['other']['date_style']." H:i",self::$config['other']['timeoffset'],self::$language,$v['time']).'</span>';
	
	if($v['from']==$wid){$sclass='right_div';}else{$sclass='left_div';}
	if($v['from']==$wid){
		$function='weixin_send_to_'.$v['input_type'];
	}else{
		$function='weixin_receive_to_'.$v['input_type'];	
		if($v['read']==0){$pdo->exec("update ".self::$table_pre."dialog set `read`=1 where `id`=".$v['id']);}
		if($v['type']=='image'){
			if(strpos($v['content'],'http')!==false){
				echo '<span  class=load_js_span src=./receive.php?target=weixin.index&act=save_image&id='.$v['id'].'></span>';
			}			
		}
	}
	$v['content']=self::$function($v['content']);
	$list.="
	<div class=".$sclass." id=div_".$v['id'].">
		<div class=web_c><div class=c>".str_replace("\r\n",'<br />',$v['content'])."</div></div>
		<div class=from_info>".get_weixin_user_info($pdo,self::$table_pre,$v['from']).$time."<a href='#' onclick='return del(".$v['id'].")'  class='del_dialog'>&nbsp;</a></div>
	</div>
	<div class=clear></div>
";	
}
if($sum==0){$list='<span class=no_related_content_span>'.self::$language['no_related_content'].'</span>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&wid=".$wid;
$module['module_save_name']=str_replace("::","_",$method.$args[1]);

$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

echo ' <div id="user_position_reset" style="display:none;"><a href="index.php"><span id=user_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a><a href="index.php?monxin=index.user">'.self::$language['user_center'].'</a><a href="index.php?monxin=weixin.account_list">'.self::$language['pages']['weixin.account_list']['name'].'</a><a href="index.php?monxin=weixin.account_list&wid='.$wid.'">'.$w_name.'</a><a href="index.php?monxin=weixin.dialog_list&wid='.$wid.'">'.self::$language['pages']['weixin.dialog_list']['name'].'</a><span class=text>'.strip_tags(get_weixin_user_info($pdo,self::$table_pre,$openid)).self::$language['pages']['weixin.dialog']['name'].'</span></div>';	

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);