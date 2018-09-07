<?php
function admin_group_get_list($pdo,$language,$parent,$module_name){
	$sql="select * from ".$pdo->index_pre."group";
	$where=" and `parent`='$parent'";
	$order=" order by `sequence` desc";
	$sql=$sql.$where.$order;
	$sql=str_replace("_group and","_group where",$sql);
	//echo($sql);
	//exit();
	$r=$pdo->query($sql,2);
	$list='';
	foreach($r as $v){
		if($v['reg_able']==1){$reg_able='checked';}else{$reg_able='';}
		if($v['require_login']==1){$require_login='checked';}else{$require_login='';}
		if($v['require_check']==1){$require_check='checked';}else{$require_check='';}
		$list.="<tr id='tr_".$v['id']."'>
		<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
		<td width=180><input type='text' name='name_".$v['id']."' id='name_".$v['id']."' value='".$v['name']."' class='name' style='width:".(100-$v['deep']*10+10)."%;' /></td>
		<td>".index::count_group($pdo,$v['id'])."</td>
  <td><input type='checkbox' name='reg_able_".$v['id']."' id='reg_able_".$v['id']."' $reg_able /></td>
  <td><input type='checkbox' name='require_check_".$v['id']."' id='require_check_".$v['id']."' $require_check  /></td>
  <td><input type='checkbox' name='require_login_".$v['id']."' id='require_login_".$v['id']."' $require_login /></td>
	  <td><input type='text' name='sequence_".$v['id']."' id='sequence_".$v['id']."' value='".$v['sequence']."' class='sequence' /></td>
	  <td><input type='text' name='credits_".$v['id']."' id='credits_".$v['id']."' value='".$v['credits']."' class='credits' /></td>
	  <td class=operation_td><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".$language['submit']."</a>  <a href='#' onclick='return del(".$v['id'].")'  class='del'>".$language['del']."</a><span id=state_".$v['id']." class='state'></span> </td>
  <td><a href='index.php?monxin=index.edit_group_parent&id=".$v['id']."' class='change_parent'>".$language['change'].$language['parent']."</a></td>
  <td><a href='index.php?monxin=index.group_require_info&id=".$v['id']."' class='require_info'>".$language['require_info']."</a><br />
  <a href='index.php?monxin=index.user_field&id=".$v['id']."' class='user_field'>".$language['user_field']."</a>
  </td>
  <td><a href='index.php?monxin=index.view_menu&id=".$v['id']."' class='power'>".$language['power']."</a></td>
	</tr>
";	
	$list.=admin_group_get_list($pdo,$language,$v['id'],$module_name);
}
	
	return $list;
}
						
$count=1;
$module['parent']=index::get_group_select($pdo,'-1',0);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$name_count=0;
$last_width=100;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['list']=admin_group_get_list($pdo,self::$language,0,$module['module_name']);


if(self::$config['web']['group_upgrade']=='money'){
	self::$language['group_upgrade']=self::$language['group_upgrade_option']['money'];
}else{
	self::$language['group_upgrade']=self::$language['group_upgrade_option']['credits'];
}

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);