<?php
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$sql="select * from ".self::$table_pre."shop_buyer_group where `shop_id`=".SHOP_ID." order by `credits` asc";
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$list.="<tr id=tr_".$v['id'].">
	<td><input type=text class=name value=".$v['name']." /></td>
	<td><input type=text class=credits value=".$v['credits']." /></td>
	<td><input type=text class=discount value=".$v['discount']." /></td>
	<td class=operation_td>
  <a href=# class=submit>".self::$language['submit']."</a>
  <a href='#'  onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span class='state'></span></td></tr>";	
}
$module['list']=$list;
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);