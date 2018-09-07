<?php
$type=intval(@$_GET['type']);
if($type==0){echo 'type id err';return false;}
$sql="select `name` from ".self::$table_pre."type where `id`=".$type;
$r=$pdo->query($sql,2)->fetch(2);
$type_name=$r['name'];
if($type_name==''){echo 'type id err';return false;}

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&type='.$type;

function get_field_type($language){
	$option='<option value="">'.$language['please_select'].'</option>';
	foreach($language['field_type'] as $key=>$v){
		$option.='<option value="'.$key.'">'.$v.'</option>';	
	}
	return $option;	
}

$module['field_type']=get_field_type(self::$language);

echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=ci.type_attribute&type='.$_GET['type'].'">'.$type_name.'</a><span class=text>'.self::$language['pages']['ci.type_attribute_add']['name'].'</span></div>';


		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
