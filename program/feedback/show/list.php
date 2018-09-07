<?php
$attribute=format_attribute($args[1]);
$field_array=get_field_array($attribute['field']);

$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=$attribute['quantity'];
$sql="select * from ".self::$table_pre."msg where `state`=1 order by `sequence` desc,`id` desc";

$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_msg and","_msg where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$limit;
$sql=str_replace("_msg and","_msg where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$v=de_safe_str($v);
	$group_id=get_username($pdo,$v['answer_user']);
	
	
	$time='';
	$answer_time='';
	$ip='';
	if(in_array('time',$field_array)){$time='<span class=time>'.get_time(self::$config['other']['date_style']." H:i",self::$config['other']['timeoffset'],self::$language,$v['time']).'</span>';}
	if(in_array('answer_time',$field_array)){$answer_time='<span class=time>'.get_time(self::$config['other']['date_style']." H:i",self::$config['other']['timeoffset'],self::$language,$v['answer_time']).'</span>';}
	if(in_array('ip',$field_array)){$ip="<span class=ip>".$v['ip']."</span>";}
	
	if($v['answer']!=''){
		$answer="<div class=answer_div align=right><div class='v' >".str_replace("\r\n",'<br />',$v['answer'])."</div></div>
		<div class=answer_info>".$answer_time."<span class=answer_user>".get_user_group_name($pdo,$group_id).'('.get_nickname($pdo,$v['answer_user']).")</span></div>";
	}else{
		$answer='';	
	}
	$list.="
	<div class=msg_div>
		<div class=sender_info><span class=sender>".$v['sender']."</span>".$time.$ip."</div>
		<div class='content_div'><div   class='v'>".str_replace("\r\n",'<br />',$v['content'])."</div></div>
		$answer
	</div>
";	
}
if($sum==0){$list='';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['module_save_name']=str_replace("::","_",$method.$args[1]);

$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
echo '<div style="display:none;" id="visitor_position_append">'.self::$language['program_name'].'</div>';
