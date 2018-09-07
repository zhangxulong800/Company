<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['visible']=@$_GET['visible'];
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select `id`,`type`,`title`,`icon`,`visit`,`reflash`,`sequence`,`state`,`username`,`tag` from ".self::$table_pre."content";

$where="";
if(intval(@$_GET['id'])!=0){
	$where=" and `id`=".intval($_GET['id']);
	echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=ci.info_admin">'.self::$language['pages']['ci.info_admin']['name'].'</a><span class=text>'.$_GET['id'].'</span></div>';
}
$_GET['state']=intval(@$_GET['state']);
if($_GET['state']>0){
	$where.=" and `state`=".$_GET['state'];
}
$_GET['type']=intval(@$_GET['type']);
if($_GET['type']>0){
	$type_ids=$this->get_type_ids($pdo,$_GET['type']);
	$where.=" and `type` in (".$type_ids.")";
}
$_GET['tag']=intval(@$_GET['tag']);
if($_GET['tag']>0){
	$where.=" and `tag` like '%|".$_GET['tag']."|%'";
}

if($_GET['search']!=''){$where=" and (`title` like '%".$_GET['search']."%' or `content` like '%".$_GET['search']."%' or `linkman` like '%".$_GET['search']."%' or `contact` like '%".$_GET['search']."%')";}
$_GET['order']=safe_str(@$_GET['order']);
if($_GET['order']==''){
	$order=" order by `id` desc";
}else{
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" `id`,`type`,`title`,`icon`,`visit`,`reflash`,`sequence`,`state`,`username`,`tag` "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_content and","_content where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_content and","_content where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';


foreach($r as $v){
	$v=de_safe_str($v);
	$list.="<tr id='tr_".$v['id']."'>
	<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
	<td><a href='./index.php?monxin=ci.detail&id=".$v['id']."' target=_blank class=icon><img wsrc=./program/ci/img_thumb/".$v['icon']." /></a></td>
	<td><div class=title><a href='./index.php?monxin=ci.detail&id=".$v['id']."' target=_blank>".$v['title']."</a></div><div class=type_tag><span class=type>".self::get_type_position($pdo,$v['type'])." <a href=./index.php?monxin=ci.set_type&c_id=".$v['id']."&id=".$v['type']." class=set>&nbsp;</a></span><span class=tag>".self::get_tags_name($pdo,$v['tag'])." <a href=./index.php?monxin=ci.set_tag&c_id=".$v['id']."&id=".$v['tag']." class=set>&nbsp;</a></span></div></td>
  <td><span class=visit>".$v['visit']."</span></td>
  <td><span class=username>".$v['username']."</span></td>
  <td><span class=time>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['reflash'])."</span></td>
  <td><input type='text' name='sequence_".$v['id']."' id='sequence_".$v['id']."' value='".$v['sequence']."' class='sequence' /></td>
  <td><select class=data_state monxin_value=".$v['state']."><option value=0>".self::$language['info_state'][0]."</option><option value=1>".self::$language['info_state'][1]."</option><option value=2>".self::$language['info_state'][2]."</option><option value=3>".self::$language['info_state'][3]."</option></select></td>
  <td class=operation_td>
  <a href=# onclick='return update(".$v['id'].")' class=submit>".self::$language['submit']."</a></a><br /> 
  <a href='#' onclick='return del(".$v['id'].")' class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
</tr>
";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

function get_tag_filter($pdo,$language,$table_pre){
	$list="<option value='-1'>".$language['visible_state']."</option>";
	$list.="<option value='' selected>".$language['all'].$language['tag']."</option>";
	$sql="select * from ".$table_pre."tag order by `sequence` desc";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$list.='<option value="'.$v['id'].'">'.$v['name'].'</option>';	
	}
	$list="<select name='tag_filter' id='tag_filter'>{$list}</select>";
	return $list;
}
function get_type_filter($pdo,$language,$list){
$list2="<option value='-1'>".$language['belong']."</option>";
$list2.="<option value='' selected>".$language['all'].$language['type']."</option>";
$_GET['type']=@$_GET['type']?@$_GET['type']:0;
$list2.=$list;
$list="<select name='type_filter' id='type_filter'>{$list2}</select>";
return $list;
}
function get_state_filter($pdo,$language){
	$list="<option value='-1'>".$language['visible_state']."</option>";
	$list.="<option value='' selected>".$language['all'].$language['state']."</option>";
	
	foreach($language['info_state'] as $k=>$v){
		$list.='<option value="'.$k.'">'.$v.'</option>';	
	}
	$list="<select name='state_filter' id='state_filter'>{$list}</select>";
	return $list;
}
if($_GET['type']==0){
	$module['export']='<a href='.$module['action_url'].'&export=0 target=_blank  class=export>'.self::$language['export'].self::$language['mobile_number'].'('.self::$language['all'].')</a>';
}else{
	$sql="select `name` from ".self::$table_pre."type where `id`=".$_GET['type'];
	$r=$pdo->query($sql,2)->fetch(2);
	$module['export']='<a href='.$module['action_url'].'&export='.$_GET['type'].' target=_blank class=export>'.self::$language['export'].self::$language['mobile_number'].'('.$r['name'].')</a>';
}

$list=$this->get_parent($pdo);
$module['filter']=get_type_filter($pdo,self::$language,$list);
$module['filter'].=get_state_filter($pdo,self::$language);
$module['filter'].=get_tag_filter($pdo,self::$language,self::$table_pre);
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);