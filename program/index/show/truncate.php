<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$sql="SELECT `TABLE_NAME`,`TABLE_COMMENT`,`TABLE_ROWS` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".$pdo->dbname."'";
$sql="SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".$pdo->dbname."'";
$r=$pdo->query($sql,2);
$module['list']='';
$forbid=array($pdo->sys_pre.'index_user',$pdo->sys_pre.'index_color',$pdo->sys_pre.'index_page',$pdo->sys_pre.'index_select',);
foreach($r as $v){
	$t=explode($pdo->sys_pre,$v['TABLE_NAME']);
	if(in_array($v['TABLE_NAME'],$forbid)){continue;}
	//var_dump($v);
	if(isset($t[1])){
		$module['list'].='<div class=t><span class=l><input type=checkbox t='.$v['TABLE_NAME'].' /></span><span class=r><span class=e>'.$v['TABLE_NAME'].'</span><span class=c><span class=n>'.$v['TABLE_COMMENT'].'</span><span class=rows>('.$v['TABLE_ROWS'].')</span></span></span></div>';
	}
	
}

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
