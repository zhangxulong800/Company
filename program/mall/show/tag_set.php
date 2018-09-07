<?php
$tag=safe_str(@$_GET['id']);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&c_id=".$_GET['c_id'];
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$sql="select `tag` from  ".self::$table_pre."goods where `id`=".intval($_GET['c_id']);
$r=$pdo->query($sql,2)->fetch(2);
$tags=explode('|',$r['tag']);

$sql="select * from ".self::$table_pre."tag order by `sequence` desc";
$r=$pdo->query($sql,2);
$module['data']='';
foreach($r as $v){
	if(in_array($v,$tags)){$checked='checked';}else{$checked='';}
	$module['data'].='<span><input type=checkbox id=t_'.$v['id'].' '.$checked.'/>'.$v['name'].'</span>';	
}


		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
