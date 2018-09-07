<?php


$sql="select * from ".self::$table_pre."free_shipping where `shop_id`=".SHOP_ID;
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']==''){
	$sql="insert into ".self::$table_pre."free_shipping (`shop_id`,`area_ids`,`time`) values ('".SHOP_ID."','','".time()."')";
	$pdo->exec($sql);
	$sql="select * from ".self::$table_pre."free_shipping where `shop_id`=".SHOP_ID;
	$r=$pdo->query($sql,2)->fetch(2);
}
$area_ids=explode(',',$r['area_ids']);

$sql="select * from ".$pdo->index_pre."area where `upid`=0 order by `sequence` desc,`id` asc";
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	  if(in_array($v['id'],$area_ids)){$checked="checked";}else{$checked='';}
	  $list.="<span><input type='checkbox' name='".$v['id']."' id='".$v['id']."' value='".$v['id']."' $checked /><m_label for='".$v['id']."'>".$v['name']."</m_label></span>\r\n";

}



$module['list']=$list;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);