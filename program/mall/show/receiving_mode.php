<?php
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$list='';
foreach(self::$language['delivery_time_info'] as $k=>$v){
	$list.="<tr id='tr_".$k."'>
		<td>".$k."</td>
		<td><input type='text' name='name_".$k."' id='name_".$k."' value='".$v."'  class='name' /></td>
	  <td><input type='text' name='remark_".$k."' id='remark_".$k."' value='".self::$language['delivery_time_info2'][$k]."'  class='remark' /></td>
	  <td class=operation_td><a href='#' onclick='return update(".$k.")'  class='submit'>".self::$language['submit']."</a> <a href='#' onclick='return del(".$k.")'  class='del'>".self::$language['del']."</a> <span id=state_".$k." class='state'></span></td>
	</tr>
";	

}
$module['list']=$list;
if($module['list']==''){$module['list']='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);	
