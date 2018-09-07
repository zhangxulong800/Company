<?php
$batch_id=intval($_GET['batch_id']);
if($batch_id==0){echo 'id err';return false;}
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".self::$table_pre."create_card where `batch_id`=".$batch_id."";

$where="";

if($_GET['search']!=''){$where=" and (`username` like '%".$_GET['search']."%' or `chip` like '%".$_GET['search']."%')";}
$_GET['order']=safe_str(@$_GET['order']);
if($_GET['order']==''){
	$order=" order by `id` desc";
}else{
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_create_card and","_create_card where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_create_card and","_create_card where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';


foreach($r as $v){
	$use_time='';
	if($v['state']){$use_time=get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['use_time']);}
	$list.="<tr id='tr_".$v['id']."'>
	<td>".$v['username']."</td>
	<td>".$v['money']."</td>
	<td>".$v['chip']."</td>	
	<td>".self::$language['card_state'][$v['state']]." ".$use_time."</td>
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

$sql="select `name` from ".self::$table_pre."create_card_batch where `id`=".$batch_id;
$r=$pdo->query($sql,2)->fetch(2);
echo '<div  style="display:none;" id="user_position_append"><a href="./index.php?monxin=mall.create_card_list">'.self::$language['pages']['mall.create_card_list']['name'].'</a><span class=text>'.$r['name'].' '.self::$language['pages']['mall.create_card_detail']['name'].'</span></div>';
