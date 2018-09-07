<?php
$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;

$module['receiver']='';
$sql="select * from ".self::$table_pre."receiver where `username`='".$_SESSION['monxin']['username']."' order by `sequence` asc";
$r=$pdo->query($sql,2);
$temp='';
foreach($r as $v){
	if($v['post_code']!=''){$v['post_code']='('.$v['post_code'].')';}
	if($v['tag']!=''){$v['tag']='<span class=tag ><span>'.$v['tag'].'</span></span>';}
	$temp.='<a href="#" class="option" id=receiver_'.$v['id'].' style="display:inline-block;vertical-align:top;">
					<div class=receiver_head><span class=name>'.$v['name'].'</span>'.$v['tag'].'</div>
					<div class=phone>'.$v['phone'].'</div>
					<div class=area_id>'.get_area_name($pdo,$v['area_id']).'</div>
					<div class=detail>'.$v['detail'].$v['post_code'].'</div>
					<div class=button_div><span class=edit>'.self::$language['edit'].'</span><span class=del>'.self::$language['del'].'</span><span class=go_left title="'.self::$language['go_left'].'">&nbsp;</span><span class=go_right title="'.self::$language['go_right'].'">&nbsp;</span></div>
				</a>';	
}	
$module['receiver']=$temp;

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
