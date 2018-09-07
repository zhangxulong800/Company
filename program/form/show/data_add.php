<?php
$table_id=intval(@$_GET['table_id']);
if($table_id==0){exit('table_id err');}

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&table_id=".$table_id;


$sql="select `name`,`description`,`add_power`,`write_state`,`authcode`,`css_width`,`css_pc_bg`,`css_pc_top`,`css_phone_bg`,`css_phone_top`,`css_diy` from ".self::$table_pre."table where `id`=$table_id";
$r=$pdo->query($sql,2)->fetch(2);
$module['data']=de_safe_str($r);
$module['data']['css_pc_top_int']=intval($module['data']['css_pc_top']);
$module['data']['bg_css']='';
if($_COOKIE['monxin_device']=='pc'){
	if($module['data']['css_pc_bg']!=''){
		$module['data']['bg_css']="
		[user_color='container']{ background:url(./program/form/img/".$module['data']['css_pc_bg']."); background-size: contain;}
		#".$module['module_name']."{height:500px; overflow: hidden;  opacity:0.8;  border-radius:5px; margin:auto; margin-top:". $module['data']['css_pc_top'].";width:".$module['data']['css_width']."; }
		
		 #".$module['module_name']."_html{ height:108%;width:110%; overflow:scroll;}";
	}else{
		$module['data']['bg_css']="
		#".$module['module_name']."{margin-top:70px; }";
	}
}else{
	if($module['data']['css_phone_bg']!=''){
		$module['data']['bg_css']="
		[user_color='container']{ background:url(./program/form/img/".$module['data']['css_phone_bg']."); background-size: contain;}
		#".$module['module_name']."{height:500px; overflow: hidden;  opacity:0.8;  border-radius:5px; margin:auto; margin-top:". $module['data']['css_phone_top'].";width:90%; }
		.page-footer,#index_phone_bottom,.fixed_right_div{ display:none;}
		 #".$module['module_name']."_html{ padding:5px; height:100%;width:110%; overflow:scroll;}";
	}else{
		$module['data']['bg_css']="
		
		#".$module['module_name']."{margin-top:10px; }";
	}
}



$table_name=$r['name'];
$table_description=$r['description'];
$table_add_power=explode('|',$r['add_power']);
$authcode=$r['authcode'];
if($r['write_state']==0){echo $r['description'].self::$language['write_able_is_off']; return false;}
if(!in_array('0',$table_add_power)){
	if(!isset($_SESSION['monxin']['group_id'])){$_SESSION['monxin']['group_id']='0';}
	if(!in_array($_SESSION['monxin']['group_id'],$table_add_power)){echo self::$language['without'].self::$language['add'].self::$language['power']; return false;}	
}
$sql="select * from ".self::$table_pre."field where `table_id`=$table_id  and `write_able`=1 order by `sequence` desc,`id` asc";
$r=$pdo->query($sql,2);
$module['fields']='';
foreach($r as $v){
	//echo $v['description'].'<br />';
	$module['fields'].=$this->get_input_html(self::$language,$v);
}
if($authcode){
	$v['name']='authcode';
	$v['input_type']='authcode';
	$v['required']=1;
	$v['input_args']='';
	$module['fields'].=$this->get_input_html(self::$language,$v);	
}
echo '<div style="display:none;" id="visitor_position_append">'.$table_description.'</div>';
$module['map_api']=self::$config['web']['map_api'];
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);