<?php
$id=intval(@$_GET['id']);
if($id==0){return not_find();}

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&id=".$id;
$module['count_url']="receive.php?target=".$method."&id=".$id.'&act=count';

$sql="select * from ".self::$table_pre."content where `id`=".$id;
$module['data']=$pdo->query($sql,2)->fetch(2);
if($module['data']['id']==''){return  not_find();}
$module['data']=de_safe_str($module['data']);
$_GET['type']=$module['data']['type'];
if($module['data']['state']!=1){echo '<div style="text-align:center">'.self::$language['info_state'][$module['data']['state']].'</div>'; return  false;}
$module['data']['reflash']=get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$module['data']['reflash']);
$module['data']['circle']=get_circle_name($pdo,$module['data']['circle']);
if($_COOKIE['monxin_device']=='phone'){
	$module['data']['contact']='<a href="tel:'.str_replace('-','',str_replace(' ','',$module['data']['contact'])).'" target="_blank">'.$module['data']['contact'].'</a>';	
}

$sql="select * from ".self::$table_pre."type where `id`=".$module['data']['type'];
$r=$pdo->query($sql,2)->fetch(2);
if($r['price']!=''){
	if($module['data']['price']>0){
		$module['price']='<div class="line price"><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.self::$language['price'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.self::format_price($module['data']['price'],self::$language['yuan'],self::$language['million_yuan']).'<span class=price_unit>'.$r['unit'].'</span></span></div>';	
	}else{
		$module['price']='<div class="line price"><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.self::$language['price'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.self::$language['negotiable'].'</span></div>';
	}
	
}else{
	$module['price']='';
}

$module['content_label']=$r['content_label'];

//============================================================================================================================================get_attribute
$sql="select `content`,`a_id` from ".self::$table_pre."attribute_value where `c_id`=".$id;
//echo $sql;
$r2=$pdo->query($sql,2);
$attribute=array();
foreach($r2 as $v2){
	if($v2['content']!=''){$attribute[$v2['a_id']]=$v2['content'];}
}
$sql="select * from ".self::$table_pre."type_attribute where `type_id`=".$r['id']." order by `sequence` desc,`id` asc";
$r2=$pdo->query($sql,2);
$module['attribute']='';
foreach($r2 as $v2){
	if(isset($attribute[$v2['id']])){
		$module['attribute'].=$this->get_input_html3($pdo,self::$language,$v2,trim($attribute[$v2['id']],'/'));
	}
}
$module['contact_remark']=str_replace('{web_name}',self::$config['web']['name'],self::$language['contact_remark']);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
echo '<div id="visitor_position_reset" style="display:none;"><span id=current_position_text>'.self::$language['current_position'].'</span><a href="./index.php"><span id=visitor_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a>'.$this->get_type_position($pdo,$module['data']['type']).''.self::$language['detail'].'</div>';
