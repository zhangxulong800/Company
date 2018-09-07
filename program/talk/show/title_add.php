<?php
$type=intval(@$_GET['type']);

if($type==0){header('location:./index.php?monxin=talk.add');}
$sql="select `title_power` from ".self::$table_pre."type where `id`='".$type."' and `visible`=1";
$r=$pdo->query($sql,2)->fetch(2);
$power=explode('|',$r['title_power']);
if(!in_array($_SESSION['monxin']['group_id'],$power)){echo self::$language['act_noPower'];return false;}


$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&type='.$type;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['class_name']=self::$config['class_name'];
$module['web_language']=self::$config['web']['language'];


$types_top='<a href="./index.php?monxin=talk.type">'.self::$language['pages']['talk.type']['name'].'</a>';	
$types='';
	
	$sql="select `parent`,`id`,`name` from ".self::$table_pre."type where `id`='".$type."'";
	$r=$pdo->query($sql,2)->fetch(2);
	$types='<a href="./index.php?monxin=talk.title&type='.$r['id'].'">'.$r['name'].'</a>';
	if($r['parent']!=0){
		$sql="select `parent`,`id`,`name` from ".self::$table_pre."type where `id`='".$r['parent']."'";
		$r=$pdo->query($sql,2)->fetch(2);
		$types='<a href="./index.php?monxin=talk.type&id='.$r['id'].'">'.$r['name'].'</a>'.$types;
	}
$types=$types_top.$types.self::$language['pages']['talk.title_add']['name'];

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
echo '<div id="visitor_position_reset" style="display:none;"><span id=current_position_text>'.self::$language['current_position'].'</span><a href="./index.php"><span id=visitor_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a>'.$types.'</div>';
