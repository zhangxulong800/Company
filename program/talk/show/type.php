<?php
//echo $args[1];
$sql="select `id` from ".self::$table_pre."type where visible=1";
$r=$pdo->query($sql,2);
foreach($r as $v){
	self::update_type_sum($pdo,$v['id']);	
}

$attribute=format_attribute($args[1]);
$id=$attribute['id'];
if(@$_GET['monxin']=='talk.type'){
	$types_top='<a href="./index.php?monxin=talk.type">'.self::$language['program_name'].'</a>';	
	$types='';
	if(intval(@$_GET['id'])!=0){
		$id=intval(@$_GET['id']);
		$sql="select `parent`,`id`,`name` from ".self::$table_pre."type where `id`='".$id."'";
		$r=$pdo->query($sql,2)->fetch(2);
		$types='<a href="./index.php?monxin=talk.type&id='.$r['id'].'">'.$r['name'].'</a>';
		if($r['parent']!=0){
			$sql="select `parent`,`id`,`name` from ".self::$table_pre."type where `id`='".$r['parent']."'";
			$r=$pdo->query($sql,2)->fetch(2);
			$types='<a href="./index.php?monxin=talk.type&id='.$r['id'].'">'.$r['name'].'</a>'.$types;
		}
	}
	$types=$types_top.$types;
}


$list=$this->get_type_names($pdo,$id,$attribute['target'],$attribute['sum']);
if($list==''){$list='<a href="#">'.self::$language['no_content'].'</a>';}
$module['list']=$list;


$module['module_width']=$attribute['width'];
$module['module_height']=$attribute['height'];
$module['module_name']=str_replace("::","_",$method.'_'.$id);
$module['module_save_name']=str_replace("::","_",$method.$args[1]);
$module['count_url']="receive.php?target=".$method."&id=".$id;

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
if(@$_GET['monxin']=='talk.type'){echo '<div id="visitor_position_reset" style="display:none;"><span id=current_position_text>'.self::$language['current_position'].'</span><a href="./index.php"><span id=visitor_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a>'.$types.'</div>';
}
