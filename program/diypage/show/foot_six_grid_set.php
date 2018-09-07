<?php
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$sql="select * from ".self::$table_pre."page_type order by `sequence` desc";
$r=$pdo->query($sql,2);
$module['type_option']='';
foreach($r as $v){
	$module['type_option'].='<option value="'.$v['id'].'">'.self::$language['type_001'].':'.$v['name'].'</option>';	
}

$sql="select * from ".self::$table_pre."foot_six_grid order by `id` asc";
$r=$pdo->query($sql,2);
$module['html']='';
foreach($r as $v){
	$module['html'].='<div class=grid id='.$v['id'].'>
            	<div class=index>'.$v['id'].'</div>
                <div class=type_div>'. self::$language['data_src'].': <select class=type monxin_value='.$v['type'].'>'.$module['type_option'].'<option value="diy">diy</option></select></div>
				<div class=max_div>'.self::$language['grid_max'].': <input type="text" class=max value="'.$v['max'].'" /></div>
                <textarea class=content>'.$v['content'].'</textarea>
            </div>';	
}
$module['foot_six_grid_target']=self::$config['foot_six_grid_target'];
$module['target_option']=get_select_value($pdo,'target','');
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
