<?php
if(@$_SESSION['monxin']['group_id']==1){
	echo '<div class=return_false>'.self::$language['relogin_apply_shop'].'</div>';return false;
}
if(!isset($_SESSION['monxin']['username'])){header('location:./index.php?monxin=index.login&backurl=./index.php?monxin=mall.apply_shop');exit;}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
echo '<div style="display:none;" id="visitor_position_append">'.self::$language['pages']['mall.apply_shop']['name'].'</div>';

$sql="select `state` from ".self::$table_pre."shop where `username`='".$_SESSION['monxin']['username']."' order by `id` desc limit 0,1";
$r=$pdo->query($sql,2)->fetch(2);
if($r['state']!=''){
	switch($r['state']){
		case 0:
			echo '<div style="line-height:100px; text-align:center;">'.self::$language['shop_state_add_info'][$r['state']].'</div>'; return  false;
			break;	
		case 1:
			
			break;	
		case 2:
			header('location:./index.php?monxin=mall.seller');exit;
			echo '<div style="line-height:100px; text-align:center;">'.self::$language['shop_state_add_info'][$r['state']].'</div>'; return  false;
			break;	
		case 3:
			header('location:./index.php?monxin=mall.seller');exit;
			echo '<div style="line-height:100px; text-align:center;">'.self::$language['shop_state_add_info'][$r['state']].'</div>'; return  false;
			break;	
		case 4:
			header('location:./index.php?monxin=mall.seller');exit;
				echo '<div style="line-height:100px; text-align:center;">'.self::$language['shop_state_add_info'][$r['state']].'</div>'; return  false;
			break;	
		case 5:
			header('location:./index.php?monxin=mall.seller');exit;
			echo '<div style="line-height:100px; text-align:center;">'.self::$language['shop_state_add_info'][$r['state']].'</div>'; return  false;
			break;	
	}	
}

$module['talk_option']=self::get_talk_option($pdo,self::$table_pre);
$module['phone_reg']=self::$config['other']['reg_phone'];

$module['agent']='';
if(@$_SESSION['share']!=''){
	$sql="select `id` from ".$pdo->index_pre."user where `username`='".$_SESSION['share']."' and `group`=".self::$config['agent_group_id'];
	$r=$pdo->query($sql,2)->fetch(2);
	$module['agent']=$r['id'];
}
if(@$_GET['agent']!=''){$module['agent']=$_GET['agent'];}

$module['circle']=get_circle_option($pdo);
$module['map_api']=self::$config['web']['map_api'];


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);

require "./plugin/html4Upfile/createHtml4.class.php";
$html4Upfile=new createHtml4();
$html4Upfile->echo_input("icon",'100%','./temp/','true','false','jpg|gif|png|jpeg','2048','1');
$html4Upfile->echo_input("certificate",'100%','./temp/','true','false','jpg|gif|png|jpeg','2048','1');
$html4Upfile->echo_input("self_certificate",'100%','./temp/','true','false','jpg|gif|png|jpeg','2048','1');
$html4Upfile->echo_input("ticket_logo",'100%','./temp/','true','false','jpg|gif|png|jpeg','2048','1');

//echo_input("控件名称",'控件宽度(百分比或像素)','保存目录','文件夹是否附加日期','是否原名保存','允许文件后缀','文件大小 上限','文件大小 下限','指定保存名');
//指定保存名时，要先设置权限 $_SESSION['replace_file']=true;  ，否则将无效
