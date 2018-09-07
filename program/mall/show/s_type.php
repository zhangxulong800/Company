<?php
if(!SHOP_ID){header('location:./index.php?monxin=mall.apply_shop');exit;}
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);


function get_list($pdo,$language,$parent,$table_pre,$class){
	global $sum,$module;
	$obj=new $class($pdo);
	$sql="select * from ".$table_pre."shop_type where `shop_id`=".SHOP_ID." and `parent`='$parent'";
	$order=" order by `visible` desc,`sequence` desc";
	$sql=$sql.$order;
	//echo($sql);
	//exit();
	$r=$pdo->query($sql,2);
	$list='';
	foreach($r as $v){
		$v['name']=de_safe_str($v['name']);
		if($v['visible']==1){$checked='checked';}else{$checked='';}
		$list.="<tr id='tr_".$v['id']."'  parentid='".$v['parent']."'>
		<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
		<td><select name='parent_".$v['id']."' id='parent_".$v['id']."'  class='parent'>
		<option value='0'>--".$language['none']."--</option>
		".$obj->get_shop_parent($pdo,$v['id'],1)."
		</select></td>
		<td><input type='text' name='name_".$v['id']."' id='name_".$v['id']."' value='".$v['name']."'  class='name' style='width:".get_name_width($pdo,$v['id'],$table_pre)."%;' /></td>
	  <td><input type='text' name='sequence_".$v['id']."' id='sequence_".$v['id']."' value='".$v['sequence']."' class='sequence' /> <a href=./index.php?monxin=mall.s_type_remark&id=".$v['id']." class=remark>".$language['remark']."</a></td>
	  <td><input type='checkbox' name='visible_".$v['id']."' id='visible_".$v['id']."'  class='visible' $checked /></td>
	  <td class=operation_td><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".$language['submit']."</a> <a href='#' onclick='return del(".$v['id'].")'  class='del'>".$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
	</tr>
";	
	$sql2="select count(id) as c from ".$table_pre."shop_type where `shop_id`=".SHOP_ID." and `parent`=".$v['id']."";
	$r2=$pdo->query($sql2,2)->fetch(2);
	if($r2['c']>0){$list.=get_list($pdo,$language,$v['id'],$table_pre,$class);}
	}
	return $list;
}

function get_name_width($pdo,$id,$table_pre){
	$sql="select `parent`,`id` from ".$table_pre."shop_type where  `shop_id`=".SHOP_ID." and `id`='$id'";
	$v=$pdo->query($sql,2)->fetch(2);
	if($v['parent']==0){return 97;}	
	$sql="select `parent`,`id` from ".$table_pre."shop_type where  `shop_id`=".SHOP_ID." and `id`='".$v['parent']."'";
	$v=$pdo->query($sql,2)->fetch(2);
	if($v['parent']==0){return 77;}	
	$sql="select `parent`,`id` from ".$table_pre."shop_type where  `shop_id`=".SHOP_ID." and `id`='".$v['parent']."'";
	$v=$pdo->query($sql,2)->fetch(2);
	if($v['parent']==0){return 57;}	
	//return 100;
}

$module['parent']=$this->get_shop_parent($pdo,-1,1);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$sum=0;

$module['list']=get_list($pdo,self::$language,0,self::$table_pre,$class);		

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
