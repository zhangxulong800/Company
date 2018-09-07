<?php
$id=intval(@$_GET['id']);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&c_id=".$_GET['c_id'];
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$sql="select `name`,`id` from ".self::$table_pre."type where `parent`=0 order by `sequence` desc,`id` asc";
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$list.="<option value='".$v['id']."'>".$v['name']."</option>";	
}
$module['class_1']=$list;
$module['class_2']='';
$module['class_3']='';
$module['class_1_value']='';
$module['class_2_value']='';
$module['class_3_value']='';
$brother='';
$father='';

if($id!=0){
	$sql="select `parent`,`name`,`id` from ".self::$table_pre."type where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['parent']!=0){
		$sql="select `parent`,`name`,`id` from ".self::$table_pre."type where `parent`=".$r['parent'];
		$r2=$pdo->query($sql,2);
		foreach($r2 as $v2){
			$brother.="<option value='".$v2['id']."'>".$v2['name']."</option>";	
		}

		$sql="select `parent`,`name`,`id` from ".self::$table_pre."type where `id`=".$r['parent'];
		$r3=$pdo->query($sql,2)->fetch(2);
		if($r3['parent']!=0){
			$sql="select `parent`,`name`,`id` from ".self::$table_pre."type where `parent`=".$r3['parent'];
			$r2=$pdo->query($sql,2);
			foreach($r2 as $v2){
				$father.="<option value='".$v2['id']."'>".$v2['name']."</option>";	
			}
			$module['class_2']=$father;
			$module['class_3']=$brother;
			$module['class_1_value']=$r3['parent'];
			$module['class_2_value']=$r3['id'];
			$module['class_3_value']=$id;
		}else{
			$module['class_2']=$brother;
			$module['class_2_value']=$r['id'];
			$module['class_1_value']=$r['parent'];
		}
	  }else{
		$module['class_1_value']=$id;
	}
	
		
}


		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
