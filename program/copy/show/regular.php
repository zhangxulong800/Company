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

$sql="select * from ".self::$table_pre."regular";

$where="";
if(intval(@$_GET['id'])!=0){
	$where=" and `id`=".intval($_GET['id']);
	echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=copy.regular">'.self::$language['pages']['copy.regular']['name'].'</a><span class=text>'.$_GET['id'].'</span></div>';
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_regular and","_regular where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$order=" order by `id` asc";	
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_regular and","_regular where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$v=de_safe_str($v);
	$list.="<tr id='tr_".$v['id']."'>
	<td><span class=name>".$v['name']."</span></td>
  <td><input type=checkbox id=switch_".$v['id']." name=switch_".$v['id']." value=".$v['switch']." class=visible  /></td>
  <td class=operation_td>
  <a href='./index.php?monxin=copy.regular_edit&id=".$v['id']."' class='edit'>".self::$language['edit']."</a> 
  <a href='./index.php?monxin=copy.table&id=".$v['id']."' class='table'>".self::$language['table_02']."</a> 
  <a href='./index.php?monxin=copy.field&id=".$v['id']."' class='edit'>".self::$language['field']."</a> 
  <a href='./index.php?monxin=copy.task_list&id=".$v['id']."' class='edit'>".self::$language['task_list']."</a> 
  <a href='./index.php?monxin=copy.task&regular_id=".$v['id']."' class='edit'>".self::$language['exe_copy']."</a> 
  <a href='./receive.php?target=copy::regular&act=export&id=".$v['id']."' target=_blank class='edit'>".self::$language['export']."</a> 
  <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
</tr>
";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);



$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);

require "./plugin/html4Upfile/createHtml4.class.php";
$html4Upfile=new createHtml4();
$html4Upfile->echo_input("import",'600px','./temp/','true','false','txt','10240','1');
//echo_input("控件名称",'控件宽度(百分比或像素)','保存目录','文件夹是否附加日期','是否原名保存','允许文件后缀','文件大小 上限','文件大小 下限','指定保存名');
//指定保存名时，要先设置权限 $_SESSION['replace_file']=true;  ，否则将无效
