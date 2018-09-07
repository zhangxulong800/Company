<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

	
if(isset($_GET['set_py'])){
	require('plugin/py/py_class.php');
	$py_class=new py_class(); 
	
	$sql="select `id`,`name` from ".$pdo->index_pre."circle";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		try { $py=$py_class->str2py($v['name']); } catch(Exception $e) { $py='';}
		$sql="update ".$pdo->index_pre."circle set `py`='".$py."' where `id`=".$v['id'];
		$pdo->exec($sql);
	}
}	

function admin_circle_get_parent($pdo,$v,$id){
	$sql="select `name`,`id` from ".$pdo->index_pre."circle where `visible`='1' and `parent_id`=0 and `id`!='$id' order by `sequence` desc";
	$stmt=$pdo->query($sql,2);
	$temp=$v;
	$module['parent']="";
	foreach($stmt as $v){
		$v=de_safe_str($v);
		if($temp==$v['id']){$selected='selected';}else{$selected='';}
		$module['parent'].="<option value='".$v['id']."' $selected >&nbsp;&nbsp;&nbsp;&nbsp;".$v['name']."</option>";
	}
	return $module['parent'];			
}

function admin_circle_get_list($pdo,$language,$parent_id,$module_name){
	global $sum;
	$visible=@$_GET['visible'];
	$open_target=safe_str(@$_GET['open_target']);
	$search=safe_str(@$_GET['search']);
	$search=trim($search);
	$sql="select * from ".$pdo->index_pre."circle";
	$where=" and `parent_id`='$parent_id'";
	if(is_numeric($visible)){$where.=" and `visible`='$visible'";}
	if($open_target!=''){$where.=" and `open_target`='$open_target'";}
	if($search!=''){$where=" and (`name` like '%$search%' or `url` like '%$search%')";}
	$order=" order by `visible` desc,`sequence` desc";
	if($sum==0){
		$sum_sql=$sql.$where;
		$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
		$sum_sql=str_replace("_circle and","_circle where",$sum_sql);
		$r=$pdo->query($sum_sql,2)->fetch(2);
		$sum=$r['c'];
	}
	$sql=$sql.$where.$order;
	$sql=str_replace("_circle and","_circle where",$sql);
	//echo($sql);
	//exit();
	$r=$pdo->query($sql,2);
	$list='';
	foreach($r as $v){
		$v=de_safe_str($v);
		if($v['visible']==1){$checked='checked';}else{$checked='';}
		if($parent_id==0){$go_sub='<a class=go_sub href=./index.php?monxin=index.circle_set&parent='.$v['id'].'></a>';}else{$go_sub='';}
		
		$list.="<tr id='tr_".$v['id']."'>
		<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
		<td><select name='parent_id_".$v['id']."' id='parent_id_".$v['id']."'  class='parent_id'>
		<option value='0'>--".$language['none']."--</option>
		".admin_circle_get_parent($pdo,$v['parent_id'],$v['id'])."
		</select></td>
		<td class=name_td><a href=# id=icon_".$v['id']." class=icon><img src='./program/index/circle_icon/".$v['id'].".png'></a><input type='text' name='name_".$v['id']."' id='name_".$v['id']."' value='".$v['name']."'  class='name' style='width:".admin_circle_get_name_width($pdo,$v['id'])."%;' /> ".$go_sub."</td>
	  <td><input type='text' monxin_type='map' name='center_".$v['id']."' id='center_".$v['id']."' value='".$v['center']."'  class='center' /></td>
	  <td><input type='text' name='range_".$v['id']."' id='range_".$v['id']."' value='".$v['range']."'  class='range' /></td>
	  <td><div class=area_div><input type='hidden' name='area_".$v['id']."' id='area_".$v['id']."' value='".$v['area_id']."'  class='area' /> <script src='area_js.php?callback=set_area&input_id=area_".$v['id']."&id=".$v['area_id']."&level=4&output=select' id='area_".$v['id']."_area_js'></script> <span class=state id=area_".$v['id']."_state></span></div></td>
	  <td><input type='text' name='sequence_".$v['id']."' id='sequence_".$v['id']."' value='".$v['sequence']."' class='sequence' /></td>
	  <td><input type='checkbox' name='visible_".$v['id']."' id='visible_".$v['id']."'  class='visible' $checked /></td>
	  <td class=operation_td><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".$language['submit']."</a> <a href='#' onclick='return del(".$v['id'].")'  class='del'>".$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
	</tr>
";	
	/*
	$sql2="select count(id) as c from ".$pdo->index_pre."circle where `parent_id`=".$v['id']."";
	$r2=$pdo->query($sql2,2)->fetch(2);
	if($search==''){
		if($r2['c']>0){$list.=admin_circle_get_list($pdo,$language,$v['id'],$module_name);}
	}
	*/
	}
	return $list;
}

function admin_circle_get_name_width($pdo,$id){
	$sql="select `parent_id`,`id` from ".$pdo->index_pre."circle where `id`='$id'";
	$v=$pdo->query($sql,2)->fetch(2);
	if($v['parent_id']==0){return 80;}	
	$sql="select `parent_id`,`id` from ".$pdo->index_pre."circle where `id`='".$v['parent_id']."'";
	$v=$pdo->query($sql,2)->fetch(2);
	if($v['parent_id']==0){return 60;}	
	$sql="select `parent_id`,`id` from ".$pdo->index_pre."circle where `id`='".$v['parent_id']."'";
	$v=$pdo->query($sql,2)->fetch(2);
	if($v['parent_id']==0){return 40;}	
	//return 100;
}

$module['parent']=admin_circle_get_parent($pdo,'-1',0);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$sum=0;


if(!isset($_GET['parent'])){$parent=0;}else{
	$parent=intval($_GET['parent']);
	$sql="select `name` from ".$pdo->index_pre."circle where `id`=".$parent;
	$r=$pdo->query($sql,2)->fetch(2);
	echo '<div id="user_position_reset" style="display:none;"><a href=index.php?monxin=index.user>'.self::$language['user_center'].'</a><a href=index.php?monxin=index.public_content_sttings>'.self::$language['pages']['index.public_content_sttings']['name'].'</a><a href=index.php?monxin=index.circle_set>'.self::$language['pages']['index.circle_set']['name'].'</a><span class=text>'.$r['name'].'</span></div>';
}
$module['list']=admin_circle_get_list($pdo,self::$language,$parent,$module['module_name']);


if($module['list']==''){$module['list']='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}
$module['map_api']=self::$config['web']['map_api'];

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);