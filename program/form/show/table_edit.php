<?php
$table_id=intval($_GET['id']);
if($table_id==0){exit('id err');}
function get_field_state_option($language,$v){
	return '<option value="1">'.$language['program_state']['opening'].'</opiton><option value="0">'.$language['program_state']['closed'].'</opiton>';	
}

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$sql="select * from ".self::$table_pre."table where `id`=$table_id";
$r=$pdo->query($sql,2)->fetch(2);
$module['table_name']=$r['name'];
$module['table_description']=$r['description'];

echo ' <div id="user_position_reset" style="display:none;"><a href="index.php"><span id=user_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a><a href="index.php?monxin=index.user">'.self::$language['user_center'].'</a><a href="index.php?monxin=form.table_admin">'.self::$language['program_name'].'</a><a href="index.php?monxin=form.table_admin&id='.$table_id.'">'.$r['description'].'</a><span class=text>'.self::$language['field'].self::$language['admin'].'</span></div>';	


$sql="select * from ".self::$table_pre."field where `table_id`=$table_id order by `sequence` desc,`id` asc";
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	if(!in_array($v['name'],self::$config['sys_field'])){
		$edit=" <a href='index.php?monxin=".$class.".field_edit&id=".$v['id']."' class='edit'>".self::$language['edit']."</a> <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a>";
		$write_checkbox="<input class=write_able type=checkbox id=write_able_".$v['id']." value=".$v['write_able']." />";
	}else{$edit="";$write_checkbox='&nbsp;';}
	
	$list.="<tr id='tr_".$v['id']."'>
	<td><span class=description>".$v['description']."</span></td>
	<td><span class=name>".$v['name']."</span></td>
	<td><span class=type>".@self::$language['field_type'][$v['input_type']]." ".$v['type']." </span></td>
	<td>".$write_checkbox."</td>
	<td><input class=read_able type=checkbox id=read_able_".$v['id']." value=".$v['read_able']." /></td>
	<td><input class=fore_list_show type=checkbox id=fore_list_show_".$v['id']." value=".$v['fore_list_show']." /></td>
	<td><input class=back_list_show type=checkbox id=back_list_show_".$v['id']." value=".$v['back_list_show']." /></td>
	<td><input class=sequence type=text id=sequence_".$v['id']." value=".$v['sequence']." /></td>
  	<td class=operation_td><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".self::$language['submit']."</a>".$edit." <span id=state_".$v['id']." class='state'></span></td>
</tr>
";	
}
if($list==''){$list='<tr><td colspan="30" style="text-align:center;">'.self::$language['no_data'].'</td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['class_name']=self::$config['class_name'];

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
