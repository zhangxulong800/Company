<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
function admin_brand_get_parent($pdo,$v,$id){
	$sql="select `name`,`id` from ".$pdo->sys_pre."mall_brand where `visible`='1' and `parent`=0 and `id`!='$id' order by `sequence` desc";
	$stmt=$pdo->query($sql,2);
	$temp=$v;
	$module['parent']="";
	//echo $sql;
	foreach($stmt as $v){
		$v=de_safe_str($v);
		if($temp==$v['id']){$selected='selected';}else{$selected='';}
		$module['parent'].="<option value='".$v['id']."' $selected >&nbsp;&nbsp;&nbsp;&nbsp;".$v['name']."</option>";
	}
	return $module['parent'];			
}

function admin_brand_get_list($pdo,$language,$parent,$module_name){
	global $sum;
	$visible=@$_GET['visible'];
	$open_target=safe_str(@$_GET['open_target']);
	$search=safe_str(@$_GET['search']);
	$search=trim($search);
	$sql="select * from ".$pdo->sys_pre."mall_brand";
	$where=" and `parent`='$parent'";
	if(is_numeric($visible)){$where.=" and `visible`='$visible'";}
	if($open_target!=''){$where.=" and `open_target`='$open_target'";}
	if($search!=''){$where=" and (`name` like '%$search%' or `url` like '%$search%')";}
	$order=" order by `visible` desc,`sequence` desc";
	if($sum==0){
		$sum_sql=$sql.$where;
		$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
		$sum_sql=str_replace("_brand and","_brand where",$sum_sql);
		$r=$pdo->query($sum_sql,2)->fetch(2);
		$sum=$r['c'];
	}
	$sql=$sql.$where.$order;
	$sql=str_replace("_brand and","_brand where",$sql);
	//echo($sql);
	//exit();
	$r=$pdo->query($sql,2);
	$list='';
	foreach($r as $v){
		$v=de_safe_str($v);
		if($v['visible']==1){$checked='checked';}else{$checked='';}
		$list.="<tr id='tr_".$v['id']."'>
		<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
		<td><select name='parent_".$v['id']."' id='parent_".$v['id']."'  class='parent'>
		<option value='0'>--".$language['none']."--</option>
		".admin_brand_get_parent($pdo,$v['parent'],$v['id'])."
		</select></td>
		<td><input type='text' name='name_".$v['id']."' id='name_".$v['id']."' value='".$v['name']."'  class='name' style='width:".admin_brand_get_name_width($pdo,$v['id'])."%;' /></td>
	  <td><input type='text' name='url_".$v['id']."' id='url_".$v['id']."' value='".$v['url']."'  class='url' /></td>
	  <td><a href=# id=icon_".$v['id']." class=icon><img src='./program/mall/brand_icon/".$v['id'].".png'></a></td>
	  <td><input type='text' name='sequence_".$v['id']."' id='sequence_".$v['id']."' value='".$v['sequence']."' class='sequence' /></td>
	  <td><input type='checkbox' name='visible_".$v['id']."' id='visible_".$v['id']."'  class='visible' $checked /></td>
	  <td class=operation_td><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".$language['submit']."</a> <a href='#' onclick='return del(".$v['id'].")'  class='del'>".$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
	</tr>
";	
	$sql2="select count(id) as c from ".$pdo->sys_pre."mall_brand where `parent`=".$v['id']."";
	$r2=$pdo->query($sql2,2)->fetch(2);
	if($search==''){
		if($r2['c']>0){$list.=admin_brand_get_list($pdo,$language,$v['id'],$module_name);}
	}
	}
	return $list;
}

function admin_brand_get_name_width($pdo,$id){
	$sql="select `parent`,`id` from ".$pdo->sys_pre."mall_brand where `id`='$id'";
	$v=$pdo->query($sql,2)->fetch(2);
	if($v['parent']==0){return 80;}	
	$sql="select `parent`,`id` from ".$pdo->sys_pre."mall_brand where `id`='".$v['parent']."'";
	$v=$pdo->query($sql,2)->fetch(2);
	if($v['parent']==0){return 60;}	
	$sql="select `parent`,`id` from ".$pdo->sys_pre."mall_brand where `id`='".$v['parent']."'";
	$v=$pdo->query($sql,2)->fetch(2);
	if($v['parent']==0){return 40;}	
	//return 100;
}

function admin_brand_get_visible_filter($pdo,$language){
	$list="<option value='-1'>".$language['visible_state']."</option>";
	$list.="<option value='' selected>".$language['all']."</option>";
	$list.=get_select_value($pdo,'visible_state',@$_GET['visible']);
	$list="<select name='visible_filter' id='visible_filter'>{$list}</select>";
	return $list;
}
function admin_brand_get_open_target_filter($pdo,$language){
	$list="<option value='-1'>".$language['target']."</option>";
	$list.="<option value='' selected>".$language['all']."</option>";
	$list.=get_select_value($pdo,'target',@$_GET['open_target']);
	$list="<select name='open_target_filter' id='open_target_filter'>{$list}</select>";
	return $list;
}
function admin_brand_get_parent_filter($pdo,$language){
	$list="<option value='-1'>".$language['parent']."</option>";
	$list.="<option value='' selected>".$language['all']."</option>";
	$parent=@$_GET['parent']?@$_GET['parent']:0;
	$list.=admin_brand_get_parent($pdo,$parent,0);
	$list="<select name='parent_filter' id='parent_filter'>{$list}</select>";
	return $list;
}
		

$module['target']=get_select_value($pdo,'target','_self');
$module['parent']=admin_brand_get_parent($pdo,'-1',0);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$sum=0;
$module['list']=admin_brand_get_list($pdo,self::$language,0,$module['module_name']);
if($module['list']==''){$module['list']='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}



$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);