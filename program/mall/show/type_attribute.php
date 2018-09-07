<?php
$type=intval(@$_GET['type']);
if($type==0){echo 'type id err';return false;}
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&type='.$type;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$sql="select * from ".self::$table_pre."type_attribute where `type_id`='".$type."' order by `sequence` desc,`id` asc";
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$list.="<tr id='tr_".$v['id']."'>
		<td><input type='text' name='name_".$v['id']."' id='name_".$v['id']."' value='".$v['name']."'  class='name' /></td>
		<td><input type='text' name='values_".$v['id']."' id='values_".$v['id']."' value='".$v['values']."'  class='values' /></td>
	  <td><input type='text' name='sequence_".$v['id']."' id='sequence_".$v['id']."' value='".$v['sequence']."'  class='sequence' /></td>
	  <td><input type='checkbox' name='list_show_".$v['id']."' id='list_show_".$v['id']."'  class='list_show' monxin_value=".$v['list_show']." /></td>
	  <td class=operation_td><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".self::$language['submit']."</a> <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
	</tr>
";	

}
$module['list']=$list;
if($module['list']==''){$module['list']='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}

$sql="select `attribute_source`,`parent`,`name` from ".self::$table_pre."type where `id`=".$type;
$r=$pdo->query($sql,2)->fetch(2);
$module['attribute_source']=$r['attribute_source'];
echo '<div  style="display:none;" id="user_position_append">'.$this->get_type_user_position($pdo,$r['parent']).'<span class=text>'.$r['name'].' '.self::$language['pages']['mall.type_attribute']['name'].'</span></div>';
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
