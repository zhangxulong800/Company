<?php
		
		$sql="select `transaction_password` from ".$pdo->index_pre."user where `username`='".$_SESSION['monxin']['username']."'";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['transaction_password']==''){echo ("<script>window.location.href='index.php?monxin=index.edit_user&field=transaction_password'</script>");return false;}
		
		$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
		$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
		$sql="select `money` from ".$pdo->index_pre."user where `id`='".$_SESSION['monxin']['id']."'";
		$r=$pdo->query($sql,2)->fetch(2);
		$module['user_money']=$r['money'];
		
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
		
