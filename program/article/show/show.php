<?php
$attribute=format_attribute($args[1]);
$field_array=get_field_array($attribute['field']);
$id=intval(@$_GET['id']);
if($id>0){
	$sql="select  ".$attribute['field'].",`type`,`title`,`id`,`tag`,`src`,`phone_content` from ".self::$table_pre."article where `id`='$id' and `visible`=1";
	$module=$pdo->query($sql,2)->fetch(2);
	if($module['id']==''){return  not_find();}
	$_GET['type']=$module['type'];
	$module['title']=(in_array('title',$field_array))?de_safe_str($module['title']):'';
	$module['content']=(in_array('content',$field_array))?de_safe_str($module['content']):'';
	if($module['phone_content']!='' && $_COOKIE['monxin_device']=='phone'){$module['content']=de_safe_str($module['phone_content']);}
	
	if($module['src']!=''){
		$module['img']=(in_array('src',$field_array))?'<img src="./program/article/img/'.$module['src'].'">':'';	
	}else{
		$module['img']='';	
	}
	if($module['tag']!=''){
		$temp=explode('|',$module['tag']);
		$temp=array_filter($temp);
		$module['tag']='';
		foreach($temp as $v){
			$module['tag'].='<span>'.$v.'</span>';	
		}	
	}
	$module['tag']=(in_array('tag',$field_array))?$module['tag']:'';
	if(in_array('visit',$field_array)){$module['tag'].='<span>'.self::$language['visit_count'].'：'.$module['visit'].'</span>';}
	if(in_array('time',$field_array)){$module['tag'].='<span>'.self::$language['time'].'：'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$module['time']).'</span>';}
	
	
	$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
	$module['count_url']="receive.php?target=".$method."&id=".$id;
	$module['module_save_name']=str_replace("::","_",$method.$args[1]);

	$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
	if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
	require($t_path);
	echo '<div id="visitor_position_reset" style="display:none;"><span id=current_position_text>'.self::$language['current_position'].'</span><a href="./index.php"><span id=visitor_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a>'.$this->get_type_position($pdo,$module['type']).self::$language['content'].'</div>';
}else{
	echo (self::$language['need_params']);
}
