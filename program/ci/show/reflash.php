<?php
$id=intval(@$_GET['id']);
if($id==0){echo 'id err';return false;}
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&id=".$id;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$sql="select `username` from ".self::$table_pre."content where `id`=".$id;
$r=$pdo->query($sql,2)->fetch(2);
if($r['username']=='' || $r['username']!=$_SESSION['monxin']['username']){echo 'id err';return false;}

$sql="select `day_reflash` from  ".self::$table_pre."user where `username`='".$_SESSION['monxin']['username']."'";
$r=$pdo->query($sql,2)->fetch(2);
if($r['day_reflash']==''){
	$sql="insert into ".self::$table_pre."user (`username`) values ('".$_SESSION['monxin']['username']."')";
	$pdo->exec($sql);	
	$r['day_reflash']=0;
}
if($r['day_reflash']<self::$config['day_reflash_max']){
	$module['info']=str_replace('{v}','<b>'.self::$config['day_reflash_max'].'</b>',self::$language['free_reflash_template']);
	$module['balance']='';
}else{
	$module['info']=str_replace('{v}','<b>'.self::$config['reflash_price'].'</b>',self::$language['deduction_money_reflash_template']);
	$sql="select `money` from ".$pdo->index_pre."user where `username`='".$_SESSION['monxin']['username']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	$module['balance']=self::$language['available_balance']." : <b class=balance>".$r['money']."</b> ".self::$language['yuan']." <a href=./index.php?monxin=index.recharge target=_blank>".self::$language['recharge']."</a>";
}


		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
