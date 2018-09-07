<?php
$id=intval(@$_GET['id']);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$sql="select `name`,`id` from ".self::$table_pre."type where `parent`=0 and `visible`=1 order by `sequence` desc,`id` asc";
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
		$sql="select `parent`,`name`,`id` from ".self::$table_pre."type where `parent`=".$r['parent']."  and `visible`=1";
		$r2=$pdo->query($sql,2);
		foreach($r2 as $v2){
			$brother.="<option value='".$v2['id']."'>".$v2['name']."</option>";	
		}

		$sql="select `parent`,`name`,`id` from ".self::$table_pre."type where `id`=".$r['parent']."  and `visible`=1";
		$r3=$pdo->query($sql,2)->fetch(2);
		if($r3['parent']!=0){
			$sql="select `parent`,`name`,`id` from ".self::$table_pre."type where `parent`=".$r3['parent']."  and `visible`=1";
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



$sql="select `type` from ".self::$table_pre."goods where `shop_id`='".SHOP_ID."'  group by `type`  order by `id`desc limit 0,10";
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$list.='<option value="'.$v['type'].'">'.self::get_type_parent_text($pdo,$v['type']).'</option>';	
}
$module['lately']='';
if($list!=''){$module['lately']='<div id=lately_div><select id=lately name=lately><option value="-1">'.self::$language['shortcat'].'</option>'.$list.'</select></div>';}
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
