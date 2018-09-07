<?php
$id=intval($_GET['id']);
if($id==0){exit('id err');}

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&id='.$id;

function get_field_type($language){
	$option='<option value="">'.$language['please_select'].'</option>';
	foreach($language['field_type'] as $key=>$v){
		$option.='<option value="'.$key.'">'.$v.'</option>';	
	}
	return $option;	
}

$module['field_type']=get_field_type(self::$language);

$sql="select * from ".self::$table_pre."type_attribute where `id`=$id";
$module['data']=$pdo->query($sql,2)->fetch(2);
$module['data']['input_args']=str_replace("\r",'',$module['data']['input_args']);
$module['data']['input_args']=str_replace("\n",'',$module['data']['input_args']);
$module['args']=format_attribute($module['data']['input_args']);

$sql="select `name`,`id` from ".self::$table_pre."type where `id`=".$module['data']['type_id'];
$r=$pdo->query($sql,2)->fetch(2);
$type_name=$r['name'];
$_GET['type']=$r['id'];


echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=ci.type_attribute&type='.$_GET['type'].'">'.$type_name.'</a><span class=text>'.self::$language['pages']['ci.type_attribute_edit']['name'].'</span></div>';




		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
