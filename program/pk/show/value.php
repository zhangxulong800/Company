<?php
$pk_id=intval($_GET['pk_id']);
if($pk_id==0){echo 'pk_id err';return false;}
$sql="select `id`,`name`,`username` from ".self::$table_pre."pk where `id`=".$pk_id;
$pk=$pdo->query($sql,2)->fetch(2);
if($pk['id']==''){echo 'pk_id err';return false;}
if($pk['username']!=$_SESSION['monxin']['username']){echo 'pk_id no power';return false;}
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&pk_id=".$pk_id;
$module['monxin_table_name']=$pk['name'].' '.self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$sql="select `id`,`name` from ".self::$table_pre."object where `pk_id`=".$pk_id." order by `sequence` desc,`id` asc";
$r=$pdo->query($sql,2);
$module['thead']='';
$item_deep=1;
$thead=array();
foreach($r as $v){
	$module['thead'].="<td>".de_safe_str($v['name'])."</td>";
	$thead[]=$v['id'];
}

$sql="select `name`,`parent`,`id` from ".self::$table_pre."item where `pk_id`=".$pk_id." and `state`=1 and `parent`=0 order by `sequence` desc,`id` asc";
$r=$pdo->query($sql,2);
$module['list']='';
foreach($r as $v){
	$sql="select `name`,`parent`,`id` from ".self::$table_pre."item where `pk_id`=".$pk_id." and `state`=1 and `parent`=".$v['id']." order by `sequence` desc,`id` asc";
	$t2=$pdo->query($sql,2);
	$t2_sum=1;
	$module['list_2']='';
	foreach($t2 as $v2){
		if($item_deep==1){$item_deep=2;}
		$sql="select `name`,`parent`,`id` from ".self::$table_pre."item where `pk_id`=".$pk_id." and `state`=1 and `parent`=".$v2['id']." order by `sequence` desc,`id` asc";
		$t3=$pdo->query($sql,2);
		$t3_sum=1;
		$module['list_3']='';
		foreach($t3 as $v3){
			$item_deep=3;
			$input3=self::get_pk_value_input($pdo,$thead,$v3['id']);
			
			$item='<td class=level_3>'.de_safe_str($v3['name']).'</td>';
			if($module['list_3']==''){
				//var_dump($v3['name']);
				$module['list_3'].='<tr>{first}'.$item.$input3.'</tr>';	
			}else{
				$t3_sum++;
				$t2_sum++;
				$module['list_3'].='<tr>'.$item.$input3.'</tr>';
			}
			
				
		}
	
		
		
		$input2=self::get_pk_value_input($pdo,$thead,$v2['id']);
		
		
		$item='<td rowspan="'.$t3_sum.'" class=level_2>'.de_safe_str($v2['name']).'</td>';
		//
		if($module['list_3']!=''){
			//var_dump($v2['name']);
			if($module['list_2']==''){
				
				$module['list_2'].=str_replace('{first}','{first}'.$item,$module['list_3']);
			}else{
				$t2_sum++;
				
				$module['list_2'].=str_replace('{first}',$item,$module['list_3']);;	
			}
			
		}else{
			if($module['list_2']==''){
				$module['list_2'].='<tr group='.$v2['id'].'>{first}'.$item.$input2.'</tr>';
			}else{
				$t2_sum++;
				$module['list_2'].='<tr group='.$v2['id'].'>'.$item.$input2.'</tr>';
			}
			
		}
		
			
	}
	
	
	$input=self::get_pk_value_input($pdo,$thead,$v['id']);
	if($module['list_2']!=''){}
	
	$item='<td rowspan="'.$t2_sum.'" class=level_1>'.de_safe_str($v['name']).'</td>';
	if($module['list_2']!=''){
		//var_dump($v['name']);
		$module['list'].=str_replace('{first}',$item,$module['list_2']);
	}else{
		$module['list'].='<tr group='.$v['id'].'>'.$item.$input.'</tr>';
	}
	
}
$module['item_deep']=$item_deep;
$module['thead']='<td colspan="'.$item_deep.'">'.de_safe_str($pk['name']).'</td>'.$module['thead'];


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);	
