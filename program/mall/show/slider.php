<?php
function get_slider_style_option($config,$value=''){
	$path='./templates/0/mall/'.$config['program']['template_1'].'/pc/style/';
	$r=scandir($path);
	$option='';
	foreach($r as $v){
		if(is_dir($path.$v)){
			if($v!='.' && $v!='..'){
				if($v==$value){$selected='selected';}else{$selected='';}
				//echo $v.'=='.$value.' '.$selected.'<br />';
				$option.="<option value=$v ".$selected.">$v</option>";	
			}	
		}	
	}
	return $option;
}

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['style_option']=get_slider_style_option(self::$config);

$search=safe_str(@$_GET['search']);
$search=trim($search);
$current_page=intval(isset($_GET['current_page'])?$_GET['current_page']:1);
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."slider where `shop_id`=".SHOP_ID;
$where='';
if(@$_GET['order']==''){
	$order=" order by `id` desc";
}else{
	$_GET['order']=safe_str($_GET['order']);
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($current_page-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_group and","_group where",$sum_sql);
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_group and","_group where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$list.="<tr id='tr_".$v['id']."'>
	<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
	<td><input type='text' name='title_".$v['id']."' id='title_".$v['id']."' value='".$v['title']."'  class='title' /></td>
	<td><select id='style_".$v['id']."' name='style_".$v['id']."' class=style>".get_slider_style_option(self::$config,$v['style'])."</select></td>
	<td><input type='text' name='width_".$v['id']."' id='width_".$v['id']."' value='".$v['width']."'  class='width' /> *</td>
	<td><input type='text' name='height_".$v['id']."' id='height_".$v['id']."' value='".$v['height']."'  class='height' /></td>
	<td><input type='text' name='duration_".$v['id']."' id='duration_".$v['id']."' value='".$v['duration']."'  class='duration' /></td>
	<td><input type='text' name='delay_".$v['id']."' id='delay_".$v['id']."' value='".$v['delay']."'  class='delay' /></td>
  <td>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</td>
  <td class=operation_td><a href='index.php?monxin=".$class.".slider_show&id=".$v['id']."' target=_blank  class='view'>".self::$language['view']."</a><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".self::$language['submit']."</a><a href='index.php?monxin=".$class.".slider_img&id=".$v['id']."' class='edit'>".self::$language['edit']."</a><a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
</tr>
";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['class_name']=self::$config['class_name'];
$module['page']=MonxinDigitPage($sum,$current_page,$page_size,'#'.$module['module_name']);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
