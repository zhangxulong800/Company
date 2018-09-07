<?php
$attribute=format_attribute($args[1]);
if(@$attribute['detail_show_method']!=''){$detail_show_method=$attribute['detail_show_method'];}else{$detail_show_method=self::$config['detail_show_method'];}
if(isset($_GET['detail_show_method']) && $_GET['detail_show_method']!=''){$detail_show_method=$_GET['detail_show_method'];}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=$attribute['quantity'];
$sql="select ".$attribute['field'].",`id`,`title`,`link` from ".self::$table_pre."img where `visible`=1";

$where="";
$_GET['type']=intval(@$_GET['type']);
if($_GET['type']>0){
	$type_ids=$this->get_type_ids($pdo,$_GET['type']);
	$where.=" and `type` in (".$type_ids.")";
	if($_GET['current_page']==1 || $_COOKIE['monxin_device']=='pc'){
		$type_sql="select `remark` from ".self::$table_pre."img_type where `id`=".$_GET['type'];
		$r=$pdo->query($type_sql,2)->fetch(2);
		$module['remark']=de_safe_str($r['remark']);
	}
	
}
if($_GET['search']!=''){$where=" and (`title` like '%".$_GET['search']."%' or `src` like '%".$_GET['search']."%' or `content` like '%".$_GET['search']."%')";}
$_GET['order']=safe_str(@$_GET['order']);
$order=" order by `".$attribute['sequence_field']."` ".$attribute['sequence_type']."";
if($_GET['order']==''){
	$_GET['order']=$attribute['sequence_field'].'|'.$attribute['sequence_type'];
	$order=" order by `".$attribute['sequence_field']."` ".$attribute['sequence_type']."";
}else{
	$temp=safe_order_by($_GET['order']);
	$temp[1]=@$temp[1];
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" ".$attribute['field'].",`id`,`title`,`link` "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_img and","_img where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_img and","_img where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
$field_array=get_field_array($attribute['field']);
foreach($r as $v){
	$v['title']=de_safe_str($v['title']);
	$title='';
	$src='';
	$visit='';
	$time='';
	if(in_array('title',$field_array)){$title='<span class=title>'.$v['title'].'</span>';}
	if(in_array('src',$field_array)){$src='<img src="./program/image/img_thumb/'.$v['src'].'" class=thumb_img alt="'.$v['title'].'" />';}
	if(in_array('visit',$field_array)){$visit='<span class=visit><span class="visit_symbol">&nbsp;</span>'.$v['visit'].'</span>';}
	if(in_array('time',$field_array)){$time='<span class=time><span class="time_symbol">&nbsp;</span>'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time']).'</span>';}
	if($v['link']==''){$link='./index.php?monxin=image.'.$detail_show_method.'&id='.$v['id'].'&type='.@$_GET['type'].'&order='.$_GET['order']."&search=".urlencode($_GET['search']);}else{$link=$v['link'];}
	
	
	$list.="<a href='".$link."' id='image_show_".$v['id']."' target='".$attribute['target']."'>".$src.$title.'<div>'.$time.$visit."</div></a>";
}
if($sum==0){$list='<span class=no_related_content_span>'.self::$language['no_related_content'].'</span>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

		

$module['module_save_name']=str_replace("::","_",$method.$args[1]);
$module['sub_module_width']=$attribute['sub_module_width'];
$module['image_height']=$attribute['image_height'];

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
echo '<div id="visitor_position_reset" style="display:none;"><span id=current_position_text>'.self::$language['current_position'].'</span><a href="./index.php"><span id=visitor_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a>'.$this->get_type_position($pdo,$_GET['type']).'</div>';