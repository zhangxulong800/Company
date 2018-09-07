<?php

$sql="select `express` from ".self::$table_pre."shop where `id`=".SHOP_ID;
$r=$pdo->query($sql,2)->fetch(2);
$express_ids=trim($r['express'],',');

$list='';
if($express_ids!=''){
	$sql="select `id`,`name` from ".self::$table_pre."express where `id` in (".$express_ids.") order by `sequence` desc,`id` asc";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		  $list.="<span><input type='checkbox' name='".$v['id']."' id='".$v['id']."' value='".$v['id']."' checked /><m_label for='".$v['id']."'>".$v['name']."</m_label><a href=".$v['id'].">".self::$language['price']."</a></span>\r\n";
	
	}
	$sql="select `id`,`name` from ".self::$table_pre."express where `id` not in (".$express_ids.") order by `sequence` desc,`id` asc";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		  $list.="<span><input type='checkbox' name='".$v['id']."' id='".$v['id']."' value='".$v['id']."'/><m_label for='".$v['id']."'>".$v['name']."</m_label><a href=".$v['id'].">".self::$language['price']."</a></span>\r\n";
	
	}
}else{
	$sql="select `id`,`name` from ".self::$table_pre."express order by `sequence` desc,`id` asc";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		  $list.="<span><input type='checkbox' name='".$v['id']."' id='".$v['id']."' value='".$v['id']."' /><m_label for='".$v['id']."'>".$v['name']."</m_label><a href=".$v['id'].">".self::$language['price']."</a></span>\r\n";
	
	}
}



$module['list']=$list;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);