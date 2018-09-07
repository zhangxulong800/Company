<?php
if(@$_GET['act']=='synchronization'){
	$sql="select `name` from ".self::$table_pre."type where `parent`=0";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$sql="select `id` from ".self::$table_pre."interest_group where `name`='".$v['name']."' limit 0,1";
		$r2=$pdo->query($sql,2)->fetch(2);
		if($r2['id']==''){
			$sql="insert into ".self::$table_pre."interest_group (`name`) values ('".$v['name']."')";	
			$pdo->exec($sql);
		}	
	}
	echo '<script>alert("'.self::$language['synchronization'].self::$language['success'].'");</script>';
}


$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$sql="select * from ".self::$table_pre."interest_group order by `sequence` desc,`id` asc";
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$list.="<tr id='tr_".$v['id']."'>
		<td><input type='text' name='name_".$v['id']."' id='name_".$v['id']."' value='".$v['name']."'  class='name' /></td>
	  <td><input type='text' name='sequence_".$v['id']."' id='sequence_".$v['id']."' value='".$v['sequence']."'  class='sequence' /></td>
	  <td><a href='index.php?monxin=mall.interest_word&group_id=".$v['id']."' class=link>".$v['words']."</a></td>
	  <td>".$v['day']."</td>
	  <td>".$v['week']."</td>
	  <td>".$v['month']."</td>
	  <td>".$v['year']."</td>
	  <td><a href='index.php?monxin=mall.interest_user_list&group_id=".$v['id']."' class=link>".$v['sum']."</a></td>
	  <td class=operation_td><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".self::$language['submit']."</a> <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
	</tr>
";	

}
$module['list']=$list;
if($module['list']==''){$module['list']='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);	
