<?php
$id=intval(@$_GET['id']);
if($id==0){echo exit('group id err');return false;}
$sql="select `require_info` from ".$pdo->index_pre."group where `id`='$id'";
$stmt=$pdo->query($sql,2);
$v=$stmt->fetch(2);
$require_info=explode(",",$v['require_info']);
$require_info=array_filter($require_info);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&id=".$id;

$sql="select * from ".$pdo->index_pre."user limit 0,1";
$stmt=$pdo->query($sql,2);
$v=$stmt->fetch(2);
$list='';
foreach($v as $key=>$v){
	if(@self::$language[$key] && $key!='identifying'){
		if(in_array($key,$require_info)){$checked="checked";}else{$checked='';}
		if(is_array(self::$language[$key]) || $key=='introducer'){continue;}
		$list.="<span><input type='checkbox' name='$key' id='$key' value='$key' $checked /><m_label for='$key'>".self::$language[$key]."</m_label></span>\r\n";
	}
}
$module['list']=$list;
$module['groups']=index::get_groups($pdo,0,"index.php?monxin=index.group_require_info&id=");
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);