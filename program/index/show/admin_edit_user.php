<?php
$id=intval(@$_GET['id']);
if($id<1){
	if(@$_GET['username']!=''){
		$sql="select `id` from ".$pdo->index_pre."user where `username`='".safe_str($_GET['username'])."'";
		$r=$pdo->query($sql,2)->fetch(2);
		$id=$r['id'];
		$_GET['id']=$id;
		if($r['id']==''){
			echo $_GET['username'].self::$language['not_exist'];
			return false;
		}
	}else{
		echo self::$language['lack_params'];
		return false;
	}
	
}
	
	$sql="select * from ".$pdo->index_pre."user where `id`='$id'";
	$module=$pdo->query($sql,2)->fetch(2);
	$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
	$module['weight']=trim($module['weight'],'0');
	//$module['birthday']=date(self::$config['other']['date_style'],$module['birthday']);

	$module['birthday']=get_date($module['birthday'],self::$config['other']['date_style'],self::$config['other']['timeoffset']);	
	$module['married']=get_select_id($pdo,'married',$module['married']);
	$module['education']=get_select_id($pdo,'education',$module['education']);
	$module['blood_type']=get_select_id($pdo,'blood_type',$module['blood_type']);
	$module['gender']=get_select_id($pdo,'gender',$module['gender']);
	$module['license_type']=get_select_id($pdo,'license_type',$module['license_type']);
	$module['annual_income']=get_select_id($pdo,'annual_income',$module['annual_income']);
	$module['chat_type']=get_select_id($pdo,'chat_type',$module['chat_type']);
	$temp=explode('.',self::$config['web']['domain']);
	if(count($temp)==2){$domain_postfix='.'.$temp[0].'.'.$temp[1];}else{$domain_postfix='.'.@$temp[count($temp)-2].'.'.$temp[count($temp)-1];}
	$module['domain_postfix']=$domain_postfix;
	$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
	$module['transaction_password_act']=($module['transaction_password']=='')?'add':'update';
	$module['manager']=self::get_manager($pdo,$module['id'],$module['group'],$module['manager'])." <a href='index.php?monxin=index.edit_user_group&id=".$module['id']."&group=".$module['group']."'>".self::$language['change']."</a>";
	
	$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
	
	require "./plugin/html4Upfile/createHtml4.class.php";
	$html4Upfile=new createHtml4();
	
	echo "<span id='icon_ele'>";
	$html4Upfile->echo_input("icon",'100%','./program/'.$class.'/user_icon/','true','false','jpg|gif|png|jpeg','500','5');
	echo '</span>';
	echo "<span id='license_photo_front_ele'>";
	$html4Upfile->echo_input("license_photo_front",'100%','./program/index/user_license_photo_front/','true','false','jpg|gif|png|jpeg','500','5');
	echo '</span>';
	echo "<span id='license_photo_reverse_ele'>";
	$html4Upfile->echo_input("license_photo_reverse",'100%','./program/index/user_license_photo_reverse/','true','false','jpg|gif|png|jpeg','500','5');
	echo '</span>';

