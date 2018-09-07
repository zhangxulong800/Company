<?php
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$sql="select * from ".self::$table_pre."foot_six_grid order by `id` asc limit 0,6";
$r=$pdo->query($sql,2);
$module['html']='';
foreach($r as $v){
	if($v['type']=='diy'){
		$content=de_safe_str($v['content']);	
	}else{
		$sql="select `name` from ".self::$table_pre."page_type where `id`=".$v['type'];
		$r2=$pdo->query($sql,2)->fetch(2);
		$content='<a href="./index.php?monxin=diypage.show_page_list&type='.$v['type'].'&order=" class=title target='.self::$config['foot_six_grid_target'].'>'.$r2['name'].'</a>';
		$sql="select `id`,`title`,`link` from ".self::$table_pre."page where `type`='".$v['type']."' and `visible`=1 order by `sequence` desc limit 0,".$v['max'];
		//echo $sql.'<br />';
		$r3=$pdo->query($sql,2);
		foreach($r3 as $v3){
			if($v3['link']==''){$link='./index.php?monxin=diypage.show&id='.$v3['id'];}else{$link=$v3['link'];}
			$content.='<a href="'.$link.'"  target='.self::$config['foot_six_grid_target'].' class=list>'.$v3['title'].'</a>';
		}	
	}
	$module['html'].='<div class=grid>'.$content.'</div>';	
}

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
