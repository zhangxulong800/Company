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

$sql="select `id`,`title`,`username`,`sequence`,`visible`,`time`,`visit`,`show_type` from ".self::$table_pre."page";

$where="";

if(@is_numeric($_GET['visible'])){$where.=" and `visible`='".$_GET['visible']."'";}
if($_GET['search']!=''){$where=" and (`title` like '%".$_GET['search']."%')";}
if(@$_GET['order']==''){
	$order=" order by `sequence` desc,`id` desc";
}else{
	$_GET['order']=safe_str($_GET['order']);
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" `id`,`title`,`username`,`sequence`,`visible`,`time`,`visit`,`show_type` "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_page and","_page where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_page and","_page where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$v=de_safe_str($v);
	if($v['visible']==1){$checked='checked';}else{$checked='';}
	if($v['show_type']==1){$show_type='checked';}else{$show_type='';}
	$list.="<tr id='tr_".$v['id']."'>
	<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
	<td><input type='text' name='title_".$v['id']."' id='title_".$v['id']."' value='".$v['title']."'  class='title' /></td>
  <td>".$v['username']."</td>
  <td>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</td>
  <td><input type='text' name='sequence_".$v['id']."' id='sequence_".$v['id']."' value='".$v['sequence']."' class='sequence' /></td>
  <td><input type='checkbox' name='visible_".$v['id']."' id='visible_".$v['id']."'  class='visible' $checked /></td>
  <td><input type='checkbox' name='show_type_".$v['id']."' id='show_type_".$v['id']."'  class='show_type' $show_type /></td>
  <td><span class=visit>".$v['visit']."</span></td>
  <td class=operation_td><a href='index.php?monxin=".$class.".show&id=".$v['id']."' target=_blank  class='view'>".self::$language['view']."</a> <a href='#' onclick='return update(".$v['id'].")'  class='submit'>".self::$language['submit']."</a> <a href='index.php?monxin=".$class.".edit&id=".$v['id']."' target=_blank class='edit'>".self::$language['edit']."</a> <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
</tr>
";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

function get_visible_filter($pdo,$language){
$list="<option value='-1'>".$language['visible_state']."</option>";
$list.="<option value='' selected>".$language['all']."</option>";
$list.=get_select_value($pdo,'visible_state',@$_GET['visible']);
$list="<select name='visible_filter' id='visible_filter'>{$list}</select>";
return $list;
}

$module['filter']=get_visible_filter($pdo,self::$language);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);