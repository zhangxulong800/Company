<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$sql="select * from ".self::$table_pre."type where `parent`=0 and visible=1 order by `sequence` desc limit 0,10";
$r=$pdo->query($sql,2);
$module['parent_0']='';
$module['sub']='';
foreach($r as $v){
	$v=de_safe_str($v);
	if($v['url']==''){$v['url']='./index.php?monxin=ci.list&type='.$v['id'];}
	$module['parent_0'].='<a href="'.$v['url'].'" class=parent_0_a id="'.$v['id'].'"><span class=icon><img src="./program/ci/type_icon/'.$v['id'].'.png" /></span><span class=name>'.$v['name'].'</span></a>';	
	$sql="select * from ".self::$table_pre."type where `parent`='".$v['id']."' and visible=1 order by `sequence` desc";
	$r2=$pdo->query($sql,2);
	$sub2='';
	foreach($r2 as $v2){
		$v2=de_safe_str($v2);
		if($v2['url']==''){$v2['url']='./index.php?monxin=ci.list&type='.$v2['id'];}
		$sql="select * from ".self::$table_pre."type where `parent`='".$v2['id']."' and visible=1 order by `sequence` desc";
		$r3=$pdo->query($sql,2);
		$sub3='';
		foreach($r3 as $v3){
			$v3=de_safe_str($v3);
			if($v3['url']==''){$v3['url']='./index.php?monxin=ci.list&type='.$v3['id'];}
			$sub3.='<a href="'.$v3['url'].'" class=sub3_a>'.$v3['name'].'</a>';
		}
		if($sub3!=''){$sub3='<div class=sub_3>'.$sub3.'</div>';}
		$sub2.='<div class=line><a href="'.$v2['url'].'" class=sub2_a>'.$v2['name'].'</a>'.$sub3.'</div>';
	}	
	if($sub2!=''){$module['sub'].='<div class=sub_2 id=ci_type_'.$v['id'].'>'.$sub2.'</div>';}

}

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
