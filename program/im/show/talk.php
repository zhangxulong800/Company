<?php
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['class_name']=self::$config['class_name'];
$module['web_language']=self::$config['web']['language'];
$my_icon=$_SESSION['monxin']['icon'];
$module['my_icon']=$my_icon;
$module['load_time']=time();
if(isset($_GET['with']) && $_GET['with']!=''){
	self::add_addressee($pdo,$_SESSION['monxin']['username'],safe_str($_GET['with']));
}


$module['talk_log']='';
$module['addressee']=array();
$i=0;
$u_sql='';

$sql="select `addressee`,`id`,`last_time`,`last_msg` from ".self::$table_pre."addressee where `username`='".$_SESSION['monxin']['username']."' and `state`=1 and `last_msg`!='' group by `addressee` order by `last_time` desc";
$r=$pdo->query($sql,2);
foreach($r as $v){
	//if($v['last_msg']==''){continue;}
	$sql="select `icon`,`last`,`id` from ".$pdo->index_pre."user where `username`='".$v['addressee']."' limit 0,1";
	$u=$pdo->query($sql,2)->fetch(2);
	if(!isset($u['id'])){
		$sql="delete from ".self::$table_pre."msg_info where `sender`='".$v['addressee']."'";
		$pdo->exec($sql);
		continue;
	}
		
	$sql="select count(`id`) as c from ".self::$table_pre."msg_info where `sender`='".$v['addressee']."' and `addressee`='".$_SESSION['monxin']['username']."' and `addressee_state`=1 and `delete_a`!='".$_SESSION['monxin']['username']."' and `delete_b`!='".$_SESSION['monxin']['username']."'";
	$t=$pdo->query($sql,2)->fetch(2);
	$module['addressee'][$i]=array();
	$module['addressee'][$i]['id']=$v['id'];
	$module['addressee'][$i]['icon']=de_safe_str($u['icon']);
	$module['addressee'][$i]['name']=de_safe_str($v['addressee']);
	$module['addressee'][$i]['last_msg']=de_safe_str($v['last_msg']);
	$module['addressee'][$i]['last_time']=self::show_time('m-d',self::$config['other']['timeoffset'],self::$language,$v['last_time']);
	$module['addressee'][$i]['new']=$t['c'];
	if($u['last']>time()-300){$module['addressee'][$i]['online']=1;}else{$module['addressee'][$i]['online']=0;}
	$i++;
	
	if($u['icon']==''){$u['icon']='default.png';}
	if(!is_url($u['icon'])){$u['icon']="./program/index/user_icon/".$u['icon'];}
	$module['talk_log'].=self::get_talk_log_div($pdo,$v['id'],$v['addressee'],$u['icon'],$my_icon);
}

$sql="select `addressee`,`id`,`last_time`,`last_msg` from ".self::$table_pre."addressee where `username`='".$_SESSION['monxin']['username']."' and `state`=1 and (`last_msg`='' || `last_msg` is NULL) group by `addressee` order by `last_time` desc";
$r=$pdo->query($sql,2);
foreach($r as $v){
	//if($v['last_msg']==''){continue;}
	$sql="select `icon`,`last`,`id` from ".$pdo->index_pre."user where `username`='".$v['addressee']."' limit 0,1";
	$u=$pdo->query($sql,2)->fetch(2);
	if(!isset($u['id'])){
		$sql="delete from ".self::$table_pre."msg_info where `sender`='".$v['addressee']."'";
		$pdo->exec($sql);
		continue;
	}
		
	$sql="select count(`id`) as c from ".self::$table_pre."msg_info where `sender`='".$v['addressee']."' and `addressee`='".$_SESSION['monxin']['username']."' and `addressee_state`=1";
	$t=$pdo->query($sql,2)->fetch(2);
	$module['addressee'][$i]=array();
	$module['addressee'][$i]['id']=$v['id'];
	$module['addressee'][$i]['icon']=de_safe_str($u['icon']);
	$module['addressee'][$i]['name']=de_safe_str($v['addressee']);
	$module['addressee'][$i]['last_msg']=de_safe_str($v['last_msg']);
	$module['addressee'][$i]['last_time']=self::show_time('m-d',self::$config['other']['timeoffset'],self::$language,$v['last_time']);
	$module['addressee'][$i]['new']=$t['c'];
	if($u['last']>time()-300){$module['addressee'][$i]['online']=1;}else{$module['addressee'][$i]['online']=0;}
	$i++;
	
	if($u['icon']==''){$u['icon']='default.png';}
	if(!is_url($u['icon'])){$u['icon']="./program/index/user_icon/".$u['icon'];}
	$module['talk_log'].=self::get_talk_log_div($pdo,$v['id'],$v['addressee'],$u['icon'],$my_icon);
}




$module['addressee']=json_encode($module['addressee']);

$sql="select `addressee`,`id`,`last_time`,`last_msg` from ".self::$table_pre."addressee where `username`='".$_SESSION['monxin']['username']."' and `state`=2 order by `last_time` desc";
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$list.="<tr id='tr_".$v['id']."'>
	<td>".$v['addressee']."</td>
	<td class=operation_td><a href='#'  class='remove'>".self::$language['remove'].self::$language['blacklist']."</a> <span id=state_".$v['id']." class='state'></span></td>
</tr>
";	
}
if($list==''){$list='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}

$module['blacklist']=$list;
if($_COOKIE['monxin_device']=='phone'){
	require "./plugin/html5Upfile/createHtml5.class.php";
	$html5Upfile=new createHtml5();
	$html5Upfile->echo_input(self::$language,"html5_up",'100%','multiple','./program/im/img/','true','false','jpg|gif|png|jpeg|3gp|rm|rmvb|wmv| avi|mpg|mpeg|mp4|mp3|wma|wav|amr|mp4|mov',1024*20,'1');
	//echo_input(语言数组,"house_model",'控件宽度(百分比或像素)','multiple','保存到文件夹','文件夹是否附加日期','是否原名保存','允许文件类型','文件最大值','文件最小值');
}

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);


