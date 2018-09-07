<?php
$table_id=intval(@$_GET['table_id']);
if($table_id==0){exit('table_id err');}
$id=intval(@$_GET['id']);
if($id==0){exit('id err');}

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&table_id=".$table_id."&id=".$id;


$sql="select `name`,`description`,`edit_power` from ".self::$table_pre."table where `id`=$table_id";
$r=$pdo->query($sql,2)->fetch(2);
$table_name=$r['name'];
$table_description=$r['description'];
$table_edit_power=explode('|',$r['edit_power']);
if(!in_array('0',$table_edit_power)){
	if(!in_array($_SESSION['monxin']['group_id'],$table_edit_power)){echo self::$language['without'].self::$language['edit'].self::$language['power']; return false;}	
}
echo ' <div id="user_position_reset" style="display:none;"><a href="index.php"><span id=user_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a><a href="index.php?monxin=index.user">'.self::$language['user_center'].'</a><a href="index.php?monxin=form.table_admin">'.self::$language['program_name'].'</a><a href="index.php?monxin=form.table_admin&id='.$table_id.'">'.$r['description'].'</a><a href="index.php?monxin=form.data_admin&table_id='.$table_id.'">'.self::$language['data'].self::$language['admin'].'</a><span class=text>'.self::$language['data'].self::$language['edit'].'</span></div>';	


$sql="select * from ".self::$table_pre.$table_name." where `id`=".$id;
$module['data']=$pdo->query($sql,2)->fetch(2);
if($module['data']['id']==''){return  not_find();}

$sql="select * from ".self::$table_pre."field where `table_id`=$table_id order by `sequence` desc,`id` asc";
$r=$pdo->query($sql,2);
$module['fields']='';
foreach($r as $v){
	//echo $v['description'].'<br />';
	$module['fields'].=$this->get_input_html2(self::$language,$v,$module['data'][$v['name']]);
}

echo '<div style="display:none;" id="visitor_position_append">'.$table_description.'</div>';
$module['map_api']=self::$config['web']['map_api'];

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);