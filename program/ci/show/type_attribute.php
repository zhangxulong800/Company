<?php

$type=intval(@$_GET['type']);
if($type==0){echo 'type id err';return false;}
$sql="select `name` from ".self::$table_pre."type where `id`=".$type;
$r=$pdo->query($sql,2)->fetch(2);
$type_name=$r['name'];
if($type_name==''){echo 'type id err';return false;}

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&type=".$type;


$sql="select * from ".self::$table_pre."type_attribute where `type_id`='".$type."' order by `sequence` desc,`id` asc";
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$list.="<tr id='tr_".$v['id']."'>
	<td><span class=name>".$v['name']." ".$v['postfix']."</span></td>
	<td><span class=type>".@self::$language['field_type'][$v['input_type']]." ".$v['type']." </span></td>
	<td><input class=screening_show type=checkbox id=screening_show_".$v['id']." monxin_value=".$v['screening_show']." /></td>
	<td><input class=sequence type=text id=sequence_".$v['id']." value=".$v['sequence']." /></td>
  	<td class=operation_td><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".self::$language['submit']."</a><a href='./index.php?monxin=ci.type_attribute_edit&id=".$v['id']."' class='edit'>".self::$language['edit']."</a><a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a><span id=state_".$v['id']." class='state'></span></td>
</tr>
";	
}
if($list==''){$list='<tr><td colspan="30" style="text-align:center;">'.self::$language['no_data'].'</td></tr>';}		
$module['list']=$list;
$module['class_name']=self::$config['class_name'];

echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=ci.type">'.$type_name.'</a><span class=text>'.self::$language['pages']['ci.type_attribute']['name'].'</span></div>';
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
