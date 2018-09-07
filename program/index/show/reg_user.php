<?php
if(isset($_SESSION['monxin']['username']) && $_SESSION['monxin']['username']!=''){header('location:./index.php?monxin=index.user');exit;}
if(@$_GET['refresh']!=''){header('location:./index.php?monxin=index.user');exit;}
$group_id=intval(@$_GET['group_id']);
$sql="select `name`,`reg_able` from ".$pdo->index_pre."group where `id`='$group_id'";
$r=$pdo->query($sql,2)->fetch(2);
if($r['reg_able']==0 && $group_id>0){
	echo self::$language['no_registration'].": ".$r['name'];
}else{
	$module['group']="<option value='0'>".self::$language['please_select']."</option>".index::get_group_select($pdo,0,0);
	$backurl=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'./index.php?monxin=index.user';
	$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&oauth=".@$_GET['oauth']."&backurl=".$backurl;
	$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
	$module['user_agreement_url']=self::$config['reg_set']['user_agreement_url'];
	

	$module['ohter_input']='';
	if(self::$config['reg_set']['phone']){
		
		if($_COOKIE['monxin_device']=='pc'){
			$module['phone_country_select']='<select class=phone_country id=phone_country name=phone_country monxin_value='.self::$config['reg_set']['phone_country'].'>'.get_phone_country_opton(self::$language['phone_country']).'</select>';
			$module['ohter_input'].='<div class=line><span class="m_label">'.self::$language['phone'].'：</span><span class=input_span><div class=phone_input_div><span class=phone_country_switch></span><input class="input_text" type="text" name="phone" id="phone" placeholder="'.self::$language['phone'].'"   /></span><span id=phone_state></span></div></div>'.$module['phone_country_select'];
		}else{
			$module['phone_country_select']='<select class=phone_country id=phone_country name=phone_country monxin_value='.self::$config['reg_set']['phone_country'].'>'.get_phone_country_opton(self::$language['phone_country']).'</select>';
			$module['ohter_input'].='<div class=line><span class="m_label">'.self::$language['phone'].'：</span><span class=input_span><div class=phone_input_div>'.$module['phone_country_select'].'<input class="input_text" type="text" name="phone" id="phone" placeholder="'.self::$language['phone'].'"   /></span><span id=phone_state></span></div></div>';
		}
	}
	if(self::$config['reg_set']['email']){
		$module['ohter_input'].='<div class=line><span class="m_label">'.self::$language['email'].'：</span><span class=input_span><input class="input_text" type="text" name="email" id="email"  /></span><span id=email_state></span></div>';
	}
	$_SESSION['form_token']=get_verification_code(10);
	$module['ohter_input'].='<input type=hidden id=token name=token value="'.$_SESSION['form_token'].'" />';
	$module['reg_email']="/^([\w\.-]+)@([a-zA-Z0-9-]+)(\.[a-zA-Z\.]+)$/i";
	
	$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
	require($t_path);	

	echo '<div style="display:none;" id="visitor_position_append"><append>'.self::$language['reg_user'].'</append></div>';

}