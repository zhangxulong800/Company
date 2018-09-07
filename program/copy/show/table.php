<?php
$id=intval(@$_GET['id']);
if($id==0){return not_find();}
$sql="select `save_to`,`id`,`name` from ".self::$table_pre."regular where `id`=".$id;
$r=$pdo->query($sql,2)->fetch(2);
if($r['id']==''){return not_find();}
echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=copy.regular&id='.$id.'">'.$r['name'].'</a><span class=text>'.self::$language['pages']['copy.table']['name'].'</span></div>';

$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&id='.$id;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['class_name']=self::$config['class_name'];
$table=explode(',',$r['save_to']);
$list='';

function get_table_multiple_option($v){
	return '<option value="0">'.$v[0].'</option><option value="1">'.$v[1].'</option>';	
}


foreach($table as $v){
	$sql="select * from ".self::$table_pre."table where `regular_id`='".$id."' and  `name`='".$v."'";
	//echo $sql;
	$v2=$pdo->query($sql,2)->fetch(2);
	if(is_array($v2)){$v2=de_safe_str($v2);}
	$list.="<tr id='tr_".$v."'>
	<td><span class=table>".$v."</span></td>
	<td><select id=multiple name=multiple monxin_value='".$v2['multiple']."'>".get_table_multiple_option(self::$language['table_multiple_option'])."</select></td>
	<td><textarea id='reg' name='reg'>".$v2['reg']."</textarea></td>
	<td class=operation_td>
  <a href='#' onclick='return update(\"tr_".$v."\")'  class='submit'>".self::$language['submit']."</a> <span id=state_tr_".$v." class='state'></span></td>
</tr>
";	
}

if($list==''){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$module['list']=$list;


		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
