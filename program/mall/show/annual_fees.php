<?php
$sql="select * from ".self::$table_pre."shop where `username`='".$_SESSION['monxin']['username']."' and `state`=2 order by `id` desc limit 0,1";
$module=$pdo->query($sql,2)->fetch(2);
if($module['id']==''){echo 'no shop';return false;}
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$module['year_option']='';
for($i=1;$i<11;$i++){
	$module['year_option'].='<option value='.$i.'>'.$i.self::$language['year'].'</option>';	
}

if($module['annual_fees']<time()){
	if(self::$config['annual_shop_order_fees']==0){
		$v=self::$language['no_annual_1'];
	}else{
		$v=self::$language['no_annual_2'];	
	}
	$v=str_replace('{times_shop_order_fees}',self::$config['times_shop_order_fees'],$v);
	$v=str_replace('{annual_shop_order_fees}',self::$config['annual_shop_order_fees'],$v);
	
	$module['info']='<div class=no_annual>'.$v.' <a href=# class=open_annual  user_color=button>'.self::$language['open_now'].'</a></div>';	
}else{
	$module['info']='<div class=is_annual>'.self::$language['annual_expiration_time'].'：<span class=date>'.date('Y-m-d',$module['annual_fees']).'</span> <a href=# class=open_annual  user_color=button>'.self::$language['renew_now'].'</a></div>';		
}

$module['shop_year_fees']=self::$config['shop_year_fees'];

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
